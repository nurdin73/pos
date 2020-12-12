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

        Route::group(['prefix' => '/suplier'], function () {
            Route::get('/', 'Admin\AdminController@suplier')->name('managementSuplier');
            Route::get('/detail/{id}', 'Admin\AdminController@detailSuplier');
        });

        Route::group(['prefix' => '/loyality-program'], function () {
            Route::get('/', 'Admin\AdminController@loyalityProgram')->name('loyalityProgram');
        });

        Route::get('/kategori', 'Admin\AdminController@kategori')->name('managementKategori');
        Route::get('/transaksi', 'Admin\AdminController@managementTransaksi')->name('managementTransaksi');
        Route::get('/cabang', 'Admin\AdminController@managementCabang')->name('managementCabang');
        Route::get('/pelanggan', 'Admin\AdminController@pelanggan')->name('managementPelanggan');
        Route::get('/management-stok', 'Admin\AdminController@managementStok')->name('managementStok');
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
        Route::get('/pelanggan', 'Admin\ReportController@reportPelanggan')->name('reportPelanggan');
        Route::group(['prefix' => '/kasbon'], function () {
            Route::get('/', 'Admin\ReportController@reportKasbon')->name('reportKasbon');
        });

        Route::group(['prefix' => '/barang'], function () {
            Route::get('/', 'Admin\ReportController@barang')->name('reportBarang');
        });
    });

    Route::group(['prefix' => 'settings'], function () {
        Route::get('/', 'Admin\SettingController@index')->name('settingProfile');
        Route::get('/toko', 'Admin\SettingController@toko')->name('settingToko');
        Route::group(['prefix' => '/api'], function () {
            Route::get('/', 'Admin\SettingController@api')->name('settingApi');
        });
        // Route::get('/database', 'Admin\SettingController@database')->name('settingDatabase');
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
            Route::get('/kategori', 'Api\Managements\KategoriController@index');
            Route::get('/categories', 'Api\Managements\KategoriController@getLike');
            Route::get('/pelanggan', 'Api\Managements\PelangganController@index');
            Route::get('/kasbon', 'Api\Managements\KasbonController@index');
            Route::get('/search-pelanggan', 'Api\Managements\PelangganController@search');
            Route::get('/kasbon-pelanggan/{id}', 'Api\Managements\PelangganController@getKasbon');
            Route::get('/pajak', 'Api\Managements\PajakController@index');
            Route::get('/carts/{no_invoice}', 'Api\Managements\TransaksiController@getCarts');
            Route::get('/transaksi', 'Api\Managements\TransaksiController@transactions');
            Route::get('/transaksi-per-jam', 'Api\Managements\TransaksiController@getTransactionPerHours');
            Route::get('/transaksi-per-hari', 'Api\Managements\TransaksiController@getTransactionPerDays');
            Route::get('/transaksi-per-bulan', 'Api\Managements\TransaksiController@getTransactionPerMonth');
            Route::get('/transaksi-per-tahun', 'Api\Managements\TransaksiController@getTransactionPerYear');
            Route::get('/stocks/{id_product}', 'Api\Managements\StokController@listStok');
            Route::get('/modal', 'Api\Managements\StokController@modal');
            Route::get('/supliers', 'Api\Managements\SuplierController@getAll');
            Route::get('/branch-stores', 'Api\Managements\BranchStoreController@getAll');

            // get detail
            Route::get('barang/{id}', 'Api\Managements\BarangController@show');
            Route::get('kategori/{id}', 'Api\Managements\KategoriController@show');
            Route::get('pelanggan/{id}', 'Api\Managements\PelangganController@show');
            Route::get('kasbon/{id}', 'Api\Managements\KasbonController@show');
            Route::get('pajak/{id}', 'Api\Managements\PajakController@show');
            Route::get('tax/{barang_id}', 'Api\Managements\PajakController@getTax');
            Route::get('cart/{id}', 'Api\Managements\TransaksiController@detailCart');
            Route::get('stok-detail/{id}', 'Api\Managements\StokController@show');
            Route::get('type-price/{id}', 'Api\Managements\barangController@detailTypePrice');
            Route::get('suplier/{id}', 'Api\Managements\SuplierController@getDetail');
            Route::get('branch-store/{id}', 'Api\Managements\BranchStoreController@show');

            // add 
            Route::group(['prefix' => 'add', 'middleware' => ['auth']], function () {
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
            });

            // delete 
            Route::group(['prefix' => 'delete', 'middleware' => ['auth']], function () {
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
            });

        });

        Route::group(['prefix' => 'reports'], function () {
            Route::get('/penjualan-barang', 'Api\Reports\PenjualanController@getAll');
            Route::get('/pembelian-barang', 'Api\Reports\PembelianController@getAll');
            Route::get('/kasbon', 'Api\Managements\KasbonController@chartKasbon');
            Route::get('/customer', 'Api\Managements\PelangganController@chartPelanggan');
            Route::get('/barang', 'Api\Managements\BarangController@reportProducts');
        });

        Route::group(['prefix' => 'exports'], function () {
            Route::get('/transactions-hours', 'Api\Exports\TransactionsController@hours')->name('exportTrxHours');
            Route::get('/transactions-days', 'Api\Exports\TransactionsController@days')->name('exportTrxDays');
            Route::get('/transactions-months', 'Api\Exports\TransactionsController@months')->name('exportTrxMonths');
            Route::get('/transactions-years', 'Api\Exports\TransactionsController@years')->name('exportTrxYears');
        });

        Route::group(['prefix' => 'settings'], function () {
            // get all
            Route::get('/staffs', 'Api\Settings\StaffController@getall');

            // get detail
            Route::get('/profile', 'Api\Settings\ProfileController@detail');
            Route::get('/store', 'Api\Settings\StoreController@detail');
            Route::get('/staff/{id}', 'Api\Settings\StaffController@get');

            // update
            Route::group(['prefix' => '/update'], function () {
                Route::put('/profile/{id}', 'Api\Settings\ProfileController@update');
                Route::put('/change-password', 'Api\Settings\ProfileController@changePassword');
                Route::post('/change-logo', 'Api\Settings\StoreController@updateLogo');
                Route::put('/change-detail-store', 'Api\Settings\StoreController@update');
                Route::put('/staff/{id}', 'Api\Settings\StaffController@update');
            });

            // add
            Route::group(['prefix' => '/add'], function () {
                Route::post('/staff', 'Api\Settings\StaffController@add');
            });

            // delete
            Route::group(['prefix' => '/delete'], function () {
                Route::delete('/staff/{id}', 'Api\Settings\StaffController@destroy');
            });
        });

        Route::group(['prefix' => 'dashboard'], function () {
            Route::get('/transaksi', 'Api\DashboardController@transactions');
            Route::get('/chart-transactions', 'Api\DashboardController@chartTransactions');
            Route::get('/best-seller', 'Api\DashboardController@bestSeller');
            Route::get('/new-transactions', 'Api\DashboardController@newTransactions');
        });
    });
});

Route::get('/home', 'HomeController@index')->name('home');