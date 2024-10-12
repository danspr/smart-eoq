const { createApp } = Vue

createApp({
    data() {
        return {
            urlGetItemList: `${baseURL}api/eoq/list`,
            urlCreateNewItem: `${baseURL}api/eoq/insert`,
            urlDetailItem: `${baseURL}eoq/detail/`,
            urlDeleteItem: `${baseURL}api/eoq/delete`,
            urlGetDetailItem: `${baseURL}api/eoq/item/detail`,
            urlGetUpdateItem: `${baseURL}api/eoq/item/update`,
            dataList: [],
            itemForm: {
                id: '', name: '', annual_demand: '', purchasing_price: ''
            },
            buttonSubmitId: 'createButton',
        }
    },
    mounted() {
        this.getItemList(true)
    },
    methods: {
        initTable(){
            $('#eoqTable').ready(function(){
                $('#eoqTable').DataTable({
                    "responsive": true,
                    "processing": true, 
                    "order": [],
                    "columnDefs": [
                        {"targets": [ -1 ],
                        "orderable": false
                        },
                    ],
                });
           })
        },
        getItemList(init) {
            let self = this;
            axios.get(this.urlGetItemList, { headers: axiosHeader })
            .then(function (response) {
                if(response.status == 200) {
                    self.dataList = (response.data).data;
                    if(init){
                        self.initTable()
                    } else {
                        $('#eoqTable').DataTable().destroy();
                        self.initTable()
                    }
                }
            })
            .catch(function (error) {
                axiosErrorCallback(error);
            })
            .finally(() => {
                hideLoadingButton(this.buttonLoginId, 'Sign In');
            })
        },
        createNewItem(){
            let self = this;
            if(this.itemForm.name == '' || this.itemForm.annual_demand == '' || this.itemForm.purchasing_price == '') {
                showAlert('warning', 'All fields are required');
                return;
            }

            showLoadingButton(this.buttonSubmitId);
            axios.post(this.urlCreateNewItem, this.itemForm, { headers: axiosHeader })
            .then(function (response) {
                if(response.status == 200) {
                    let data = (response.data).data;
                    showAlert('success', getMessage('success.create'));
                    setTimeout(() => {
                        redirect(self.urlDetailItem + data.id);
                    }, 1000)
                }
            })
            .catch(function (error) {
                axiosErrorCallback(error);
            })
            .finally(() => {
                hideLoadingButton(this.buttonSubmitId, 'Create');
            })
        },
        deleteItem(id) {
            let self = this;
            let confirmation = confirm(getMessage('confirm.delete'));
            if(confirmation) {
                axios.post(this.urlDeleteItem, { id: id }, { headers: axiosHeader })
                .then(function (response) {
                    if(response.status == 200) {
                        showAlert('success', getMessage('success.delete'));
                        setTimeout(() => {
                            self.getItemList(false);
                        }, 1000)
                    }
                })
                .catch(function (error) {
                    axiosErrorCallback(error);
                })
            }
        },
        getItemDetail(id) {
            let self = this;
            this.itemForm.id = id;
            axios.get(this.urlGetDetailItem + `?id=${id}`, { headers: axiosHeader })
            .then(function (response) {
                if(response.status == 200) {
                    self.itemForm.id = (response.data).data.id;
                    self.itemForm.name = (response.data).data.name;
                    self.itemForm.annual_demand = (response.data).data.annual_demand;
                    self.itemForm.purchasing_price = (response.data).data.purchasing_price;
                    $('#eoqUpdateModal').modal('show');
                }
            })
            .catch(function (error) {
                axiosErrorCallback(error);
            })
        },
        updateItem() {
            let self = this;
            if(this.itemForm.name == '' || this.itemForm.annual_demand == '' || this.itemForm.purchasing_price == '') {
                showAlert('warning', 'All fields are required');
                return;
            }

            let confirmation = confirm("If you update the item, the analysis result will be reset. Do you want to continue?");
            if(confirmation) {
                axios.post(this.urlGetUpdateItem, this.itemForm, { headers: axiosHeader })
                .then(function (response) {
                    if(response.status == 200) {
                        showAlert('success', getMessage('success.update'));
                        setTimeout(() => {
                            redirect(self.urlDetailItem + self.itemForm.id);
                        }, 1000)
                        $('#eoqUpdateModal').modal('hide');
                    }
                })
                .catch(function (error) {
                    axiosErrorCallback(error);
                })
            }
        },    
        formatCurrency(number){
            return 'Rp '+ new Intl.NumberFormat().format(number);
        },
        formatNumber(number){
            return new Intl.NumberFormat().format(number);
        }
    }
}).mount('#app-wrapper')