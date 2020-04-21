<template>

    <div class="kt-portlet kt-portlet--tabs">
        <div class="kt-portlet__head d-flex justify-content-center">
            <div class="kt-portlet__head-toolbar">
                <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-brand nav-tabs-line-2x nav-tabs-line-right nav-tabs-bold"
                    role="tablist">
                    <li class="nav-item" v-for="date in dates">
                        <a href="#" :class="['nav-link',{active: date.date === activeDate}]" @click="onActiveDateClick(date.date)">
                            <div class="d-flex flex-column align-items-center">
                                <span>{{date.readableDay}}</span>
                                <span>{{date.readableDate}}</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="d-flex justify-content-between flex-wrap">
                <a href="#" class="bg-light py-2 px-4 m-1" v-for="hour in hours">{{formatTime(hour)}}</a>
            </div>
        </div>
    </div>


</template>

<script>

    import helper from './../../mixins/helper';

    export default {
        name: "bookings",

        mixins: [helper],

        data() {
            return {
                dates: [],
                hours: [],
                activeDate: '',
            }
        },

        created() {
            this.getDates();
            this.getHours();
        },

        methods: {
            getDates() {
                axios.get('/admin/ajax/activity/date-time/dates').then(res => this.dates = res.data);
            },

            getHours() {
                axios.get('/admin/ajax/activity/date-time/hours').then(res => this.hours = res.data);
            },

            onActiveDateClick(date){
                console.log(date);
                this.activeDate = date;
            }
        }
    }
</script>

<style scoped>

</style>