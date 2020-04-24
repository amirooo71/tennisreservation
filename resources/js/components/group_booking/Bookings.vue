<template>

    <div class="kt-portlet kt-portlet--tabs">
        <div class="row mt-5 mx-4">
            <div class="form-group col-md-6">
                <label>انتخاب زمین</label>
                <select v-model="courtId" class="form-control" @change="onCourtChange">
                    <option v-for="court in courts" :value="court.id">{{court.name}}</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label>انتخاب مربی</label>
                <select v-model="ownerId" class="form-control">
                    <option v-for="coach in coaches" :value="coach.id">{{coach.name}}</option>
                </select>
            </div>
        </div>
        <div class="kt-portlet__head d-flex justify-content-center">
            <div class="kt-portlet__head-toolbar">
                <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-brand nav-tabs-line-2x nav-tabs-line-right nav-tabs-bold"
                    role="tablist">
                    <li class="nav-item" v-for="date in dates">
                        <a href="#" :class="['nav-link',{active: date.date === activeDate}]"
                           @click="onActiveDateClick(date.date)">
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
            <div class="row mt-3">
                <div class="col-md-6 offset-md-3">
                    <div class="form-group">
                        <select v-model="from" class="form-control">
                            <option v-for="hour in hours" :value="hour">{{hour}}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select v-model="to" class="form-control">
                            <option v-for="hour in hours" :value="hour">{{hour}}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success" @click="onClick">رزرو</button>
                    </div>
                </div>
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
                coaches: [],
                courts: [],
                bookings: [],
                activeDate: '',
                courtId: '',
                ownerId: '',
                from: '',
                to: '',
            }
        },

        created() {
            this.getDates();
            this.getHours();
            this.getCoaches();
            this.getCourts();
        },

        methods: {

            getDates() {
                axios.get('/admin/ajax/activity/date-time/dates').then(res => this.dates = res.data);
            },

            getHours() {
                axios.get('/admin/ajax/activity/date-time/hours').then(res => this.hours = res.data);
            },

            getCoaches() {
                axios.get('/admin/ajax/coaches').then(res => this.coaches = res.data);
            },

            getCourts() {
                axios.get('/admin/ajax/courts').then(res => this.courts = res.data);
            },

            getCourtBookings() {
                axios.get('/admin/ajax/court/bookings', {
                    params: {
                        date: this.formatDate(this.activeDate),
                        courtId: this.courtId
                    }
                }).then(res => {
                    console.log(res.data);
                });
            },

            onActiveDateClick(date) {
                this.activeDate = date;
                this.getCourtBookings();
            },

            onCourtChange() {
                this.getCourtBookings();
            },

            onClick() {
                console.log(this.activeDate);
                axios.post('/admin/group/bookings', {
                    court_id: this.courtId,
                    renter_name: 'jafar',
                    date: this.formatDate(this.activeDate),
                    from: this.from,
                    to: this.to,
                    owner_id: this.ownerId,
                }).then(res => console.log(res.data.msg)).catch(err => console.log('Error was happend'));
            },

        }
    }
</script>

<style scoped>

</style>