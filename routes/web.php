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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('admin/login', 'Auth\AdminLoginController@showLoginForm');
Route::post('admin/login', 'Auth\AdminLoginController@login')->name('admin.login');
Route::post('admin/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

Route::prefix('admin')->middleware('auth:adminuser')->group(function () {
    Route::get('/', 'AdminDashboardController@index');
    Route::get('/admin/datatables/ssd', 'AdminDashboardController@ssd');
    Route::get('/create', 'AdminDashboardController@create');
    Route::post('/store', 'AdminDashboardController@store');
    Route::get('{id}/edit/', 'AdminDashboardController@edit');
    Route::patch('{id}/update', 'AdminDashboardController@update');
    Route::delete('/delete/{id}', 'AdminDashboardController@destroy');

    Route::resource('users', 'UserController');
    Route::get('users/datatables/ssd', 'UserController@ssd');

    Route::resource('two', 'TwoController');
    Route::get('two/datatables/ssd', 'TwoController@ssd');

    Route::get('two-overview', 'TwoOverviewController@index')->name('two-overview.index');

    Route::get('two-overview/datatables/ssd', 'TwoOverviewController@ssd');
});

Route::post('two/create', 'HomeController@two');
Route::post('two-total', 'HomeController@total');
