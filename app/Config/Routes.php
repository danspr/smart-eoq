<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

/** Dashboard routes */
$routes->get('/dashboard', 'Home::dashboardView');

/** Auth routes */
$routes->get('/login', 'Auth::loginView');
$routes->get('/logout', 'Auth::logout');

/** EOQ routes */
$routes->get('/eoq', 'EOQ::index');
$routes->get('/eoq/parameter', 'EOQ::eoqParamterView');
$routes->get('/eoq/detail/([0-9]+)', 'EOQ::eoqDetailView/$1');

/** User routes */
$routes->get('/user', 'User::index');

/** Goods routes */
$routes->get('/goods', 'Goods::index');

/**
 * API routes
 */
$routes->group('api', ['namespace' => 'App\Controllers\Api'], static function ($routes) {
    /** Auth */
    $routes->group('auth', static function ($routes) {
        $routes->post('signin', 'Auth::signin');
        $routes->post('signout', 'Auth::signout');
        $routes->post('password', 'Auth::getPassword');
    });

    /** EOQ */
    $routes->group('eoq', static function ($routes) {
        $routes->get('list', 'EOQ::getEOQList');
        $routes->get('item/detail', 'EOQ::getEOQItemDetail');
        $routes->post('item/update', 'EOQ::updateEOQItem');
        $routes->get('detail', 'EOQ::getDetailAnalysis');
        $routes->post('update', 'EOQ::updateDetailAnalysis');
        $routes->post('insert', 'EOQ::insertNewAnalysis');
        $routes->post('delete', 'EOQ::deleteAnalysis');
    });

    /** EOQ Parameter */
    $routes->group('eoq-parameter', static function ($routes) {
        $routes->get('list', 'EOQ::getParameterList');
        $routes->get('detail', 'EOQ::getParameterDetail');
        $routes->post('insert', 'EOQ::insertNewParameter');
        $routes->post('update', 'EOQ::updateParameter');
        $routes->post('delete', 'EOQ::deleteParameter');
        $routes->post('default/update', 'EOQ::updateDefaultParameter');
        $routes->post('default/delete', 'EOQ::deleteDefaultParameter');
    });

     /** User */
     $routes->group('user', static function ($routes) {
        $routes->get('list', 'User::getUserList');
        $routes->get('detail', 'User::getUserDetail');
        $routes->post('update', 'User::updateUser');
        $routes->post('insert', 'User::insertUser');
        $routes->post('delete', 'User::deleteUser');
        $routes->post('change-password', 'User::changePassword');
        $routes->post('current-user', 'User::getCurrentUser');
    });

     /** User */
     $routes->group('goods', static function ($routes) {
        $routes->get('list', 'Goods::getItemList');
        $routes->get('detail', 'Goods::getItemDetail');
        $routes->post('insert', 'Goods::insertItem');
        $routes->post('update', 'Goods::updateItem');
        $routes->post('delete', 'Goods::deleteItem');
    });

});
