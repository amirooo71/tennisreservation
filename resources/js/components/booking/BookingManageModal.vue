<template>
    <!--Manage book modal-->
    <sweet-modal ref="modal" overlay-theme="dark">

        <booking-info :hour="hour" :court-name="court.name"></booking-info>

        <sweet-modal-tab title="پرداخت" id="tab-pay">

            <h4 v-if="isAlreadyPaid" class="text-success">پرداخت شده</h4>

            <pay v-if="!booked.is_paid"
                 :label="showBookedPayLabel"
                 :booked="booked"
                 :court="court"
                 :hour="hour"
                 :is-part-time="false">
            </pay>

            <pay v-if="partTimeBooked && !partTimeBooked.is_paid"
                 :label="showPartTimeBookedPayLabel"
                 :part-time-booked="partTimeBooked"
                 :court="court"
                 :hour="hour"
                 :is-part-time="true">
            </pay>

        </sweet-modal-tab>

        <sweet-modal-tab title="کنسل" id="tab-cancel">

            <div class="row" v-if="!booked.is_canceled">
                <div class="col">
                    <div class="alert alert-elevate alert-light d-flex justify-content-between align-items-center"
                         role="alert">
                        <div>
                            {{showBookedCancelLabel}}
                        </div>
                        <button class="btn btn-danger btn-sm" @click="cancel">کنسل کن</button>
                    </div>
                </div>
            </div>

            <div class="row" v-if="partTimeBooked && !partTimeBooked.is_canceled">
                <div class="col">
                    <div class="alert alert-elevate alert-light d-flex justify-content-between align-items-center"
                         role="alert">
                        <div>
                            {{showPartTimeBookedCancelLabel}}
                        </div>
                        <button class="btn btn-danger btn-sm" @click="cancelPartTimeBooked">کنسل کن</button>
                    </div>
                </div>
            </div>

        </sweet-modal-tab>

    </sweet-modal>
    <!--/Manage book modal-->
</template>

<script>

    import BaseComponent from './BaseComponent';
    import {SweetModal, SweetModalTab} from 'sweet-modal-vue';
    import BookingInfo from './partials/BookInfo';
    import Pay from './partials/Pay';

    export default BaseComponent.extend({

        name: "booking-manage-modal",

        components: {SweetModal, SweetModalTab, BookingInfo, Pay},

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
                this.$refs.modal.open('tab-pay');
            });

            Events.$on(`close-manage-booking-modal`, () => {
                this.$refs.modal.close();
            });

        },

        methods: {

            cancelPartTimeBooked() {
                let asyncRes = axios.delete(`/admin/bookings/${this.partTimeBooked.id}/part-time/cancel`).then(res => {
                    Events.$emit(`on-success-part-time-booked-cancel-court-${this.court.id}-at-${this.hour}`, {partTimeBooked: res.data.partTimeBooked});
                    this.$refs.modal.close();
                    toastr.success(res.data.msg);
                }).catch(err => toastr.warning('خطایی رخ داده'));
                this.redrawTblHeader(asyncRes);
            },

        },

        computed: {

            showBookedPayLabel: function () {

                return `${this.booked.renter_name} مبلغ ${this.court.price} تومان بدهکار است`;

            },

            showPartTimeBookedPayLabel: function () {
                return `${this.partTimeBooked.renter_name} مبلغ ${this.court.price} تومان بدهکار است`;
            },


            showBookedCancelLabel: function () {

                return `آیا می خواهید رزرو را برای ${this.booked.renter_name} کنسل کنید؟`;

            },

            showPartTimeBookedCancelLabel: function () {
                return `آیا می خواهید رزرو را برای ${this.partTimeBooked.renter_name} کنسل کنید؟`;
            },

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
            }

        },

    });
</script>

<style scoped>

</style>