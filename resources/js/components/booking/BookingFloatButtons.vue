<template>
    <div>
        <fab bgColor="#C51162"
             icon-size="small"
             startOpened="true"
             position="bottom-left"
             fixedTooltip="true"
             :actions="fabActions"
             @home="onHome"
        ></fab>
    </div>
</template>

<script>

    import fab from 'vue-fab';

    export default {
        name: "booking-float-buttons",

        components: {fab},

        data() {
            return {
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