<template>
    <div class="alert alert-secondary" role="alert">
        <div class="alert-text" v-if="hour && courtName">{{courtName}} برای ساعت {{this.formatTime(hour)}}</div>
        <div class="alert-text" v-else>در حال بارگزاری...</div>
    </div>
</template>

<script>

    import helper from './../../../mixins/helper';

    export default {

        name: "info",

        mixins: [helper],

        props: ['hour', 'courtName'],
    }
</script>

<style scoped>

</style>