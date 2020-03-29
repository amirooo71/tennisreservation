<template>
    <tr>
        <th scope="col" class="text-center">{{hour}}</th>
        <book v-for="court in courts" :court="court" :hour="hour" :date="date" :key="court.id"></book>
    </tr>
</template>

<script>

    import Book from './Book';

    export default {

        name: "booking",

        props: ['courts','hour','date'],

        components: {Book},

        data() {
            return {}
        },

    }
</script>

<style scoped>

</style>