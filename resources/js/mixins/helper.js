export default {

    methods: {

        today() {
            jmoment.loadPersian({
                usePersianDigits: false,
            });
            return moment().format('YYYY-M-D')
        },

        formatTime(time, format = 'HH:mm') {
            return moment(time, 'HH:mm').format(format);
        },

        formatDate(date) {
            jmoment.loadPersian({
                usePersianDigits: false,
            });
            return moment(date, 'YYYY-M-D').format('YYYY-M-D')
        },

        redrawTblHeader(asyncFn) {
            asyncFn.then(() => {
                table.columns.adjust().fixedColumns().relayout();
            });
        },

    },


}