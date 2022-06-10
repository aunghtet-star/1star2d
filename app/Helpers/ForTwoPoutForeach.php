<?php

namespace App\Helpers;

use App\TwoPoutAm;
use Illuminate\Support\Facades\Auth;

class ForTwoPoutForeach
{
    public static function UpdateOrCreate($model,$data,$date,$two){
        foreach ($data as $twopout){
            $model::updateOrCreate([
                'user_id' => $twopout->user_id,
                'date' => $date,
                'two' =>  $two
            ],[
                'admin_user_id' => Auth::guard('adminuser')->user()->user_id,
                'user_id' => $twopout->user_id,
                'amount' => $twopout->total,
                'two' =>  $two,
                'date' => $date
            ]);
        }
    }
}
