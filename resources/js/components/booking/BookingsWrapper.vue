<template>

    <full-page ref="fullpage" :options="options" id="fullpage">
        <div class="section">
            <slot></slot>
            <fab bgColor="#C51162"
                 icon-size="small"
                 startOpened="true"
                 position="bottom-left"
                 fixedTooltip="true"
                 :actions="fabActions"
                 @home="onHome"
            ></fab>
        </div>
    </full-page>


</template>

<script>

    import 'fullpage.js/vendors/scrolloverflow' // Optional. When using scrollOverflow:true
    import VueFullPage from 'vue-fullpage.js';
    import fab from 'vue-fab';

    export default {

        name: "bookings-wrapper",

        components: {VueFullPage, fab},


        mounted() {
            this.$refs.fullpage.init();
        },

        data() {
            return {
                options: {
                    licenseKey: 'YOUR_KEY_HEERE',
                },
                fabActions: [
                    {
                        name: 'home',
                        icon: 'home',
                        tooltip: 'بازگشت به خانه'
                    },
                    {
                        name: '',
                        icon: 'calendar_today',
                        tooltip: `تاریخ امروز: ${jmoment().format("jMM/jDD")}`
                    },
                    {
                        name: '',
                        icon: 'navigate_next',
                        tooltip: `روز بعد`
                    },
                    {
                        name: '',
                        icon: 'navigate_before',
                        tooltip: `روز قبل`
                    }
                ]
            }
        },

        methods: {
            onHome() {
                window.location.href = "/admin/dashboard";
            }
        }

    }
</script>

<style scoped>

</style>