<template>
    <div class="alert alert-secondary" role="alert">
        <div class="alert-text" v-if="hour && courtName">{{courtName}} برای ساعت {{this.formatTime(hour)}}</div>
        <div class="alert-text" v-else>در حال بارگزاری...</div>
    </div>
</template>

<script>

    import jdatetime from './../../../mixins/jdatetime';

    export default {

        name: "book-info",

        mixins: [jdatetime],

        props: ['hour', 'courtName']
    }
</script>

<style scoped>

</style>