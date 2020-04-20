<template>

    <div class="alert alert-light alert-elevate row p-2" role="alert">
        <div class="d-flex col-md-12 justify-content-between align-items-center">
            <p class="pt-3">{{isPartTime ? showPartTimeBookedPayLabel : showBookedPayLabel}}</p>
            <div>
                <button class="btn btn-success btn-sm btn-elevate m-1"
                        v-on="{ click: isPartTime  ? payPartTimeBooked : pay }">
                    پرداخت شد
                </button>
            </div>
        </div>
        <div class="mt-3 col-md-12">
            <input v-model="price" type="number" class="form-control form-control-sm">
            <span class="form-text text-muted">مبلغ به صورت پیش فرض برابر با هزینه ی زمین است</span>
        </div>
    </div>

</template>

<script>

    import helper from './../../../mixins/helper';

    export default {

        name: "pay.vue",

        mixins: [helper],

        props: ['label', 'isPartTime', 'booked', 'partTimeBooked', 'court', 'hour'],

        data() {
            return {
                showInput: false,
                price: '',
            }
        },


        mounted() {

            let multipy = {
                '15': 1,
                '30': 2,
                '45': 3,
                '60': 4
            };

            if (this.isPartTime) {
                this.price = (this.court.price * multipy[this.partTimeBooked.duration]) / 4;
            } else {
                this.price = (this.court.price * multipy[this.booked.duration]) / 4;
            }

        },

        methods: {

            pay() {
                let asyncRes = axios.patch(`/admin/bookings/${this.booked.id}/pay`, {price: this.price}).then(res => {
                    Events.$emit(`close-booking-modal`);
                    Events.$emit(`close-manage-booking-modal`);
                    Events.$emit(`on-success-booked-paid-court-${this.court.id}-at-${this.hour}`, {booked: res.data.booked});
                    toastr.success(res.data.msg);
                }).catch(err => toastr.warning('خطایی رخ داده'));
                this.redrawTblHeader(asyncRes);
            },

            payPartTimeBooked() {
                let asyncRes = axios.patch(`/admin/bookings/${this.partTimeBooked.id}/part-time/pay`, {price: this.price}).then(res => {
                    Events.$emit(`close-manage-booking-modal`);
                    Events.$emit(`on-success-part-time-booked-paid-court-${this.court.id}-at-${this.hour}`, {partTimeBooked: res.data.partTimeBooked});
                    toastr.success(res.data.msg);
                }).catch(err => toastr.warning('خطایی رخ داده'));
                this.redrawTblHeader(asyncRes);
            },
        },


        computed: {

            showBookedPayLabel: function () {

                if (this.booked) {

                    return `${this.booked.renter_name} مبلغ ${this.price} تومان بدهکار است`;

                }

            },

            showPartTimeBookedPayLabel: function () {
                return `${this.partTimeBooked.renter_name} مبلغ ${this.price} تومان بدهکار است`;
            },

        }

    }

</script>

<style scoped>

</style>