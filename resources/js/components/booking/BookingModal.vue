<template>

    <div>

        <!--Book modal-->
        <sweet-modal ref="modal" overlay-theme="dark" @close="reset">

            <info v-if="hour || court" :hour="hour" :court-name="court.name"></info>

            <!--Book for guest tab-->
            <sweet-modal-tab title="رزرو مهمان" id="tab-guest">

                <part-time-booking-alert v-if="booked"
                                         :booked="booked"
                                         :empty-time="emptyTime">
                </part-time-booking-alert>

                <form class="kt-form" @submit.prevent="onGuestBookSubmit">
                    <div class="form-group text-left">
                        <label>نام رزرو کننده را وارد کنید</label>
                        <input type="text" class="form-control" v-model="renterName">
                    </div>

                    <part-time-input-hours
                            v-if="!booked"
                            :booked="booked"
                            :hour="hour"
                            @timeChanged="onTimeChanged">
                    </part-time-input-hours>

                    <div class="form-group">
                        <button class="btn btn-primary">ذخیره</button>
                    </div>

                </form>
            </sweet-modal-tab>
            <!--/Book for guest tab-->
            <!--Book for coach tab-->
            <sweet-modal-tab title="رزرو مربی" id="tab-coach">

                <part-time-booking-alert v-if="booked"
                                         :booked="booked"
                                         :empty-time="emptyTime">
                </part-time-booking-alert>

                <form class="kt-form" @submit.prevent="onCoachBookSubmit">
                    <div class="form-group text-left">
                        <label>مربی مورد نظر را انتخاب کنید</label>
                        <select v-model="coachId" class="form-control">
                            <option v-for="coach in coaches" :value="coach.id">{{coach.first_name}}</option>
                        </select>
                    </div>

                    <part-time-input-hours
                            v-if="!booked"
                            :booked="booked"
                            :hour="hour"
                            @timeChanged="onTimeChanged">
                    </part-time-input-hours>

                    <div class="form-group text-left">
                        <label class="kt-checkbox">
                            <input type="checkbox" @change="hasPartnerName = !hasPartnerName" :checked="hasPartnerName">
                            نام
                            شاگرد
                            <span></span>
                        </label>
                    </div>

                    <div class="form-group text-left" v-if="hasPartnerName">
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

                <div v-if="showPay">
                    <pay v-if="booked && !booked.is_paid"
                         :booked="booked"
                         :court="court"
                         :hour="hour">
                    </pay>
                </div>

                <div v-if="booked && !booked.is_canceled">
                    <div class="alert alert-elevate alert-light d-flex justify-content-between align-items-center"
                         role="alert">
                        <div>
                            {{showBookedCancelLabel}}
                        </div>
                        <button class="btn btn-danger btn-sm" @click="handleCancel">
                            کنسل
                            کن
                        </button>
                    </div>
                </div>

            </sweet-modal-tab>

        </sweet-modal>

        <sweet-modal overlay-theme="dark" ref="chargeCreditorModal">

            <h4>آیا می خواهید هزینه را به رزرو کننده برگردانید؟</h4>
            <div class="mt-3">
                <button class="btn btn-success" @click="cancel({chargeCreditor: 1})">بله</button>
                <button class="btn btn-danger" @click="cancel">خیر</button>
            </div>

        </sweet-modal>

        <sweet-modal overlay-theme="dark" ref="chargeDebtorModal">

            <h2 class="text-danger">تایم کنسلی گذشته است!</h2>
            <h4> آیا می خواهید هزینه را از رزرو کننده بگیرید؟</h4>
            <div class="mt-3">
                <button class="btn btn-success" @click="cancel({chargeDebtor: 1})">بله</button>
                <button class="btn btn-danger" @click="cancel">خیر</button>
            </div>

        </sweet-modal>

    </div>

</template>

<script>

    import {SweetModal, SweetModalTab} from 'sweet-modal-vue';
    import helper from './../../mixins/helper';

    export default {

        name: "booking-modal",

        mixins: [helper],

        components: {
            SweetModal,
            SweetModalTab,
            PartTimeBookingAlert: () => import('./partials/PartTimeBookingAlert'),
            PartTimeInputHours: () => import('./partials/PartTimeInputHours'),
            Info: () => import('./partials/Info'),
            Pay: () => import('./partials/Pay'),
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
                coachId: '',
                startTime: '',
                endTime: '',
                partnerName: '',
                emptyTime: '',
                isPartTime: '',
                partTimeStartAt: '',
                hasPartTimeManageTab: false,
                hasPartnerName: false,
                url: '/admin/bookings',
                duration: '',
                showPay: false,
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
                this.booked = data.booked;
                this.hasPartTimeManageTab = data.hasPartTimeManageTab;

                if (data.booked) {
                    this.partTimeStartAt = data.booked.start_time ? data.hour : data.booked.end_time;
                }

                this.showPay = true;

                this.$refs.modal.open('tab-guest');
            });


            Events.$on('close-booking-modal', () => {
                this.$refs.modal.close();
            });

        },

        methods: {

            book(name) {

                if (this.booked) {

                    this.url = `/admin/bookings/${this.booked.id}/part-time`;

                }

                let asyncRes = axios.post(this.url, {renter_name: name, ...this.getPostedData()}).then(res => {
                    this.booked ? this.triggerSuccessSubmitEventOnPartTimeBooking(res) : this.triggerSuccessSubmitEvents(res);
                    toastr.success(res.data.msg);
                    this.$refs.modal.close();
                }).catch(err => toastError((err.response.data.msg)));

                this.redrawTblHeader(asyncRes);
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
                Events.$emit(`on-success-booking-court-${this.court.id}-at-${this.hour}`, {booked: res.data.book,});
                Events.$emit('reset-part-time-hours');
            },

            triggerSuccessSubmitEventOnPartTimeBooking(res) {
                Events.$emit(`on-success-booking-part-time-court-${this.court.id}-at-${this.hour}`, {partTimeBooked: res.data.book,});
            },

            getPostedData() {
                return {
                    court_id: this.court.id,
                    date: this.date,
                    time: this.hour,
                    coach_id: this.coachId,
                    partner_name: this.partnerName,
                    start_time: this.startTime,
                    end_time: this.endTime,
                    is_part_time: this.isPartTimeBook(),
                    start_at: this.partTimeStartAt,
                    duration: this.duration ? this.duration : 60,
                }
            },

            reset() {
                this.renterName = '';
                this.startTime = '';
                this.endTime = '';
                this.hasPartnerName = false;
                this.partnerName = '';
                this.coachId = '';
                this.bookedId = '';
                this.coachName = '';
                this.hour = '';
                this.date = '';
                this.court = '';
                this.emptyTime = '';
                this.isPartTime = '';
                this.partTimeStartAt = '';
                this.hasPartTimeManageTab = false;
                this.url = '/admin/bookings';
                this.duration = '';
                this.showPay = false;
                Events.$emit('reset-part-time-hours');
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

                this.duration = data.duration;

            },

            handleCancel() {

                if (this.booked.is_paid) {

                    this.$refs.chargeCreditorModal.open();

                } else {

                    this.checkIsValidTimeForCanceling();

                }

            },

            cancel(params = {}) {
                let asyncRes = axios.patch(`/admin/bookings/${this.booked.id}/cancel`, null, {params: params}).then(res => {
                    Events.$emit(`on-success-booked-cancel-court-${this.court.id}-at-${this.hour}`, {booked: res.data.booked});
                    this.$refs.chargeCreditorModal.close();
                    this.$refs.chargeDebtorModal.close();
                    Events.$emit(`close-booking-modal`);
                    toastr.success(res.data.msg);
                }).catch(err => toastError());
                this.redrawTblHeader(asyncRes);
            },

            checkIsValidTimeForCanceling() {

                axios.get(`/admin/bookings/${this.booked.id}/cancel/is-valid-time`).then(res => {
                    if (res.data.isValidTime) {
                        this.cancel();
                    } else {
                        this.$refs.chargeDebtorModal.open();
                    }
                }).catch(err => toastError());

            },

        },

        watch: {

            coachId: function (val) {
                this.coaches.forEach(coach => {
                    if (coach.id === val) {
                        this.coachName = coach.first_name + ' ' + coach.last_name;
                    }
                });
            },

        },


        computed: {

            showBookedCancelLabel: function () {

                if (this.booked) {
                    return `آیا می خواهید رزرو را برای ${this.booked.renter_name} کنسل کنید؟`;
                }

            },
        }


    }

</script>

<style scoped>

</style>