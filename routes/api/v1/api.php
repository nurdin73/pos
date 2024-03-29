<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1/' , 'middleware' => 'auth:api'], function() {
    Route::group(['prefix' => 'managements'], function () {

        // uploadImage
        Route::post('/upload-image-product', 'UploadFileController@uploadProductImage');
        Route::delete('/delete-image-product/{id}', 'UploadFileController@delImageProduct');

        // get all
        Route::get('/', 'Api\Managements\BarangController@index');
        Route::get('/kategori', 'Api\Managements\KategoriController@index');
        Route::get('/categories', 'Api\Managements\KategoriController@getLike');
        Route::get('/pelanggan', 'Api\Managements\PelangganController@index');
        Route::get('/kasbon', 'Api\Managements\KasbonController@index');
        Route::get('/search-pelanggan', 'Api\Managements\PelangganController@search');
        Route::get('/kasbon-pelanggan/{id}', 'Api\Managements\PelangganController@getKasbon');
        Route::get('/pajak', 'Api\Managements\PajakController@index');
        Route::get('/carts/{no_invoice}', 'Api\Managements\TransaksiController@getCarts');
        Route::get('/list-transaction', 'Api\Managements\TransaksiController@listTransaksi');
        Route::get('/transaksi', 'Api\Managements\TransaksiController@transactions');
        Route::get('/transaksi-per-jam', 'Api\Managements\TransaksiController@getTransactionPerHours');
        Route::get('/transaksi-per-hari', 'Api\Managements\TransaksiController@getTransactionPerDays');
        Route::get('/transaksi-per-bulan', 'Api\Managements\TransaksiController@getTransactionPerMonth');
        Route::get('/transaksi-per-tahun', 'Api\Managements\TransaksiController@getTransactionPerYear');
        Route::get('/stocks/{id_product}', 'Api\Managements\StokController@listStok');
        Route::get('/modal', 'Api\Managements\StokController@modal');
        Route::get('/supliers', 'Api\Managements\SuplierController@getAll');
        Route::get('/branch-stores', 'Api\Managements\BranchStoreController@getAll');
        Route::get('/chart-pajak', 'Api\Managements\PajakController@cartPajak');
        Route::get('/loyality-program', 'Api\Managements\LoyalityProgramController@getall');
        Route::get('/return-products', 'Api\Managements\ReturnProductController@getall');

        // get detail
        Route::get('barang/{id}', 'Api\Managements\BarangController@show');
        Route::get('kategori/{id}', 'Api\Managements\KategoriController@show');
        Route::get('pelanggan/{id}', 'Api\Managements\PelangganController@show');
        Route::get('kasbon/{id}', 'Api\Managements\KasbonController@show');
        Route::get('pajak/{id}', 'Api\Managements\PajakController@show');
        Route::get('cart/{id}', 'Api\Managements\TransaksiController@detailCart');
        Route::get('stok-detail/{id}', 'Api\Managements\StokController@show');
        Route::get('type-price/{id}', 'Api\Managements\barangController@detailTypePrice');
        Route::get('suplier/{id}', 'Api\Managements\SuplierController@getDetail');
        Route::get('branch-store/{id}', 'Api\Managements\BranchStoreController@show');
        Route::get('invoice/{id}', 'Api\Managements\TransaksiController@invoice');
        Route::get('kode-barang/{id}', 'Api\Managements\BarangController@codeProduct');
        Route::get('cetak-struk/{id}', 'Api\Managements\TransaksiController@cetakStruk');
        Route::get('loyality-program/{id}', 'Api\Managements\LoyalityProgramController@get');
        Route::get('return-product/{id}', 'Api\Managements\ReturnProductController@get');

        // add 
        Route::group(['prefix' => 'add'], function () {
            Route::post('/barang', 'Api\Managements\BarangController@store');
            Route::post('/kategori', 'Api\Managements\KategoriController@store');
            Route::post('/pelanggan', 'Api\Managements\PelangganController@store');
            Route::post('/kasbon', 'Api\Managements\KasbonController@store');
            Route::post('/payment-kasbon/{id}', 'Api\Managements\KasbonController@payment');
            Route::post('/pajak', 'Api\Managements\PajakController@store');
            Route::post('/cart', 'Api\Managements\TransaksiController@store');
            Route::post('/transaction', 'Api\Managements\TransaksiController@addTransaksi');
            Route::post('/type-price', 'Api\Managements\BarangController@addTypePrice');
            Route::post('/suplier', 'Api\Managements\SuplierController@addSuplier');
            Route::post('/branch-store', 'Api\Managements\BranchStoreController@add');
            Route::post('/kode-barang', 'Api\Managements\BarangController@addCodeProduct');
            Route::post('/loyality-program', 'Api\Managements\LoyalityProgramController@store');
            Route::post('/return-product', 'Api\Managements\ReturnProductController@add');
        });

        // update 
        Route::group(['prefix' => 'update'], function () {
            Route::put('/barang/{id}', 'Api\Managements\BarangController@update');
            Route::put('/stok/{id}', 'Api\Managements\StokController@update');
            Route::put('/stok-history/{id}', 'Api\Managements\StokController@updateStok');
            Route::put('/kategori/{id}', 'Api\Managements\KategoriController@update');
            Route::put('/pelanggan/{id}', 'Api\Managements\PelangganController@update');
            Route::put('/kasbon/{id}', 'Api\Managements\KasbonController@update');
            Route::put('/pajak/{id}', 'Api\Managements\PajakController@update');
            Route::put('/cart/{id}', 'Api\Managements\TransaksiController@updateCart');
            Route::put('/type-price/{id}', 'Api\Managements\BarangController@updateTypePrice');
            Route::put('/price-cart/{id}', 'Api\Managements\TransaksiController@changePrice');
            Route::put('/suplier/{id}', 'Api\Managements\SuplierController@updateSuplier');
            Route::put('/branch-store/{id}', 'Api\Managements\BranchStoreController@update');
            Route::put('/kode-barang/{id}', 'Api\Managements\BarangController@updateCodeProduct');
            Route::put('/loyality-program/{id}', 'Api\Managements\LoyalityProgramController@update');
            Route::put('/return-product/{id}', 'Api\Managements\ReturnProductController@update');
        });

        // delete 
        Route::group(['prefix' => 'delete'], function () {
            Route::delete('/barang/{id}', 'Api\Managements\BarangController@destroy');
            Route::delete('/stok/{id}', 'Api\Managements\StokController@destroy');
            Route::delete('/kategori/{id}', 'Api\Managements\KategoriController@destroy');
            Route::delete('/pelanggan/{id}', 'Api\Managements\PelangganController@destroy');
            Route::delete('/kasbon/{id}', 'Api\Managements\KasbonController@destroy');
            Route::delete('/pajak/{id}', 'Api\Managements\PajakController@destroy');
            Route::delete('/cart/{id}', 'Api\Managements\TransaksiController@deleteCart');
            Route::delete('/type-price/{id}', 'Api\Managements\BarangController@deleteTypePrice');
            Route::delete('/suplier/{id}', 'Api\Managements\SuplierController@deleteSuplier');
            Route::delete('/branch-store/{id}', 'Api\Managements\BranchStoreController@delete');
            Route::delete('/kode-barang/{id}', 'Api\Managements\BarangController@deleteCodeProduct');
            Route::delete('/transaksi/{no_invoince}', 'Api\Managements\TransaksiController@cancelTransaction');
            Route::delete('/loyality-program/{id}', 'Api\Managements\LoyalityProgramController@delete');
            Route::delete('/return-product/{id}', 'Api\Managements\ReturnProductController@destroy');
        });

    });

    Route::group(['prefix' => 'reports'], function () {
        Route::get('/penjualan-barang', 'Api\Reports\PenjualanController@getAll')->name('reportPenjualanProduct');
        Route::get('/pembelian-barang', 'Api\Reports\PembelianController@getAll');
        Route::get('/kasbon', 'Api\Managements\KasbonController@chartKasbon')->name('reportKasbonChart');
        Route::get('/customer', 'Api\Managements\PelangganController@chartPelanggan');
        Route::get('/barang', 'Api\Managements\BarangController@reportProducts');
        Route::get('/pajak', 'Api\Managements\PajakController@reportTaxes');
    });

    Route::group(['prefix' => 'settings'], function () {
        // get all
        Route::get('/staffs', 'Api\Settings\StaffController@getall');
        Route::get('/roles', 'Api\Settings\RoleController@getall');
        Route::get('/role-access', 'Api\Settings\RoleAccessController@all');
        Route::get('/sub-menus/{role_id}', 'Api\Settings\SubMenuController@getall');

        // get detail
        Route::get('/profile', 'Api\Settings\ProfileController@detail');
        Route::get('/store', 'Api\Settings\StoreController@detail');
        Route::get('/staff/{id}', 'Api\Settings\StaffController@get');
        Route::post('/printer/{id}', 'Api\Settings\PrinterController@setting');
        Route::get('/printer/{id}', 'Api\Settings\PrinterController@getSetting');
        Route::get('/role/{id}', 'Api\Settings\RoleController@get');

        Route::get('/test-printer', 'Api\Settings\PrinterController@testConnection');

        // update
        Route::group(['prefix' => '/update'], function () {
            Route::put('/profile/{id}', 'Api\Settings\ProfileController@update');
            Route::put('/change-password', 'Api\Settings\ProfileController@changePassword');
            Route::post('/change-logo', 'Api\Settings\StoreController@updateLogo');
            Route::put('/change-detail-store', 'Api\Settings\StoreController@update');
            Route::put('/staff/{id}', 'Api\Settings\StaffController@update');
            Route::put('/role/{id}', 'Api\Settings\RoleController@update');
            Route::put('/role-access/{id}', 'Api\Settings\RoleAccessController@isGranted');
            Route::put('/locked', 'Api\Settings\ProfileController@locked');
        });

        // add
        Route::group(['prefix' => '/add'], function () {
            Route::post('/staff', 'Api\Settings\StaffController@add');
            Route::post('/role', 'Api\Settings\RoleController@create');
        });

        // delete
        Route::group(['prefix' => '/delete'], function () {
            Route::delete('/staff/{id}', 'Api\Settings\StaffController@destroy');
            Route::delete('/role/{id}', 'Api\Settings\RoleController@destroy');
        });
    });

    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/transaksi', 'Api\DashboardController@transactions');
        Route::get('/chart-transactions', 'Api\DashboardController@chartTransactions');
        Route::get('/best-seller', 'Api\DashboardController@bestSeller');
        Route::get('/new-transactions', 'Api\DashboardController@newTransactions');
    });

    Route::group(['prefix' => 'utils'], function() {
        Route::get('/menus', 'Api\Settings\UtilsController@menus');
    });
});
