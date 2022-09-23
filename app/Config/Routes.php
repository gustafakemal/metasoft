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
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override(function() {
    return view('Common/404_error');
});
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('login', 'Auth::login');
$routes->get('logout', 'Auth::logout');

$routes->group('api', static function ($routes) {
    $routes->group('master', static function ($routes) {
        $routes->get('kertas', 'MFJenisKertas::apiGetAll');
        $routes->get('kertas/(:num)', 'MFJenisKertas::apiGetById/$1');
        $routes->post('kertas', 'MFJenisKertas::apiAddProcess');
        $routes->put('kertas', 'MFJenisKertas::apiEditProcess');

        $routes->get('tinta', 'MFJenisTinta::apiGetAll');
        $routes->get('tinta/(:num)', 'MFJenisTinta::apiGetById/$1');
        $routes->post('tinta', 'MFJenisTinta::apiAddProcess');
        $routes->put('tinta', 'MFJenisTinta::apiEditProcess');

        $routes->get('flute', 'MFJenisFlute::apiGetAll');
        $routes->get('flute/(:num)', 'MFJenisFlute::apiGetById/$1');
        $routes->post('flute', 'MFJenisFlute::apiAddProcess');
        $routes->put('flute', 'MFJenisFlute::apiEditProcess');

        $routes->get('finishing', 'MFProsesFinishing::apiGetAll');
        $routes->get('finishing/(:num)', 'MFProsesFinishing::apiGetById/$1');
        $routes->post('finishing', 'MFProsesFinishing::apiAddProcess');
        $routes->put('finishing', 'MFProsesFinishing::apiEditProcess');

        $routes->get('manual', 'MFProsesManual::apiGetAll');
        $routes->get('manual/(:num)', 'MFProsesManual::apiGetById/$1');
        $routes->post('manual', 'MFProsesManual::apiAddProcess');
        $routes->put('manual', 'MFProsesManual::apiEditProcess');

        $routes->get('khusus', 'MFProsesKhusus::apiGetAll');
        $routes->get('khusus/(:num)', 'MFProsesKhusus::apiGetById/$1');
        $routes->post('khusus', 'MFProsesKhusus::apiAddProcess');
        $routes->put('khusus', 'MFProsesKhusus::apiEditProcess');
    });
});
$routes->add('partproduk/add', 'MFPartProduk::addPartProduct');
$routes->add('partproduk/edit/(:any)', 'MFPartProduk::editPartProduct/$1');
$routes->add('partproduk/rev/(:any)/(:any)', 'MFPartProduk::editPartProduct/$1/$2');
$routes->add('partproduk/detail/(:any)', 'MFPartProduk::detailPartProduct/$1');
$routes->add('partproduk/del/(:any)', 'MFPartProduk::delPartProduk/$1');

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
