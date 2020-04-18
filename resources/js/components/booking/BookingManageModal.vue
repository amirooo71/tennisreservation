<template>
    <!--Manage book modal-->
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

            <cancel
                    v-if="booked && !booked.is_canceled"
                    :booked="booked"
                    :court="court"
                    :hour="hour"
                    :is-part-time="false">
            </cancel>

            <cancel
                    v-if="partTimeBooked && !partTimeBooked.is_canceled"
                    :part-time-booked="partTimeBooked"
                    :court="court"
                    :hour="hour"
                    :is-part-time="true">
            </cancel>

        </sweet-modal-tab>

    </sweet-modal>
    <!--/Manage book modal-->
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
            Cancel: () => import('./partials/Cancel'),
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

            onCloseModal() {
                this.showPay = false;
            }

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
            }

        },

    }
</script>

<style scoped>

</style>