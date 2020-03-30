<template>
    <tr>
        <th scope="col" class="text-center">{{hour}}</th>
        <booking v-for="court in courts" :court="court" :hour="hour" :date="date" :key="court.id"></booking>
    </tr>
</template>

<script>

    import Booking from './Booking';

    export default {

        name: "bookings",

        props: ['courts','hour','date'],

        components: {Booking},

        data() {
            return {}
        },

    }
</script>

<style scoped>

</style>