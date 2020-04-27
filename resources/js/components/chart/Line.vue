<script>

    Chart.defaults.global.defaultFontFamily = 'IRANSans4';

    import {Line} from 'vue-chartjs'

    export default {
        extends: Line,
        props: ['chartData', 'chartLabels', 'chartLabel'],

        data() {
            return {
                datacollection: {
                    labels: this.chartLabels,
                    datasets: [
                        {
                            label: this.chartLabel,
                            data: this.chartData,
                            borderWidth: 3,
                            borderColor: '#fe346e',
                        }
                    ]
                },

                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                }
            }
        },

        mounted() {
            this.renderChart(this.datacollection, this.options)
        }
    }
</script>
