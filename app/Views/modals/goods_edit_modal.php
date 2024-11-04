<div class="modal fade" id="goodsEditModal" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">New Product
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fs-14 text-dark">Item Name</label>
                    <input type="text" class="form-control" placeholder="" v-model="form.name">
                </div>
                <div class="mb-3">
                    <label class="form-label fs-14 text-dark">Current Stock</label>
                    <input type="number" min='0' class="form-control"  placeholder="" v-model="form.qty">
                </div>
                <div class="mb-3">
                    <label class="form-label fs-14 text-dark">EOQ Analysis</label>
                    <select class="form-control" data-trigger id="select-eoq-edit" v-model="form.eoq_id" @change="changeEoq($event)">
                        <option value="">Select EOQ Item</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fs-14 text-dark">Safety Stock</label>
                    <input type="text" disabled class="form-control" v-model="form.safety_stock">
                </div>
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" @click="updateItem"  id="createButton">Update</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>