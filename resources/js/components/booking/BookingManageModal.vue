<template>

    <div>

        <sweet-modal ref="modal" overlay-theme="dark" @close="onCloseModal">

            <info v-if="hour || court" :hour="hour" :court-name="court.name"></info>

            <sweet-modal-tab title="پرداخت" id="tab-pay">

                <h4 v-if="isAlreadyPaid" class="text-success">پرداخت شده</h4>

                <div v-if="showPay">
                    <pay v-if="booked && !booked.is_paid"
                         :booked="booked"
                         :court="court"
                         :hour="hour"
                         :is-part-time="false">
                    </pay>

                    <pay v-if="partTimeBooked && !partTimeBooked.is_paid"
                         :part-time-booked="partTimeBooked"
                         :court="court"
                         :hour="hour"
                         :is-part-time="true">
                    </pay>
                </div>

            </sweet-modal-tab>

            <sweet-modal-tab title="کنسل" id="tab-cancel">

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


                <div v-if="partTimeBooked && !partTimeBooked.is_canceled">
                    <div class="alert alert-elevate alert-light d-flex justify-content-between align-items-center"
                         role="alert">
                        <div>
                            {{showPartTimeBookedCancelLabel}}
                        </div>
                        <button class="btn btn-danger btn-sm" @click="handlePartTimeCancel">
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

        <!--Part Time-->

        <sweet-modal overlay-theme="dark" ref="chargeCreditorPartTimeModal">

            <h4>آیا می خواهید هزینه را به رزرو کننده برگردانید؟</h4>
            <div class="mt-3">
                <button class="btn btn-success" @click="cancelPartTime({chargeCreditor: 1})">بله</button>
                <button class="btn btn-danger" @click="cancelPartTime">خیر</button>
            </div>

        </sweet-modal>

        <sweet-modal overlay-theme="dark" ref="chargeDebtorPartTimeModal">

            <h2 class="text-danger">تایم کنسلی گذشته است!</h2>
            <h4> آیا می خواهید هزینه را از رزرو کننده بگیرید؟</h4>
            <div class="mt-3">
                <button class="btn btn-success" @click="cancelPartTime({chargeDebtor: 1})">بله</button>
                <button class="btn btn-danger" @click="cancelPartTime">خیر</button>
            </div>

        </sweet-modal>

    </div>
</template>

<script>

    import {SweetModal, SweetModalTab} from 'sweet-modal-vue';
    import helper from './../../mixins/helper';

    export default {

        name: "booking-manage-modal",

        mixins: [helper],

        components: {
            SweetModal,
            SweetModalTab,
            Info: () => import('./partials/Info'),
            Pay: () => import('./partials/Pay'),
        },

        data() {
            return {
                booked: '',
                partTimeBooked: '',
                hour: '',
                date: '',
                court: '',
                showPay: false,
            }
        },

        mounted() {

            Events.$on('open-manage-booking-modal', (data) => {
                this.court = data.court;
                this.hour = data.hour;
                this.date = data.date;
                this.booked = data.booked;
                this.partTimeBooked = data.partTimeBooked;
                this.showPay = true;
                this.$refs.modal.open('tab-pay');
            });

            Events.$on(`close-manage-booking-modal`, () => {
                this.$refs.modal.close();
            });

        },

        methods: {

            cancel(params = null) {


                let asyncRes = axios.patch(`/admin/bookings/${this.booked.id}/cancel`, null, {params: params}).then(res => {
                    Events.$emit(`on-success-booked-cancel-court-${this.court.id}-at-${this.hour}`, {booked: res.data.booked});
                    this.$refs.chargeCreditorModal.close();
                    this.$refs.chargeDebtorModal.close();
                    Events.$emit(`close-manage-booking-modal`);
                    toastr.success(res.data.msg);
                }).catch(err => toastError());
                this.redrawTblHeader(asyncRes);
            },

            cancelPartTime(params = null) {

                let asyncRes = axios.patch(`/admin/bookings/${this.partTimeBooked.id}/part-time/cancel`, null, {params: params}).then(res => {
                    Events.$emit(`on-success-part-time-booked-cancel-court-${this.court.id}-at-${this.hour}`, {partTimeBooked: res.data.partTimeBooked});
                    this.$refs.chargeDebtorPartTimeModal();
                    this.$refs.chargeCreditorPartTimeModal();
                    Events.$emit(`close-manage-booking-modal`);
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

            checkIsValidTimeForPartTimeCanceling() {
                axios.get(`/admin/bookings/part-time/${this.partTimeBooked.id}/cancel/is-valid-time`).then(res => {
                    if (res.data.isValidTime) {
                        this.cancelPartTime();
                    } else {
                        this.$refs.chargeDebtorPartTimeModal.open();
                    }
                }).catch(err => toastError());
            },

            onCloseModal() {
                this.showPay = false;
            },

            handleCancel() {

                if (this.booked.is_paid) {

                    this.$refs.chargeCreditorModal.open();

                } else {

                    this.checkIsValidTimeForCanceling();

                }

            },

            handlePartTimeCancel() {

                if (this.partTimeBooked.is_paid) {

                    this.$refs.chargeCreditorPartTimeModal.open();

                } else {

                    this.checkIsValidTimeForPartTimeCanceling();

                }

            },


        },

        computed: {

            isAlreadyPaid() {

                if (this.partTimeBooked && this.partTimeBooked.is_paid && this.booked.is_paid) {

                    return true;
                }

                if (this.partTimeBooked && !this.partTimeBooked.is_paid && this.booked.is_paid) {

                    return false;
                }

                if (this.booked.is_paid) {
                    return true;
                }

                return false;
            },

            showBookedCancelLabel: function () {

                if (this.booked) {
                    return `آیا می خواهید رزرو را برای ${this.booked.renter_name} کنسل کنید؟`;
                }

            },

            showPartTimeBookedCancelLabel: function () {
                return `آیا می خواهید رزرو را برای ${this.partTimeBooked.renter_name} کنسل کنید؟`;
            },


        },

    }
</script>

<style scoped>

</style>