<div class="modal fade" id="eoqParameterNewModal" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="eoqNewParameterModalTitle">New Parameter </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fs-14 text-dark">Parameter Name</label>
                    <input type="text" class="form-control" placeholder="" v-model="form.name">
                </div>
                <div class="mb-3">
                    <label class="form-label fs-14 text-dark" id="eoqNewParameterModalValue">Value</label>
                    <input type="number" min="0" class="form-control"  placeholder="" v-model="form.value">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="eoqNewParameterModalButton" @click="createParameter">Create</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>