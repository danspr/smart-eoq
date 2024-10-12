<!-- Start::app-content -->
<div class="main-content app-content" id="app-wrapper" menu-active-path="eoq-parameters">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0"><?= $pageName ?></h1>
            <div class="ms-md-1 ms-0">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">EOQ</a></li>
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
                    <!-- <div class="card-header justify-content-between">
                        <div class="card-title">
                            EOQ Results
                        </div>
                        <div class="d-flex">
                            <button class="btn btn-sm btn-primary btn-wave waves-light"  data-bs-toggle="modal"
                            data-bs-target="#eoqNewModal"><i class="ri-add-line fw-semibold align-middle me-1"></i> Create Analysis</button>
                        </div>
                    </div> -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-2">
                                <nav class="nav nav-tabs flex-column nav-style-5" role="tablist">
                                    <a class="nav-link active" data-bs-toggle="tab" role="tab"
                                        aria-current="page" href="#home-vertical-link" aria-selected="true"><i
                                            class="ri-home-smile-line me-2 align-middle d-inline-block"></i>Holding Cost (HC)</a>
                                    <a class="nav-link" data-bs-toggle="tab" role="tab"
                                    aria-current="page" href="#about-vertical-link" aria-selected="false"><i
                                            class="ri-archive-drawer-line me-2 align-middle d-inline-block"></i>Transaction Cost (TC)</a>
                                    <a class="nav-link" data-bs-toggle="tab" role="tab"
                                    aria-current="page" href="#services-vertical-link" aria-selected="false"><i
                                            class="ri-bank-line me-2 align-middle d-inline-block"></i>Default Parameter</a>
                                </nav>
                            </div>
                            <div class="col-xl-10">
                                <div class="tab-content">
                                    <div class="tab-pane active text-muted" id="home-vertical-link"
                                        role="tabpanel">
                                        <div class="text-end">
                                            <button class="btn btn-sm btn-primary btn-wave waves-light mb-3" @click="showNewParameterModal('hc')"><i class="ri-add-line fw-semibold align-middle me-1"></i> Add New</button>
                                        </div>
                                        <?= view('tables/eoq_parameter_hc_table') ?>
                                    </div>
                                    <div class="tab-pane text-muted" id="about-vertical-link"
                                        role="tabpanel">
                                        <div class="text-end">
                                            <button class="btn btn-sm btn-primary btn-wave waves-light mb-3" @click="showNewParameterModal('tc')"><i class="ri-add-line fw-semibold align-middle me-1"></i> Add New</button>
                                        </div>
                                        <?= view('tables/eoq_parameter_tc_table') ?>
                                    </div>
                                    <div class="tab-pane show text-muted" id="services-vertical-link"
                                        role="tabpanel">
                                        <?= view('tables/eoq_parameter_default_table') ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End::row-1 -->
    </div>
    <?= view('modals/eoq_parameter_new_modal') ?>
    <?= view('modals/eoq_parameter_edit_modal') ?>
</div>
<!-- End::app-content -->

