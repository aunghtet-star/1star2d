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

Auth::routes(['register' => false]);


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
    Route::get('/users/detail', 'UserController@userDetail');

    Route::resource('two', 'TwoController');
    Route::get('two/datatables/ssd', 'TwoController@ssd');
    Route::get('two-overview/history', 'TwoController@twoHistory')->name('two-overview.history');
    Route::get('two-overview/two-history-table', 'TwoController@twoHistoryTable')->name('two-overview.history-table');


    // Route::get('two-overview', 'TwoOverviewController@index')->name('two-overview.index');
    // Route::get('two-overview/datatables/ssd', 'TwoOverviewController@ssd');

    Route::resource('three', 'ThreeController');
    Route::get('three/datatables/ssd', 'ThreeController@ssd');
    Route::get('three-overview/history', 'ThreeController@threeHistory')->name('three-overview.history');
    Route::get('three-overview/three-history-table', 'ThreeController@threeHistoryTable')->name('three-overview.history-table');

    Route::resource('amountbreaks', 'BreakNumberController');
    Route::get('amountbreaks/datatables/ssd', 'BreakNumberController@ssd');
});

Route::middleware('auth')->group(function () {
    Route::get('/', 'HomeController@index')->name('home');

    Route::get('/two', 'HomeController@index');
    Route::post('two/create', 'HomeController@two');
    Route::get('user/history-two', 'HomeController@historyTwo')->name('user.history-two');
    
    Route::get('two/htaitpait', 'frontend\HtaitPaitController@index');
    Route::post('two/htaitpait/store', 'frontend\HtaitPaitController@store');


    Route::get('/three', 'frontend\ThreeController@index');
    Route::post('three/create', 'frontend\ThreeController@three');
    Route::get('user/history-three', 'frontend\ThreeController@historyThree')->name('user.history-three');
    
    
    Route::get('user/history', 'HomeController@history')->name('user.history');
});
