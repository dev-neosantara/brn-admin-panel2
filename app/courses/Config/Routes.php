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
$routes->group('course', ['namespace' => 'Courses\Controllers'], function ($routes) {
    $routes->get('/', 'CoursesController::index');
    $routes->get('list', 'CoursesController::listajax', ['as' => 'list_course_ajax']);
    $routes->get('add', 'CoursesController::form', ['as' => 'add_course']);
    $routes->get('edit/(:num)', 'CoursesController::form/$1');
    $routes->get('hapus/(:num)', 'CoursesController::delete/$1');
    $routes->post('insert', 'CoursesController::insert', ['as' => 'insert_course']);
    $routes->post('update', 'CoursesController::insert', ['as' => 'update_course']);

    $routes->group('users', ['namespace' => 'Courses\Controllers'], function ($routes) {
        $routes->get('/', 'CourseUsersController::index');
    });
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
