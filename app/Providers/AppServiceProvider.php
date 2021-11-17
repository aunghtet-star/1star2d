<?php

namespace App\Providers;

use App\ShowHide;
use App\Http\Controllers;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
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
                $view->with(['twoform'=> $twoform,'htaitpaitform'=>$htaitpaitform,'threeform'=>$threeform]);
            }
        });
    }
}
