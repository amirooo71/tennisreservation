<template>
    <div>
       <line-chart :chart-data="datacollection" :options="options"></line-chart>
    </div>
</template>

<script>

    Chart.defaults.global.defaultFontFamily = 'IRANSans4';

    import LineChart from './../chart/Line';

    export default {
        name: "revenue",

        components: {LineChart},

        data(){
            return {
                datacollection: {
                    labels: ['فروردین', 'اردیبهشت'],
                    datasets: [
                        {
                            label: 'Data One',
                            backgroundColor: '#f87979',
                            data: [40, 20]
                        }
                    ]
                },

                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                }
            }
        },

    }
</script>

<style scoped>

</style>