<template>
    <div class="alert alert-elevate alert-light d-flex justify-content-between align-items-center"
         role="alert">
        <div>
            {{isPartTime ? showPartTimeBookedCancelLabel : showBookedCancelLabel}}
        </div>
        <button class="btn btn-danger btn-sm" v-on="{ click: isPartTime  ? cancelPartTimeBooked : cancel }">کنسل کن
        </button>
    </div>
</template>

<script>

    import helper from './../../../mixins/helper';

    export default {

        name: "cancel",

        mixins: [helper],

        props: ['label', 'isPartTime', 'booked', 'partTimeBooked', 'hour', 'court'],

        methods: {

            cancel() {
                let asyncRes = axios.patch(`/admin/bookings/${this.booked.id}/cancel`).then(res => {
                    Events.$emit(`close-booking-modal`);
                    Events.$emit(`close-manage-booking-modal`);
                    Events.$emit(`on-success-booked-cancel-court-${this.court.id}-at-${this.hour}`, {booked: res.data.booked});
                    toastr.success(res.data.msg);
                }).catch(err => toastr.warning('خطایی رخ داده'));
                this.redrawTblHeader(asyncRes);
            },

            cancelPartTimeBooked() {
                let asyncRes = axios.delete(`/admin/bookings/${this.partTimeBooked.id}/part-time/cancel`).then(res => {
                    Events.$emit(`close-manage-booking-modal`);
                    Events.$emit(`on-success-part-time-booked-cancel-court-${this.court.id}-at-${this.hour}`, {partTimeBooked: res.data.partTimeBooked});
                    toastr.success(res.data.msg);
                }).catch(err => toastr.warning('خطایی رخ داده'));
                this.redrawTblHeader(asyncRes);
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