<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class ForThreePoutForeach
{
    public static function UpdateOrCreate($model,$data,$date,$three){
        foreach ($data as $three_pout){
            $model::updateOrCreate([
                'user_id' => $three_pout->user_id,
                'date' => $date,
                'three' =>  $three
            ],[
                'admin_user_id' => Auth::guard('adminuser')->user()->user_id,
                'user_id' => $three_pout->user_id,
                'amount' => $three_pout->total,
                'three' =>  $three,
                'date' => $date
            ]);
        }
    }
}
