<template>

    <td :class="[defaultClass,dynamicClass]" style="position: relative;">
        <div v-if="booked" style="position: absolute; top: 0; right: 0; padding: 5px; z-index: 1;"
             @click="onDeleteClick">
            <i class="fas fa-trash"></i>
        </div>
        <div v-on="{ click: shouldCallBookMethod()  ? onBookClick : onManageClick }">
            <div class="row d-flex align-items-center" v-if="booked" style="min-width: 300px; min-height: 38.5px;">
                <div :class="['col d-flex flex-column',booked.start_time ? 'order-2' : 'order-1']">
                    <span>{{booked.renter_name}}</span>
                    <div class="d-flex justify-content-center">
                        <i v-if="booked.partner_name" class="fa fa-user-friends p-1"
                           v-tooltip="booked.partner_name"></i>
                        <i v-if="booked.start_time || booked.end_time" class="fa fa-clock p-1"
                           v-tooltip="showDurationTimes"></i>
                        <i v-if="booked.is_part_time && booked.is_paid" class="fas fa-coins text-light p-1"
                           v-tooltip="'پرداخت شده'"></i>
                    </div>
                </div>

                <div :class="['col',booked.end_time ? 'order-2' : 'order-1']" v-if="booked.is_part_time">
                    <div v-if="partTimeBooked" class="d-flex flex-column">
                        <span>{{partTimeBooked.renter_name}}</span>
                        <div class="d-flex justify-content-center">
                            <i v-if="partTimeBooked.partner_name" class="fa fa-user-friends p-1"
                               v-tooltip="partTimeBooked.partner_name"></i>
                            <i class="fa fa-clock p-1" v-tooltip="showPartTimeDurationTimes"></i>
                            <i v-if="partTimeBooked.is_paid" class="fas fa-coins text-light p-1"
                               v-tooltip="'پرداخت شده'"></i>
                        </div>
                    </div>
                    <span class="kt-badge kt-badge--warning kt-badge--inline" v-else>
                    {{showGapedTimeLabel}}
                </span>
                </div>
            </div>
            <div v-else style="min-width: 300px; min-height: 38.5px;">
            </div>
        </div>
    </td>

</template>

<script>


    import VTooltip from 'v-tooltip';
    import helper from './../../mixins/helper';


    export default {

        name: "book",

        props: ['court', 'hour', 'date'],

        mixins: [helper],

        components: {
            VTooltip
        },


        data() {

            return {
                defaultClass: 'text-center td-book align-middle',
                dynamicClass: '',
                booked: null,
                partTimeBooked: null,
            }

        },

        created() {

            this.showBookings();
        },

        mounted() {

            Events.$on(`on-success-booking-court-${this.court.id}-at-${this.hour}`, (data) => {
                this.booked = data.booked;
            });


            Events.$on(`on-success-booking-part-time-court-${this.court.id}-at-${this.hour}`, (data) => {
                this.partTimeBooked = data.partTimeBooked;
            });

            Events.$on(`on-success-booked-cancel-court-${this.court.id}-at-${this.hour}`, (data) => {
                this.booked = data.booked;
                this.partTimeBooked = null;

            });

            Events.$on(`on-success-part-time-booked-cancel-court-${this.court.id}-at-${this.hour}`, () => {
                this.partTimeBooked = null;

            });

            Events.$on(`on-success-booked-paid-court-${this.court.id}-at-${this.hour}`, (data) => {
                this.booked = data.booked;
            });

            Events.$on(`on-success-part-time-booked-paid-court-${this.court.id}-at-${this.hour}`, (data) => {
                this.partTimeBooked = data.partTimeBooked;
            });
        },

        methods: {

            showBookings() {
                this.court.bookings.forEach(booked => {
                    let jTime = this.formatTime(booked.time);
                    let jCurrentTime = this.formatTime(this.hour);
                    if (this.date === booked.date && jTime === jCurrentTime) {
                        this.booked = booked;
                        this.partTimeBooked = booked.part_time ? booked.part_time : null;
                    }
                });
            },

            shouldCallBookMethod() {

                if (!this.booked) {
                    return true;
                }


                if (this.booked.is_part_time && !this.partTimeBooked) {
                    return true;
                }

                return false;

            },

            onBookClick() {

                Events.$emit('open-booking-modal', {
                    court: this.court,
                    hour: this.hour,
                    date: this.date,
                    emptyTime: this.getGapedMinutes() ? this.getGapedMinutes() : null,
                    hasPartTimeManageTab: this.hasManagePartTimeBookTab(),
                    booked: this.booked,
                });

            },

            onManageClick() {

                Events.$emit('open-manage-booking-modal', {
                    court: this.court,
                    hour: this.hour,
                    date: this.date,
                    booked: this.booked,
                    partTimeBooked: this.partTimeBooked,
                });
            },

            getGapedMinutes() {

                if (!this.booked) {
                    return null;
                }

                if (this.booked.start_time) {

                    return moment(this.booked.start_time, "HH:mm").format("mm");

                }

                if (this.booked.end_time) {

                    let gaped = {
                        '۱۵': '۴۵',
                        '۳۰': '۳۰',
                        '۴۵': '۱۵',
                    };

                    let endAt = moment(this.booked.end_time, "HH:mm").format("mm");

                    return gaped[endAt];

                }


            },

            hasManagePartTimeBookTab() {
                if (this.booked && this.booked.is_part_time && !this.partTimeBooked) {
                    return true;
                } else {
                    return false;
                }
            },

            onDeleteClick() {

                Swal.fire({
                    title: 'آیا اطمینان دارید؟',
                    text: 'امکان بازگشت اطلاعات بعد از حذف رزرو وجود ندارد',
                    showCancelButton: !!this.partTimeBooked,
                    showConfirmButton: true,
                    showCloseButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#d33',
                    confirmButtonText: this.booked.renter_name,
                    cancelButtonText: this.partTimeBooked ? this.partTimeBooked.renter_name : null,
                }).then((result) => {
                    if (result.value) {
                        axios.delete(`/admin/bookings/${this.booked.id}/delete`).then(res => {
                            this.booked = res.data.booked;
                            this.partTimeBooked = null;
                            toastr.success(res.data.msg);
                        }).catch(err => toastError());
                    }
                    if (result.dismiss === 'cancel') {
                        axios.delete(`/admin/bookings/${this.partTimeBooked.id}/part-time/delete`).then(res => {
                            this.partTimeBooked = null;
                            toastr.success(res.data.msg);
                        }).catch(err => toastError());
                    }
                })
            }


        },

        computed: {

            showPartnerName: function () {

                if (this.booked.partner_name) {
                    return `<span>${this.booked.renter_name}</span><span>-</span><span>${this.booked.partner_name}</span>`;
                }

                return `<span>${this.booked.renter_name}</span>`;

            },

            showPartTimeBookedRenterLabel: function () {

                if (this.partTimeBooked.partner_name) {
                    return `<span>${this.partTimeBooked.renter_name}</span><span>-</span><span>${this.partTimeBooked.partner_name}</span>`;
                }

                return `<span>${this.partTimeBooked.renter_name}</span>`;

            },


            showDurationTimes() {

                if (this.booked.start_time) {

                    let finishTime = moment(this.hour, "HH:mm:ss").add(1, 'hours').format("HH:mm");

                    return `${this.formatTime(this.booked.start_time)} تا ${finishTime}`;

                } else {
                    return `${this.formatTime(this.hour)} تا ${this.formatTime(this.booked.end_time)} `;
                }

            },


            showPartTimeDurationTimes() {

                if (this.booked.start_time) {

                    return `${this.formatTime(this.partTimeBooked.start_at)} تا ${this.formatTime(this.booked.start_time)}`;
                } else {

                    let finishTime = moment(this.hour, "HH:mm:ss").add(1, 'hours').format("HH:mm");
                    return `${this.formatTime(this.partTimeBooked.start_at)} تا ${finishTime}`;

                }

            },


            showGapedTimeLabel() {

                let startGapedTimesMsg = {
                    '۱۵': '۱۵ دقیقه زمان خالی',
                    '۳۰': '۳۰ دقیقه زمان خالی',
                    '۴۵': '۴۵ دقیقه زمان خالی',
                };

                let endGapedTimesMsg = {
                    '۱۵': '۴۵ دقیقه زمان خالی',
                    '۳۰': '۳۰ دقیقه زمان خالی',
                    '۴۵': '۱۵ دقیقه زمان خالی',
                };

                if (this.booked.start_time) {
                    return startGapedTimesMsg[this.formatTime(this.booked.start_time, 'mm')];
                }

                if (this.booked.end_time) {
                    return endGapedTimesMsg[this.formatTime(this.booked.end_time, 'mm')];
                }

            },

        },


        watch: {

            booked: function () {

                if (!this.booked) {
                    return this.dynamicClass = '';
                }

                if (!this.booked.is_paid) {
                    return this.dynamicClass = 'bg-danger text-white animated zoomIn faster';
                }

                /*
                 * Full paid --> bg-success
                 */
                if (this.booked.is_paid && this.partTimeBooked && this.partTimeBooked.is_paid) {
                    return this.dynamicClass = 'bg-success text-white';
                }

                /*
                 *Paid but it is part time booked --> bg-danger
                 */
                if (this.booked.is_paid && this.booked.is_part_time) {
                    return this.dynamicClass = 'bg-danger text-white';
                }

                /*
                 * Paid and it is not part time booked --> bg-success
                 */
                if (this.booked.is_paid && !this.booked.is_part_time) {
                    return this.dynamicClass = 'bg-success text-white';
                }

            },

            partTimeBooked: function () {

                /*
                 * Full paid --> bg-success
                 */
                if (this.partTimeBooked && this.partTimeBooked.is_paid && this.booked.is_paid) {
                    return this.dynamicClass = 'bg-success text-white';
                }

            },


        },


    }
</script>

<style scoped>

    .td-book:hover {
        border: 2px solid #007bff;
        cursor: pointer;
    }

</style>