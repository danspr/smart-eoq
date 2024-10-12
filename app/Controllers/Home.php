<?php

namespace App\Controllers;

class Home extends BaseController
{

    public function __construct()
    {
        $auth = new Auth();
        $auth->isSessionExist();
    }
    
    public function index()
    {
        return redirect()->to(base_url('eoq')); 
        // $contents = view('pages/home_view');
        // $data = [
        //     ... $this->defaultDataView(),
        //     'pageTitle' => 'Dashboard | SmartEOQ',
        //     'contents' => $contents,
        //     // 'vueScript' => 'assets/js/ps-script-admin.js',
        // ];

        // return view('templates/main_view', $data);
    }
}
