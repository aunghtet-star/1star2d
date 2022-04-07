<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\backend\TwoController;
use App\Http\Controllers\backend\PoutController;
use App\Http\Controllers\backend\RoleController;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\backend\AgentController;
use App\Http\Controllers\backend\ThreeController;
use App\Http\Controllers\backend\MasterController;
use App\Http\Controllers\backend\WalletController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\backend\ShowHideController;
use App\Http\Controllers\backend\DashBoardController;
use App\Http\Controllers\backend\BetHistoryController;
use App\Http\Controllers\backend\FakeNumberController;
use App\Http\Controllers\backend\PermissionController;
use App\Http\Controllers\backend\RealNumberController;
use App\Http\Controllers\frontend\HtaitPaitController;
use App\Http\Controllers\backend\TwoOverviewController;
use App\Http\Controllers\backend\NotificationController;
use App\Http\Controllers\backend\WalletHistoryController;
use App\Http\Controllers\backend\AdminDashboardController;
use App\Http\Controllers\backend\AllBreakWithAmountController;

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

// ------------------------------- Auth --------------------------------------------------------------

Auth::routes(['register' => false]);


Route::get('admin/login', [AdminLoginController::class,'showLoginForm']);
Route::post('admin/login', [AdminLoginController::class,'login'])->name('admin.login');
Route::post('admin/logout', [AdminLoginController::class,'logout'])->name('admin.logout');

// ------------------------------- frontend --------------------------------------------------------------

Route::middleware('auth:web')->group(function () {
    Route::get('/', [HomeController::class,'home'])->name('home');

    Route::get('/two', [HomeController::class,'index'])->name('two.index.blade');
    Route::post('/two/confirm', [HomeController::class,'twoconfirm']);
    Route::post('two/create', [HomeController::class,'two']);
    Route::get('user/history-two',  [HomeController::class,'historyTwo'])->name('user.history-two');
    Route::get('user/history', [HomeController::class,'history'])->name('user.history');
    
    Route::get('two/htaitpait', [HtaitPaitController::class,'index']);
    Route::post('two/htaitpait/confirm', [HtaitPaitController::class,'confirm']);
    Route::post('two/htaitpait/store', [HtaitPaitController::class,'store']);


    Route::get('/three', [App\Http\Controllers\frontend\ThreeController::class,'index']);
    Route::post('/three/confirm', [App\Http\Controllers\frontend\ThreeController::class,'threeconfirm']);
    Route::post('three/create', [App\Http\Controllers\frontend\ThreeController::class,'three']);
    Route::get('user/history-three', [App\Http\Controllers\frontend\ThreeController::class,'historyThree'])->name('user.history-three');
    
    Route::get('/notification', [NotificationController::class,'index']);
});

// ------------------------------- backend --------------------------------------------------------------


Route::prefix('admin')->middleware(['auth:adminuser'])->group(function () {

    Route::get('/dashboard',[DashBoardController::class,'index'])->name('dashboard.index');

    Route::get('/', [AdminDashboardController::class,'index']);
    Route::get('/admin/datatables/ssd', [AdminDashboardController::class,'ssd']);
    Route::get('/create', [AdminDashboardController::class,'create']);
    Route::post('/store', [AdminDashboardController::class,'store']);
    Route::get('{id}/edit/', [AdminDashboardController::class,'edit']);
    Route::patch('{id}/update', [AdminDashboardController::class,'update']);
    Route::delete('/delete/{id}', [AdminDashboardController::class,'destroy']);

    Route::resource('master',MasterController::class);
    Route::get('master/datatables/ssd', [MasterController::class,'ssd']);

    Route::resource('agent',AgentController::class);
    Route::get('agent/datatables/ssd', [AgentController::class,'ssd']);

    Route::resource('users', UserController::class);
    Route::get('users/datatables/ssd', [UserController::class,'ssd']);
    Route::get('users/detail/{date}', [UserController::class,'userDetail'])->name('users.detail');

    Route::resource('two', TwoController::class);
    Route::get('two/datatables/ssd', [TwoController::class,'ssd']);
    Route::get('two-overview/am_history',[TwoController::class,'twoHistoryAM'])->name('two-overview.am_history');
    Route::get('two-overview/pm_history', [TwoController::class,'twoHistoryPM'])->name('two-overview.pm_history');
    Route::get('two-overview/am-two-kyon', [TwoController::class,'twoKyonAM'])->name('two-overview.kyon-am');
    Route::get('two-overview/pm-two-kyon', [TwoController::class,'twoKyonPM'])->name('two-overview.kyon-pm');


    Route::get('twooverview', [TwoOverviewController::class,'index']);
    Route::post('two-overview/new_amount/{date}/{twoD}', [TwoOverviewController::class,'NewAmount']);
    Route::post('two-overview/pm_new_amount/{date}/{twoD}', [TwoOverviewController::class,'pmNewAmount']);

    Route::post('two-overview/kyon_amount_am', [TwoOverviewController::class,'kyonAmountAm']);
    Route::post('two-overview/kyon_amount_pm', [TwoOverviewController::class,'kyonAmountPm']);
    

    Route::get('/two-overview/twopout/{two}/date={date}', [PoutController::class,'twoPout']);
    Route::get('/three-overview/threepout/{three}/from={from}/to={to}', [PoutController::class,'threePout']);

    Route::post('/two-pout/{user_id}', [PoutController::class,'twoBet']);
    Route::post('/three-pout/{user_id}', [PoutController::class,'threeBet']);

    Route::get('/two-pout/history', [BetHistoryController::class,'index'])->name('bet_history.index');
    Route::get('/two-pout/history-datatables-ssd', [BetHistoryController::class,'ssd']);

    Route::resource('three', ThreeController::class);
    Route::get('three/datatables/ssd', [ThreeController::class,'ssd']);
    Route::get('three-overview/history', [ThreeController::class,'threeHistory'])->name('three-overview.history');
    Route::get('three-overview/kyon', [ThreeController::class,'threeKyon'])->name('three-overview.kyon');

    // Route::resource('amountbreaks', 'BreakNumberController');
    // Route::get('amountbreaks/datatables/ssd', 'BreakNumberController@ssd');

    Route::resource('allbreakwithamount', AllBreakWithAmountController::class);
    Route::get('allbreakwithamount/datatables/ssd', [AllBreakWithAmountController::class,'ssd']);

    Route::get('/wallet',[WalletController::class,'index'])->name('wallet.index');
    Route::get('/wallet/datatables/ssd', [WalletController::class,'ssd']);

    Route::get('/wallet/add', [WalletController::class,'add']);
    Route::post('/wallet/store', [WalletController::class,'store']);

    Route::get('/wallet/substract', [WalletController::class,'substract']);
    Route::post('/wallet/remove', [WalletController::class,'remove']);

    Route::get('/wallets/history', [WalletHistoryController::class , 'index'])->name('history.index');
    Route::get('/wallets/history/datatables/ssd', [WalletHistoryController::class , 'ssd']);
    
    Route::resource('roles', RoleController::class);
    Route::get('roles/datatables/ssd', [RoleController::class,'ssd']);

    Route::resource('permissions', PermissionController::class);
    Route::get('permissions/datatables/ssd', [PermissionController::class,'ssd']);

    
    Route::post('/two/showhide', [ShowHideController::class,'TwoShowHide']);
    Route::post('/htaitpait/showhide', [ShowHideController::class,'HtaitPaitShowHide']);
    Route::post('/three/showhide', [ShowHideController::class,'ThreeShowHide']);

    Route::resource('/fake_number',FakeNumberController::class);
    Route::get('/fake_number/datatables/ssd',[FakeNumberController::class,'ssd']);

    Route::get('/real_number',[RealNumberController::class,'realNumber'])->name('real_number');
});

