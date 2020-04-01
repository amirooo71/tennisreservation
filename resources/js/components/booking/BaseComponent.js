export default Vue.extend({

    methods: {

        cancel() {
            axios.patch(`/admin/bookings/${this.booked.id}/cancel`).then(res => {
                Events.$emit(`on-success-booked-cancel-court-${this.court.id}-at-${this.hour}`, {booked: res.data.booked});
                toastr.success(res.data.msg);
                this.$refs.modal.close();
            }).catch(err => toastr.warning('خطایی رخ داده'));
        },

        pay() {
            axios.patch(`/admin/bookings/${this.booked.id}/paid`).then(res => {
                Events.$emit(`on-success-booked-paid-court-${this.court.id}-at-${this.hour}`, {booked: res.data.booked});
                this.$refs.modal.close();
                toastr.success(res.data.msg);
            }).catch(err => toastr.warning('خطایی رخ داده'));
        },

    }

});