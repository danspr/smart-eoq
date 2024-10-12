<?php

namespace App\Controllers;

use App\Models\EOQModel;

class EOQ extends BaseController
{

    public function __construct()
    {
        $auth = new Auth();
        $auth->isSessionExist();
        $this->eoqModel = new EOQModel();
    }
    
    public function index(): string
    {
        $pageName = 'EOQ Analysis';
        $pageView = [
            'pageName' => $pageName,
        ];

        $contents = view('pages/eoq/eoq_view', $pageView);
        $data = [
            ... $this->defaultDataView(),
            'pageTitle' => 'EOQ Analysis | ' . getAppName(),
            'contents' => $contents,
            'vueScript' => 'assets/js/vue/smarteoq.eoq.js',
        ];

        return view('templates/main_view', $data);
    }

    public function eoqDetailView($id){
        if(!isset($id)){
            return;
        }

        $eoqDetail = $this->eoqModel->getItemDetail($id);
        if(empty($eoqDetail)){
            return;
        }

        $pageName = $eoqDetail['name'];
        $pageView = [
            'pageName' => $pageName,
            'itemId' => $id,
        ];

        $contents = view('pages/eoq/eoq_detail_view', $pageView);
        $data = [
            ... $this->defaultDataView(),
            'pageTitle' => 'EOQ Detail | ' . getAppName(),
            'contents' => $contents,
            'vueScript' => 'assets/js/vue/smarteoq.eoq.detail.js',
            'customParam' => [ 
                'itemId' => $id
            ]
        ];

        return view('templates/main_view', $data);
    }

    public function eoqParamterView(){
        $pageName = 'EOQ Parameter';
        $pageView = [
            'pageName' => $pageName,
        ];

        $contents = view('pages/eoq/eoq_parameter_view', $pageView);
        $data = [
            ... $this->defaultDataView(),
            'pageTitle' => 'Parameter | ' . getAppName(),
            'contents' => $contents,
            'vueScript' => 'assets/js/vue/smarteoq.parameter.js',
        ];

        return view('templates/main_view', $data);
    }
}
