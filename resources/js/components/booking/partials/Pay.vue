<template>

    <div class="alert alert-light alert-elevate row" role="alert">
        <div class="d-flex col-md-12 justify-content-between align-items-center">
            <p class="pt-3">{{label}}</p>
            <div>
                <button class="btn btn-primary btn-sm btn-elevate m-1" @click="showInput = !showInput">مبلغ دلخواه</button>
                <button class="btn btn-success btn-sm btn-elevate m-1"
                        v-on="{ click: isPartTime  ? payPartTimeBooked : pay }">
                    پرداخت شد
                </button>
            </div>
        </div>
        <div class="mt-3 col-md-12" v-if="showInput">
            <input type="text" class="form-control form-control-sm">
            <span class="form-text text-muted">مبلغ به صورت پیش فرض برابر با هزینه ی زمین است</span>
        </div>
    </div>

</template>

<script>

    import BaseComponent from './../BaseComponent';

    export default BaseComponent.extend({

        name: "pay.vue",

        props: ['label', 'isPartTime', 'booked', 'partTimeBooked', 'court', 'hour'],

        data() {
            return {
                showInput: false,
            }
        },

        methods: {

            pay() {
                let asyncRes = axios.patch(`/admin/bookings/${this.booked.id}/paid`).then(res => {
                    Events.$emit(`close-booking-modal`);
                    Events.$emit(`close-manage-booking-modal`);
                    Events.$emit(`on-success-booked-paid-court-${this.court.id}-at-${this.hour}`, {booked: res.data.booked});
                    toastr.success(res.data.msg);
                }).catch(err => toastr.warning('خطایی رخ داده'));
                this.redrawTblHeader(asyncRes);
            },

            payPartTimeBooked() {
                let asyncRes = axios.patch(`/admin/bookings/${this.partTimeBooked.id}/part-time/pay`).then(res => {
                    Events.$emit(`close-manage-booking-modal`);
                    Events.$emit(`on-success-part-time-booked-paid-court-${this.court.id}-at-${this.hour}`, {partTimeBooked: res.data.partTimeBooked});
                    toastr.success(res.data.msg);
                }).catch(err => toastr.warning('خطایی رخ داده'));
                this.redrawTblHeader(asyncRes);
            },

        }

    });

</script>

<style scoped>

</style>