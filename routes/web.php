<?php

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
    return view('welcome');
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
        // route barang
        Route::group(['prefix' => '/barang'], function () {
            Route::get('/', 'Admin\AdminController@barang')->name('managementBarang');
            Route::get('/edit/{id}', 'Admin\AdminController@editProduct');
            Route::get('/detail/{id}', 'Admin\AdminController@detailProduct');
        });

        Route::get('/kategori', 'Admin\AdminController@kategori')->name('managementKategori');
        Route::get('/management-stok', 'Admin\AdminController@managementStok')->name('managementStok');
        Route::get('/pelanggan', 'Admin\AdminController@pelanggan')->name('managementPelanggan');
        Route::group(['prefix' => '/kasbon'], function () {
            Route::get('/', 'Admin\AdminController@kasbon')->name('managementKasbon');
            // Route::get('/add', 'Admin\AdminController@addKasbon')->name('addKasbon');
            Route::get('/bayar/{id}', 'Admin\AdminController@bayarKasbon');
            // bayar kasbon
            Route::get('/bayar/{id}/{id_kasbon}', 'Admin\AdminController@payment');
        });
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

Route::group(['prefix' => 'api/'], function () {
    Route::group(['prefix' => 'v1/'], function () {
        Route::group(['prefix' => 'managements'], function () {

            // uploadImage
            Route::post('/upload-image-product', 'UploadFileController@uploadProductImage');
            Route::delete('/delete-image-product/{id}', 'UploadFileController@delImageProduct');

            // get all
            Route::get('/', 'Api\Managements\BarangController@index');
            Route::get('/stok', 'Api\Managements\StokController@index');
            Route::get('/kategori', 'Api\Managements\KategoriController@index');
            Route::get('/categories', 'Api\Managements\KategoriController@getLike');
            Route::get('/pelanggan', 'Api\Managements\PelangganController@index');
            Route::get('/kasbon', 'Api\Managements\KasbonController@index');
            Route::get('/search-pelanggan', 'Api\Managements\PelangganController@search');
            Route::get('/kasbon-pelanggan/{id}', 'Api\Managements\PelangganController@getKasbon');
            Route::get('/pajak', 'Api\Managements\PajakController@index');

            // get detail
            Route::get('barang/{id}', 'Api\Managements\BarangController@show');
            Route::get('stok/{id}', 'Api\Managements\StokController@show');
            Route::get('kategori/{id}', 'Api\Managements\KategoriController@show');
            Route::get('pelanggan/{id}', 'Api\Managements\PelangganController@show');
            Route::get('kasbon/{id}', 'Api\Managements\KasbonController@show');
            Route::get('pajak/{id}', 'Api\Managements\PajakController@show');

            // add 
            Route::group(['prefix' => 'add'], function () {
                Route::post('/barang', 'Api\Managements\BarangController@store');
                Route::post('/stok', 'Api\Managements\StokController@store');
                Route::post('/kategori', 'Api\Managements\KategoriController@store');
                Route::post('/pelanggan', 'Api\Managements\PelangganController@store');
                Route::post('/kasbon', 'Api\Managements\KasbonController@store');
                Route::post('/pajak', 'Api\Managements\PajakController@store');
            });

            // update 
            Route::group(['prefix' => 'update'], function () {
                Route::put('/barang/{id}', 'Api\Managements\BarangController@update');
                Route::put('/stok/{id}', 'Api\Managements\StokController@update');
                Route::put('/kategori/{id}', 'Api\Managements\KategoriController@update');
                Route::put('/pelanggan/{id}', 'Api\Managements\PelangganController@update');
                Route::put('/kasbon/{id}', 'Api\Managements\KasbonController@update');
                Route::put('/pajak/{id}', 'Api\Managements\PajakController@update');
            });

            // delete 
            Route::group(['prefix' => 'delete'], function () {
                Route::delete('/barang/{id}', 'Api\Managements\BarangController@destroy');
                Route::delete('/stok/{id}', 'Api\Managements\StokController@destroy');
                Route::delete('/kategori/{id}', 'Api\Managements\KategoriController@destroy');
                Route::delete('/pelanggan/{id}', 'Api\Managements\PelangganController@destroy');
                Route::delete('/kasbon/{id}', 'Api\Managements\KasbonController@destroy');
                Route::delete('/pajak/{id}', 'Api\Managements\PajakController@destroy');
            });

        });
    });
});

Route::get('/home', 'HomeController@index')->name('home');