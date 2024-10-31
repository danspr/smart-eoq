<?php

namespace App\Controllers;

class Home extends BaseController
{

    public function __construct() {
       
    }
    
    public function index()
    {
        $data = [];
        return view('pages/home_view', $data);
    }

    public function dashboardView()
    {
        $auth = new Auth();
        $auth->isSessionExist();

        $pageName = 'Dashboard';
        $pageView = [
            'pageName' => $pageName,
        ];

        $contents = view('pages/dashboard/dashboard_view', $pageView);
        $data = [
            ... $this->defaultDataView(),
            'pageTitle' => 'Dashboard | ' . getAppName(),
            'contents' => $contents,
            // 'vueScript' => 'assets/js/vue/smarteoq.goods.js',
        ];

        return view('templates/main_view', $data);
    }
}
