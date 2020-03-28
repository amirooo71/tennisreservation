<template>
    <!--Manage book modal-->
    <sweet-modal ref="modal" overlay-theme="dark">
        <div class="row">
            <div class="col">
                <button class="btn btn-danger" @click="cancel">رزرو را کنسل کن</button>
            </div>
            <div class="col">
                <button class="btn btn-success" @click="paid">هزینه پرداخت شد</button>
            </div>
        </div>
    </sweet-modal>
    <!--/Manage book modal-->
</template>

<script>

    import {SweetModal, SweetModalTab} from 'sweet-modal-vue'

    export default {

        name: "manage-booking-modal",

        components: {SweetModal, SweetModalTab},

        data() {
            return {
                bookedId: '',
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
                this.bookedId = data.bookedId;
                this.$refs.modal.open();
            });

        },

        methods: {

            cancel() {
                axios.patch(`/admin/bookings/${this.bookedId}/cancel`).then(res => {
                    Events.$emit(`on-success-cancel-booking-court-${this.court.id}-at-${this.hour}`);
                    toastr.success(res.data.msg);
                    this.$refs.modal.close();
                }).catch(err => toastr.warning('خطایی رخ داده'));
            },

            paid() {
                axios.patch(`/admin/bookings/${this.bookedId}/paid`).then(res => {
                    Events.$emit(`on-success-paid-booking-court-${this.court.id}-at-${this.hour}`);
                    this.isPaid = true;
                    this.$refs.modal.close();
                    toastr.success(res.data.msg);
                }).catch(err => toastr.warning('خطایی رخ داده'));
            },


        }
    }
</script>

<style scoped>

</style>