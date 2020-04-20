<template>
    <div class="alert alert-elevate alert-light d-flex justify-content-between align-items-center"
         role="alert">
        <div>
            {{partTimeBooked ? showPartTimeBookedCancelLabel : showBookedCancelLabel}}
        </div>
        <!--<button class="btn btn-danger btn-sm" v-on="{ click: isPartTime  ? handleCancelPartTimeBooked : handleCancel }">-->
        <button class="btn btn-danger btn-sm" @click="handleCancel">
            کنسل
            کن
        </button>
    </div>
</template>

<script>

    import helper from './../../../mixins/helper';

    export default {

        name: "cancel",

        mixins: [helper],

        props: ['isManage', 'booked', 'partTimeBooked', 'hour', 'court'],

        mounted() {

            if (this.booked) {

                if (this.isManage) {

                    Events.$on(`charge-debtor-with-booked-id-${this.booked.id}`, () => {
                        console.log('Charge Debtor');
                    });

                    Events.$on(`do-not-charge-debtor-with-booked-id-${this.booked.id}`, () => {
                        console.log('Called');
                        this.cancel();
                    });

                    Events.$on(`charge-creditor-with-booked-id-${this.booked.id}`, () => {
                        console.log('Charge creditor');
                    });

                    Events.$on(`do-not-charge-creditor-with-booked-id-${this.booked.id}`, () => {
                        this.cancel();
                    });

                } else {

                    Events.$on(`charge-debtor-with-booked-id-${this.booked.id}-in-booking-modal`, () => {
                        console.log('Charge Debtor');
                    });

                    Events.$on(`do-not-charge-debtor-with-booked-id-${this.booked.id}-in-booking-modal`, () => {
                        console.log('Called');
                        this.cancel();
                    });

                    Events.$on(`charge-creditor-with-booked-id-${this.booked.id}-in-booking-modal`, () => {
                        console.log('Charge creditor');
                    });

                    Events.$on(`do-not-charge-creditor-with-booked-id-${this.booked.id}-in-booking-modal`, () => {
                        this.cancel();
                    });

                }

            } else {

                Events.$on(`pt-charge-debtor-with-booked-id-${this.partTimeBooked.id}`, () => {
                    console.log('PT charge Debtor');
                });

                Events.$on(`pt-do-not-charge-debtor-with-booked-id-${this.partTimeBooked.id}`, () => {
                    this.cancelPartTimeBooked();
                });

                Events.$on(`pt-charge-creditor-with-booked-id-${this.partTimeBooked.id}`, () => {
                    console.log('PT charge creditor');
                });

                Events.$on(`pt-do-not-charge-creditor-with-booked-id-${this.partTimeBooked.id}`, () => {
                    this.cancelPartTimeBooked();
                });

            }


        },

        methods: {

            handleCancel() {

                if (this.booked) {

                    if (this.booked.is_paid) {
                        this.emitCreditorEvents();
                    } else {
                        this.checkIsValidTimeForCanceling();
                    }


                } else {

                    if (this.partTimeBooked.is_paid) {
                        this.emitCreditorPTEvents();
                    } else {
                        this.checkIsValidTimeForCancelingPartTime();
                    }

                }

            },

            cancel(params = null) {
                let asyncRes = axios.patch(`/admin/bookings/${this.booked.id}/cancel`, {params}).then(res => {
                    this.closeAllModal();
                    Events.$emit(`on-success-booked-cancel-court-${this.court.id}-at-${this.hour}`, {booked: res.data.booked});
                    toastr.success(res.data.msg);
                }).catch(err => toastError());
                this.redrawTblHeader(asyncRes);
            },

            cancelPartTimeBooked(params = null) {
                let asyncRes = axios.patch(`/admin/bookings/${this.partTimeBooked.id}/part-time/cancel`, {params}).then(res => {
                    this.closeAllModal();
                    Events.$emit(`on-success-part-time-booked-cancel-court-${this.court.id}-at-${this.hour}`, {partTimeBooked: res.data.partTimeBooked});
                    toastr.success(res.data.msg);
                }).catch(err => toastError());
                this.redrawTblHeader(asyncRes);
            },

            checkIsValidTimeForCanceling() {

                axios.get(`/admin/bookings/${this.booked.id}/cancel/is-valid-time`).then(res => {
                    if (res.data.isValidTime) {
                        this.cancel();
                    } else {
                        this.emitDebtorEvents();
                    }
                }).catch(err => toastError());

            },

            checkIsValidTimeForCancelingPartTime() {
                axios.get(`/admin/bookings/part-time/${this.partTimeBooked.id}/cancel/is-valid-time`).then(res => {
                    if (res.data.isValidTime) {
                        this.cancelPartTimeBooked();
                    } else {
                        this.emitDebtorPTEvents();

                    }
                }).catch(err => toastError());
            },

            emitCreditorEvents() {

                if (!this.isManage) {
                    Events.$emit('open-charge-creditor-modal', {cancelId: this.booked.id});
                } else {
                    Events.$emit('open-manage-charge-creditor-modal', {cancelId: this.booked.id});
                }

            },

            emitDebtorEvents() {

                if (!this.isManage) {
                    Events.$emit('open-charge-debtor-modal', {cancelId: this.booked.id});
                } else {
                    Events.$emit('open-manage-charge-debtor-modal', {cancelId: this.booked.id});
                }

            },

            emitCreditorPTEvents() {

                if (!this.isManage) {
                    Events.$emit('open-charge-creditor-pt-modal', {PTCancelId: this.partTimeBooked.id});
                } else {
                    Events.$emit('open-manage-charge-creditor-pt-modal', {PTCancelId: this.partTimeBooked.id});
                }

            },

            emitDebtorPTEvents() {

                if (!this.isManage) {
                    Events.$emit('open-charge-debtor-pt-modal', {PTCancelId: this.partTimeBooked.id});
                } else {
                    Events.$emit('open-manage-charge-debtor-pt-modal', {PTCancelId: this.partTimeBooked.id});
                }

            },

        },

        computed: {

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