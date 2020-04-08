export default {

    methods: {

        formatTime(time, format = 'HH:mm') {
            return moment(time, 'HH:mm').format(format);
        },

    }


}