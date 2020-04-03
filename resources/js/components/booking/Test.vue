<template>

    <full-page ref="fullpage" :options="options" id="fullpage">
        <div class="section">
            <slot></slot>
        </div>
    </full-page>


</template>

<script>

    import 'fullpage.js/vendors/scrolloverflow' // Optional. When using scrollOverflow:true
    import VueFullPage from 'vue-fullpage.js';

    export default {
        name: "test.vue",

        components: {VueFullPage},


        mounted() {
            this.$refs.fullpage.init()
        },

        data() {
            return {
                options: {
                    licenseKey: 'YOUR_KEY_HEERE',
                },
            }
        }

    }
</script>

<style scoped>

</style>