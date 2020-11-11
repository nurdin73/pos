<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('layouts.template');
});

// Auth::routes([
//     'login' => 
// ]);

Route::group(['prefix' => 'auth'], function () {
    Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('/login', 'Auth\LoginController@login')->name('loginPost');
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'Admin\AdminController@index')->name('dashboardAdmin');
    Route::group(['prefix' => 'management'], function () {
        Route::get('/', 'Admin\AdminController@barang')->name('managementBarang');
        Route::get('/kategori', 'Admin\AdminController@kategori')->name('managementKategori');
        Route::get('/management-stok', 'Admin\AdminController@managementStok')->name('managementStok');
        Route::get('/pelanggan', 'Admin\AdminController@pelanggan')->name('managementPelanggan');
        Route::get('/kasbon', 'Admin\AdminController@kasbon')->name('managementKasbon');
        Route::get('/pajak', 'Admin\AdminController@pajak')->name('managementPajak');
    });

    Route::group(['prefix' => 'reports'], function () {
        Route::get('/', 'Admin\ReportController@index')->name('reportUmum');
        Route::get('/transaksi', 'Admin\ReportController@transaksi')->name('reportTransaksi');
        Route::get('/penjualan', 'Admin\ReportController@penjualan')->name('reportPenjualan');
        Route::get('/pembelian', 'Admin\ReportController@pembelian')->name('reportPembelian');
        Route::get('/modal', 'Admin\ReportController@modal')->name('reportModal');
        Route::get('/pajak', 'Admin\ReportController@pajak')->name('reportPajak');
        Route::get('/pengunjung', 'Admin\ReportController@pengunjung')->name('reportPengunjung');
    });

    Route::group(['prefix' => 'settings'], function () {
        Route::get('/', 'Admin\SettingController@index')->name('settingProfile');
        Route::get('/toko', 'Admin\SettingController@toko')->name('settingToko');
        Route::get('/database', 'Admin\SettingController@database')->name('settingDatabase');
        Route::get('/management-staff', 'Admin\SettingController@managementStaff')->name('settingManagementStaff');
    });

});


Route::get('/home', 'HomeController@index')->name('home');
