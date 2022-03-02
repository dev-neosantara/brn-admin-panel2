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
$routes->group('blacklist', ['namespace' => 'Brn\Controllers'], function ($routes) {
    $routes->get('/', 'BlacklistController::index');
    // $routes->get('articles', 'Article::index', ['as' => 'list_article']);
    $routes->get('list', 'BlacklistController::listajax', ['as' => 'list_blacklist_ajax']);
    $routes->get('add', 'BlacklistController::form', ['as' => 'add_blacklist']);
    $routes->get('edit/(:num)', 'BlacklistController::form/$1');
    $routes->get('hapus/(:num)', 'BlacklistController::delete/$1');
    // $routes->post('category/add', 'Article::categoryinsert');
    // $routes->get('category/add', 'Article::categoryadd', ['as' => 'add_category']);
    // $routes->get('category/edit/(:num)', 'Article::categoryadd/$1', ['as' => 'edit_category']);
    // // $routes->get('category/edit/(:num)', 'Article::categoryadd/$1', ['as' => 'edit_category']);
    
    // $routes->get('categoriesajax', 'Article::categoriesajax');
    // $routes->get('categories', 'Article::categories');
    // $routes->get('category/delete/(:num)', 'Article::deletecat/$1');
    $routes->post('insert', 'BlacklistController::insertblacklist', ['as' => 'insert_blacklist']);
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
