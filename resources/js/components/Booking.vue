<template>
    <tr>
        <th scope="col" class="text-center">{{hour}}</th>
        <book v-for="court in courts" :court="court" :hour="hour" :date="date" :key="court.id"></book>
    </tr>
</template>

<script>

    import Book from './Book.vue';

    export default {

        name: "booking",

        props: ['courts','hour','date'],

        components: {Book},

        data() {
            return {}
        },

        mounted() {

        },

        methods: {

            onBookingColClick() {

                console.log(123456);

            },

        },

    }
</script>

<style scoped>

</style>