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
$routes->set404Override(function () {
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
$routes->post('auth/verify', 'Auth::verify', ['as' => 'verifikasi']);
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

$routes->group('mxsolventtinta', static function ($routes) {
    $routes->get('/', 'MXSolventTinta::index');
    $routes->get('api', 'MXSolventTinta::apiGetAll');
    $routes->get('api/(:num)', 'MXSolventTinta::apiGetById/$1');
    $routes->post('add/api', 'MXSolventTinta::apiAddProcess');
    $routes->put('edit/api', 'MXSolventTinta::apiEditProcess');
    $routes->get('delete/(:num)', 'MXSolventTinta::delete/$1');
});

$routes->group('mxaksesori', static function ($routes) {
    $routes->get('/', 'MXAksesori::index');
    $routes->get('api', 'MXAksesori::apiGetAll');
    $routes->get('api/(:num)', 'MXAksesori::apiGetById/$1');
    $routes->post('add/api', 'MXAksesori::apiAddProcess');
    $routes->put('edit/api', 'MXAksesori::apiEditProcess');
    $routes->get('delete/(:num)', 'MXAksesori::delete/$1');
});

$routes->group('mxadhesive', static function ($routes) {
    $routes->get('/', 'MXAdhesive::index');
    $routes->get('api', 'MXAdhesive::apiGetAll');
    $routes->get('api/(:num)', 'MXAdhesive::apiGetById/$1');
    $routes->post('add/api', 'MXAdhesive::apiAddProcess');
    $routes->put('edit/api', 'MXAdhesive::apiEditProcess');
    $routes->get('delete/(:num)', 'MXAdhesive::delete/$1');
});

$routes->group('mxkonstanta', static function ($routes) {
    $routes->get('/', 'MXKonstanta::index');
    $routes->get('api', 'MXKonstanta::apiGetAll');
    $routes->get('api/(:num)', 'MXKonstanta::apiGetById/$1');
    $routes->post('add/api', 'MXKonstanta::apiAddProcess');
    $routes->put('edit/api', 'MXKonstanta::apiEditProcess');
    $routes->get('delete/(:num)', 'MXKonstanta::delete/$1');
});

$routes->group('mxjenisproduk', static function ($routes) {
    $routes->get('/', 'MXJenisProduk::index');
    $routes->get('api', 'MXJenisProduk::apiGetAll');
    $routes->get('api/(:num)', 'MXJenisProduk::apiGetById/$1');
    $routes->post('add/api', 'MXJenisProduk::apiAddProcess');
    $routes->put('edit/api', 'MXJenisProduk::apiEditProcess');
    $routes->get('delete/(:num)', 'MXJenisProduk::delete/$1');
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

$routes->group('mxjenistinta', static function ($routes) {
    $routes->get('/', 'MXJenisTinta::index');
    $routes->get('api', 'MXJenisTinta::apiGetAll');
    $routes->get('api/(:num)', 'MXJenisTinta::apiGetById/$1');
    $routes->post('add/api', 'MXJenisTinta::apiAddProcess');
    $routes->put('edit/api', 'MXJenisTinta::apiEditProcess');
    $routes->get('delete/(:num)', 'MXJenisTinta::delete/$1');
});

$routes->group('mxjenisfilm', static function ($routes) {
    $routes->get('/', 'MXJenisFilm::index');
    $routes->get('api', 'MXJenisFilm::apiGetAll');
    $routes->get('api/(:num)', 'MXJenisFilm::apiGetById/$1');
    $routes->post('add/api', 'MXJenisFilm::apiAddProcess');
    $routes->put('edit/api', 'MXJenisFilm::apiEditProcess');
    $routes->get('delete/(:num)', 'MXJenisFilm::delete/$1');
});

$routes->group('mxjeniskonten', static function ($routes) {
    $routes->get('/', 'MXJenisKonten::index');
    $routes->get('api', 'MXJenisKonten::apiGetAll');
    $routes->get('api/(:num)', 'MXJenisKonten::apiGetById/$1');
    $routes->post('add/api', 'MXJenisKonten::apiAddProcess');
    $routes->put('edit/api', 'MXJenisKonten::apiEditProcess');
    $routes->get('delete/(:num)', 'MXJenisKonten::delete/$1');
});

$routes->group('mxsegmen', static function ($routes) {
    $routes->get('/', 'MXSegmen::index');
    $routes->get('api', 'MXSegmen::apiGetAll');
    $routes->get('api/(:num)', 'MXSegmen::apiGetById/$1');
    $routes->post('add/api', 'MXSegmen::apiAddProcess');
    $routes->put('edit/api', 'MXSegmen::apiEditProcess');
    $routes->get('delete/(:num)', 'MXSegmen::delete/$1');
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

$routes->group('inputprospek', static function ($routes) {
    $routes->get('/', 'MXProspect::add');
    $routes->post('/', 'MXProspect::addProcess');
    $routes->post('api', 'MXProspect::createAlt');
    $routes->post('edit', 'MXProspect::editProcess');
});

$routes->group('listprospek', static function ($routes) {
    $routes->get('/', 'MXProspect::index');
    $routes->get('detail/(:any)/(:num)', 'MXProspect::detail/$1/$2');
    $routes->get('api', 'MXProspect::apiGetAll');
    $routes->post('/', 'MXProspect::apiSearch');
    $routes->get('add/(:any)/(:num)', 'MXProspect::alt/$1/$2');
    $routes->post('add', 'MXProspect::altProcess');
    $routes->get('edit/(:any)/(:num)', 'MXProspect::edit/$1/$2');
    $routes->post('set/priority', 'MXProspect::setPriority');
    $routes->post('delete', 'MXProspect::delete');
});


$routes->group('produk', static function ($routes) {
    $routes->get('/', 'MFProduk::index');
    $routes->post('/', 'MFProduk::productSearch');
    $routes->post('add', 'MFProduk::apiAddProcess');
    $routes->get('edit/(:num)', 'MFProduk::edit/$1');
    $routes->post('edit', 'MFProduk::apiEditProcess');
    $routes->get('delete/(:num)/(:any)', 'MFProduk::delItemKelProduk/$1/$2');
    $routes->post('delete', 'MFProduk::delItemProduct');
});

$routes->group('partproduk', static function ($routes) {
    $routes->get('/', 'MFPartProduk::index');
    $routes->post('/', 'MFPartProduk::partProductSearch');
    $routes->get('api/(:num)', 'MFPartProduk::apiGetByProduct/$1');
    $routes->post('api', 'MFPartProduk::apiAllSisiByPart');
    $routes->get('rev/(:any)/(:any)', 'MFPartProduk::editPartProduct/$1/$2');
    $routes->get('detail/(:any)', 'MFPartProduk::detailPartProduct/$1');
    $routes->post('add/toproduk', 'MFPartProduk::apiAddToProduct');
    $routes->get('add', 'MFPartProduk::addPartProduct');
    $routes->post('add', 'MFPartProduk::apiAddProcess');
    $routes->get('edit/(:any)', 'MFPartProduk::editPartProduct/$1');
    $routes->get('delete/(:any)', 'MFPartProduk::delPartProduk/$1');
});

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
