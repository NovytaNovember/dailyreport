<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Rute untuk Dashboard
$routes->get('/', 'Dashboard::index');  // Route ke halaman utama dashboard
$routes->get('dashboard', 'Dashboard::index');  // Route alternatif ke dashboard
 

// Rute untuk Cetak Laporan
$routes->get('/cetak_laporan_cpp', 'Cetaklaporan::cetakLaporanCpp');  // Halaman Cetak Laporan CPP
$routes->get('/cetak_laporan_port', 'Cetaklaporan::cetakLaporanPort'); // Halaman Cetak Laporan Port

// Rute untuk CPP
$routes->group('', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('cpp', 'CppController::index');
    $routes->get('cpp/search', 'CppController::search'); // Rute untuk pencarian
    $routes->post('cpp/uploadFile', 'CppController::uploadFile');
    $routes->get('cpp/rincian/(:num)', 'CppController::rincian/$1');
    $routes->get('cpp/edit/(:num)', 'CppController::edit/$1');
    $routes->post('cpp/update', 'CppController::update');
    $routes->post('cpp/delete', 'CppController::delete');
    $routes->get('cpp/download/(:num)', 'CppController::download/$1');
});