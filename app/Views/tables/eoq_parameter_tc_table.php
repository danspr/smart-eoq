<table class="table text-nowrap table-bordered" id="eoqParamTCTable" style="width:100%">
    <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Parameter Name</th>
            <th scope="col">Value</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="(item, index) in dataList.tc" :key="item.id">
            <td>{{ index + 1 }}</td>
            <td>{{ item.name }}</td>
            <td>{{ item.value }} Hour</td>
            <td>
                <button @click="getParameterDetail(item.id, item.category)" class="btn btn-primary-light btn-icon btn-sm" title="Edit Parameter" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Print"><i class="ri-edit-line"></i></button>
                <button @click="deleteParameter(item.id)" class="btn btn-danger-light btn-icon ms-1 btn-sm invoice-btn" title="Delete Parameter" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"><i class="ri-delete-bin-5-line"></i></button>
            </td>
        </tr>
    </tbody>
</table>