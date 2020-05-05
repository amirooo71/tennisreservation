<template>

    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        یادداشت ها
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-actions">
                        <a href="#" class="btn btn-sm btn-icon btn-clean btn-icon-md"
                           @click.prevent="onClosePanel"><i class="la la-close"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="kt-list-timeline">
                <div class="kt-list-timeline__items">
                    <div class="kt-list-timeline__item" v-for="note in notes">
                        <span class="kt-list-timeline__badge"></span>
                        <span class="kt-list-timeline__text">{{note.description}}</span>
                        <span class="kt-list-timeline__time">{{formatTime(note.time)}}</span>
                    </div>
                </div>
            </div>
            <div class="form-group mt-3">
                <textarea v-model="description" cols="30" rows="5" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-success" @click="onSubmit">ذخیره</button>
            </div>
        </div>
    </div>

</template>

<script>

    import helper from './../../mixins/helper';

    export default {
        name: "note",

        props: ['date'],

        mixins: [helper],

        data() {
            return {
                description: '',
                notes: [],
            }
        },


        created() {
            this.getNotes();
        },

        methods: {
            onClosePanel() {
                Events.$emit('close-booking-note-panel');
            },

            getNotes() {

                axios.get('/admin/ajax/booking/note', {params: {date: this.date}}).then(res => {
                    this.notes = res.data;
                });

            },

            onSubmit() {
                axios.post('/admin/ajax/booking/note', {description: this.description, date: this.date})
                    .then(res => {
                        console.log(res.data.note);
                        this.notes.push(res.data.note);
                        this.description = '';
                        toastr.success(res.data.msg);
                    })
                    .catch(err => {
                        toastError();
                    });
            }
        }
    }
</script>

<style scoped>

</style>