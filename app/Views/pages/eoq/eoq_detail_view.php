<!-- Start::app-content -->
<div class="main-content app-content" id="app-wrapper" menu-active-path="eoq">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0"><?= $pageName ?></h1>
            <div class="ms-md-1 ms-0">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>eoq">EOQ Result</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= $pageName ?></li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Page Header Close -->

        <!-- Start::row-1 -->
        <div class="row">
            <div class="col-xl-6">
                <div class="card custom-card">
                    <div class="card-header d-md-flex d-block">
                        <div class="h5 mb-0 d-sm-flex d-bllock align-items-center">
                            <!-- <div class="avatar avatar-sm">
                                <img src="../assets/images/brand-logos/toggle-logo.png" alt="">
                            </div> -->
                            <div class="ms-sm-2 ms-0 mt-sm-0 mt-2">
                                <div class="h6 fw-semibold mb-0">EOQ Detail Result</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row gy-3">
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-6">
                                        <table class="table table-sm text-nowrap mb-0 table-borderless">
                                            <tr>
                                                <td class="pb-2 text-muted">Item ID</td>
                                                <td class="pb-2 fw-bold">: {{ data.id }}</span></td>
                                            </tr>
                                            <tr>
                                                <td class="pb-2 text-muted">Item Name</td>
                                                <td class="pb-2 fw-bold">: {{ data.name }}</td>
                                            </tr>
                                            <tr>
                                                <td class="pb-2 text-muted">Annual Demand (Qty)</td>
                                                <td class="pb-2 fw-bold">: {{ formatNumber(data.annual_demand) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="pb-2 text-muted">Annual Demand (Rp)</td>
                                                <td class="pb-2 fw-bold">: {{ formatCurrency(data.total) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="pb-2 text-muted">Purchasing Price</td>
                                                <td class="pb-2 fw-bold">: {{ formatCurrency(data.purchasing_price) }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xl-12 mt-4">
                                <div class="ms-sm-2 ms-0 mt-sm-0">
                                    <div class="h6 fw-semibold mb-0">Holding Cost (HC)</div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table nowrap text-nowrap border mt-3">
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td class="fw-bold text-end">Percentage</td>
                                                <td class="fw-bold text-end">Cost</td>
                                            </tr>
                                            <tr v-for="(item, index) in data.holding_cost.parameters" :key="item.name">
                                                <td class="text-muted">{{ item.name }}</td>
                                                <td class="text-muted text-end">{{ item.percentage }}</td>
                                                <td class="text-muted text-end">{{ formatCurrency(item.cost) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Holding Cost (HC)</td>
                                                <td class="fw-bold text-end">{{ data.holding_cost.total_percentage }}</td>
                                                <td class="fw-bold text-end">{{ formatCurrency(data.holding_cost.total_cost) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-xl-12 mt-5">
                                <div class="ms-sm-2 ms-0 mt-sm-0">
                                    <div class="h6 fw-semibold mb-0">Transaction Cost (TC)</div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table nowrap text-nowrap border mt-3">
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td class="fw-bold text-end">Hour</td>
                                                <td class="fw-bold text-end">Cost</td>
                                            </tr>
                                            <tr v-for="(item, index) in data.transaction_cost.parameters" :key="item.name">
                                                <td class="text-muted">{{ item.name }}</td>
                                                <td class="text-muted text-end">{{ item.hour }}</td>
                                                <td class="text-muted text-end">{{ formatCurrency(item.cost) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Transaction Cost (HC)</td>
                                                <td class="fw-bold text-end">{{ data.transaction_cost.total_hour }}</td>
                                                <td class="fw-bold text-end">{{ formatCurrency(data.transaction_cost.total_cost) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            Summary
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row gy-3">
                            <div class="col-xl-12">
                                <div class="table-responsive">
                                    <table class="table nowrap text-nowrap border">
                                        <tbody>
                                            <tr>
                                                <td class="">EOQ = Economic Order Quantity</td>
                                                <td class="fw-bold">{{ formatNumber(data.eoq_analysis.eoq_result) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="">N =Number of Order per year</td>
                                                <td class="fw-bold">{{ formatNumber(data.eoq_analysis.number_order) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="">F = Frequency Order (in days)</td>
                                                <td class="fw-bold">{{ formatNumber(data.eoq_analysis.frequency_order) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button class="btn btn-success" @click="updateResult">Save Result <i class="ri-download-2-line ms-1 align-middle"></i></button>
                    </div>
                </div>
            </div>
                    
        </div>
        <!--End::row-1 -->
    </div>
</div>
<!-- End::app-content -->