<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

// ADD HERE THE  NEW ROUTES!!....

$routes->post('auth/login', 'AuthController::Login');
$routes->post('auth/register', 'AuthController::Register');


$routes->group('api',['namespace'=>'App\Controllers\API'],function($routes){
    
    //----------------------Clients----------------------------------------

    $routes->get('clients', 'ClientController::index');
    $routes->get('client/getById/(:num)', 'ClientController::getById/$1');
    $routes->post('client/create', 'ClientController::create');
    $routes->put('client/update/(:num)', 'ClientController::update/$1');
    $routes->delete('client/deleteById/(:num)', 'ClientController::deleteById/$1');

    //--------------------Account--------------------------------------------

    $routes->get('accounts', 'AccountController::index');
    $routes->post('account/create', 'AccountController::create');

    //--------------------Transactions--------------------------------------------

    $routes->get('transactions', 'TransactionController::index');
    $routes->post('transaction/create', 'TransactionController::create');
    $routes->get('transaction/getByClientId/(:num)', 'TransactionController::getTransactionByClientId/$1');

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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
