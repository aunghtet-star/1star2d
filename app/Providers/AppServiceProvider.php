<?php

namespace App\Providers;

use App\ShowHide;
use App\Http\Controllers;
use Illuminate\Database\Events\MigrationsEnded;
use Illuminate\Database\Events\MigrationsStarted;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Schema::defaultStringLength(100);

//        Event::listen(MigrationsStarted::class, function (){
//
//                DB::statement('SET SESSION sql_require_primary_key=0');
//
//        });
//
//        Event::listen(MigrationsEnded::class, function (){
//
//                DB::statement('SET SESSION sql_require_primary_key=1');
//
//        });

        Paginator::useBootstrap();


        View::composer('*', function ($view) {
            $unread_noti = 0;
            if (Auth::guard('web')->check()) {
                $unread_noti =  auth::guard('web')->user()->unreadNotifications()->count();
            }
            $view->with('unread_noti', $unread_noti);
        });

        View::composer('*', function ($view) {
            if (Auth::guard('adminuser')->check()) {
                $twoform = ShowHide::where('name', 'twoform')->where('admin_user_id', Auth::guard('adminuser')->user()->id)->first();
                $htaitpaitform = ShowHide::where('name', 'htaitpaitform')->where('admin_user_id', Auth::guard('adminuser')->user()->id)->first();
                $threeform = ShowHide::where('name', 'threeform')->where('admin_user_id', Auth::guard('adminuser')->user()->id)->first();
                $dubai_twoform = ShowHide::where('name', 'dubai_twoform')->where('admin_user_id', Auth::guard('adminuser')->user()->id)->first();
                $dubai_htaitpaitform = ShowHide::where('name', 'dubai_htaitpaitform')->where('admin_user_id', Auth::guard('adminuser')->user()->id)->first();

                $view->with(['twoform'=> $twoform,'htaitpaitform'=>$htaitpaitform,'threeform'=>$threeform,'dubai_twoform'=>$dubai_twoform,'dubai_htaitpaitform'=>$dubai_htaitpaitform]);
            }
        });
    }
}
