<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="dark" data-toggled="close">
    <?= view('templates/metadata', ['pageTitle' => $pageTitle]) ?>
    
<body>
    <div class="page">
        <?= view('templates/header') ?>
        <?= view('templates/sidebar') ?>
        
        <?= $contents ?>
       
        <?= view('templates/footer') ?>
    </div>

    
    <div class="scrollToTop">
        <span class="arrow"><i class="ri-arrow-up-s-fill fs-20"></i></span>
    </div>
    <div id="responsive-overlay"></div>

    <?= view('templates/script') ?>

</body>

</html>