<div class="modal fade" id="eoqNewModal" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">New EOQ Analysis
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fs-14 text-dark">Item Name</label>
                    <input type="text" class="form-control" placeholder="" v-model="itemForm.name">
                </div>
                <div class="mb-3">
                    <label class="form-label fs-14 text-dark">Annual Demmand</label>
                    <input type="number" min="0" class="form-control"  placeholder="" v-model="itemForm.annual_demand">
                </div>
                <div class="mb-3">
                    <label class="form-label fs-14 text-dark">Purchasing Price</label>
                    <input type="number" min="0" class="form-control" placeholder="" v-model="itemForm.purchasing_price">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" @click="createNewItem" id="createButton">Create</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>