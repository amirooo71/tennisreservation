<template>

    <div>
        <!--Book modal-->
        <sweet-modal ref="modal" overlay-theme="dark" @close="reset">
            <!--Book for guest tab-->
            <sweet-modal-tab title="رزرو مهمان" id="tab-guest">

                <part-time-booking-alert :is-part-time="isPartTime" :empty-time="emptyTime"></part-time-booking-alert>

                <form class="kt-form" @submit.prevent="onGuestBookSubmit">
                    <div class="form-group">
                        <label>نام رزرو کننده را وارد کنید</label>
                        <input type="text" class="form-control" v-model="renterName">
                    </div>

                    <part-time-input-hours
                            :is-part-time="isPartTime"
                            :end-time="endTime"
                            :start-time="startTime"
                            :hour="hour"
                            @timeChanged="onTimeChanged"
                    ></part-time-input-hours>

                    <div class="form-group">
                        <button class="btn btn-primary">ذخیره</button>
                    </div>
                </form>
            </sweet-modal-tab>
            <!--/Book for guest tab-->
            <!--Book for coach tab-->
            <sweet-modal-tab title="رزرو مربی" id="tab-coach">

                <part-time-booking-alert :is-part-time="isPartTime" :empty-time="emptyTime"></part-time-booking-alert>

                <form class="kt-form" @submit.prevent="onCoachBookSubmit">
                    <div class="form-group">
                        <label>مربی مورد نظر را انتخاب کنید</label>
                        <select v-model="ownerId" class="form-control">
                            <option v-for="coach in coaches" :value="coach.id">{{coach.name}}</option>
                        </select>
                    </div>

                    <part-time-input-hours
                            :is-part-time="isPartTime"
                            :end-time="endTime"
                            :start-time="startTime"
                            :hour="hour"
                            @timeChanged="onTimeChanged"
                    ></part-time-input-hours>

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
    import PartTimeBookingAlert from './partials/PartTimeBookingAlert';
    import PartTimeInputHours from './partials/PartTimeInputHours';

    export default {

        name: "booking-modal",

        components: {
            SweetModal,
            SweetModalTab,
            PartTimeBookingAlert,
            PartTimeInputHours
        },

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
                emptyTime: '',
                isPartTime: '',
                remainPartTime: '',
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
                this.emptyTime = data.emptyTime;
                this.isPartTime = data.isPartTime;
                this.bookedId = data.bookedId;
                this.remainPartTime = data.startTime ? data.hour : data.endTime;

                this.$refs.modal.open('tab-guest');
            })
        },

        methods: {

            book(name) {

                let url;

                if (this.isPartTime) {
                    url = `/admin/bookings/${this.bookedId}/part-time`;
                } else {
                    url = `/admin/bookings`;
                }

                axios.post(url, {renter_name: name, ...this.getPostedData()}).then(res => {
                    this.isPartTime ? this.triggerSuccessSubmitEventOnPartTimeBooking(res) : this.triggerSuccessSubmitEvents(res);
                    toastr.success(res.data.msg);
                    this.$refs.modal.close();
                }).catch(err => toastr.warning('خطایی رخ داده است'));
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

            triggerSuccessSubmitEvents(res) {
                Events.$emit(`on-success-booking-court-${this.court.id}-at-${this.hour}`, {
                    renterName: res.data.book.renter_name,
                    bookedId: res.data.book.id,
                    partnerName: res.data.book.partner_name,
                    startTime: res.data.book.start_time,
                    endTime: res.data.book.end_time,
                    isPartTime: res.data.book.is_part_time
                });
                Events.$emit('reset-part-time-hours');
            },

            triggerSuccessSubmitEventOnPartTimeBooking(res) {
                Events.$emit(`on-success-booking-part-time-court-${this.court.id}-at-${this.hour}`, {
                    partTimeDetail: res.data.book,
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
                    is_part_time: this.isPartTimeBook(),
                    remain_time: this.remainPartTime,
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
                this.emptyTime = '';
                this.isPartTime = '';
                this.remainPartTime = '';
            },

            isPartTimeBook() {

                if (this.startTime || this.endTime) {
                    return true;
                }

                return false;
            },

            onTimeChanged(data) {

                if (data.startTime) {
                    this.startTime = data.startTime;
                } else {
                    this.endTime = data.endTime;
                }

            },

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


    }
</script>

<style scoped>

</style>