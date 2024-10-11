<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $contents = view('pages/home_view');
        $data = [
            'pageTitle' => 'Dashboard | SmartEOQ',
            'contents' => $contents,
            // 'vueScript' => 'assets/js/ps-script-admin.js',
        ];

        return view('templates/main_view', $data);
    }
}
