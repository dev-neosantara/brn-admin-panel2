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
    $routes->post('insert', 'BlacklistController::insertblacklist', ['as' => 'insert_blacklist']);
});
$routes->group('sponsors', ['namespace' => 'Brn\Controllers'], function ($routes) {
    $routes->get('/', 'SponsorsController::index');
    // $routes->get('articles', 'Article::index', ['as' => 'list_article']);
    $routes->get('list', 'SponsorsController::listajax', ['as' => 'list_sponsor_ajax']);
    $routes->get('add', 'SponsorsController::form', ['as' => 'add_sponsor']);
    $routes->get('edit/(:num)', 'SponsorsController::form/$1');
    $routes->get('hapus/(:num)', 'SponsorsController::delete/$1');
    $routes->post('insert', 'SponsorsController::insert', ['as' => 'insert_sponsor']);
});
$routes->group('events', ['namespace' => 'Brn\Controllers'], function ($routes) {
    $routes->get('/', 'EventsController::index');
    $routes->get('list', 'EventsController::listajax', ['as' => 'list_event_ajax']);
    $routes->get('add', 'EventsController::form', ['as' => 'add_event']);
    $routes->get('edit/(:num)', 'EventsController::form/$1');
    $routes->get('getqr', 'EventsController::get_generateqr');
    $routes->get('detail/(:num)', 'EventController::index/$1');
    $routes->get('detailajax/(:num)', 'EventController::listajax/$1');
    $routes->get('hapus/(:num)', 'EventsController::delete/$1');
    $routes->post('insert', 'EventsController::insert', ['as' => 'insert_event']);
    $routes->post('update', 'EventsController::insert', ['as' => 'update_event']);
    $routes->get('invitation', 'EventsController::invitation');

});
$routes->group('diklat', ['namespace' => 'Brn\Controllers'], function ($routes) {
    $routes->get('/', 'DiklatsController::index');
    $routes->get('list', 'DiklatsController::listajax', ['as' => 'list_diklat_ajax']);
    $routes->get('add', 'DiklatsController::form', ['as' => 'add_diklat']);
    $routes->get('edit/(:num)', 'DiklatsController::form/$1');
    $routes->get('detail/(:num)', 'DiklatsController::index/$1');
    $routes->get('detailajax/(:num)', 'DiklatsController::listajax/$1');
    $routes->get('hapus/(:num)', 'DiklatsController::delete/$1');
    $routes->post('insert', 'DiklatsController::insert', ['as' => 'insert_diklat']);
    $routes->post('update', 'DiklatsController::insert', ['as' => 'update_diklat']);

    $routes->group('users', ['namespace' => 'Brn\Controllers'], function ($routes) {
        $routes->get('/', 'DiklatUsersController::index');
    });
});
$routes->group('cars', ['namespace' => 'Brn\Controllers'], function ($routes) {
    $routes->get('/', 'CarsController::index');
    $routes->get('list', 'CarsController::listajax', ['as' => 'list_car_ajax']);
    $routes->get('add', 'CarsController::form', ['as' => 'add_car']);
    $routes->get('edit/(:num)', 'CarsController::form/$1');
    $routes->get('images', 'CarsController::listimageajax');
    $routes->get('detail/(:num)', 'CarsController::index/$1');
    $routes->get('detailajax/(:num)', 'CarsController::listajax/$1');
    $routes->get('hapus/(:num)', 'CarsController::delete/$1');
    $routes->post('insert', 'CarsController::insert', ['as' => 'insert_car']);
    $routes->post('update', 'CarsController::insert', ['as' => 'update_car']);
});
$routes->group('regions', ['namespace' => 'Brn\Controllers'], function ($routes) {
    $routes->get('/', 'RegionsController::index');
    $routes->get('list', 'RegionsController::listajax');
    $routes->get('add', 'RegionsController::add');
    $routes->get('edit', 'RegionsController::add');
    $routes->post('update', 'RegionsController::update');
    $routes->get('delete', 'RegionsController::delete');
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
