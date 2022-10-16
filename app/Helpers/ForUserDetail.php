<?php

namespace App\Helpers;

use App\Three;
use App\Two;
use Carbon\Carbon;

class ForUserDetail
{
    public static function Total($model,$user,$date){

        //For Thai
        $am_sum = $model::where('user_id', $user->id)->where('admin_user_id', Auth()->user()->id)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'11:59:59')])->sum('amount');
        $pm_sum = $model::where('user_id', $user->id)->where('admin_user_id', Auth()->user()->id)->whereBetween('created_at', [Carbon::parse($date.' '.'12:00:00'),Carbon::parse($date.' '.'23:59:59')])->sum('amount');

        //For Dubai

        $am_11_sum = $model::where('user_id', $user->id)->where('admin_user_id', Auth()->user()->id)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'10:59:59')])->sum('amount');
        $pm_1_sum = $model::where('user_id', $user->id)->where('admin_user_id', Auth()->user()->id)->whereBetween('created_at', [Carbon::parse($date.' '.'11:00:00'),Carbon::parse($date.' '.'12:59:59')])->sum('amount');
        $pm_3_sum = $model::where('user_id', $user->id)->where('admin_user_id', Auth()->user()->id)->whereBetween('created_at', [Carbon::parse($date.' '.'13:00:00'),Carbon::parse($date.' '.'14:59:59')])->sum('amount');
        $pm_5_sum = $model::where('user_id', $user->id)->where('admin_user_id', Auth()->user()->id)->whereBetween('created_at', [Carbon::parse($date.' '.'15:00:00'),Carbon::parse($date.' '.'16:59:59')])->sum('amount');
        $pm_7_sum = $model::where('user_id', $user->id)->where('admin_user_id', Auth()->user()->id)->whereBetween('created_at', [Carbon::parse($date.' '.'17:00:00'),Carbon::parse($date.' '.'18:59:59')])->sum('amount');
        $pm_9_sum = $model::where('user_id', $user->id)->where('admin_user_id', Auth()->user()->id)->whereBetween('created_at', [Carbon::parse($date.' '.'19:00:00'),Carbon::parse($date.' '.'23:59:59')])->sum('amount');

        return ['am_sum' => $am_sum , 'pm_sum' => $pm_sum , 'am_11_sum' => $am_11_sum , 'pm_1_sum' => $pm_1_sum , 'pm_3_sum' => $pm_3_sum ,'pm_5_sum' => $pm_5_sum, 'pm_7_sum' => $pm_7_sum, 'pm_9_sum' => $pm_9_sum];
    }

    public static function TotalFromUserDashboard($model,$user,$date){

        //For Thai
        $am_sum = $model::where('user_id', $user->id)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'11:59:59')])->sum('amount');
        $pm_sum = $model::where('user_id', $user->id)->whereBetween('created_at', [Carbon::parse($date.' '.'12:00:00'),Carbon::parse($date.' '.'23:59:59')])->sum('amount');

        return ['am_sum' => $am_sum , 'pm_sum' => $pm_sum ];
    }

    public static function Digit($model,$user,$date){
        $am = $model::where('user_id', $user->id)->where('admin_user_id', Auth()->user()->id)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'11:59:59')]);
        $pm = $model::where('user_id', $user->id)->where('admin_user_id', Auth()->user()->id)->whereBetween('created_at', [Carbon::parse($date.' '.'12:00:00'),Carbon::parse($date.' '.'23:59:59')]);

        if ($date) {
            $am = $am->whereDate('date', $date);
            $pm = $pm->whereDate('date', $date);
        }

        $am = $am->get();
        $pm = $pm->get();

        return ['am' => $am ,'pm' => $pm];
    }

    public static function DigitFromUserDashboard($model,$user,$date){
        $am = $model::where('user_id', $user->id)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'11:59:59')]);
        $pm = $model::where('user_id', $user->id)->whereBetween('created_at', [Carbon::parse($date.' '.'12:00:00'),Carbon::parse($date.' '.'23:59:59')]);

        if ($date) {
            $am = $am->whereDate('date', $date);
            $pm = $pm->whereDate('date', $date);
        }

        $am = $am->get();
        $pm = $pm->get();

        return ['am' => $am ,'pm' => $pm];
    }

    public static function DubaiDigit($model,$user,$date){
        $am_11 = $model::where('user_id', $user->id)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'10:59:59')]);
        $pm_1 = $model::where('user_id', $user->id)->whereBetween('created_at', [Carbon::parse($date.' '.'11:00:00'),Carbon::parse($date.' '.'12:59:59')]);
        $pm_3 = $model::where('user_id', $user->id)->whereBetween('created_at', [Carbon::parse($date.' '.'13:00:00'),Carbon::parse($date.' '.'14:59:59')]);
        $pm_5 = $model::where('user_id', $user->id)->whereBetween('created_at', [Carbon::parse($date.' '.'15:00:00'),Carbon::parse($date.' '.'16:59:59')]);
        $pm_7 = $model::where('user_id', $user->id)->whereBetween('created_at', [Carbon::parse($date.' '.'17:00:00'),Carbon::parse($date.' '.'18:59:59')]);
        $pm_9 = $model::where('user_id', $user->id)->whereBetween('created_at', [Carbon::parse($date.' '.'19:00:00'),Carbon::parse($date.' '.'23:59:59')]);

        if ($date) {
            $am_11 = $am_11->whereDate('date', $date);
            $pm_1 = $pm_1->whereDate('date', $date);
            $pm_3 = $pm_3->whereDate('date', $date);
            $pm_5 = $pm_5->whereDate('date', $date);
            $pm_7 = $pm_7->whereDate('date', $date);
            $pm_9 = $pm_9->whereDate('date', $date);

        }

        $am_11 = $am_11->get();
        $pm_1 = $pm_1->get();
        $pm_3 = $pm_3->get();
        $pm_5 = $pm_5->get();
        $pm_7 = $pm_7->get();
        $pm_9 = $pm_9->get();

        return ['am_11' => $am_11 ,'pm_1' => $pm_1,'pm_3' => $pm_3,'pm_5'=>$pm_5,'pm_7'=>$pm_7,'pm_9'=>$pm_9];
    }
}
