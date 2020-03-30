<template>
    <!--Manage book modal-->
    <sweet-modal ref="modal" overlay-theme="dark">


        <sweet-modal-tab title="پرداخت" id="tab-pay">

            <div v-if="booked.is_paid && partTimeBooked && partTimeBooked.is_paid">
                پرداخت شده است
            </div>
            <div>
                <div class="row" v-if="!booked.is_paid">
                    <div class="col">
                        <div class="alert alert-elevate alert-light d-flex justify-content-between align-items-center"
                             role="alert">
                            <div>
                                {{showBookedPayLabel}}
                            </div>
                            <button class="btn btn-success btn-sm" @click="payBooked">پرداخت شد</button>
                        </div>
                    </div>
                </div>

                <div class="row" v-if="partTimeBooked && !partTimeBooked.is_paid">
                    <div class="col">
                        <div class="alert alert-elevate alert-light d-flex justify-content-between align-items-center"
                             role="alert">
                            <div>
                                {{showPartTimeBookedPayLabel}}
                            </div>
                            <button class="btn btn-success btn-sm" @click="payPartTimeBooked">پرداخت شد</button>
                        </div>
                    </div>
                </div>
            </div>


        </sweet-modal-tab>


        <sweet-modal-tab title="کنسل" id="tab-cancel">

            <div>
                <div class="row" v-if="!booked.is_canceled">
                    <div class="col">
                        <div class="alert alert-elevate alert-light d-flex justify-content-between align-items-center"
                             role="alert">
                            <div>
                                {{showBookedPayLabel}}
                            </div>
                            <button class="btn btn-danger btn-sm" @click="cancelBooked">کنسل کنید</button>
                        </div>
                    </div>
                </div>

                <div class="row" v-if="partTimeBooked && !partTimeBooked.is_canceled">
                    <div class="col">
                        <div class="alert alert-elevate alert-light d-flex justify-content-between align-items-center"
                             role="alert">
                            <div>
                                {{showPartTimeBookedPayLabel}}
                            </div>
                            <button class="btn btn-danger btn-sm" @click="cancelPartTimeBooked">کنسل کنید</button>
                        </div>
                    </div>
                </div>
            </div>

        </sweet-modal-tab>


        <sweet-modal-tab title="ویرایش" id="tab-edit" disabled>Tab 3 is disabled</sweet-modal-tab>


    </sweet-modal>
    <!--/Manage book modal-->
</template>

<script>

    import {SweetModal, SweetModalTab} from 'sweet-modal-vue'

    export default {

        name: "booking-manage-modal",

        components: {SweetModal, SweetModalTab},

        data() {
            return {
                booked: '',
                partTimeBooked: '',
                hour: '',
                date: '',
                court: '',
            }
        },

        mounted() {

            Events.$on('open-manage-booking-modal', (data) => {
                this.court = data.court;
                this.hour = data.hour;
                this.date = data.date;
                this.booked = data.booked;
                this.partTimeBooked = data.partTimeBooked;
                this.$refs.modal.open();
            });

        },

        methods: {

            cancelBooked() {
                axios.patch(`/admin/bookings/${this.booked.id}/cancel`).then(res => {
                    Events.$emit(`on-success-booked-cancel-court-${this.court.id}-at-${this.hour}`,{booked: res.data.booked});
                    this.$refs.modal.close();
                    toastr.success(res.data.msg);
                }).catch(err => toastr.warning('خطایی رخ داده'));
            },

            cancelPartTimeBooked() {
                axios.delete(`/admin/bookings/${this.partTimeBooked.id}/part-time/cancel`).then(res => {
                    Events.$emit(`on-success-part-time-booked-cancel-court-${this.court.id}-at-${this.hour}`,{partTimeBooked: res.data.partTimeBooked});
                    this.$refs.modal.close();
                    toastr.success(res.data.msg);
                }).catch(err => toastr.warning('خطایی رخ داده'));
            },

            payBooked() {
                axios.patch(`/admin/bookings/${this.booked.id}/paid`).then(res => {
                    Events.$emit(`on-success-booked-paid-court-${this.court.id}-at-${this.hour}`,{booked: res.data.booked});
                    this.$refs.modal.close();
                    toastr.success(res.data.msg);
                }).catch(err => toastr.warning('خطایی رخ داده'));
            },

            payPartTimeBooked() {
                axios.patch(`/admin/bookings/${this.partTimeBooked.id}/part-time/pay`).then(res => {
                    Events.$emit(`on-success-part-time-booked-paid-court-${this.court.id}-at-${this.hour}`,{partTimeBooked: res.data.partTimeBooked});
                    this.$refs.modal.close();
                    toastr.success(res.data.msg);
                }).catch(err => toastr.warning('خطایی رخ داده'));
            }

        },

        computed: {

            showBookedPayLabel: function () {

                return `مبلغ ${this.court.price} از ${this.booked.renter_name} دریافت شد.`;
            },

            showPartTimeBookedPayLabel: function () {
                return `مبلغ ${this.court.price} از ${this.partTimeBooked.renter_name} دریافت شد.`;
            },

        },
    }
</script>

<style scoped>

</style>