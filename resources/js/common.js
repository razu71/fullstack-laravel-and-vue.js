export default {
    data() {
        return {
            token: ''
        }
    },
    created() {
        this.token = window.Laravel.csrfToken;
    },
    methods: {
        async callApi(method, url, dataObj) {
            try {
                return await axios({
                    method: method,
                    url: url,
                    data: dataObj,
                    // headers: {
                    //     Accept: 'application/json'
                    // }
                });
            } catch (error) {
                return error.response;
            }
        },
        //show toaster notification
        info(title, des) {
            this.$Notice.info({
                title: title,
                desc: des
            });
        },
        success(title, des) {
            this.$Notice.success({
                title: title,
                desc: des
            });
        },
        warning(title, des) {
            this.$Notice.warning({
                title: title,
                desc: des
            });
        },
        error(title, des) {
            this.$Notice.error({
                title: title,
                desc: des
            });
        },
        swr(title, des) {
            this.$Notice.error({
                title: title,
                desc: des
            });
        }
    },
}
