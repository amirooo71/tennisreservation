<template>
    <td :class="tdCssClass"
        v-on="{ click: isBooked ? onManageBookedClick : onBookClick }">
        {{renterName}}
    </td>
</template>

<script>
    export default {

        name: "book",

        props: ['court', 'hour', 'date'],

        data() {

            return {
                isBooked: false,
                renterName: '',
            }

        },

        mounted() {

            this.showBookings();

        },

        methods: {

            onBookClick() {
                Swal.fire({
                    title: `نام اجاره کننده را وارد کنید`,
                    text: `${this.court.name} در ساعت ${this.hour}`,
                    input: 'text',
                    showCancelButton: true,
                    confirmButtonText: 'ذخیره',
                    cancelButtonText: 'بستن',
                    showLoaderOnConfirm: true,
                    preConfirm: (name) => this.book(name),
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => this.onSuccessBook(result))
            },

            onManageBookedClick() {
                console.log('manage');
            },

            book(name) {
                return axios.post('/admin/bookings', {
                    renter_name: name,
                    court_id: this.court.id,
                    date: this.date,
                    time: this.hour,
                }).then(res => {
                    return res.data;

                }).catch(err => {
                    Swal.showValidationMessage(
                        `Request failed:`
                    )
                });
            },

            onSuccessBook(result) {
                if (result.value) {
                    this.isBooked = true;
                    this.renterName = result.value.book.renter_name;
                }
            },

            showBookings() {
                this.court.bookingsDate.forEach(b => {
                    let time = moment(b.time, 'HH:mm').format('HH:mm');
                    if (this.date === b.date && this.hour === time) {
                        this.isBooked = true;
                        this.renterName = b.renter_name;
                    }
                });
            },

        },

        computed: {

            tdCssClass() {
                return this.isBooked ? 'text-center text-white bg-success animated zoomIn faster' : 'text-center bg-light';
            }

        },
    }
</script>

<style scoped>

</style>