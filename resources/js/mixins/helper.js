export default {

    methods: {

        formatTime(time, format = 'HH:mm') {
            return moment(time, 'HH:mm').format(format);
        },

        redrawTblHeader(asyncFn) {
            asyncFn.then(() => {
                table.columns.adjust().fixedColumns().relayout();
            });
        },

        closeAllModal() {
            Events.$emit(`close-booking-modal`);
            Events.$emit(`close-manage-booking-modal`);
            Events.$emit('close-charge-debtor-modal');
            Events.$emit('close-charge-creditor-modal');
            Events.$emit('close-manage-charge-debtor-modal');
            Events.$emit('close-manage-charge-creditor-modal');
            Events.$emit('close-manage-charge-debtor-pt-modal');
            Events.$emit('close-manage-charge-creditor-pt-modal');
        },

        //Booking modal
        
        chargeDebtorInBookingModal() {
            Events.$emit(`charge-debtor-with-booked-id-${this.cancelId}-in-booking-modal`);
        },

        doNotChargeDebtorInBookingModal() {
            Events.$emit(`do-not-charge-debtor-with-booked-id-${this.cancelId}-in-booking-modal`);
        },

        chargeCreditorInBookingModal() {
            Events.$emit(`charge-creditor-with-booked-id-${this.cancelId}-in-booking-modal`);
        },

        doNotChargeCreditorInBookingModal() {
            Events.$emit(`do-not-charge-creditor-with-booked-id-${this.cancelId}-in-booking-modal`);
        },

        // Manage modal
        chargeDebtor() {
            Events.$emit(`charge-debtor-with-booked-id-${this.cancelId}`);
        },

        doNotChargeDebtor() {
            Events.$emit(`do-not-charge-debtor-with-booked-id-${this.cancelId}`);
        },

        chargeCreditor() {
            Events.$emit(`charge-creditor-with-booked-id-${this.cancelId}`);
        },

        doNotChargeCreditor() {
            Events.$emit(`do-not-charge-creditor-with-booked-id-${this.cancelId}`);
        },

        //Part Time

        chargeDebtorPT() {
            Events.$emit(`pt-charge-debtor-with-booked-id-${this.PTCancelId}`);
        },

        doNotChargeDebtorPT() {
            Events.$emit(`pt-do-not-charge-debtor-with-booked-id-${this.PTCancelId}`);
        },

        chargeCreditorPT() {
            Events.$emit(`pt-charge-creditor-with-booked-id-${this.PTCancelId}`);
        },

        doNotChargeCreditorPT() {
            Events.$emit(`pt-do-not-charge-creditor-with-booked-id-${this.PTCancelId}`);
        }

    }


}