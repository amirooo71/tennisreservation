<template>
    <td class="text-center bg-light" @click="onClick">
    </td>
</template>

<script>
    export default {
        name: "book",

        props: ['court', 'hour', 'date'],

        data() {

            return {}

        },

        methods: {

            onClick() {
                Swal.fire({
                    title: `نام اجاره کننده را وارد کنید`,
                    text: `${this.court.name} در ساعت ${this.hour}`,
                    input: 'text',
                    showCancelButton: true,
                    confirmButtonText: 'ذخیره',
                    cancelButtonText: 'بستن',
                    showLoaderOnConfirm: true,
                    preConfirm: (name) => {

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
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.value) {
                        console.log(result);
                    }
                })
            }

        }
    }
</script>

<style scoped>

</style>