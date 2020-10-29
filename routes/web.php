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
    Route::resource('user', 'UserController');
    Route::resource('role', 'RoleController');
    Route::resource('customer', 'CustomerController');

    Route::post('user/update', 'UserController@update')->name('user.update');
    Route::post('role/update', 'RoleController@update')->name('role.update');
    Route::post('customer/update', 'CustomerController@update')->name('customer.update');
});

Route::middleware(['auth.two', 'auth'])->group(function () {

});

Route::middleware(['auth.three', 'auth'])->group(function () {

});
