<template>

    <div class="kt-portlet kt-portlet--tabs">

        <loading :active.sync="loading" :is-full-page="true"></loading>

        <div class="row mt-5 mx-4">
            <div class="form-group col-md-6">
                <label>انتخاب زمین</label>
                <select v-model="courtId" class="form-control" @change="onCourtChange">
                    <option v-for="court in courts" :value="court.id">{{court.name}}</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label>انتخاب مربی</label>
                <select v-model="coachId" class="form-control" :disabled="!courtId" @change="onCoachChange">
                    <option v-for="coach in coaches" :value="coach.id">{{coach.first_name}}</option>
                </select>
            </div>
        </div>
        <div v-if="coachId">
            <div class="kt-portlet__head d-flex justify-content-between align-items-center">

                <a href="#" @click.prevent="onPrevWeek">
                    <i class="fas fa-arrow-alt-circle-right" style="font-size: 3rem;"></i>
                </a>

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

                <a href="#" @click.prevent="onNextWeek">
                    <i class="fas fa-arrow-alt-circle-left" style="font-size: 3rem;"></i>
                </a>

            </div>
            <div class="kt-portlet__body">
                <div class="row mt-3">
                    <div class="col-md-6 offset-md-3">
                        <div v-if="activeDate">
                            <div class="alert alert-danger fade show" role="alert" v-if="bookings.length > 0">
                                <div class="alert-icon"><i class="flaticon-questions-circular-button"></i></div>
                                <div class="alert-text">در این تاریخ رزرو انجام شده است و شما امکان انجام عملیات رزرو
                                    گروهی را ندارید
                                </div>
                            </div>
                            <form action="" v-else>
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
                                    <button class="btn btn-success" @click.prevent="onClick">
                                        رزرو
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div v-else>
                            <div class="text-center">
                                <h4 class="text-muted">تاریخ مورد نظر را انتخاب کنید</h4>
                                <i class="text-secondary fas fa-calendar-week my-5" style="font-size: 15rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else>
            <div class="row">
                <div class="col">
                    <div class="text-center">
                        <h4 class="text-muted">زمین و مربی مورد نظر را انتخاب کنید</h4>
                        <i class="fas fa-running text-secondary my-5" style="font-size: 20rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>

    import helper from './../../mixins/helper';
    import Loading from 'vue-loading-overlay';

    export default {
        name: "bookings",

        mixins: [helper],

        components: {
            Loading,
        },

        data() {
            return {
                dates: [],
                hours: [],
                coaches: [],
                courts: [],
                bookings: [],
                activeDate: '',
                courtId: '',
                coachId: '',
                renterName: '',
                from: '',
                to: '',
                loading: false,
                endOfWeek: '',
            }
        },

        created() {
            this.getDates();
            this.getHours();
            this.getCoaches();
            this.getCourts();
        },

        methods: {

            getDates(param = null) {
                axios.get('/admin/ajax/activity/date-time/dates', param).then(res => {
                    this.endOfWeek = res.data.endOfWeek;
                    this.dates = res.data.week;
                });
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
                    this.bookings = res.data;
                });
            },

            onActiveDateClick(date) {
                this.activeDate = date;
                this.from = '';
                this.to = '';
                this.getCourtBookings();
            },

            onCourtChange() {
                this.activeDate = '';
                this.from = '';
                this.to = '';
                this.bookings = [];
            },

            onCoachChange() {
                this.activeDate = '';
                this.from = '';
                this.to = '';
                this.bookings = [];
            },

            onClick() {
                this.loading = true;
                axios.post('/admin/hours/bookings', {
                    court_id: this.courtId,
                    renter_name: this.renterName,
                    date: this.formatDate(this.activeDate),
                    from: this.from,
                    to: this.to,
                    coach_id: this.coachId,
                }).then(res => {
                    this.activeDate = '';
                    this.courtId = '';
                    this.coachId = '';
                    this.bookings = [];
                    this.from = '';
                    this.to = '';
                    this.renterName = '';
                    this.loading = false;
                    toastr.success(res.data.msg);
                }).catch(err => {
                    this.loading = false;
                    toastError(err.response.data.msg)
                });
            },

            onPrevWeek() {
                this.getDates({params: {prevWeek: 1, endOfWeek: this.endOfWeek}});
                this.activeDate = '';
                this.bookings = [];
            },

            onNextWeek() {
                this.getDates({params: {nextWeek: 1, endOfWeek: this.endOfWeek}});
                this.activeDate = '';
                this.bookings = [];
            },

        },

        watch: {
            coachId: function (val) {
                this.coaches.forEach(c => {
                    if (c.id === val) {
                        this.renterName = c.first_name + ' ' + c.last_name;
                    }
                });
            }
        }
    }
</script>

<style scoped>

</style>
