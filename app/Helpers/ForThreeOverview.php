<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class ForThreeOverview
{
    public static function Overview($data,$date,$model){
        foreach($data as $three){
            $exist = $model::where('three',$three->three)->where('date',$date)->exists();
            if($exist){
                $three_overviews = $model::where('three',$three->three);
                $three_overviews = $three_overviews->update([
                    'amount' => $three->total
                ]);
            }else{
                $three_overviews = new $model();
                $three_overviews->admin_user_id = Auth::guard('adminuser')->user()->id;
                $three_overviews->three =  $three->three;
                $three_overviews->amount = $three->total;
                $three_overviews->date = $date;
                $three_overviews->save();
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
