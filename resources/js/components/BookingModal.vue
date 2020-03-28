<template>

    <div>
        <!--Book modal-->
        <sweet-modal ref="modal" overlay-theme="dark" @close="reset">
            <!--Book for guest tab-->
            <sweet-modal-tab title="رزرو مهمان" id="tab-guest">
                <form class="kt-form" @submit.prevent="onGuestBookSubmit">
                    <div class="form-group">
                        <label>نام رزرو کننده را وارد کنید</label>
                        <input type="text" class="form-control" v-model="renterName">
                    </div>
                    <div class="form-group text-left">
                        <label class="kt-checkbox">
                            <input type="checkbox" @change="hasPartTime = !hasPartTime" :checked="hasPartTime">
                            تغییر ساعت
                            <span></span>
                        </label>
                    </div>
                    <div class="form-group" v-if="hasPartTime">
                        <label>ساعت شروع را وارد کنید</label>
                        <vue-timepicker
                                :disabled="endTime !== ''"
                                auto-scroll
                                hour-label="ساعت"
                                minute-label="دقیقه"
                                v-model="startTime"
                                input-class="form-control"
                                :minute-interval="15"
                                :minute-range="[15,30,45]"
                                :hour-range="[getValidCustomHour]"></vue-timepicker>
                        <span class="form-text text-muted pt-3">شما می توانید ساعت شروع رزرو را در اینجا تغییر دهید به عنوان مثال (16:30)</span>
                    </div>
                    <div class="form-group" v-if="hasPartTime">
                        <label>ساعت پایان را وارد کنید</label>
                        <vue-timepicker
                                :disabled="startTime !== ''"
                                auto-scroll
                                hour-label="ساعت"
                                minute-label="دقیقه"
                                v-model="endTime"
                                input-class="form-control"
                                :minute-interval="15"
                                :minute-range="[15,30,45]"
                                :hour-range="[getValidCustomHour]"></vue-timepicker>
                        <span class="form-text text-muted pt-3">شما می توانید ساعت پایان رزرو را در اینجا تغییر دهید به عنوان مثال (16:30)</span>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary">ذخیره</button>
                    </div>
                </form>
            </sweet-modal-tab>
            <!--/Book for guest tab-->
            <!--Book for coach tab-->
            <sweet-modal-tab title="رزرو مربی" id="tab-coach">
                <form class="kt-form" @submit.prevent="onCoachBookSubmit">
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
    import VueTimepicker from 'vue2-timepicker';

    export default {

        name: "booking-modal",

        components: {SweetModal, SweetModalTab, VueTimepicker},

        data() {
            return {
                renterName: '',
                coachName: '',
                bookedId: '',
                coaches: [],
                ownerId: '',
                startTime: '',
                endTime: '',
                hasPartTime: false,
                hasPartnerName: false,
                partnerName: '',
                date: '',
                hour: '',
                court: '',
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

                this.$refs.modal.open('tab-guest');
            })
        },

        methods: {

            book(name) {
                axios.post('/admin/bookings', {renter_name: name, ...this.getPostedData()}).then(res => {
                    this.triggerSuccessSubmitEvent(res);
                    toastr.success(res.data.msg);
                    this.$refs.modal.close();
                }).catch(err => Swal.showValidationMessage('خطایی رخ داده است'));
            },

            onGuestBookSubmit() {
                this.book(this.renterName);
            },


            onCoachBookSubmit() {
                this.book(this.coachName);
            },

            getCoaches() {
                axios.get('/admin/ajax/coaches').then(res => {
                    this.coaches = res.data;
                }).catch(err => toastr.warning('خطایی رخ داده است'));
            },

            triggerSuccessSubmitEvent(res) {
                Events.$emit(`on-success-booking-court-${this.court.id}-at-${this.hour}`, {
                    renterName: res.data.book.renter_name,
                    bookedId: res.data.book.id,
                    partnerName: res.data.book.partner_name,
                    startTime: res.data.book.start_time,
                    endTime: res.data.book.end_time,
                    isPartTime: res.data.book.is_part_time
                });
            },

            getPostedData() {
                return {
                    court_id: this.court.id,
                    date: this.date,
                    time: this.hour,
                    owner_id: this.ownerId,
                    partner_name: this.partnerName,
                    start_time: this.startTime,
                    end_time: this.endTime,
                    is_part_time: this.isPartTime(),
                }
            },

            reset() {
                this.renterName = '';
                this.hasPartTime = false;
                this.startTime = '';
                this.endTime = '';
                this.hasPartnerName = false;
                this.partnerName = '';
                this.ownerId = '';
                this.bookedId = '';
                this.coachName = '';
                this.hour = '';
                this.date = '';
                this.court = '';
            },

            isPartTime() {

                if (this.startTime || this.endTime) {
                    return true;
                }

                return false;
            }

        },

        watch: {
            ownerId: function (val) {
                this.coaches.forEach(coach => {
                    if (coach.id === val) {
                        this.coachName = coach.name;

                    }
                });
            }
        },

        computed: {

            getValidCustomHour: function () {
                let firstChar = this.hour.charAt(0);

                if (firstChar !== 0) {
                    return this.hour.slice(0, 2);
                } else {
                    return this.hour.slice(0, 1);
                }
            }
        },


    }
</script>

<style scoped>

</style>