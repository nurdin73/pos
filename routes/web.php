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

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'checkLockAccount']], function () {
    Route::get('/', 'Admin\AdminController@index')->name('dashboardAdmin')->middleware('role:dashboardAdmin');
    Route::group(['prefix' => 'management'], function () {
        // route barang
        Route::group(['prefix' => '/barang'], function () {
            Route::get('/', 'Admin\AdminController@barang')->name('managementBarang')->middleware('role:managementBarang');
            Route::get('/edit/{id}', 'Admin\AdminController@editProduct')->middleware('role:managementBarang');
            Route::get('/detail/{id}', 'Admin\AdminController@detailProduct')->middleware('role:managementBarang');
        });
        Route::group(['prefix' => '/return'], function(){
            Route::get('/', 'Admin\AdminController@return')->name('returnBarang')->middleware('role:returnBarang');
        });

        Route::group(['prefix' => '/suplier'], function () {
            Route::get('/', 'Admin\AdminController@suplier')->name('managementSuplier')->middleware('role:managementSuplier');
            Route::get('/detail/{id}', 'Admin\AdminController@detailSuplier')->middleware('role:managementSuplier');
        });

        Route::group(['prefix' => '/loyality-program'], function () {
            Route::get('/', 'Admin\AdminController@loyalityProgram')->name('loyalityProgram')->middleware('role:loyalityProgram');
        });

        Route::get('/kategori', 'Admin\AdminController@kategori')->name('managementKategori')->middleware('role:managementKategori');;
        
        Route::group(['prefix' => '/transaksi'], function () {
            Route::get('/', 'Admin\AdminController@managementTransaksi')->name('managementTransaksi')->middleware('role:#');
            Route::get('/list-transaksi', 'Admin\AdminController@listTransaksi')->name('listTransaksi')->middleware('role:#');
            Route::get('/invoice/{id}', 'Admin\AdminController@invoice')->middleware('role:#');
        });

        Route::get('/cabang', 'Admin\AdminController@managementCabang')->name('managementCabang')->middleware('role:managementCabang');
        Route::get('/cabang/detail/{id}', 'Admin\AdminController@detailCabang')->middleware('role:managementCabang');
        Route::get('/pelanggan', 'Admin\AdminController@pelanggan')->name('managementPelanggan')->middleware('role:managementPelanggan');
        Route::get('/management-stok', 'Admin\AdminController@managementStok')->name('managementStok')->middleware('role:managementStok');
        Route::group(['prefix' => '/kasbon', 'middleware' => ['role:managementKasbon']], function () {
            Route::get('/', 'Admin\AdminController@kasbon')->name('managementKasbon');
            // Route::get('/add', 'Admin\AdminController@addKasbon')->name('addKasbon');
            Route::get('/bayar/{id}', 'Admin\AdminController@bayarKasbon');
            // bayar kasbon
            Route::get('/bayar/{id}/{id_kasbon}', 'Admin\AdminController@payment');
        });
        Route::group(['prefix' => '/pajak', 'middleware' => ['role:pajakUniversal']], function () {
            Route::get('/barang', 'Admin\AdminController@pajakBarang')->name('pajakBarang');
            Route::get('/universal', 'Admin\AdminController@pajakUniversal')->name('pajakUniversal');
        });
        Route::group(['prefix' => '/staff', 'middleware' => 'role:settingManagementStaff'], function() {
            Route::get('/', 'Admin\AdminController@managementStaff')->name('settingManagementStaff');
        });
    });

    Route::group(['prefix' => 'reports'], function () {
        Route::get('/', 'Admin\ReportController@index')->name('reportUmum')->middleware('role:#');
        Route::get('/transactions', 'Admin\ReportController@transaksi')->name('reportTransaksi')->middleware('role:#');
        Route::get('/penjualan', 'Admin\ReportController@penjualan')->name('reportPenjualan')->middleware('role:#');
        Route::get('/pembelian', 'Admin\ReportController@pembelian')->name('reportPembelian')->middleware('role:#');
        Route::get('/modals', 'Admin\ReportController@modal')->name('reportModal')->middleware('role:reportModal');
        Route::get('/pajak', 'Admin\ReportController@pajak')->name('reportPajak')->middleware('role:reportPajak');
        Route::get('/customers', 'Admin\ReportController@reportPelanggan')->name('reportPelanggan')->middleware('role:reportPelanggan');
        Route::group(['prefix' => '/kasbon', 'middleware' => ['role:reportKasbon']], function () {
            Route::get('/', 'Admin\ReportController@reportKasbon')->name('reportKasbon');
        });

        Route::group(['prefix' => '/barang', 'middleware' => ['role:reportBarang']], function () {
            Route::get('/', 'Admin\ReportController@barang')->name('reportBarang');
        });
        Route::post('/cetak-struk', 'Admin\ReportController@cetakStruk')->name('cetakStruk');
        
        Route::get('/transactions-hours', 'Api\Exports\TransactionsController@hours')->name('exportTrxHours');
        Route::get('/transactions-days', 'Api\Exports\TransactionsController@days')->name('exportTrxDays');
        Route::get('/transactions-months', 'Api\Exports\TransactionsController@months')->name('exportTrxMonths');
        Route::get('/transactions-years', 'Api\Exports\TransactionsController@years')->name('exportTrxYears');

        Route::get('/products', 'Api\Exports\ProductController@index')->name('exportProduct');

        Route::get('/pembelian-products', 'Api\Reports\PembelianController@export')->name('exportPembelianProduct');
        Route::get('/modal', 'Api\Exports\ModalController@export')->name('exportModal');

        Route::get('/pelanggan', 'Api\Exports\CustomerController@report')->name('exportCustomer');

        Route::get('/penjualan-barang-export', 'Api\Reports\PenjualanController@getAll')->name('exportPenjualaBarang');
        Route::get('/kasbon-export', 'Api\Managements\KasbonController@chartKasbon')->name('exportKasbon');

        Route::get('/transaksi', 'Api\Exports\TransactionsController@transactions')->name('exportTrx');

        Route::get('/invoice', 'Api\Exports\TransactionsController@invoice')->name('printPdfInvoice');

        // export databases
        Route::post('/databases', 'Api\Exports\DatabaseController@export')->name('exportDatabases');
        Route::get('/databases', 'Api\Exports\DatabaseController@all')->name('getListDatabaseExport');
    });

    Route::group(['prefix' => 'settings'], function () {
        Route::get('/', 'Admin\SettingController@index')->name('settingProfile')->middleware('role:settingProfile');
        Route::get('/toko', 'Admin\SettingController@toko')->name('settingToko')->middleware('role:settingToko');
        Route::group(['prefix' => '/api', 'middleware' => ['role:settingApi']], function () {
            Route::get('/', 'Admin\SettingController@api')->name('settingApi');
        });
        Route::get('/database', 'Admin\SettingController@database')->name('settingDatabase')->middleware('role:settingDatabase');
        Route::get('/printer-settings', 'Admin\SettingController@printerSettings')->name('printerSettings')->middleware('role:printerSettings');
        Route::get('/hak-akses', 'Admin\SettingController@hakAkses')->name('settingAccess')->middleware('role:settingAccess');
        Route::get('/roles', 'Admin\SettingController@roles')->name('settingRoles')->middleware('role:settingRoles');
    });
});

// Route::group(['prefix' => 'api/'], function () {
//     Route::group(['prefix' => 'v1/', 'middleware' => ['checkLogin']], function () {
        
//     });
// });

Route::get('/home', 'HomeController@index')->name('home');