<?php

namespace App\Helpers;

use App\AllBrakeWithAmount;
use Illuminate\Support\Facades\Auth;

class ForThreeKyon
{
    public static function Kyon($three_overviews,$date,$model){

        $three_brake = AllBrakeWithAmount::select('amount')->where('type', '3D')->first();

        foreach($three_overviews as $three_overview) {
            //$three_kyon_am = ($three_overview->amount - $three_overview->new_amount) - ($three_brake ? $three_brake->amount : 0);

            $exist = $model::where('three', $three_overview->three)->where('date', $date)->exists();
            if ($exist) {
                $three_kyons = $model::where('three', $three_overview->three);


                $three_kyons->update([
                    'amount' => $three_overview->amount > ($three_brake ? $three_brake->amount : 99999999999999999999999) ? ($three_overview->amount - ($three_brake ? $three_brake->amount : 0)) : 0,
                    'new_amount' => $three_overview->new_amount
                ]);


            } else {
                $three_kyons = new $model();
                $three_kyons->admin_user_id = Auth::guard('adminuser')->user()->id;
                $three_kyons->three = $three_overview->three;
                $three_kyons->new_amount = $three_overview->new_amount;
                $three_kyons->amount = $three_overview->amount > ($three_brake ? $three_brake->amount : 99999999999999999999999) ? ($three_overview->amount - ($three_brake ? $three_brake->amount : 0)) : 0;
                $three_kyons->date = $date;
                $three_kyons->save();
            }
        }
    }
}
