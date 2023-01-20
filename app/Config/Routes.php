<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/persiapan', 'Preparation::province');
$routes->get('/persiapan/nasional', 'Preparation::national');
$routes->get('/persiapan/lain-lain', 'Preparation::others');
$routes->get('/silabus', 'Syllabus::national');
$routes->get('/olimpiade', 'Competition::listNational');
$routes->get('/olimpiade/internasional', 'Competition::listInternational');
$routes->get('/olimpiade/regional', 'Competition::listRegional');
$routes->get('/arsip', 'Archive::national');
$routes->get('/arsip/kota', 'Archive::city');
$routes->get('/arsip/provinsi', 'Archive::province');
$routes->get('/statistik', 'Statistics::persons');
$routes->post('/statistik', 'Statistics::persons');
$routes->get('/statistik/indonesia', 'Statistics::national');
$routes->get('/statistik/provinsi', 'Statistics::provinces');
$routes->get('/statistik/provinsi/(:alphanum)', 'Statistics::province/$1');
$routes->get('/statistik/sekolah', 'Statistics::schools');
$routes->post('/statistik/sekolah', 'Statistics::schools');
$routes->get('/statistik/sekolah/(:alphanum)', 'Statistics::school/$1');
$routes->get('/statistik/peserta/(:alphanum)', 'Statistics::person/$1');
$routes->get('/(:alphanum)', 'Competition::info/$1');
$routes->get('/(:alphanum)/silabus', 'Competition::syllabus/$1');
$routes->get('/(:alphanum)/peraturan', 'Competition::rules/$1');
$routes->get('/(:alphanum)/hasil', 'Competition::results/$1');
$routes->get('/(:alphanum)/provinsi', 'Competition::provinces/$1');
$routes->get('/(:alphanum)/open', 'Competition::openContest/$1');
$routes->get('/(:alphanum)/open-results', 'Competition::openContestResults/$1');

/**
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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
