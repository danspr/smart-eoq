<!-- Start::app-content -->
<div class="main-content app-content" id="app-wrapper" menu-active-path="dashboard">
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <p class="fw-semibold fs-18 mb-0">Welcome back !</p>
                <span class="fs-semibold text-muted">Track your stock activity, leads and deals here.</span>
            </div>
        </div>

       <div class="row">
            <div class="col-xxl-12 col-xl-12">
                <div class="row">
                    <div class="col-xxl-4 col-lg-4 col-md-4">
                        <div class="card custom-card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6 pe-0">
                                        <p class="mb-2">
                                            <span class="fs-16">Total Stock</span>
                                        </p>
                                        <p class="mb-2 fs-12">
                                            <span class="fs-25 fw-semibold lh-1 vertical-bottom mb-0"><?= $totalStock ?></span>
                                            <span class="d-block fs-10 fw-semibold text-muted">Items</span>
                                        </p>
                                        <a href="<?= base_url('goods') ?>" class="fs-12 mb-0 text-primary">Show full stats<i class="ti ti-chevron-right ms-1"></i></a>
                                    </div>
                                    <div class="col-6">
                                        <!-- <p class="badge bg-success-transparent float-end d-inline-flex"><i class="ti ti-caret-up me-1"></i>42%</p> -->
                                        <p class="main-card-icon mb-0"><svg class="svg-primary" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M19,19c0,0.55-0.45,1-1,1s-1-0.45-1-1v-3H8V5h11V19z" opacity=".3"></path><path d="M0,0h24v24H0V0z" fill="none"></path><g><path d="M19.5,3.5L18,2l-1.5,1.5L15,2l-1.5,1.5L12,2l-1.5,1.5L9,2L7.5,3.5L6,2v14H3v3c0,1.66,1.34,3,3,3h12c1.66,0,3-1.34,3-3V2 L19.5,3.5z M19,19c0,0.55-0.45,1-1,1s-1-0.45-1-1v-3H8V5h11V19z"></path><rect height="2" width="6" x="9" y="7"></rect><rect height="2" width="2" x="16" y="7"></rect><rect height="2" width="6" x="9" y="10"></rect><rect height="2" width="2" x="16" y="10"></rect></g></svg></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-lg-4 col-md-4">
                        <div class="card custom-card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6 pe-0">
                                        <p class="mb-2">
                                            <span class="fs-16">In Stock</span>
                                        </p>
                                        <p class="mb-2 fs-12">
                                            <span class="fs-25 fw-semibold lh-1 vertical-bottom mb-0"><?= $inStock ?></span>
                                            <span class="d-block fs-10 fw-semibold text-muted">products</span>
                                        </p>
                                        <a href="<?= base_url('goods') ?>" class="fs-12 mb-0 text-primary">Show full stats<i class="ti ti-chevron-right ms-1"></i></a>
                                    </div>
                                    <div class="col-6">
                                        <!-- <p class="badge bg-success-transparent float-end d-inline-flex"><i class="ti ti-caret-up me-1"></i>42%</p> -->
                                        <p class="main-card-icon mb-0"><svg class="svg-primary" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M19,19c0,0.55-0.45,1-1,1s-1-0.45-1-1v-3H8V5h11V19z" opacity=".3"></path><path d="M0,0h24v24H0V0z" fill="none"></path><g><path d="M19.5,3.5L18,2l-1.5,1.5L15,2l-1.5,1.5L12,2l-1.5,1.5L9,2L7.5,3.5L6,2v14H3v3c0,1.66,1.34,3,3,3h12c1.66,0,3-1.34,3-3V2 L19.5,3.5z M19,19c0,0.55-0.45,1-1,1s-1-0.45-1-1v-3H8V5h11V19z"></path><rect height="2" width="6" x="9" y="7"></rect><rect height="2" width="2" x="16" y="7"></rect><rect height="2" width="6" x="9" y="10"></rect><rect height="2" width="2" x="16" y="10"></rect></g></svg></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-lg-4 col-md-4">
                        <div class="card custom-card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6 pe-0">
                                        <p class="mb-2">
                                            <span class="fs-16">Out of Stock</span>
                                        </p>
                                        <p class="mb-2 fs-12">
                                            <span class="fs-25 fw-semibold lh-1 vertical-bottom mb-0"><?= $outStock ?></span>
                                            <span class="d-block fs-10 fw-semibold text-muted">products</span>
                                        </p>
                                        <a href="<?= base_url('goods') ?>" class="fs-12 mb-0 text-primary">Show full stats<i class="ti ti-chevron-right ms-1"></i></a>
                                    </div>
                                    <div class="col-6">
                                        <!-- <p class="badge bg-success-transparent float-end d-inline-flex"><i class="ti ti-caret-up me-1"></i>42%</p> -->
                                        <p class="main-card-icon mb-0"><svg class="svg-primary" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M19,19c0,0.55-0.45,1-1,1s-1-0.45-1-1v-3H8V5h11V19z" opacity=".3"></path><path d="M0,0h24v24H0V0z" fill="none"></path><g><path d="M19.5,3.5L18,2l-1.5,1.5L15,2l-1.5,1.5L12,2l-1.5,1.5L9,2L7.5,3.5L6,2v14H3v3c0,1.66,1.34,3,3,3h12c1.66,0,3-1.34,3-3V2 L19.5,3.5z M19,19c0,0.55-0.45,1-1,1s-1-0.45-1-1v-3H8V5h11V19z"></path><rect height="2" width="6" x="9" y="7"></rect><rect height="2" width="2" x="16" y="7"></rect><rect height="2" width="6" x="9" y="10"></rect><rect height="2" width="2" x="16" y="10"></rect></g></svg></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card custom-card">
                            <div class="card-header">
                                <div class="card-title">Top Selling Products</div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table text-nowrap mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Product Name</th>
                                                <th scope="col">Current Stock</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Total Sales</th>
                                            </tr>
                                        </thead>
                                        <tbody class="top-selling">
                                        <?php foreach ($topSales as $index =>$item): ?>
                                            <tr>
                                                <td><?= esc($index+1); ?></td>
                                                <td><?= esc($item['name']); ?></td>
                                                <td><?= esc($item['qty']); ?></td>
                                                <td>
                                                    <?php if ($item['status'] === 'In Stock'): ?>
                                                        <span class="badge badge-sm bg-success-transparent text-success"><?= esc($item['status']); ?></span>
                                                    <?php else: ?>
                                                        <span class="badge badge-sm bg-danger-transparent text-danger"><?= esc($item['status']); ?></span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= esc($item['annual_demand']); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End::app-content -->

