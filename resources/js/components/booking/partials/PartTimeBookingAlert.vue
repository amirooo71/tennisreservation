<template>
    <div role="alert" class="alert alert-primary">
        <div class="alert-icon">
            <i class="flaticon-warning"></i>
        </div>
        <div class="alert-text">
            {{emptyTime}} دقیقه زمان در این کورت خالی است شما می توانید آن را اجاره دهید
        </div>
    </div>
</template>

<script>
    export default {

        name: "part-time-booking-alert",

        props: ['booked', 'emptyTime'],

    }
</script>

<style scoped>

</style>