<template>
    <div>
        <div class="form-group text-left">
            <label class="kt-checkbox">
                <input type="checkbox" @change="hasPartTime = !hasPartTime" :checked="hasPartTime">
                تغییر ساعت
                <span></span>
            </label>
        </div>
        <div class="form-group" v-if="hasPartTime">
            <label>ساعت شروع رزرو</label>
            <vue-timepicker
                    :disabled="end !== ''"
                    auto-scroll
                    hour-label="ساعت"
                    minute-label="دقیقه"
                    v-model="start"
                    input-class="form-control"
                    :minute-interval="15"
                    :minute-range="[15,30,45]"
                    :hour-range="[getCurrentHour]"
                    @open="start = hour"
                    @change="onStartTimeChange"></vue-timepicker>
            <span class="form-text text-muted pt-3">شما می توانید ساعت شروع رزرو را در اینجا تغییر دهید به عنوان مثال (16:30)</span>
        </div>
        <div class="form-group" v-if="hasPartTime">
            <label>ساعت پایان رزرو</label>
            <vue-timepicker
                    :disabled="start !== ''"
                    auto-scroll
                    hour-label="ساعت"
                    minute-label="دقیقه"
                    v-model="end"
                    input-class="form-control"
                    :minute-interval="15"
                    :minute-range="[15,30,45]"
                    :hour-range="[getCurrentHour]"
                    @open="end = hour"
                    @change="onEndTimeChange"
            ></vue-timepicker>
            <span class="form-text text-muted pt-3">شما می توانید ساعت پایان رزرو را در اینجا تغییر دهید به عنوان مثال (16:30)</span>
        </div>
    </div>
</template>

<script>

    import VueTimepicker from 'vue2-timepicker';

    export default {

        name: "part-time-input-hours",

        props: ['booked', 'hour'],

        components: {VueTimepicker},

        data() {
            return {
                hasPartTime: false,
                start: '',
                end: '',
            }
        },


        mounted() {
            Events.$on('reset-part-time-hours', () => {
                this.hasPartTime = false;
                this.start = '';
                this.end = '';
            });
        },

        methods: {

            onStartTimeChange() {
                let time = this.start.split(':');
                let durations = {
                    '15': '45',
                    '30': '30',
                    '45': '15',
                };
                // SartTime must be have different than hour
                this.$emit('timeChanged', {
                    startTime: time[1] !== '00' ? this.start : null,
                    duration: durations[time[1]]
                })

            },

            onEndTimeChange() {
                let time = this.end.split(':');
                // Endtime must be have different than hour
                this.$emit('timeChanged', {
                    endTime: time[1] !== '00' ? this.end : null,
                    duration: time[1] !== '00' ? time[1] : 60
                })
            }

        },

        computed: {

            getCurrentHour: function () {

                let firstChar = this.hour.charAt(0);

                if (firstChar !== 0) {
                    return this.hour.slice(0, 2);
                } else {
                    return this.hour.slice(0, 1);
                }
            },

        },


    }
</script>

<style scoped>

</style>