<?php

namespace App\Controllers;

use App\Models\EOQModel;

class Goods extends BaseController
{

    public function __construct()
    {
        $auth = new Auth();
        $auth->isSessionExist();
        $this->eoqModel = new EOQModel();
    }

    public function index(): string
    {
        $pageName = 'Product Management';
        $pageView = [
            'pageName' => $pageName,
        ];

        $contents = view('pages/goods/goods_view', $pageView);
        $data = [
            ... $this->defaultDataView(),
            'pageTitle' => 'Product Management | ' . getAppName(),
            'contents' => $contents,
            'vueScript' => 'assets/js/vue/smarteoq.goods.js',
        ];

        return view('templates/main_view', $data);
    }

}