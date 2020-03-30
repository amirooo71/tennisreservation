<template>

    <td :class="[defaultClass,dynamicClass]" v-on="{ click: shouldCallBookMethod()  ? onBookClick : onManageClick }">

        <div class="row" v-if="booked">

            <div :class="[booked.is_part_time ? 'col border-right' : 'col']">
                <span>{{showBookedRenterLabel}}</span>
                <span v-if="booked.start_time || booked.end_time" class="kt-badge kt-badge--warning kt-badge--inline">
                     {{showPartTimeBookedTimeLabel}}
                </span>
                <i v-if="booked.is_part_time && booked.is_paid" class="fas fa-coins text-warning"></i>
            </div>

            <div class="col border-left" v-if="booked.is_part_time">
                <div v-if="partTimeBooked">
                    <span>{{showPartTimeBookedRenterLabel}}</span>
                    <span class="kt-badge kt-badge--warning kt-badge--inline">
                        {{showStartingTimePartTimeBooked}}
                    </span>
                </div>
                <span class="kt-badge kt-badge--warning kt-badge--inline" v-else>
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

            booked: function (val) {


                //Cancel it
                if (!this.booked) {
                    this.dynamicClass = 'bg-danger text-white animated zoomOut';
                    return;
                }

                //Paid is it not part time booked
                if (this.booked.is_paid && !this.booked.is_part_time) {
                    this.dynamicClass = 'bg-success text-white';
                    return
                }


                //Paid is it not part time booked
                if (!this.partTimeBooked && this.booked.is_paid && this.booked.is_part_time) {
                    this.dynamicClass = 'bg-danger text-white';
                    return
                }


                if (this.partTimeBooked && this.booked.is_paid && this.partTimeBooked.is_paid) {
                    this.dynamicClass = 'bg-success text-white';
                    return
                }


                this.dynamicClass = 'bg-danger text-white animated zoomIn faster';

            },

            partTimeBooked: function(){

                if(this.partTimeBooked && this.partTimeBooked.is_paid){
                    this.dynamicClass = 'bg-success text-white';
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