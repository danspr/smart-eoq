const { createApp } = Vue

createApp({
    data() {
        return {
            urlGetItemList: `${baseURL}api/eoq-parameter/list`,
            urlGetItemDetail: `${baseURL}api/eoq-parameter/detail`,
            urlDeleteItem: `${baseURL}api/eoq-parameter/delete`,
            urlCreateItem: `${baseURL}api/eoq-parameter/insert`,
            urlUpdateItem: `${baseURL}api/eoq-parameter/update`,
            urlUpdateDefaultItem: `${baseURL}api/eoq-parameter/default/update`,
            urlDeleteDefaultItem: `${baseURL}api/eoq-parameter/default/delete`,
            tableId: { hc: '#eoqParamHCTable', tc: '#eoqParamTCTable', default: '#eoqParamDefaultTable' },
            dataList: { hc: [], tc: [], default: [] },
            form: { id: '', name: '', category: '', value: '' },
            newParameterBtnId: 'eoqParameterNewModalButton',
            editParameterBtnId: 'eoqParameterUpdateModalButton',
        }
    },
    mounted() {
        this.getParameterList('HC', this.tableId.hc, true)
        this.getParameterList('TC', this.tableId.tc, true)
        this.getParameterList('default', this.tableId.default, true)
        this.initView()
    },
    methods: {
        initTable(tableId){
            $(tableId).ready(function(){
                $(tableId).DataTable({
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
        initView() {
            let self = this;
            let clearModal = function() {
                self.form = { id: '', name: '', category: '', value: '' };
                $('#eoqParameterEditModalName').prop('disabled', false);
            }
            $("#eoqParameterEditModal").on('hide.bs.modal', function(){
                clearModal();
            });
            $("#eoqParameterNewModal").on('hide.bs.modal', function(){
                clearModal();
            });
        },
        getParameterList(category, tableId, init) {
            let self = this
            axios.get(this.urlGetItemList + `?category=${category}`, { headers: axiosHeader })
            .then(function (response) {
                if (response.status == 200) {
                    if (category == 'HC') {
                        self.dataList.hc = (response.data).data;
                    } else if (category == 'TC') {
                        self.dataList.tc = (response.data).data;
                    }  else if (category == 'default') {
                        self.dataList.default = (response.data).data;
                    }
                    if (init) {
                        self.initTable(tableId)
                    } else {
                        $(tableId).DataTable().destroy();
                        self.initTable(tableId)
                    }
                }
            })
            .catch(function (error) {
                axiosErrorCallback(error);
            })
            .finally(() => {
                // hideLoadingButton(this.buttonLoginId, 'Sign In');
            });      
        },
        deleteParameter(id) {
            let self = this
            let confirmation = confirm(getMessage('confirm.delete'))
            if (confirmation) {
                axios.post(this.urlDeleteItem, { id: id }, { headers: axiosHeader })
                .then(function (response) {
                    if (response.status == 200) {
                        showAlert('success', getMessage('success.delete'))
                        self.getParameterList('HC', self.tableId.hc, false)
                        self.getParameterList('TC', self.tableId.tc, false)
                    }
                })
                .catch(function (error) {
                    axiosErrorCallback(error);
                })
            }
        },
        showNewParameterModal(category){
            let self = this
            this.form.category = category;
            if (category == 'HC') {
                $('#eoqNewParameterModalTitle').text('New Holding Cost (HC) Parameter')
                $('#eoqNewParameterModalValue').text('Value (%)')
            } else if (category == 'TC') {
                $('#eoqNewParameterModalTitle').text('New Transaction Cost (TC) Parameter')
                $('#eoqNewParameterModalValue').text('Value (Hour)')
            }
            $('#eoqParameterNewModal').modal('show');
        },
        showUpdateParameterModal(category){
            let self = this
            this.form.category = category;
            if (category == 'HC') {
                $('#eoqNewParameterModalTitle').text('New Holding Cost (HC) Parameter')
                $('#eoqNewParameterModalValue').text('Value (%)')
            } else if (category == 'TC') {
                $('#eoqNewParameterModalTitle').text('New Transaction Cost (TC) Parameter')
                $('#eoqNewParameterModalValue').text('Value (Hour)')
            } else if(category == 'default') {
                $('#eoqParameterEditModalName').prop('disabled', true);
            }
            $('#eoqParameterEditModal').modal('show');
        },
        createParameter(){
            let self = this
            let payload = {
                name: this.form.name,
                category: this.form.category,
                value: this.form.value
            }

            showLoadingButton(this.newParameterBtnId, 'Saving...');
            axios.post(this.urlCreateItem, payload, { headers: axiosHeader })
            .then(function (response) {
                if (response.status == 200) {
                    showAlert('success', getMessage('success.create'))
                    self.getParameterList('HC', self.tableId.hc, false);
                    self.getParameterList('TC', self.tableId.tc, false);
                    $('#eoqParameterNewModal').modal('hide');
                }
            })
            .catch(function (error) {
                axiosErrorCallback(error);
            })
            .finally(() => {
                hideLoadingButton(this.newParameterBtnId, 'Create');
            })
        },
        getParameterDetail(id, category) {
            let self = this
            this.form.category = category
            this.form.id = id;

            axios.get(this.urlGetItemDetail + `?id=${id}&category=${this.form.category}`, { headers: axiosHeader })
            .then(function (response) {
                if (response.status == 200) {
                    self.form.id = (response.data).data.id;
                    self.form.name = (response.data).data.name;
                    self.form.value = (response.data).data.value;
                    self.showUpdateParameterModal(self.form.category)
                }
            })
            .catch(function (error) {
                axiosErrorCallback(error);
            })
        },
        updateParameter(){
            if(this.form.category == 'default') {
                this.updateDefaultParameter();
                return;
            }
            let self = this;
            let payload = {
                id: this.form.id,
                name: this.form.name,
                value: this.form.value
            }
            showLoadingButton(this.editParameterBtnId, 'Saving...');
            axios.post(this.urlUpdateItem, payload, { headers: axiosHeader })
            .then(function (response) {
                if (response.status == 200) {
                    showAlert('success', getMessage('success.update'))
                    self.getParameterList('HC', self.tableId.hc, false);
                    self.getParameterList('TC', self.tableId.tc, false);
                    $('#eoqParameterEditModal').modal('hide');
                }
            })
            .catch(function (error) {
                axiosErrorCallback(error);
            })
            .finally(() => {
                hideLoadingButton(this.editParameterBtnId, 'Update');
            })
        },
        updateDefaultParameter(){
            let self = this;
            let payload = {
                id: this.form.id,
                value: this.form.value
            }
            showLoadingButton(this.editParameterBtnId, 'Saving...');
            axios.post(this.urlUpdateDefaultItem, payload, { headers: axiosHeader })
            .then(function (response) {
                if (response.status == 200) {
                    showAlert('success', getMessage('success.update'))
                    self.getParameterList('default', self.tableId.default, false);
                    $('#eoqParameterEditModal').modal('hide');
                }
            })
            .catch(function (error) {
                axiosErrorCallback(error);
            })
            .finally(() => {
                hideLoadingButton(this.editParameterBtnId, 'Update');
            })
        }  
    }
}).mount('#app-wrapper')