<?php

namespace App\Helpers;

use App\TwoPoutAm;

class ForTwoPoutStatusUpdate
{
    public static function UpdateStatus($model,$user_id,$date,$two){

        $two_pout = $model::where('user_id',$user_id)->where('date',$date)->where('two',$two)->first();

        $two_pout->update([
            'status' => 'done'
        ]);

    }
}
