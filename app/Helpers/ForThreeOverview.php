<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class ForThreeOverview
{
    public static function Overview($data,$date,$model){

        $data->chunk(100,function ($ts) use ($date,$model){
            foreach($ts as $three){
                $exist = $model::select('three','amount')->where('three',$three->three)->where('amount',$three->total)->where('date',$date)->exists();
                if(!$exist){
                    $three_overviews = $model::updateOrCreate(
                            [
                                'three' => $three->three,
                                'date' => $date

                            ],
                            [
                                'admin_user_id' => Auth::guard('adminuser')->user()->id,
                                'three' => $three->three,
                                'amount' => $three->total,
                                'date' => $date
                            ]);
                }
            }
        });

    }

    public static function OverviewTotal($model,$date){
        $amount_total = $model::select('amount')->whereDate('date', $date)->sum('amount');
        $new_amount_total = $model::select('new_amount')->whereDate('date', $date)->sum('new_amount');
        $kyon_amount_total = $model::select('kyon_amount')->whereDate('date', $date)->sum('kyon_amount');

        return ['amount' => $amount_total , 'new_amount' => $new_amount_total, 'kyon_amount' => $kyon_amount_total];
    }
}
