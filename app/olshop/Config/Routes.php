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
// $routes->setDefaultNamespace('App\Controllers');
// $routes->setDefaultController('Home');
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
// $routes->get('/', 'Dashboard::index');
$routes->group('olshop', ['namespace' => 'Olshop\Controllers'], function ($routes) {
    $routes->get('product', 'Product::index', ['as' => 'list_product']);
    $routes->get('product/list', 'Product::listajax', ['as' => 'list_product_ajax']);
    $routes->get('product/add', 'Product::form', ['as' => 'add_product']);
    $routes->post('product/add', 'Product::addproduct', ['as' => 'action_add_product']);
    $routes->get('product/edit/(:num)', 'Product::form/$1', ['as' => 'edit_product']);
    $routes->get('product/publish/(:num)', 'Product::publish/$1', ['as' => 'publish_product']);
    $routes->get('product/delete/(:num)', 'Product::delete/$1', ['as' => 'delete_product']);
    $routes->get('product/deleteimage/(:num)', 'Product::deleteimage/$1', ['as' => 'delete_pd_images']);
    $routes->post('product/deleteimage', 'Product::deleteimage', ['as' => 'delete_pd_image']);
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
