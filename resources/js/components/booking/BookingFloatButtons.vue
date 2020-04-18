<template>
    <div>
        <fab bgColor="#C51162"
             icon-size="small"
             position="bottom-left"
             fixedTooltip="true"
             :actions="fabActions"
             @home="onHome"
             @nextDay="onNextDay"
             @prevDay="onPrevDay"
             @currentDay="onCurrentDay"
             @sync="onSync"
        ></fab>
    </div>
</template>

<script>

    import fab from 'vue-fab';

    export default {

        name: "booking-float-buttons",

        props: ['date'],

        components: {fab},

        data() {
            return {
                nextDate: '',
                prevDate: '',
                fabActions: [
                    {
                        name: 'home',
                        icon: 'home',
                        tooltip: 'بازگشت به خانه'
                    },
                    {
                        name: 'currentDay',
                        icon: 'calendar_today',
                        tooltip: `تاریخ: ${moment(this.date, 'jYYYY-jM-jD').format('YYYY/M/D')}`
                    },
                    {
                        name: 'nextDay',
                        icon: 'navigate_next',
                        tooltip: `روز بعد`
                    },
                    {
                        name: 'prevDay',
                        icon: 'navigate_before',
                        tooltip: `روز قبل`
                    },
                    {
                        name: 'sync',
                        icon: 'refresh',
                        tooltip: `همگام سازی`
                    }
                ]
            }
        },

        methods: {

            onHome() {
                window.location.href = "/admin/dashboard";
            },

            onNextDay() {

                jmoment.loadPersian({
                    usePersianDigits: false,
                });

                let urlParams = new URLSearchParams(window.location.search);

                if (urlParams.has('date')) {
                    let date = urlParams.get('date');
                    this.nextDate = moment(date, 'jYYYY-jM-jD').add(1, 'day').format('YYYY-M-D');
                } else {
                    console.log(this.date);
                    this.nextDate = moment(this.date, 'jYYYY-jM-jD').add(1, 'day').format('YYYY-M-D');

                }

                window.location.href = `/admin/bookings?date=${this.nextDate}`;

            },

            onPrevDay() {

                jmoment.loadPersian({
                    usePersianDigits: false,
                });

                let urlParams = new URLSearchParams(window.location.search);

                if (urlParams.has('date')) {
                    let date = urlParams.get('date');
                    this.prevDate = moment(date, 'jYYYY-jM-jD').subtract(1, 'day').format('YYYY-M-D');
                } else {
                    console.log(this.date);
                    this.prevDate = moment(this.date, 'jYYYY-jM-jD').subtract(1, 'day').format('YYYY-M-D');

                }

                window.location.href = `/admin/bookings?date=${this.prevDate}`;

            },

            onCurrentDay() {
                window.location.href = `/admin/bookings`;
            },

            onSync() {
                location.reload();
            },

        },


    }
</script>

<style scoped>

</style>