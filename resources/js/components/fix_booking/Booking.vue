<template>

    <div>

        <loading :active.sync="loading" :is-full-page="true"></loading>

        <ValidationObserver v-slot="{ handleSubmit }">
            <form @submit.prevent="handleSubmit(onSubmit)">

                <div class="form-group">
                    <ValidationProvider name="Court-id" rules="required" v-slot="{ errors }">
                        <label>کورت</label>
                        <select v-model="court_id" class="form-control">
                            <option v-for="court in courts" :value="court.id">{{ court.name }}</option>
                        </select>
                        <span class="form-text text-danger" v-if="errors[0]">
                        <i class="fas fa-exclamation-circle"></i>
                         {{ errors[0] }}
                    </span>
                    </ValidationProvider>
                </div>

                <div class="form-group">
                    <ValidationProvider name="Renter-name" rules="" v-slot="{ errors }">
                        <label>نام رزرو کننده</label>
                        <input type="text" class="form-control" v-model="renter_name">
                        <span class="form-text text-danger" v-if="errors[0]">
                      <i class="fas fa-exclamation-circle"></i>
                         {{ errors[0] }}
                  </span>
                    </ValidationProvider>
                </div>

                <div class="form-group">
                    <ValidationProvider name="Coach-id" rules="" v-slot="{ errors }">
                        <lavel>نام مربی</lavel>
                        <select class="form-control" v-model="coach_id">
                            <option v-for="coach in coaches" :value="coach.id">
                                {{ coach.first_name + ' ' + coach.last_name }}
                            </option>
                        </select>
                        <span class="form-text text-danger" v-if="errors[0]">
                      <i class="fas fa-exclamation-circle"></i>
                         {{ errors[0] }}
                  </span>
                    </ValidationProvider>
                </div>

                <div class="form-group">
                    <label>نام شاگرد</label>
                    <select @change="onPlayerChange" name="player_id" v-model="player_id" class="form-control">
                        <option v-for="player in players" :value="player.id">
                            {{ player.first_name + ' ' + player.last_name }}
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <ValidationProvider name="day" rules="required" v-slot="{ errors }">
                        <label>روز هفته</label>
                        <select v-model="day" name="day" id="day" class="form-control">
                            <option value="شنبه">شنبه</option>
                            <option value="یکشنبه">یکشنبه</option>
                            <option value="دوشنبه">دوشنبه</option>
                            <option value="سه شنبه">سه شنبه</option>
                            <option value="چهارشنبه">چهارشنبه</option>
                            <option value="پنج شنبه">پنج شنبه</option>
                            <option value="جمعه">جمعه</option>
                        </select>
                        <span class="form-text text-danger" v-if="errors[0]">
                      <i class="fas fa-exclamation-circle"></i>
                         {{ errors[0] }}
                  </span>
                    </ValidationProvider>
                </div>

                <div class="form-group">
                    <ValidationProvider name="time" rules="required" v-slot="{ errors }">
                        <label>ساعت</label>
                        <select v-model="time" name="time" id="time" class="form-control">
                            <option v-for="hour in hours">{{ hour }}</option>
                        </select>
                        <span class="form-text text-danger" v-if="errors[0]">
                      <i class="fas fa-exclamation-circle"></i>
                         {{ errors[0] }}
                  </span>
                    </ValidationProvider>
                </div>

                <button type="submit" class="btn btn-success">ذخیره</button>
            </form>
        </ValidationObserver>

    </div>


</template>

<script>

import {ValidationProvider, ValidationObserver, extend} from 'vee-validate';
import {required} from 'vee-validate/dist/rules';
import Loading from 'vue-loading-overlay';

extend('required', required);

export default {

    name: "booking",

    props: ['courts', 'hours', 'coaches', 'players'],

    components: {
        ValidationProvider,
        ValidationObserver,
        Loading
    },

    data() {
        return {
            court_id: '',
            renter_name: '',
            coach_id: '',
            partner_name: '',
            day: '',
            time: '',
            player_id: '',
            loading: false,
        }
    },

    methods: {

        onSubmit() {
            this.store();
        },

        store() {
            this.loading = true;
            axios.post('/admin/fix/bookings', this.$data)
                .then(res => {
                    this.court_id = this.renter_name = this.coach_id = this.player_id = this.partner_name = this.day = this.time = '';
                    this.loading = false;
                    toastr.success(res.data.msg);
                    Events.$emit('success-fix-booked', {booked: res.data.booked});
                })
                .catch(err => {
                    this.loading = false;
                    toastError(err.response.data.msg);
                });
        },

        onPlayerChange(e) {
            let player = this.players.find(player => player.id == e.target.value);
            this.partner_name = player.first_name + ' ' + player.last_name;
            console.log(this.partner_name);
        }

    },
}
</script>

<style scoped>

</style>
