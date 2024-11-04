<?php

namespace App\Controllers;

use App\Models\GoodsModel;

class Home extends BaseController
{

    public function __construct() {
        $this->goodsModel = new GoodsModel();
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

        $totalStock = $this->goodsModel->getTotalStock();
        $topSales = $this->goodsModel->getItemTopSales();
        $topSalesFormatter = [];
        foreach ($topSales as $value) {
            $item = (array) $value;
           
            if($value->qty >= $value->eoq_result) {
                $item['status'] = 'In Stock';
            } else {
                $item['status'] = 'Out of Stock';
            }

            $topSalesFormatter[] = $item;
        }

        $pageName = 'Dashboard';
        $pageView = [
            'pageName' => $pageName,
            'totalStock' => ($totalStock != null) ? $totalStock : 0,
            'inStock' =>  $this->goodsModel->getTotalInStock(),
            'outStock' =>  $this->goodsModel->getTotalOutStock(),
            'topSales' => $topSalesFormatter
        ];

        // echo json_encode($pageView);
        // exit();
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
