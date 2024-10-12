const { createApp } = Vue

createApp({
    data() {
        return {
            urlGetItemList: `${baseURL}api/eoq/detail`,
            urlUpdateResultItem: `${baseURL}api/eoq/update`,
            itemId: customParam.itemId,
            data: {
                holding_cost: { parameters: [] },
                transaction_cost: { parameters: [] },
                eoq_analysis: {}
            },
        }
    },
    mounted() {
        this.getDetailResult()
    },
    methods: {
        getDetailResult() {
            let self = this;
            axios.get(this.urlGetItemList + '?id=' + this.itemId, { headers: axiosHeader })
            .then(function (response) {
                if(response.status == 200) {
                    self.data = (response.data).data;
                }
            })
            .catch(function (error) {
                axiosErrorCallback(error);
            })
            .finally(() => {
                hideLoadingButton(this.buttonLoginId, 'Sign In');
            })
        },
        updateResult(){
            let self = this;
            let payload = {
                id: this.itemId,
                ... this.data.eoq_analysis
            }
            axios.post(this.urlUpdateResultItem, payload, { headers: axiosHeader })
            .then(function (response) {
                if(response.status == 200) {
                    showAlert('success', getMessage('success.update'));
                    setTimeout(() => {
                        redirect(baseURL + 'eoq');
                    }, 1000)
                }
            })
            .catch(function (error) {
                axiosErrorCallback(error);
            })
        },
        formatCurrency(number){
            return 'Rp '+ new Intl.NumberFormat().format(number);
        },
        formatNumber(number){
            return new Intl.NumberFormat().format(number);
        }
    }
}).mount('#app-wrapper')