<?php

use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\backend\{AdminDashboardController,
    AgentController,
    AgentDashboardController,
    AllBreakWithAmountController,
    BetHistoryController,
    BreakNumberController,
    CommisionController,
    DashBoardController,
    DubaiPoutController,
    DubaiTwoController,
    DubaiTwoKyonCleaner,
    DubaiTwoKyonController,
    DubaiTwoOverviewController,
    FakeNumberController,
    FixMoneyFromAdminController,
    MasterController,
    MasterDashboardController,
    NotificationController,
    PermissionController,
    PoutController,
    RealNumberController,
    RoleController,
    ShowHideController,
    ThreeController,
    ThreeKyonCleanerController,
    ThreePoutController,
    TwoController,
    TwoKyonCleaner,
    UserBrakeAmountAllController,
    UserController,
    UserDashboardController,
    WalletController,
    WalletHistoryController};

use App\UserBrakeAmountAll;
use App\Http\Controllers\frontend\{Dubai\DubaiHtaitPaitController,
    PasswordChangeController,
    Thai\HtaitPaitController,
    UserHistoryController};

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
    Route::get('/dubai-two', [\App\Http\Controllers\frontend\Dubai\DubaiTwoController::class,'index'])->name('frontend-dubai-two.index');
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

    Route::get('/normal-three', [\App\Http\Controllers\frontend\Thai\NormalThreeController::class,'index']);
    Route::post('/normal-three/confirm', [\App\Http\Controllers\frontend\Thai\NormalThreeController::class,'threeconfirm']);
    Route::post('normal-three/create', [\App\Http\Controllers\frontend\Thai\NormalThreeController::class,'three']);

    // User History
    Route::get('user/history', [UserHistoryController::class,'history'])->name('user.history');
    Route::get('user/dubai-history', [UserHistoryController::class,'DubaiHistory'])->name('user.dubai-history');
    Route::get('user/history-two',  [UserHistoryController::class,'historyTwo'])->name('user.history-two');
    Route::get('user/dubai-history-two',  [UserHistoryController::class,'historyOfDubaiTwo'])->name('user.history-dubai-two');

    Route::get('user/password-change',[PasswordChangeController::class,'index'])->name('password');
    Route::post('user/password-change-post',[PasswordChangeController::class,'changePassword'])->name('change-password');
    //Notification
    Route::get('/notification', [NotificationController::class,'index']);
});

// ------------------------------- backend --------------------------------------------------------------


Route::prefix('admin')->middleware(['auth:adminuser'])->group(function () {

    Route::get('/',[DashBoardController::class,'index'])->name('dashboard.index');

    //Admin User

    Route::resource('/admin-user',AdminDashboardController::class);
    Route::get('/admin-user/datatables/ssd', [AdminDashboardController::class,'ssd']);

    Route::resource('master',MasterController::class);
    Route::get('master/datatables/ssd', [MasterController::class,'ssd']);

    Route::resource('agent',AgentController::class);
    Route::get('agent/datatables/ssd', [AgentController::class,'ssd']);

    Route::resource('users', UserController::class);
    Route::get('users/datatables/ssd', [UserController::class,'ssd']);

    //User Dashboard
    Route::resource('user-dashboard', UserDashboardController::class);
    Route::get('user-dashboard/datatables/ssd', [UserDashboardController::class,'ssd']);
    Route::get('user-dashboard/{id}/add', [UserDashboardController::class,'add']);
    Route::get('user-dashboard/{id}/subtract', [UserDashboardController::class,'subtract']);
    Route::post('user-dashboard/store', [UserDashboardController::class,'store']);
    Route::post('user-dashboard/remove', [UserDashboardController::class,'remove']);

    //Master Dashboard
    Route::resource('master-dashboard', MasterDashboardController::class);
    Route::get('master-dashboard/datatables/ssd', [MasterDashboardController::class,'ssd']);
    Route::get('master-dashboard/{id}/add', [MasterDashboardController::class,'add']);
    Route::get('master-dashboard/{id}/subtract', [MasterDashboardController::class,'subtract']);
    Route::post('master-dashboard/store', [MasterDashboardController::class,'store']);
    Route::post('master-dashboard/remove', [MasterDashboardController::class,'remove']);

    //Agent Dashboard
    Route::resource('agent-dashboard', AgentDashboardController::class);
    Route::get('agent-dashboard/datatables/ssd', [AgentDashboardController::class,'ssd']);
    Route::get('agent-dashboard/{id}/add', [AgentDashboardController::class,'add']);
    Route::get('agent-dashboard/{id}/subtract', [AgentDashboardController::class,'subtract']);
    Route::post('agent-dashboard/store', [AgentDashboardController::class,'store']);
    Route::post('agent-dashboard/remove', [AgentDashboardController::class,'remove']);


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
    Route::get('/two-overview/two-pout-am/{two}/{date}', [PoutController::class,'twoPoutAm']);
    Route::get('/two-overview/two-pout-pm/{two}/{date}', [PoutController::class,'twoPoutPm']);


    //Two Bet Controller
    Route::post('/two-pout-am/{user_id}', [PoutController::class,'twoBetAm']);
    Route::post('/two-pout-pm/{user_id}', [PoutController::class,'twoBetPm']);


    Route::get('/three-overview/threepout/{three}/{from}/{to}', [ThreePoutController::class,'threePout']);
    Route::post('/three-pout/{user_id}', [ThreePoutController::class,'threeBet']);


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
    Route::get('dubai-twopout-11am/{two}/{date}', [DubaiPoutController::class,'DubaiTwoPout11Am']);
    Route::get('dubai-twopout-1pm/{two}/{date}', [DubaiPoutController::class,'DubaiTwoPout1Pm']);
    Route::get('dubai-twopout-3pm/{two}/{date}', [DubaiPoutController::class,'DubaiTwoPout3Pm']);
    Route::get('dubai-twopout-5pm/{two}/{date}', [DubaiPoutController::class,'DubaiTwoPout5Pm']);
    Route::get('dubai-twopout-7pm/{two}/{date}', [DubaiPoutController::class,'DubaiTwoPout7Pm']);
    Route::get('dubai-twopout-9pm/{two}/{date}', [DubaiPoutController::class,'DubaiTwoPout9Pm']);

    //Dubai Two Bet Controller
    Route::post('/dubai-twopout-11am/{user_id}', [DubaiPoutController::class,'DubaiTwoBet11Am']);
    Route::post('/dubai-twopout-1pm/{user_id}', [DubaiPoutController::class,'DubaiTwoBet1Pm']);
    Route::post('/dubai-twopout-3pm/{user_id}', [DubaiPoutController::class,'DubaiTwoBet3Pm']);
    Route::post('/dubai-twopout-5pm/{user_id}', [DubaiPoutController::class,'DubaiTwoBet5Pm']);
    Route::post('/dubai-twopout-7pm/{user_id}', [DubaiPoutController::class,'DubaiTwoBet7Pm']);
    Route::post('/dubai-twopout-9pm/{user_id}', [DubaiPoutController::class,'DubaiTwoBet9Pm']);

    //Dubai Two Kyon Cleaner
    Route::get('dubai-twooverview', [DubaiTwoKyonCleaner::class,'index']);

    Route::post('kyon_amount_11am', [DubaiTwoKyonCleaner::class,'kyonAmount_11am']);
    Route::post('kyon_amount_1pm', [DubaiTwoKyonCleaner::class,'kyonAmount_1pm']);
    Route::post('kyon_amount_3pm', [DubaiTwoKyonCleaner::class,'kyonAmount_3pm']);
    Route::post('kyon_amount_5pm', [DubaiTwoKyonCleaner::class,'kyonAmount_5pm']);
    Route::post('kyon_amount_7pm', [DubaiTwoKyonCleaner::class,'kyonAmount_7pm']);
    Route::post('kyon_amount_9pm', [DubaiTwoKyonCleaner::class,'kyonAmount_9pm']);

    //Dubai new amount
    Route::post('dubai-two-overview-11am/new_amount/{date}/{twoD}', [DubaiTwoKyonCleaner::class,'NewAmount_11am']);
    Route::post('dubai-two-overview-1pm/new_amount/{date}/{twoD}', [DubaiTwoKyonCleaner::class,'NewAmount_1pm']);
    Route::post('dubai-two-overview-3pm/new_amount/{date}/{twoD}', [DubaiTwoKyonCleaner::class,'NewAmount_3pm']);
    Route::post('dubai-two-overview-5pm/new_amount/{date}/{twoD}', [DubaiTwoKyonCleaner::class,'NewAmount_5pm']);
    Route::post('dubai-two-overview-7pm/new_amount/{date}/{twoD}', [DubaiTwoKyonCleaner::class,'NewAmount_7pm']);
    Route::post('dubai-two-overview-9pm/new_amount/{date}/{twoD}', [DubaiTwoKyonCleaner::class,'NewAmount_9pm']);

    //Commission Controller

    Route::get('commission', [CommisionController::class,'index'])->name('commissions.index');

    //Route::get('two-am/commission/{date}/{user-id}',  );

    //Bet History Controller
    Route::get('/two-pout/history', [BetHistoryController::class,'index'])->name('bet_history.index');
    Route::get('/two-pout/history-datatables-ssd', [BetHistoryController::class,'ssd']);

    //Fix money from admin History Controller
    Route::get('/fix-money-from-admin', [FixMoneyFromAdminController::class,'index'])->name('fix-money-from-admin.index');
    Route::get('/fix-money-from-admin/datatables-ssd', [FixMoneyFromAdminController::class,'ssd']);

    //Three Controller
    Route::resource('three', ThreeController::class)->only('index');
    Route::get('three/datatables/ssd', [ThreeController::class,'ssd']);
    Route::get('three-overview/history', [ThreeController::class,'threeHistory'])->name('three-overview.history');
    Route::get('three-overview/kyon', [ThreeController::class,'threeKyon'])->name('three-overview.kyon');

    //Three New Amount
    Route::post('three-overview/new_amount/{date}/{threeD}', [ThreeKyonCleanerController::class,'NewAmount']);
    Route::post('three/kyon_amount', [ThreeKyonCleanerController::class,'KyonAmount']);

    //Only Amount Brake

     Route::resource('amountbreaks', BreakNumberController::class);
     Route::get('amountbreaks/datatables/ssd', [BreakNumberController::class,'ssd']);

    //User Brake Amount All
    Route::resource('user_brake_amount_all', UserBrakeAmountAllController::class);
    Route::get('user_brake_amount_all/datatables/ssd', [UserBrakeAmountAllController::class,'ssd']);


     //All Amount Brake
    Route::resource('allbreakwithamount', AllBreakWithAmountController::class);
    Route::get('allbreakwithamount/datatables/ssd', [AllBreakWithAmountController::class,'ssd']);

    // WalletRequest Controller
    Route::get('/wallet',[WalletController::class,'index'])->name('wallet.index');
    Route::get('/wallet/datatables/ssd', [WalletController::class,'ssd']);

    Route::get('/wallet/add', [WalletController::class,'add']);
    Route::post('/wallet/store', [WalletController::class,'store']);

    Route::get('/wallet/substract', [WalletController::class,'substract']);
    Route::post('/wallet/removed', [WalletController::class,'remove']);

    //WalletRequest History
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

