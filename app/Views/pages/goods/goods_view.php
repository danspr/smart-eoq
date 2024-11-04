<!-- Start::app-content -->
<div class="main-content app-content" id="app-wrapper" menu-active-path="good">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0"><?= $pageName ?></h1>
            <div class="ms-md-1 ms-0">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= $pageName ?></li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Page Header Close -->

        <!-- Start::row-1 -->
        <div class="row">
            <div class="col-xl-122">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Product List
                        </div>
                        <div class="d-flex">
                            <button class="btn btn-sm btn-primary btn-wave waves-light"  data-bs-toggle="modal"
                            data-bs-target="#goodsNewModal"><i class="ri-add-line fw-semibold align-middle me-1"></i> Add New Product</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table text-nowrap table-bordered" id="goodsTable">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Item Name</th>
                                    <th scope="col">Safety Stock</th>
                                    <th scope="col">Current Stock</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in dataList" :key="item.id">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ item.name }}</td>
                                    <td>{{ item.eoq_result }}</td>
                                    <td>{{ item.qty }}</td>
                                    <td>
                                        <span v-if="item.status == 'fulfilled'" class="badge bg-success">In Stock</span>
                                        <span v-else class="badge bg-danger">Out of Stock</span>
                                    </td>
                                    <td>
                                        <button @click="editItem(item.id)" class="btn btn-primary-light btn-icon btn-sm" title="Edit Goods"><i class="ri-edit-line"></i></button>
                                        <button  @click="deleteItem(item.id)" class="btn btn-icon ms-1 btn-sm invoice-btn btn-danger-light" title="Delete Goods"><i class="ri-delete-bin-5-line"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--End::row-1 -->
    </div>

    <?= view('modals/goods_new_modal') ?>
    <?= view('modals/goods_edit_modal') ?>
</div>
<!-- End::app-content -->

