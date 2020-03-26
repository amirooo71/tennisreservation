<template>
    <td :class="[defaultClass,bookClass,cancelClass]"
        v-on="{ click: isBooked ? onCancelClick : onBookClick }">
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
                bookedId: '',
                isCanceled: false,
            }

        },

        mounted() {

            this.showBookings();

        },

        methods: {

            onBookClick() {
                Swal.fire({
                    title: `نام رزرو کننده را وارد کنید`,
                    text: `${this.court.name} برای ساعت ${this.hour}`,
                    input: 'text',
                    showCancelButton: true,
                    confirmButtonText: 'ذخیره',
                    confirmButtonColor: '#3085d6',
                    cancelButtonText: 'بستن',
                    showLoaderOnConfirm: true,
                    preConfirm: (name) => this.book(name),
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => this.onSuccessBook(result))
            },

            onCancelClick() {

                Swal.fire({
                    title: `آیا می خواهید رزرو را برای ${this.renterName} لغو کنید؟`,
                    text: `${this.court.name} برای ساعت ${this.hour}  رزرو شده است`,
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'بله لغو کن!',
                    cancelButtonText: 'خیر'
                }).then((result) => {
                    if (result.value) {
                        axios.patch(`/admin/bookings/${this.bookedId}`).then(res => {
                            this.isBooked = false;
                            this.renterName = '';
                            this.bookedId = '';
                            this.isCanceled = true;
                            toastr.success(res.data.msg);
                        }).catch(err => toastr.warning('خطایی رخ داده'));
                    }
                });

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
                    this.bookedId = result.value.book.id;
                    this.isCanceled = false;
                    toastr.success(result.value.msg);
                }
            },

            showBookings() {
                this.court.bookingsDate.forEach(b => {
                    let time = moment(b.time, 'HH:mm').format('HH:mm');
                    if (this.date === b.date && this.hour === time) {
                        this.isBooked = true;
                        this.renterName = b.renter_name;
                        this.bookedId = b.id;
                    }
                });
            },

        },

        computed: {

            defaultClass() {
                return 'text-center td-book';
            },

            bookClass() {
                return this.isBooked ? ' bg-success text-white animated zoomIn faster' : '';
            },

            cancelClass() {
                return this.isCanceled ? ' bg-danger text-white animated zoomOut' : '';
            }


        },
    }
</script>

<style scoped>

    .td-book:hover {
        border-bottom: 1px solid #007bff !important;
        cursor: pointer;
    }

</style>