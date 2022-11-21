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
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('login', 'Auth::login');
$routes->post('auth/verify', 'Auth::verify');
$routes->get('logout', 'Auth::logout');

$routes->group('pelanggan', static function ($routes) {
    $routes->get('/', 'Customer::index');
    $routes->get('api', 'Customer::apiGetAll');
    $routes->get('api/(:num)', 'Customer::apiGetById/$1');
    $routes->post('add/api', 'Customer::apiAddProcess');
    $routes->put('edit/api', 'Customer::apiEditProcess');
    $routes->get('delete/(:num)', 'Customer::delete/$1');
});

$routes->group('sales', static function ($routes) {
    $routes->get('/', 'Sales::index');
    $routes->get('api', 'Sales::apiGetAll');
    $routes->get('api/(:num)', 'Sales::apiGetById/$1');
    $routes->post('add/api', 'Sales::apiAddProcess');
    $routes->put('edit/api', 'Sales::apiEditProcess');
    $routes->get('delete/(:num)', 'Sales::delete/$1');
});

$routes->group('tujuankirim', static function ($routes) {
    $routes->get('/', 'MFTujuanKirim::index');
    $routes->get('api', 'MFTujuanKirim::apiGetAll');
    $routes->get('api/(:num)', 'MFTujuanKirim::apiGetById/$1');
    $routes->post('add/api', 'MFTujuanKirim::apiAddProcess');
    $routes->put('edit/api', 'MFTujuanKirim::apiEditProcess');
    $routes->get('delete/(:num)', 'MFTujuanKirim::delete/$1');
});

$routes->group('jeniskertas', static function ($routes) {
    $routes->get('/', 'MFJenisKertas::index');
    $routes->get('api', 'MFJenisKertas::apiGetAll');
    $routes->get('api/(:num)', 'MFJenisKertas::apiGetById/$1');
    $routes->post('add/api', 'MFJenisKertas::apiAddProcess');
    $routes->put('edit/api', 'MFJenisKertas::apiEditProcess');
    $routes->get('delete/(:num)', 'MFJenisKertas::delete/$1');
});

$routes->group('jenistinta', static function ($routes) {
    $routes->get('/', 'MFJenisTinta::index');
    $routes->get('api', 'MFJenisTinta::apiGetAll');
    $routes->get('api/(:num)', 'MFJenisTinta::apiGetById/$1');
    $routes->post('add/api', 'MFJenisTinta::apiAddProcess');
    $routes->put('edit/api', 'MFJenisTinta::apiEditProcess');
    $routes->get('delete/(:num)', 'MFJenisTinta::delete/$1');
});

$routes->group('jenisflute', static function ($routes) {
    $routes->get('/', 'MFJenisFlute::index');
    $routes->get('api', 'MFJenisFlute::apiGetAll');
    $routes->get('api/(:num)', 'MFJenisFlute::apiGetById/$1');
    $routes->post('add/api', 'MFJenisFlute::apiAddProcess');
    $routes->put('edit/api', 'MFJenisFlute::apiEditProcess');
    $routes->get('delete/(:num)', 'MFJenisFlute::delete/$1');
});

$routes->group('prosesfinishing', static function ($routes) {
    $routes->get('/', 'MFProsesFinishing::index');
    $routes->get('api', 'MFProsesFinishing::apiGetAll');
    $routes->get('api/(:num)', 'MFProsesFinishing::apiGetById/$1');
    $routes->post('add/api', 'MFProsesFinishing::apiAddProcess');
    $routes->put('edit/api', 'MFProsesFinishing::apiEditProcess');
    $routes->get('delete/(:num)', 'MFProsesFinishing::delete/$1');
});

$routes->group('prosesmanual', static function ($routes) {
    $routes->get('/', 'MFProsesManual::index');
    $routes->get('api', 'MFProsesManual::apiGetAll');
    $routes->get('api/(:num)', 'MFProsesManual::apiGetById/$1');
    $routes->post('add/api', 'MFProsesManual::apiAddProcess');
    $routes->put('edit/api', 'MFProsesManual::apiEditProcess');
    $routes->get('delete/(:num)', 'MFProsesManual::delete/$1');
});

$routes->group('proseskhusus', static function ($routes) {
    $routes->get('/', 'MFProsesKhusus::index');
    $routes->get('api', 'MFProsesKhusus::apiGetAll');
    $routes->get('api/(:num)', 'MFProsesKhusus::apiGetById/$1');
    $routes->post('add/api', 'MFProsesKhusus::apiAddProcess');
    $routes->put('edit/api', 'MFProsesKhusus::apiEditProcess');
    $routes->get('delete/(:num)', 'MFProsesKhusus::delete/$1');
});

$routes->group('setting', static function ($routes) {
    $routes->group('modul', static function ($routes) {
        $routes->get('/', 'Setting::modul');
        $routes->get('api', 'Setting::apiGetModul');
        $routes->get('api/(:num)', 'Setting::apiGetModulById/$1');
        $routes->post('add/api', 'Setting::apiAddModul');
    });
    $routes->group('hakakses', static function ($routes) {
        $routes->get('/', 'Setting::accessright');
        $routes->get('api', 'Setting::apiGetAccessRight');
        $routes->get('api/(:any)', 'Setting::modulAccess/$1');
        $routes->post('edit/api', 'Setting::updateAccess');
//        $routes->post('add/api', 'Setting::apiAddModul');
    });
});

$routes->group('produk', static function ($routes) {
    $routes->get('/', 'MFProduk::index');
});

$routes->add('partproduk/add', 'MFPartProduk::addPartProduct');
$routes->add('partproduk/edit/(:any)', 'MFPartProduk::editPartProduct/$1');
$routes->add('partproduk/rev/(:any)/(:any)', 'MFPartProduk::editPartProduct/$1/$2');
$routes->add('partproduk/detail/(:any)', 'MFPartProduk::detailPartProduct/$1');
$routes->add('partproduk/del/(:any)', 'MFPartProduk::delPartProduk/$1');
$routes->add('partproduk/addcopysisi', 'MFPartProduk::addcopysisi');

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
