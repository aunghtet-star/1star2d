<?php

namespace App\Helpers;

class ForThreePoutStatusUpdate
{
    public static function UpdateStatus($model,$user_id,$date,$three){

        $three_pout = $model::where('user_id',$user_id)->where('date',$date)->where('three',$three)->first();

        $three_pout->update([
            'status' => 'done'
        ]);

    }
}
