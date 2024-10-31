const { createApp } = Vue

createApp({
    data() {
        return {
            urlGetItemList: `${baseURL}api/goods/list`,          
            urlGetItemDetail: `${baseURL}api/goods/detail`,          
            urlGetEOQList: `${baseURL}api/eoq/list`,   
            urlCreateNewItem: `${baseURL}api/goods/insert`,     
            urlUpdateItem: `${baseURL}api/goods/update`,        
            urlDeleteItem: `${baseURL}api/goods/delete`,      
            dataList: [], eoqList: [],
            form: { id: '', name: '', qty: '0', eoq_id: '', safety_stock: '0' },
            buttonSubmitId: 'createButton', editSelectOption: null,
        }
    },
    mounted() {
        this.getEOQList()
        this.getItemList(true)
    },
    methods: {
        initTable(){
            $('#goodsTable').ready(function(){
                $('#goodsTable').DataTable({
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
            let self = this
            axios.get(this.urlGetItemList, { headers: axiosHeader })
            .then(function (response) {
                if (response.status == 200) {
                    self.dataList = (response.data).data
                    if (init) {
                        self.initTable()
                    } else {
                        $('#goodsTable').DataTable().destroy();
                        self.initTable()
                    }
                }
            })
            .catch(function (error) {
                axiosErrorCallback(error);
            })
        },
        getEOQList() {
            let self = this
            axios.get(this.urlGetEOQList, { headers: axiosHeader })
            .then(function (response) {
                if (response.status == 200) {
                    self.eoqList = (response.data).data
                    new Choices('#select-eoq', {
                        choices: self.parseOptions(self.eoqList),
                    });
                    self.editSelectOption = new Choices('#select-eoq-edit', {
                        choices: self.parseOptions(self.eoqList),
                    });
                }
            })
            .catch(function (error) {
                axiosErrorCallback(error);
            })
        },
        parseOptions(data) {
            let options = []
            for (let i = 0; i < data.length; i++) {
                options.push({ value: data[i].id, label: data[i].name })
            }
            return options
        },
        changeEoq(event) {
            let filter = this.eoqList.filter((item) => item.id == event.target.value)
            this.form.safety_stock = filter[0].eoq_result
        },
        createNewItem() {
            let self = this
            if(this.form.name == '' || this.form.qty == '' || this.form.eoq_id == '') {
                showAlert('error', 'Please fill all required fields')
                return;
            }
            axios.post(this.urlCreateNewItem, this.form, { headers: axiosHeader })
            .then(function (response) {
                if (response.status == 200) {
                    self.getItemList(false)
                    showAlert('success', getMessage('success.create'))
                    $('#goodsNewModal').modal('hide');
                    self.form = { id: '', name: '', qty: '0', eoq_id: '', safety_stock: '0' };
                }
            })
            .catch(function (error) {
                axiosErrorCallback(error);
            })
        },
        editItem(id) {
            let self = this
            axios.get(this.urlGetItemDetail + `?id=${id}`, { headers: axiosHeader })
            .then(function (response) {
                if (response.status == 200) {
                    let data = (response.data).data
                    self.form = { id: data.id, name: data.name, qty: data.qty, eoq_id: data.eoq_id, safety_stock: data.eoq_result };
                    
                    self.editSelectOption.setChoiceByValue(data.eoq_id);

                    $('#goodsEditModal').modal('show');
                }
            })
            .catch(function (error) {
                axiosErrorCallback(error);
            })
        },
        updateItem() {
            let self = this
            if(this.form.name == '' || this.form.qty == '' || this.form.eoq_id == '') {
                showAlert('error', 'Please fill all required fields')
                return;
            }
            let payload = {
                id: self.form.id,
                name: self.form.name,
                qty: self.form.qty,
                eoq_id: self.form.eoq_id
            }
            axios.post(this.urlUpdateItem, payload, { headers: axiosHeader })
            .then(function (response) {
                if (response.status == 200) {
                    self.getItemList(false)
                    showAlert('success', getMessage('success.update'))
                    $('#goodsEditModal').modal('hide');
                    self.form = { id: '', name: '', qty: '0', eoq_id: '', safety_stock: '0' };
                }
            })
            .catch(function (error) {
                axiosErrorCallback(error);
            })
        },
        deleteItem(id) {
            let self = this
            let confirmation = confirm(getMessage('confirm.delete'))
            if(confirmation) {
                axios.post(this.urlDeleteItem, { id: id }, { headers: axiosHeader })
                .then(function (response) {
                    if (response.status == 200) {
                        self.getItemList(false)
                        showAlert('success', getMessage('success.delete'))
                    }
                })
                .catch(function (error) {
                    axiosErrorCallback(error);
                })
            }
        },
    }
}).mount('#app-wrapper')