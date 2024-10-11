<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

/** Auth routes */
$routes->get('/login', 'Auth::loginView');
$routes->get('/logout', 'Auth::logout');


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

});
