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
    Route::get('users/detail/{date}', 'UserController@userDetail')->name('users.detail');

    Route::resource('two', 'TwoController');
    Route::get('two/datatables/ssd', 'TwoController@ssd');
    Route::get('two-overview/history', 'TwoController@twoHistory')->name('two-overview.history');
    Route::get('two-overview/two-history-table', 'TwoController@twoHistoryTable')->name('two-overview.history-table');

    Route::get('/two-overview/twopout/{two}/date={date}', 'PoutController@twoPout');
    Route::get('/three-overview/threepout/{three}/from={from}/to={to}', 'PoutController@threePout');

    Route::resource('three', 'ThreeController');
    Route::get('three/datatables/ssd', 'ThreeController@ssd');
    Route::get('three-overview/history', 'ThreeController@threeHistory')->name('three-overview.history');

    Route::resource('amountbreaks', 'BreakNumberController');
    Route::get('amountbreaks/datatables/ssd', 'BreakNumberController@ssd');

    Route::resource('allbreakwithamount', 'AllBreakWithAmountController');
    Route::get('allbreakwithamount/datatables/ssd', 'AllBreakWithAmountController@ssd');

    Route::get('/wallet', 'WalletController@index')->name('wallet.index');
    Route::get('/wallet/datatables/ssd', 'WalletController@ssd');
    Route::get('/wallet/add', 'WalletController@add');
    Route::post('/wallet/store', 'WalletController@store');

    Route::get('/wallet/substract', 'WalletController@substract');
    Route::post('/wallet/remove', 'WalletController@remove');

    Route::resource('roles', 'RoleController');
    Route::get('roles/datatables/ssd', 'RoleController@ssd');

    Route::resource('permissions', 'PermissionController');
    Route::get('permissions/datatables/ssd', 'PermissionController@ssd');

    Route::get('profile', 'ProfileController@index')->name('profile');
    Route::get('profile/updatepassword', 'ProfileController@updatepassword');
    Route::post('profile/updatepassword/store', 'ProfileController@store');
    Route::get('profile/transactions', 'ProfileController@transactions');

    
    Route::post('/two/showhide', 'ShowHideController@TwoShowHide');
    Route::post('/htaitpait/showhide', 'ShowHideController@HtaitPaitShowHide');
    Route::post('/three/showhide', 'ShowHideController@ThreeShowHide');
});

Route::middleware('auth')->group(function () {
    Route::get('/', 'HomeController@index')->name('home');

    Route::get('/two', 'HomeController@index')->name('two.index.blade');
    Route::post('/two/confirm', 'HomeController@twoconfirm');
    Route::post('two/create', 'HomeController@two');
    Route::get('user/history-two', 'HomeController@historyTwo')->name('user.history-two');
    
    Route::get('two/htaitpait', 'frontend\HtaitPaitController@index');
    Route::post('two/htaitpait/confirm', 'frontend\HtaitPaitController@confirm');
    Route::post('two/htaitpait/store', 'frontend\HtaitPaitController@store');


    Route::get('/three', 'frontend\ThreeController@index');
    Route::post('/three/confirm', 'frontend\ThreeController@threeconfirm');
    Route::post('three/create', 'frontend\ThreeController@three');
    Route::get('user/history-three', 'frontend\ThreeController@historyThree')->name('user.history-three');
    
    
    Route::get('user/history', 'HomeController@history')->name('user.history');

    Route::get('/notification', 'NotificationController@index');
});
