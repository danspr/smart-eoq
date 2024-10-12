<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

/** Auth routes */
$routes->get('/login', 'Auth::loginView');
$routes->get('/logout', 'Auth::logout');

/** EOQ routes */
$routes->get('/eoq', 'EOQ::index');
$routes->get('/eoq/parameter', 'EOQ::eoqParamterView');
$routes->get('/eoq/detail/([0-9]+)', 'EOQ::eoqDetailView/$1');

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

});
