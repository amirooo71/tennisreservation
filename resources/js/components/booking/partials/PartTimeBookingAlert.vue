<template>
    <div role="alert" class="alert alert-light alert-elevate" v-if="isPartTime">
        <div class="alert-icon">
            <i class="flaticon-warning kt-font-brand"></i>
        </div>
        <div class="alert-text">
            {{emptyTime}} دقیقه زمان در این کورت خالی است شما می توانید آن را اجاره دهید
        </div>
    </div>
</template>

<script>
    export default {

        name: "part-time-booking-alert",

        props: ['isPartTime', 'emptyTime']

    }
</script>

<style scoped>

</style>