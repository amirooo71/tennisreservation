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
                    <div class="kt-list-timeline__item">
                        <span class="kt-list-timeline__badge"></span>
                        <span class="kt-list-timeline__text">12 new users registered and pending for activation</span>
                        <span class="kt-list-timeline__time">Just now</span>
                    </div>
                    <div class="kt-list-timeline__item">
                        <span class="kt-list-timeline__badge"></span>
                        <span class="kt-list-timeline__text">Scheduled system reboot completed <span
                                class="kt-badge kt-badge--brand kt-badge--inline">completed</span></span>
                        <span class="kt-list-timeline__time">14 mins</span>
                    </div>
                    <div class="kt-list-timeline__item">
                        <span class="kt-list-timeline__badge"></span>
                        <span class="kt-list-timeline__text">New order has been planced and pending for processing</span>
                        <span class="kt-list-timeline__time">20 mins</span>
                    </div>
                    <div class="kt-list-timeline__item">
                        <span class="kt-list-timeline__badge"></span>
                        <span class="kt-list-timeline__text">Database server overloaded 80% and requires quick reboot <span
                                class="kt-badge kt-badge--danger kt-badge--inline">settled</span></span>
                        <span class="kt-list-timeline__time">1 hr</span>
                    </div>
                    <div class="kt-list-timeline__item">
                        <span class="kt-list-timeline__badge"></span>
                        <span class="kt-list-timeline__text">System error occured and hard drive has been shutdown - <a
                                href="#" class="kt-link">Check</a></span>
                        <span class="kt-list-timeline__time">2 hrs</span>
                    </div>
                    <div class="kt-list-timeline__item">
                        <span class="kt-list-timeline__badge"></span>
                        <span class="kt-list-timeline__text">Production server is rebooting...</span>
                        <span class="kt-list-timeline__time">3 hrs</span>
                    </div>
                </div>
            </div>
            <div class="form-group mt-3">
                <textarea name="" id="" cols="30" rows="10" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-success">ذخیره</button>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name: "note",

        data() {
            return {}
        },

        mounted(){
            console.log('open');
        },

        methods: {
            onClosePanel() {
                Events.$emit('close-booking-note-panel');
            }
        }
    }
</script>

<style scoped>

</style>