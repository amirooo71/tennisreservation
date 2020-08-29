<template>

    <ul class="list-group list-group-flush">
        <li class="list-group-item" v-for="book in booked">{{bookedMessage(book)}}</li>
    </ul>

</template>

<script>
export default {

    name: "list",

    data() {
        return {
            booked: [],
        }
    },

    mounted() {

        Events.$on('success-fix-booked', (data) => {
            this.booked.push(data.booked);
        });

    },

    methods: {

        bookedMessage(book) {
            console.log(book);
            if (book.renter_name) {
                return `${book.court_name} در ساعت  ${book.time} برای روز ${book.day} به نام ${book.renter_name} رزرو فیکس شد.`;
            }

            return `${book.court_name} در ساعت  ${book.time} برای روز ${book.day} به نام ${book.coach_name} رزرو فیکس شد.`;
        }

    },
}
</script>

<style scoped>

</style>
