<template>
    <tr>
        <th scope="col" class="text-center col-sticky">{{formatTime(hour)}}</th>
        <booking v-for="court in courts" :court="court" :hour="hour" :date="date" :key="court.id"></booking>
    </tr>
</template>

<script>

    import Booking from './Booking';
    import jdatetime from './../../mixins/jdatetime';

    export default {

        name: "bookings",

        props: ['courts', 'hour', 'date'],

        mixins: [jdatetime],

        components: {Booking},

        data() {
            return {}
        },

    }
</script>

<style scoped>

</style>