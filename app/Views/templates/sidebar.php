<!-- Start::app-sidebar -->
<aside class="app-sidebar sticky" id="sidebar">

<!-- Start::main-sidebar-header -->
<div class="main-sidebar-header">
    <a href="<?= base_url() ?>" class="header-logo">
        <img src="<?= base_url() ?>assets/images/brand-logos/smarteoq-logo.png" alt="logo" class="desktop-logo">
        <img src="<?= base_url() ?>assets/images/brand-logos/smarteoq-toggle-logo.png" alt="logo" class="toggle-logo">
        <img src="<?= base_url() ?>assets/images/brand-logos/smarteoq-logo.png" alt="logo" class="desktop-dark">
        <img src="<?= base_url() ?>assets/images/brand-logos/smarteoq-toggle-logo.png" alt="logo" class="toggle-dark">
    </a>
</div>
<!-- End::main-sidebar-header -->

<!-- Start::main-sidebar -->
<div class="main-sidebar" id="sidebar-scroll">

    <!-- Start::nav -->
    <nav class="main-menu-container nav nav-pills flex-column sub-open">
        <div class="slide-left" id="slide-left">
            <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path> </svg>
        </div>
        <ul class="main-menu">
            <!-- Start::slide__category -->
            <li class="slide__category"><span class="category-name">Main</span></li>
            <!-- End::slide__category -->

             <!-- Start::slide -->
             <li class="slide">
                <a href="/dashboard" active-path="dashboard" class="side-menu__item">
                    <i class="bx bx-home side-menu__icon"></i>
                    <span class="side-menu__label">Dashboard</span>
                </a>
            </li>
            <!-- End::slide -->

            <!-- Start::slide -->
            <li class="slide">
                <a href="<?= base_url('goods') ?>" active-path="good" class="side-menu__item">
                    <i class="bx bx-box side-menu__icon"></i>
                    <span class="side-menu__label">Product</span>
                </a>
            </li>
            <li class="slide has-sub">
                <a href="javascript:void(0);" class="side-menu__item">
                    <i class="bx bx-math side-menu__icon"></i>
                    <span class="side-menu__label">EOQ</span>
                    <i class="fe fe-chevron-right side-menu__angle"></i>
                </a>
                <ul class="slide-menu child1">
                    <li class="slide side-menu__label1">
                        <a href="javascript:void(0)">EOQ</a>
                    </li>
                    <li class="slide">
                        <a href="<?= base_url('eoq') ?>" active-path="eoq" class="side-menu__item">EOQ Analysis</a>
                    </li>
                    <li class="slide">
                        <a href="<?= base_url('eoq/parameter') ?>" active-path="eoq-parameters"  class="side-menu__item">Parameters</a>
                    </li>
                </ul>
            </li>
            <!-- End::slide -->
            </li>
            <!-- End::slide -->

            <!-- Start::slide__category -->
            <li class="slide__category"><span class="category-name">Setting</span></li>
            <!-- End::slide__category -->

            <!-- Start::slide -->
            <li class="slide">
                <a href="<?= base_url('user') ?>" active-path="user"  class="side-menu__item">
                    <i class="bx bx-user side-menu__icon"></i>
                    <span class="side-menu__label">User Management</span>
                </a>
            </li>
            <!-- End::slide -->

             <!-- Start::slide -->
             <!-- <li class="slide">
                <a href="icons.html" class="side-menu__item">
                    <i class="bx bx-cog side-menu__icon"></i>
                    <span class="side-menu__label">Setting</span>
                </a>
            </li> -->
            <!-- End::slide -->
            
        </ul>
        <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path> </svg></div>
    </nav>
    <!-- End::nav -->

</div>
<!-- End::main-sidebar -->

</aside>
<!-- End::app-sidebar -->