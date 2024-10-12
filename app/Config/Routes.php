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
$routes->get('/eoq/parameter', '');
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

});
