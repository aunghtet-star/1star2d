<?php

namespace App\Helpers;

use App\TwoOverview;
use App\TwoOverviewPM;
use Illuminate\Support\Facades\Auth;

class ForTwoOverview
{
    public static function Overview($data,$date,$model){
        foreach($data as $two){
            $exist = $model::where('two',$two->two)->where('date',$date)->exists();
            if($exist){
                $two_overviews = $model::where('two',$two->two);
                $two_overviews = $two_overviews->update([
                    'amount' => $two->total
                ]);
            }else{
                $two_overviews = new $model();
                $two_overviews->admin_user_id = Auth::guard('adminuser')->user()->id;
                $two_overviews->two =  $two->two;
                $two_overviews->amount = $two->total;
                $two_overviews->date = $date;
                $two_overviews->save();
            }
        }
    }

    public static function OverviewTotal($model,$date){
        $amount_total = $model::select('amount')->whereDate('date', $date)->sum('amount');
        $new_amount_total = $model::select('new_amount')->whereDate('date', $date)->sum('new_amount');
        $kyon_amount_total = $model::select('kyon_amount')->whereDate('date', $date)->sum('kyon_amount');

        return ['amount' => $amount_total , 'new_amount' => $new_amount_total, 'kyon_amount' => $kyon_amount_total];
    }
}
