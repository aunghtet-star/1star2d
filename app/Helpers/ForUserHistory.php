<?php

namespace App\Helpers;

use App\DubaiTwo;
use App\Three;
use App\Two;
use Carbon\Carbon;

class ForUserHistory
{
    public static function Two($date,$StartTime,$EndTime){
        $two_totals = Two::where('user_id', Auth()->user()->id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.$StartTime),Carbon::parse($date.' '.$EndTime)])->sum('amount');
        $two_users = Two::where('user_id', Auth()->user()->id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.$StartTime),Carbon::parse($date.' '.$EndTime)])->get();

        return ['two_totals' => $two_totals , 'two_users' => $two_users];
    }

    public static function DubaiTwo($date,$StartTime,$EndTime){
        $dubai_two_totals = DubaiTwo::where('user_id', Auth()->user()->id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.$StartTime),Carbon::parse($date.' '.$EndTime)])->sum('amount');
        $dubai_two_users = DubaiTwo::where('user_id', Auth()->user()->id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.$StartTime),Carbon::parse($date.' '.$EndTime)])->get();

        return ['dubai_two_totals' => $dubai_two_totals , 'dubai_two_users' => $dubai_two_users];
    }

    public static function Three($date,$StartTime,$EndTime){
        $three_totals = Three::where('user_id', Auth()->user()->id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.$StartTime),Carbon::parse($date.' '.$EndTime)])->sum('amount');
        $three_users = Three::where('user_id', Auth()->user()->id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.$StartTime),Carbon::parse($date.' '.$EndTime)])->get();

        return ['three_totals' => $three_totals , 'three_users' => $three_users];
    }
}
