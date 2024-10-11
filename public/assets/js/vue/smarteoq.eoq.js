const { createApp } = Vue

createApp({
    data() {
        return {
            urlGetItemList: `${baseURL}api/eoq/list`,
            urlRegisterValidationPage: `${baseURL}register-confirmation`,
            dataList: [],
        }
    },
    mounted() {
        this.getItemList()
    },
    methods: {
        getItemList() {
            let self = this;
            axios.get(this.urlGetItemList, { headers: axiosHeader })
            .then(function (response) {
                if(response.status == 200) {
                    self.dataList = (response.data).data;
                }
            })
            .catch(function (error) {
                axiosErrorCallback(error);
            })
            .finally(() => {
                hideLoadingButton(this.buttonLoginId, 'Sign In');
            })
        }
    }
}).mount('#app-wrapper')