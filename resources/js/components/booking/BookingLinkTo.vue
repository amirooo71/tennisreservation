<template>

    <div class="form-group row">
        <div class="col-md-5">
            <select v-model="hour" class="form-control">
                <option v-for="hour in hours" :value="hour"></option>
            </select>
        </div>
        <div class="col-md-5">
            <select v-model="court" class="form-control">
                <option v-for="(item,index) in courts" :value="index">{{item}}</option>
            </select>
        </div>
        <div class="col-md-2" id="toggle">
            <button id="tgg" class="btn btn-info btn-block" @click="onClick">جست و جو</button>
            <a data-easing="linear" href="#court-43-at-14">asdf</a>
        </div>
    </div>

</template>

<script>

    import VueScrollTo from 'vue-scrollto';

    export default {
        name: "booking-link-to",

        components: {VueScrollTo},

        data() {
            return {
                hours: [],
                courts: [],
                hour: '',
                court: '',
                options: {
                    x: true,
                    y: false
                }
            }
        },

        created() {
            this.getHours();
            this.getCourts();
        },

        methods: {

            getHours() {
                axios.get('/admin/hours').then(res => this.hours = res.data);
            },

            getCourts() {
                axios.get('/admin/courts').then(res => this.courts = res.data);
            },

            onClick() {
                console.log(123);
                this.$scrollTo('#court-43-at-07',1,this.options);
            },

            onStart() {
            },

            onDone() {

            },

            onCancel() {

            },

        }

    }
</script>

<style scoped>

</style>