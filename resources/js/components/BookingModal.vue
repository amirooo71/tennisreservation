<template>

    <div>
        <!--Book modal-->
        <sweet-modal ref="modal" overlay-theme="dark" @close="reset">
            <!--Book for guest tab-->
            <sweet-modal-tab title="رزرو مهمان" id="tab-guest">
                <form class="kt-form" @submit.prevent="onBookSubmit">
                    <div class="form-group">
                        <label>نام رزرو کننده را وارد کنید</label>
                        <input type="text" class="form-control" v-model="renterName">
                    </div>
                    <div class="form-group text-left">
                        <label class="kt-checkbox">
                            <input type="checkbox" @change="hasCustomTime = !hasCustomTime" :checked="hasCustomTime">
                            تغییر ساعت
                            <span></span>
                        </label>
                    </div>
                    <div class="form-group" v-if="hasCustomTime">
                        <label>ساعت را وارد کنید</label>
                        <input type="text" class="form-control" data-provide="timepicker" data-show-meridian="false"
                               v-model="customTime">
                        <span class="form-text text-muted">شما می توانید ساعت رزرو را در اینجا تغییر دهید به عنوان مثال (16:30)</span>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary">ذخیره</button>
                    </div>
                </form>
            </sweet-modal-tab>
            <!--/Book for guest tab-->
            <!--Book for coach tab-->
            <sweet-modal-tab title="رزرو مربی" id="tab-coach">
                <form class="kt-form" @submit.prevent="onBookSubmit">
                    <div class="form-group">
                        <label>مربی مورد نظر را انتخاب کنید</label>
                        <select v-model="ownerId" class="form-control">
                            <option v-for="coach in coaches" :value="coach.id">{{coach.name}}</option>
                        </select>
                    </div>
                    <div class="form-group text-left">
                        <label class="kt-checkbox">
                            <input type="checkbox" @change="hasPartnerName = !hasPartnerName" :checked="hasPartnerName">
                            نام
                            شاگرد
                            <span></span>
                        </label>
                    </div>
                    <div class="form-group" v-if="hasPartnerName">
                        <label>نام شاگرد را وارد کنید</label>
                        <input v-model="partnerName" type="text" class="form-control">
                        <span class="form-text text-muted">در صورت تمایل می توانید نام شاگرد را وارد کنید</span>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary">ذخیره</button>
                    </div>
                </form>
            </sweet-modal-tab>
            <!--/Book for coach tab-->
        </sweet-modal>
    </div>

</template>

<script>

    import {SweetModal, SweetModalTab} from 'sweet-modal-vue'

    export default {

        name: "booking-modal",

        components: {SweetModal, SweetModalTab},

        data() {
            return {
                renterName: '',
                bookedId: '',
                coaches: [],
                ownerId: '',
                customTime: '',
                hasCustomTime: false,
                hasPartnerName: false,
                partnerName: '',
            }
        },

        created() {
            this.getCoaches();
        },

        mounted() {

            Events.$on('open-booking-modal', (data) => {

                this.court = data.court;
                this.hour = data.hour;
                this.date = data.date;

                this.$refs.modal.open();
            })
        },

        methods: {

            onBookSubmit() {

                return axios.post('/admin/bookings', this.getPostedData()).then(res => {
                    this.triggerSuccessSubmitEvent(res);
                    toastr.success(res.data.msg);
                    this.$refs.modal.close();
                }).catch(err => Swal.showValidationMessage('خطایی رخ داده است'));

            },

            getCoaches() {
                axios.get('/admin/ajax/coaches').then(res => {
                    this.coaches = res.data;
                }).catch(err => toastr.warning('خطایی رخ داده است'));
            },

            reset() {
                this.renterName = '';
                this.hasCustomTime = false;
                this.customTime = '';
                this.hasPartnerName = false;
                this.partnerName = '';
            },

            triggerSuccessSubmitEvent(res) {
                Events.$emit(`on-success-booking-court-${this.court.id}-at-${this.hour}`, {
                    renterName: res.data.book.renter_name,
                    bookedId: res.data.book.id,
                });
            },

            getPostedData() {
                return {
                    renter_name: this.renterName,
                    court_id: this.court.id,
                    date: this.date,
                    time: this.hour,
                    owner_id: this.ownerId,
                    partner_name: this.partnerName,
                    custom_time: this.customTime,
                }
            },

        },


        watch: {
            ownerId: function (val) {
                this.coaches.forEach(coach => {
                    if (coach.id === val) {
                        this.renterName = coach.name;

                    }
                });
            }
        }

    }
</script>

<style scoped>

</style>