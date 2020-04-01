<template>

    <td :class="[defaultClass,dynamicClass]" v-on="{ click: shouldCallBookMethod()  ? onBookClick : onManageClick }">

        <div class="row" v-if="booked">

            <div :class="['col d-flex align-items-center' ,booked.start_time ? 'border-left order-2' : 'order-1',!booked.is_part_time ? 'justify-content-center' : 'justify-content-between']">
                <span>{{showBookedRenterLabel}}</span>
                <div class="d-none align-items-center justify-content-between d-sm-block">
                    <span v-if="booked.start_time || booked.end_time"
                          class="kt-badge kt-badge--light kt-badge--inline">
                         {{showPartTimeBookedTimeLabel}}
                    </span>
                    <i v-if="booked.is_part_time && booked.is_paid" class="fas fa-coins text-light ml-1"></i>
                </div>
            </div>

            <div :class="['col d-flex justify-content-between align-items-center',booked.end_time ? 'border-left order-2' : 'order-1']"
                 v-if="booked.is_part_time">
                <div v-if="partTimeBooked" class="col d-flex justify-content-between align-items-center">
                    <span>{{showPartTimeBookedRenterLabel}}</span>
                    <div class="d-none align-items-center justify-content-between d-sm-block">
                        <span class="kt-badge kt-badge--light kt-badge--inline">
                            {{showStartingTimePartTimeBooked}}
                        </span>
                        <i v-if="partTimeBooked.is_paid" class="fas fa-coins text-light ml-1"></i>
                    </div>
                </div>
                <span class="kt-badge kt-badge--warning kt-badge--inline col justify-content-center align-items-center"
                      v-else>
                    {{showGapedTimeLabel}}
                </span>
            </div>

        </div>

    </td>

</template>

<script>


    export default {

        name: "book",

        props: ['court', 'hour', 'date'],


        data() {

            return {
                defaultClass: 'text-center td-book',
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


            /*
             * Good refactor
             */
            showBookings() {
                this.court.bookingDates.forEach(booked => {
                    let time = moment(booked.time, 'HH:mm').format('HH:mm');
                    if (this.date === booked.date && this.hour === time) {
                        this.booked = booked;
                        this.partTimeBooked = booked.part_time ? booked.part_time : null;
                    }
                });
            },

            /*
            * Good refactor
            */
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
                    return moment(this.booked.end_time, "HH:mm").format("mm");
                }


            },


            /*
             * Helper
             */
            formatTime(time) {
                return moment(time, 'HH:mm').format('HH:mm');
            },

            hasManagePartTimeBookTab() {
                if (this.booked && this.booked.is_part_time && !this.partTimeBooked) {
                    return true;
                } else {
                    return false;
                }
            },


        },

        computed: {

            showBookedRenterLabel: function () {

                if (this.booked.partner_name) {
                    return `${this.booked.renter_name} - ${this.booked.partner_name}`;
                }

                return this.booked.renter_name;

            },

            showPartTimeBookedRenterLabel: function () {

                if (this.partTimeBooked.partner_name) {
                    return `${this.partTimeBooked.renter_name} - ${this.partTimeBooked.partner_name}`;
                }

                return this.partTimeBooked.renter_name;

            },


            showPartTimeBookedTimeLabel() {
                if (this.booked.start_time) {
                    return `زمان شروع: ${this.formatTime(this.booked.start_time)}`;
                } else {
                    return `زمان پایان: ${this.formatTime(this.booked.end_time)}`;
                }

            },

            showGapedTimeLabel() {

                console.log(this.booked.start_time);
                console.log(this.booked.end_time);

                let startGapedTimesMsg = {
                    15: '۱۵ دقیقه زمان خالی',
                    30: '۳۰ دقیقه زمان خالی',
                    45: '۴۵ دقیقه زمان خالی',
                };

                let endGapedTimesMsg = {
                    15: '۴۵ دقیقه زمان خالی',
                    30: '۳۰ دقیقه زمان خالی',
                    45: '۱۵ دقیقه زمان خالی',
                };

                if (this.booked.start_time) {
                    let partTimeMinute = moment(this.booked.start_time, "HH:mm").format("mm");
                    return startGapedTimesMsg[partTimeMinute];
                }

                if (this.booked.end_time) {
                    let partTimeMinute = moment(this.booked.end_time, "HH:mm").format("mm");
                    return endGapedTimesMsg[partTimeMinute];
                }

            },

            showStartingTimePartTimeBooked() {
                return `ساعت شروع: ${this.formatTime(this.partTimeBooked.remain_time)}`;
            }


        },


        watch: {

            booked: function () {

                if (!this.booked) {
                    return this.dynamicClass = 'bg-danger text-white animated zoomOut';
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