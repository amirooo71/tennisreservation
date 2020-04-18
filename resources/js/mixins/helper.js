export default {

    methods: {

        formatTime(time, format = 'HH:mm') {
            return moment(time, 'HH:mm').format(format);
        },

        redrawTblHeader(asyncFn) {
            asyncFn.then(() => {
                table.columns.adjust().fixedColumns().relayout();
            });
        }

    }


}