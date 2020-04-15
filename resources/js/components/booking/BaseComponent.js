export default Vue.extend({

    methods: {

        redrawTblHeader(asyncFn) {
            asyncFn.then(() => {
                table.columns.adjust().fixedColumns().relayout();
            });
        }

    },

    computed: {

        showBookedPayLabel: function () {

            if (this.booked) {

                return `${this.booked.renter_name} مبلغ ${this.court.price} تومان بدهکار است`;

            }

        },

        showBookedCancelLabel: function () {

            if (this.booked) {
                return `آیا می خواهید رزرو را برای ${this.booked.renter_name} کنسل کنید؟`;
            }

        },

    },

});