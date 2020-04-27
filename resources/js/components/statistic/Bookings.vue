<template>
    <div>
        <div class="form-group row">
            <div class="col-md-6">
                <label>بازه زمانی:</label>
                <select class="form-control" @change="getRevenue($event.target.value)">
                    <option value="weekly">هفتگی</option>
                    <option value="monthly">ماهیانه</option>
                    <option value="annually">سالانه</option>
                </select>
            </div>
        </div>
        <line-chart v-if="loaded" :chart-data="data" :chart-labels="labels" :chart-label="label"></line-chart>
    </div>
</template>

<script>

    import LineChart from './../chart/Line';

    export default {
        name: "bookings",

        props: ['keys', 'values'],

        components: {LineChart},

        created() {
            this.getRevenue('weekly');
        },

        data() {
            return {
                loaded: false,
                label: 'دقیقه',
                labels: [],
                data: [],
            }
        },

        methods: {

            getRevenue(range) {
                this.loaded = false;
                axios.get('/admin/ajax/statistic/bookings/' + range).then(res => {
                    this.labels = res.data.labels;
                    this.data = res.data.data;
                    this.loaded = true;
                });
            }
        }

    }
</script>

<style scoped>

</style>