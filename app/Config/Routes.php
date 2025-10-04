<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/persiapan', 'Preparation::province');
$routes->get('/persiapan/nasional', 'Preparation::national');
$routes->get('/persiapan/lain-lain', 'Preparation::others');
$routes->get('/silabus', 'Syllabus::national');
$routes->get('/silabus/kota', 'Syllabus::city');
$routes->get('/silabus/provinsi', 'Syllabus::province');
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
$routes->get('/(:alphanum)/(?i)open', 'Competition::openContest/$1');
$routes->get('/(:alphanum)/(?i)open-results', 'Competition::openContestResults/$1');
