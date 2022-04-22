<?php

namespace App\Helpers;

use App\TwoOverview;
use Illuminate\Support\Facades\Auth;

class ForRealNumber
{
    public static function AmountTotal($model,$date){
        $amount_total = $model::select('amount')->where('admin_user_id', Auth::guard('adminuser')->user()->id)->whereDate('date', $date)->sum('amount');
        $new_amount_total = $model::select('new_amount')->where('admin_user_id', Auth::guard('adminuser')->user()->id)->whereDate('date', $date)->sum('new_amount');
        $kyon_amount_total = $model::select('kyon_amount')->where('admin_user_id', Auth::guard('adminuser')->user()->id)->whereDate('date', $date)->sum('kyon_amount');

        return ['amount_total' => $amount_total,'new_amount_total' => $new_amount_total,'kyon_amount_total' => $kyon_amount_total];
    }
}
