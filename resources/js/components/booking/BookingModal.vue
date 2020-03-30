<template>

    <div>

        <!--Book modal-->
        <sweet-modal ref="modal" overlay-theme="dark" @close="reset">

            <!--Book for guest tab-->
            <sweet-modal-tab title="رزرو مهمان" id="tab-guest">

                <part-time-booking-alert :booked="booked" :empty-time="emptyTime"></part-time-booking-alert>

                <form class="kt-form" @submit.prevent="onGuestBookSubmit">
                    <div class="form-group">
                        <label>نام رزرو کننده را وارد کنید</label>
                        <input type="text" class="form-control" v-model="renterName">
                    </div>

                    <part-time-input-hours
                            :booked="booked"
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

                <part-time-booking-alert :booked="booked" :empty-time="emptyTime"></part-time-booking-alert>

                <form class="kt-form" @submit.prevent="onCoachBookSubmit">
                    <div class="form-group">
                        <label>مربی مورد نظر را انتخاب کنید</label>
                        <select v-model="ownerId" class="form-control">
                            <option v-for="coach in coaches" :value="coach.id">{{coach.name}}</option>
                        </select>
                    </div>

                    <part-time-input-hours
                            :booked="booked"
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

            <sweet-modal-tab :disabled="!hasPartTimeManageTab"
                             :title="hasPartTimeManageTab ? 'مدیریت رزرو' : ''"
                             id="part-time-manage-tab">
                <button class="btn btn-danger" @click="cancel">کنسل</button>
                <button class="btn btn-success" @click="paid">هزینه پرداخت شد</button>
            </sweet-modal-tab>

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
                coaches: [],
                booked: null,
                date: '',
                hour: '',
                court: '',
                renterName: '',
                coachName: '',
                ownerId: '',
                startTime: '',
                endTime: '',
                partnerName: '',
                emptyTime: '',
                isPartTime: '',
                remainPartTime: '',
                hasPartTimeManageTab: false,
                hasPartTime: false,
                hasPartnerName: false,
                url: '/admin/bookings',
            }
        },

        created() {
            this.getCoaches();
        },

        mounted() {

            Events.$on('open-booking-modal', (data) => {

                console.log(data);

                this.court = data.court;
                this.hour = data.hour;
                this.date = data.date;
                this.emptyTime = data.emptyTime;
                this.booked = data.booked;
                this.hasPartTimeManageTab = data.hasPartTimeManageTab;

                if (data.booked) {
                    this.remainPartTime = data.booked.start_time ? data.hour : data.booked.end_time;
                }

                this.$refs.modal.open('tab-guest');
            })
        },

        methods: {

            book(name) {


                if (this.booked) {

                    this.url = `/admin/bookings/${this.booked.id}/part-time`;

                }

                axios.post(this.url, {renter_name: name, ...this.getPostedData()}).then(res => {
                    this.booked ? this.triggerSuccessSubmitEventOnPartTimeBooking(res) : this.triggerSuccessSubmitEvents(res);
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
                    booked: res.data.book,
                });
                Events.$emit('reset-part-time-hours');
            },

            triggerSuccessSubmitEventOnPartTimeBooking(res) {
                Events.$emit(`on-success-booking-part-time-court-${this.court.id}-at-${this.hour}`, {
                    partTimeBooked: res.data.book,
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
                this.hasPartTimeManageTab = false;
                this.url = '/admin/bookings'
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
                    this.endTime = '';
                } else {
                    this.endTime = data.endTime;
                    this.startTime = '';
                }

            },

            cancel() {
                axios.patch(`/admin/bookings/${this.booked.id}/cancel`).then(res => {
                    Events.$emit(`on-success-cancel-booking-court-${this.court.id}-at-${this.hour}`);
                    toastr.success(res.data.msg);
                    this.$refs.modal.close();
                }).catch(err => toastr.warning('خطایی رخ داده'));
            },

            paid() {
                axios.patch(`/admin/bookings/${this.booked.id}/paid`).then(res => {
                    Events.$emit(`on-success-paid-booking-court-${this.court.id}-at-${this.hour}`);
                    this.$refs.modal.close();
                    toastr.success(res.data.msg);
                }).catch(err => toastr.warning('خطایی رخ داده'));
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