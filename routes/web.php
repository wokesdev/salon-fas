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
    return view('auth.login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
});

Route::middleware(['auth.one', 'auth'])->group(function () {
    Route::resource('account', 'AccountController')->except('create', 'show', 'update');
    Route::resource('account-detail', 'AccountDetailController')->except('create', 'show', 'update');
    Route::resource('user', 'UserController')->except('create', 'show', 'update');
    Route::resource('role', 'RoleController')->except('create', 'show', 'update');
    Route::resource('customer', 'CustomerController')->except('create', 'show', 'update');
    Route::resource('package', 'PackageController')->except('create', 'show', 'update');
    Route::resource('supplier', 'SupplierController')->except('create', 'show', 'update');
    Route::resource('purchase', 'PurchaseController');
    Route::resource('purchase-detail', 'PurchaseDetailController');
    Route::resource('sale', 'SaleController');
    Route::resource('sale-detail', 'SaleDetailController');

    Route::post('account/update', 'AccountController@update')->name('account.update');
    Route::post('account-detail/update', 'AccountDetailController@update')->name('account-detail.update');
    Route::post('user/update', 'UserController@update')->name('user.update');
    Route::post('role/update', 'RoleController@update')->name('role.update');
    Route::post('customer/update', 'CustomerController@update')->name('customer.update');
    Route::post('package/update', 'PackageController@update')->name('package.update');
    Route::post('supplier/update', 'SupplierController@update')->name('supplier.update');
    Route::post('purchase/update', 'PurchaseController@update')->name('purchase.update');
    Route::post('purchase-detail/update', 'PurchaseDetailController@update')->name('purchase-detail.update');
    Route::post('sale/update', 'SaleController@update')->name('sale.update');
    Route::post('sale-detail/update', 'SaleController@update')->name('sale-detail.update');

    Route::post('purchase/import', 'PurchaseController@importExcel')->name('purchase.import');
});

Route::middleware(['auth.two', 'auth'])->group(function () {

});

Route::middleware(['auth.three', 'auth'])->group(function () {

});
