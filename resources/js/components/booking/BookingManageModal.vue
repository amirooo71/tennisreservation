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

                <div v-if="showCancel">
                    <cancel
                            v-if="booked && !booked.is_canceled"
                            :is-manage="true"
                            :booked="booked"
                            :court="court"
                            :hour="hour">
                    </cancel>
                    <cancel
                            v-if="partTimeBooked && !partTimeBooked.is_canceled"
                            :is-manage="true"
                            :part-time-booked="partTimeBooked"
                            :court="court"
                            :hour="hour">
                    </cancel>
                </div>

            </sweet-modal-tab>

        </sweet-modal>

        <sweet-modal overlay-theme="dark" ref="chargeCreditorModal">

            <h4>آیا می خواهید هزینه را به رزرو کننده برگردانید؟</h4>
            <div class="mt-3">
                <button class="btn btn-success" @click="chargeCreditor">بله</button>
                <button class="btn btn-danger" @click="doNotChargeCreditor">خیر</button>
            </div>

        </sweet-modal>

        <sweet-modal overlay-theme="dark" ref="chargeDebtorModal">

            <h2 class="text-danger">تایم کنسلی گذشته است!</h2>
            <h4> آیا می خواهید هزینه را از رزرو کننده بگیرید؟</h4>
            <div class="mt-3">
                <button class="btn btn-success" @click="chargeDebtor">بله</button>
                <button class="btn btn-danger" @click="doNotChargeDebtor">خیر</button>
            </div>

        </sweet-modal>

        //Part Time

        <sweet-modal overlay-theme="dark" ref="chargeCreditorPTModal">

            <h4>آیا می خواهید هزینه را به رزرو کننده برگردانید؟</h4>
            <div class="mt-3">
                <button class="btn btn-success" @click="chargeCreditorPT">بله</button>
                <button class="btn btn-danger" @click="doNotChargeCreditorPT">خیر</button>
            </div>

        </sweet-modal>

        <sweet-modal overlay-theme="dark" ref="chargeDebtorPTModal">

            <h2 class="text-danger">تایم کنسلی گذشته است!</h2>
            <h4> آیا می خواهید هزینه را از رزرو کننده بگیرید؟</h4>
            <div class="mt-3">
                <button class="btn btn-success" @click="chargeDebtorPT">بله</button>
                <button class="btn btn-danger" @click="doNotChargeDebtorPT">خیر</button>
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
                showCancel: false,
                cancelId: '',
                PTCancelId: '',
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
                this.showCancel = true;
                this.$refs.modal.open('tab-pay');
            });

            Events.$on(`close-manage-booking-modal`, () => {
                this.$refs.modal.close();
            });

            Events.$on('open-manage-charge-creditor-modal', (data) => {
                this.cancelId = data.cancelId;
                this.$refs.chargeCreditorModal.open();
            });

            Events.$on('open-manage-charge-debtor-modal', (data) => {
                this.cancelId = data.cancelId;
                this.$refs.chargeDebtorModal.open();
            });

            Events.$on('close-manage-charge-creditor-modal', () => {
                this.$refs.chargeCreditorModal.close();
            });

            Events.$on('close-manage-charge-debtor-modal', () => {
                this.$refs.chargeDebtorModal.close();
            });


            //Part Time

            Events.$on('open-manage-charge-creditor-pt-modal', (data) => {
                this.PTCancelId = data.PTCancelId;
                this.$refs.chargeCreditorPTModal.open();
            });

            Events.$on('open-manage-charge-debtor-pt-modal', (data) => {
                this.PTCancelId = data.PTCancelId;
                this.$refs.chargeDebtorPTModal.open();
            });

            Events.$on('close-manage-charge-creditor-pt-modal', () => {
                this.$refs.chargeCreditorPTModal.close();
            });

            Events.$on('close-manage-charge-debtor-pt-modal', () => {
                this.$refs.chargeDebtorPTModal.close();
            });


        },

        methods: {

            onCloseModal() {
                this.showPay = false;
                this.showCancel = false;
                this.cancelId = '';
                this.PTCancelId = '';
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
            }

        },

    }
</script>

<style scoped>

</style>