<template>

    <fragment>

        <td :class="[defaultClass,dynamicClass]"
            v-on="{ click: isBooked ? onManageClick : onBookClick }">
            {{renterName}}
        </td>

    </fragment>

</template>

<script>

    import {Plugin} from 'vue-fragment';

    Vue.use(Plugin);

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
            });

            Events.$on(`on-success-cancel-booking-court-${this.court.id}-at-${this.hour}`, () => {
                this.isBooked = false;
                this.renterName = '';
                this.bookedId = '';
                this.isCanceled = true;
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
                    }
                });
            },

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


        }

    }
</script>

<style scoped>

    .td-book:hover {
        border-bottom: 1px solid #007bff !important;
        cursor: pointer;
    }

</style>