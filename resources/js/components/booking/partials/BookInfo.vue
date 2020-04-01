<template>
    <div class="alert alert-secondary" role="alert">
        <div class="alert-text">{{courtName}} برای ساعت {{hour}}</div>
    </div>
</template>

<script>
    export default {
        name: "book-info",

        props: ['hour','courtName']
    }
</script>

<style scoped>

</style>