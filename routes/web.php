<?php

use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\backend\
{
    AdminDashboardController,
    AgentController,
    AllBreakWithAmountController,
    BetHistoryController,
    BreakNumberController,
    DashBoardController,
    DubaiPoutController,
    DubaiTwoController,
    DubaiTwoKyonCleaner,
    DubaiTwoKyonController,
    DubaiTwoOverviewController,
    FakeNumberController,
    MasterController,
    NotificationController,
    PermissionController,
    PoutController,
    RealNumberController,
    RoleController,
    ShowHideController,
    ThreeController,
    TwoController,
    TwoKyonCleaner,
    UserController,
    WalletController,
    WalletHistoryController
};

use App\Http\Controllers\frontend\
{
    Dubai\DubaiHtaitPaitController,
    Thai\HtaitPaitController,
    UserHistoryController
};

use App\Http\Controllers\HomeController;
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

// ------------------------------- Auth --------------------------------------------------------------

Auth::routes(['register' => false]);


Route::get('admin/login', [AdminLoginController::class,'showLoginForm']);
Route::post('admin/login', [AdminLoginController::class,'login'])->name('admin.login');
Route::post('admin/logout', [AdminLoginController::class,'logout'])->name('admin.logout');

// ------------------------------- frontend --------------------------------------------------------------

Route::middleware('auth:web')->group(function () {
    Route::get('/', [HomeController::class,'home'])->name('home');

    //Thai Two
    Route::get('/two', [HomeController::class,'index'])->name('two.index.blade');
    Route::post('/two/confirm', [HomeController::class,'twoconfirm']);
    Route::post('two/create', [HomeController::class,'two']);

    //Thai 2D HtaitPait
    Route::get('two/htaitpait', [HtaitPaitController::class,'index']);
    Route::post('two/htaitpait/confirm', [HtaitPaitController::class,'confirm']);
    Route::post('two/htaitpait/store', [HtaitPaitController::class,'store']);

    //Dubai Two
    Route::get('/dubai-two', [\App\Http\Controllers\frontend\Dubai\DubaiTwoController::class,'index'])->name('dubai-two.index');
    Route::post('/dubai-two/confirm', [\App\Http\Controllers\frontend\Dubai\DubaiTwoController::class,'twoconfirm']);
    Route::post('dubai-two/create', [\App\Http\Controllers\frontend\Dubai\DubaiTwoController::class,'two']);

    //Dubai Two HtaitPait
    Route::get('dubai-two/htaitpait', [DubaiHtaitPaitController::class,'index']);
    Route::post('dubai-two/htaitpait/confirm', [DubaiHtaitPaitController::class,'confirm']);
    Route::post('dubai-two/htaitpait/store', [DubaiHtaitPaitController::class,'store']);

    //Thai Three D
    Route::get('/three', [\App\Http\Controllers\frontend\Thai\ThreeController::class,'index']);
    Route::post('/three/confirm', [\App\Http\Controllers\frontend\Thai\ThreeController::class,'threeconfirm']);
    Route::post('three/create', [\App\Http\Controllers\frontend\Thai\ThreeController::class,'three']);

    // User History
    Route::get('user/history', [UserHistoryController::class,'history'])->name('user.history');
    Route::get('user/dubai-history', [UserHistoryController::class,'DubaiHistory'])->name('user.dubai-history');
    Route::get('user/history-two',  [UserHistoryController::class,'historyTwo'])->name('user.history-two');
    Route::get('user/dubai-history-two',  [UserHistoryController::class,'historyOfDubaiTwo'])->name('user.history-dubai-two');

    //Notification
    Route::get('/notification', [NotificationController::class,'index']);
});

// ------------------------------- backend --------------------------------------------------------------


Route::prefix('admin')->middleware(['auth:adminuser'])->group(function () {

    Route::get('/',[DashBoardController::class,'index'])->name('dashboard.index');

    //Admin User

    Route::resource('/admin-user',AdminDashboardController::class);
    Route::get('/admin-user/datatables/ssd', [AdminDashboardController::class,'ssd']);

//    Route::get('/', [AdminDashboardController::class,'index']);
//    Route::get('/create', [AdminDashboardController::class,'create']);
//    Route::post('/store', [AdminDashboardController::class,'store']);
//    Route::get('{id}/edit/', [AdminDashboardController::class,'edit']);
//    Route::patch('{id}/update', [AdminDashboardController::class,'update']);
//    Route::delete('/delete/{id}', [AdminDashboardController::class,'destroy']);

    Route::resource('master',MasterController::class);
    Route::get('master/datatables/ssd', [MasterController::class,'ssd']);

    Route::resource('agent',AgentController::class);
    Route::get('agent/datatables/ssd', [AgentController::class,'ssd']);

    Route::resource('users', UserController::class);
    Route::get('users/datatables/ssd', [UserController::class,'ssd']);
    Route::get('users/detail/{date}', [UserController::class,'userDetail'])->name('users.detail');


    // Two Controller
    Route::resource('two', TwoController::class)->only('index');
    Route::get('two/datatables/ssd', [TwoController::class,'ssd']);

    // Two Overview Controller
    Route::get('two-overview/am_history',[TwoController::class,'twoHistoryAM'])->name('two-overview.am_history');
    Route::get('two-overview/pm_history', [TwoController::class,'twoHistoryPM'])->name('two-overview.pm_history');

    // Two Kyon Controller
    Route::get('two-overview/am-two-kyon', [TwoController::class,'twoKyonAM'])->name('two-overview.kyon-am');
    Route::get('two-overview/pm-two-kyon', [TwoController::class,'twoKyonPM'])->name('two-overview.kyon-pm');

    //Two Pout Controller
    Route::get('/two-overview/twopout/{two}/date={date}', [PoutController::class,'twoPout']);
    Route::get('/three-overview/threepout/{three}/from={from}/to={to}', [PoutController::class,'threePout']);

    //Two Bet Controller
    Route::post('/two-pout/{user_id}', [PoutController::class,'twoBet']);
    Route::post('/three-pout/{user_id}', [PoutController::class,'threeBet']);


    //Two Kyon Cleaner
    Route::get('twooverview', [TwoKyonCleaner::class,'index']);
    Route::post('two-overview/kyon_amount_am', [TwoKyonCleaner::class,'kyonAmountAm']);
    Route::post('two-overview/kyon_amount_pm', [TwoKyonCleaner::class,'kyonAmountPm']);

    //new amount
    Route::post('two-overview/new_amount/{date}/{twoD}', [TwoKyonCleaner::class,'NewAmount']);
    Route::post('two-overview/pm_new_amount/{date}/{twoD}', [TwoKyonCleaner::class,'pmNewAmount']);


    //Dubai Two Controller
    Route::resource('dubai-two', DubaiTwoController::class)->only('index');
    Route::get('dubai-two/datatables/ssd', [DubaiTwoController::class,'ssd']);

    // Dubai Two Overview Controller
    Route::get('dubai-two-overview/11am_overview',[DubaiTwoOverviewController::class,'twoOverview_11am'])->name('dubai-two-overview.11am_overview');
    Route::get('dubai-two-overview/1pm_overview', [DubaiTwoOverviewController::class,'twoOverview_1pm'])->name('dubai-two-overview.1pm_overview');
    Route::get('dubai-two-overview/3pm_overview', [DubaiTwoOverviewController::class,'twoOverview_3pm'])->name('dubai-two-overview.3pm_overview');
    Route::get('dubai-two-overview/5pm_overview', [DubaiTwoOverviewController::class,'twoOverview_5pm'])->name('dubai-two-overview.5pm_overview');
    Route::get('dubai-two-overview/7pm_overview', [DubaiTwoOverviewController::class,'twoOverview_7pm'])->name('dubai-two-overview.7pm_overview');
    Route::get('dubai-two-overview/9pm_overview', [DubaiTwoOverviewController::class,'twoOverview_9pm'])->name('dubai-two-overview.9pm_overview');

    // Dubai Two Kyon Controller
    Route::get('dubai-two-kyon/11am-two-kyon', [DubaiTwoKyonController::class,'twoKyon_11am'])->name('dubai-two-kyon.11am');
    Route::get('dubai-two-kyon/1pm-two-kyon', [DubaiTwoKyonController::class,'twoKyon_1pm'])->name('dubai-two-kyon.1pm');
    Route::get('dubai-two-kyon/3pm-two-kyon', [DubaiTwoKyonController::class,'twoKyon_3pm'])->name('dubai-two-kyon.3pm');
    Route::get('dubai-two-kyon/5pm-two-kyon', [DubaiTwoKyonController::class,'twoKyon_5pm'])->name('dubai-two-kyon.5pm');
    Route::get('dubai-two-kyon/7pm-two-kyon', [DubaiTwoKyonController::class,'twoKyon_7pm'])->name('dubai-two-kyon.7pm');
    Route::get('dubai-two-kyon/9pm-two-kyon', [DubaiTwoKyonController::class,'twoKyon_9pm'])->name('dubai-two-kyon.9pm');

    //Dubai Pout Controller
    Route::get('/dubai-two-overview/twopout/{two}/date={date}', [DubaiPoutController::class,'twoPout']);

    //Dubai Two Bet Controller
    Route::post('/dubai-two-pout/{user_id}', [DubaiPoutController::class,'twoBet']);

    //Dubai Two Kyon Cleaner
    Route::get('dubai-twooverview', [DubaiTwoKyonCleaner::class,'index']);

    Route::post('dubai-two-overview/kyon_amount_11am', [DubaiTwoKyonCleaner::class,'kyonAmount_11am']);
    Route::post('dubai-two-overview/kyon_amount_1pm', [DubaiTwoKyonCleaner::class,'kyonAmount_1pm']);
    Route::post('dubai-two-overview/kyon_amount_3pm', [DubaiTwoKyonCleaner::class,'kyonAmount_3pm']);
    Route::post('dubai-two-overview/kyon_amount_5pm', [DubaiTwoKyonCleaner::class,'kyonAmount_5pm']);
    Route::post('dubai-two-overview/kyon_amount_7pm', [DubaiTwoKyonCleaner::class,'kyonAmount_7pm']);
    Route::post('dubai-two-overview/kyon_amount_9pm', [DubaiTwoKyonCleaner::class,'kyonAmount_9pm']);

    //Dubai new amount
    Route::post('dubai-two-overview-11am/new_amount/{date}/{twoD}', [DubaiTwoKyonCleaner::class,'NewAmount_11am']);
    Route::post('dubai-two-overview-1pm/new_amount/{date}/{twoD}', [DubaiTwoKyonCleaner::class,'NewAmount_1pm']);
    Route::post('dubai-two-overview-3pm/new_amount/{date}/{twoD}', [DubaiTwoKyonCleaner::class,'NewAmount_3pm']);
    Route::post('dubai-two-overview-5pm/new_amount/{date}/{twoD}', [DubaiTwoKyonCleaner::class,'NewAmount_5pm']);
    Route::post('dubai-two-overview-7pm/new_amount/{date}/{twoD}', [DubaiTwoKyonCleaner::class,'NewAmount_7pm']);
    Route::post('dubai-two-overview-9pm/new_amount/{date}/{twoD}', [DubaiTwoKyonCleaner::class,'NewAmount_9pm']);


    //Bet History Controller
    Route::get('/two-pout/history', [BetHistoryController::class,'index'])->name('bet_history.index');
    Route::get('/two-pout/history-datatables-ssd', [BetHistoryController::class,'ssd']);

    //Three Controller
    Route::resource('three', ThreeController::class)->only('index');
    Route::get('three/datatables/ssd', [ThreeController::class,'ssd']);
    Route::get('three-overview/history', [ThreeController::class,'threeHistory'])->name('three-overview.history');
    Route::get('three-overview/kyon', [ThreeController::class,'threeKyon'])->name('three-overview.kyon');


    //Only Amount Brake

     Route::resource('amountbreaks', BreakNumberController::class);
     Route::get('amountbreaks/datatables/ssd', [BreakNumberController::class,'ssd']);

     //All Amount Brake
    Route::resource('allbreakwithamount', AllBreakWithAmountController::class);
    Route::get('allbreakwithamount/datatables/ssd', [AllBreakWithAmountController::class,'ssd']);

    // Wallet Controller
    Route::get('/wallet',[WalletController::class,'index'])->name('wallet.index');
    Route::get('/wallet/datatables/ssd', [WalletController::class,'ssd']);

    Route::get('/wallet/add', [WalletController::class,'add']);
    Route::post('/wallet/store', [WalletController::class,'store']);

    Route::get('/wallet/substract', [WalletController::class,'substract']);
    Route::post('/wallet/remove', [WalletController::class,'remove']);

    //Wallet History
    Route::get('/wallets/history', [WalletHistoryController::class , 'index'])->name('history.index');
    Route::get('/wallets/history/datatables/ssd', [WalletHistoryController::class , 'ssd']);


    //Role and permission
    Route::resource('roles', RoleController::class);
    Route::get('roles/datatables/ssd', [RoleController::class,'ssd']);

    Route::resource('permissions', PermissionController::class);
    Route::get('permissions/datatables/ssd', [PermissionController::class,'ssd']);

    // Show Hide Controller
    Route::post('/two/showhide', [ShowHideController::class,'TwoShowHide']);
    Route::post('/htaitpait/showhide', [ShowHideController::class,'HtaitPaitShowHide']);
    Route::post('/three/showhide', [ShowHideController::class,'ThreeShowHide']);
    Route::post('/dubai-two/showhide', [ShowHideController::class,'DubaiTwoShowHide']);
    Route::post('/dubai-htaitpait/showhide', [ShowHideController::class,'DubaiHtaitPaitShowHide']);

    //Fake Number
    Route::resource('/fake_number',FakeNumberController::class);
    Route::get('/fake_number/datatables/ssd',[FakeNumberController::class,'ssd']);

    //Real Number
    Route::get('/real_number',[RealNumberController::class,'realNumber'])->name('real_number');
});

