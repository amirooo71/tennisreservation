<template>

    <td :class="[defaultClass,dynamicClass]"
        v-on="{ click: isBooked ? onManageClick : onBookClick }">

        <div class="row" v-if="endTime">
            <div :class="[isPartTime ? 'col border-right' : 'col']">
                <span v-if="!partnerName">{{renterName}}</span>
                <span v-else>{{renterName}} - {{partnerName}} </span>
                <span v-if="startTime" class="kt-badge kt-badge--warning kt-badge--inline">
                    زمان شروع: {{formatStartTime}}
                </span>
                <span v-if="endTime" class="kt-badge kt-badge--warning kt-badge--inline">
                    زمان پایان: {{formatEndTime}}
                </span>
            </div>
            <div class="col border-left" v-if="isPartTime">
                <div v-if="partTimeDetail">
                    <span v-if="!partnerName">{{renterName}}</span>
                    <span v-else>{{renterName}} - {{partnerName}} </span>
                    <!--<span v-if="startTime"-->
                    <!--class="kt-badge kt-badge&#45;&#45;warning kt-badge&#45;&#45;inline">ساعت شروع: {{startTime}}</span>-->
                    <!--<span v-if="endTime"-->
                    <!--class="kt-badge kt-badge&#45;&#45;warning kt-badge&#45;&#45;inline">ساعت پایان: {{endTime}}</span>-->
                </div>
                <span v-else>
                     <span class="kt-badge kt-badge--warning kt-badge--inline">
                     {{getGapedTime()}}
                    </span>
                </span>
            </div>
        </div>

        <div class="row" v-else>
            <div class="col border-right" v-if="isPartTime">
                <div v-if="partTimeDetail">
                    <span v-if="!partnerName">{{renterName}}</span>
                    <span v-else>{{renterName}} - {{partnerName}} </span>
                    <!--<span v-if="startTime"-->
                    <!--class="kt-badge kt-badge&#45;&#45;warning kt-badge&#45;&#45;inline">ساعت شروع: {{startTime}}</span>-->
                    <!--<span v-if="endTime"-->
                    <!--class="kt-badge kt-badge&#45;&#45;warning kt-badge&#45;&#45;inline">ساعت پایان: {{endTime}}</span>-->
                </div>
                <span v-else>
                     <span class="kt-badge kt-badge--warning kt-badge--inline">
                     {{getGapedTime()}}
                    </span>
                </span>
            </div>
            <div :class="[isPartTime ? 'col border-left' : 'col']">
                <span v-if="!partnerName">{{renterName}}</span>
                <span v-else>{{renterName}} - {{partnerName}} </span>
                <span v-if="startTime" class="kt-badge kt-badge--warning kt-badge--inline">
                    زمان شروع: {{formatStartTime}}
                </span>
                <span v-if="endTime" class="kt-badge kt-badge--warning kt-badge--inline">
                    زمان پایان: {{formatEndTime}}
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
                isBooked: false,
                renterName: '',
                bookedId: '',
                isCanceled: false,
                isPaid: false,
                defaultClass: 'text-center td-book',
                dynamicClass: '',
                partnerName: '',
                startTime: '',
                endTime: '',
                isPartTime: false,
                partTimeDetail: null,

            }

        },

        created() {
            this.showBookings();
        },

        mounted() {

            Events.$on(`on-success-booking-court-${this.court.id}-at-${this.hour}`, (data) => {
                this.isBooked = true;
                this.renterName = data.renterName;
                this.bookedId = data.bookedId;
                this.isCanceled = false;
                this.partnerName = data.partnerName;
                this.coachName = data.coachName;
                this.startTime = data.startTime;
                this.endTime = data.endTime;
                this.isPartTime = data.isPartTime;
            });

            Events.$on(`on-success-cancel-booking-court-${this.court.id}-at-${this.hour}`, () => {
                this.isBooked = false;
                this.renterName = '';
                this.bookedId = '';
                this.isCanceled = true;
                this.partnerName = '';
                this.coachName = '';
            });

            Events.$on(`on-success-paid-booking-court-${this.court.id}-at-${this.hour}`, () => {
                this.isPaid = true;
            });
        },

        methods: {

            onBookClick() {
                Events.$emit('open-booking-modal', {
                    court: this.court,
                    hour: this.hour,
                    date: this.date,
                });
            },

            onManageClick() {
                Events.$emit('open-manage-booking-modal', {
                    court: this.court,
                    hour: this.hour,
                    date: this.date,
                    bookedId: this.bookedId,
                });
            },

            showBookings() {
                this.court.bookingDates.forEach(b => {
                    let time = moment(b.time, 'HH:mm').format('HH:mm');
                    if (this.date === b.date && this.hour === time) {
                        this.isBooked = true;
                        this.renterName = b.renter_name;
                        this.bookedId = b.id;
                        this.isPaid = b.is_paid;
                        this.partnerName = b.partner_name;
                        this.startTime = b.start_time;
                        this.endTime = b.end_time;
                        this.isPartTime = b.is_part_time;
                        this.partTimeDetail = b.part_time;
                    }
                });
            },

            getGapedTime() {

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

                if (this.startTime) {
                    let partTimeMinute = moment(this.startTime, "HH:mm").format("mm");
                    return startGapedTimesMsg[partTimeMinute];
                }

                if (this.endTime) {
                    let partTimeMinute = moment(this.endTime, "HH:mm").format("mm");
                    return endGapedTimesMsg[partTimeMinute];
                }


            }

        },

        watch: {

            isBooked: function (val) {

                if (val && this.isPaid) {

                    this.dynamicClass = 'bg-success text-white animated zoomIn faster';

                } else {

                    this.dynamicClass = 'bg-danger text-white animated zoomIn faster';

                }
            },

            isCanceled: function (val) {

                if (val) {
                    this.dynamicClass = 'bg-danger animated zoomOut';
                }

            },

            isPaid: function (val) {

                if (val) {
                    this.dynamicClass = 'bg-success text-white';
                }

            },

        },

        computed: {

            formatStartTime: function () {
                return moment(this.startTime, 'HH:mm').format('HH:mm');
            },

            formatEndTime: function () {
                return moment(this.endTime, 'HH:mm').format('HH:mm');
            }
        },

    }
</script>

<style scoped>

    .td-book:hover {
        border: 2px solid #007bff;
        cursor: pointer;
    }

</style>