<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/auth', 'Auth::index');
$routes->get('/auth/logout', 'Auth::logout');
$routes->post('/auth/plogin', 'Auth::plogin');

$routes->get('/pegawai', 'Pegawai::index');
$routes->get('/pegawai/ajax_data', 'Pegawai::ajax_data');

$routes->setAutoRoute(true);

