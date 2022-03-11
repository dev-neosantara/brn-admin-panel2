<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Dashoard');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Dashboard::index');
$routes->post('/common/uploadfile', 'CommonController::uploadfile', ['as' => 'uploafile']);
// $routes->match(['get', 'post'], 'imagerender/(:segment)', 'RenderImage::index/$1');
$routes->get('/imagerender', 'RenderImage::index');
$routes->post('/imagerender', 'RenderImage::index');

$routes->group('extra', function ($routes) {
    $routes->get('regions', 'Extra::get_regions');
    $routes->get('areas', 'Extra::get_areas');
    $routes->get('subdistrict', 'Extra::get_subdistrict');
});

$routes->group('users', function ($routes) {
    $routes->get('/', 'UsersController::index');
    $routes->get('pendaftar', 'UsersController::index/new');
    $routes->get('perpanjangan', 'UsersController::index/ext');
    $routes->get('member', 'UsersController::index/member');
    $routes->get('tool/generateid/(:num)', 'UsersController::generateid/$1');
    $routes->get('list/(:any)', 'UsersController::listajax/$1');
    $routes->get('list', 'UsersController::listajax');


    $routes->get('tambah/(:any)', 'UsersController::formtambah/$1');
    $routes->get('tambah', 'UsersController::form');
    $routes->post('tambah', 'UsersController::insertuser');
    $routes->get('update/(:num)', 'UsersController::form/$1');
    $routes->post('update/(:num)', 'UsersController::update/$1');
    $routes->post('hapus/(:num)', 'UsersController::remove/$1');
    $routes->get('konfirmasi/(:any)', 'UsersController::confirmation/$1');
    $routes->get('reset-password', 'UsersController::reset_password');
    $routes->get('(:any)', 'UsersController::index/$1');

    
});

$routes->group('admins', function ($routes) {
    $routes->get('/', 'UsersController::admins');
    $routes->get('list', 'UsersController::listadminajax');
    $routes->get('edit/(:num)', 'UsersController::addadmin/$1');
    $routes->post('update', 'UsersController::insertadmin');
    $routes->post('insert', 'UsersController::insertadmin');
    $routes->get('tambah', 'UsersController::addadmin');
    $routes->get('hapus/(:num)', 'UsersController::removeadmin/$1');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
