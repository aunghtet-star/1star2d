<?php

namespace App\Helpers;

use App\AllBrakeWithAmount;
use Illuminate\Support\Facades\Auth;

class ForTwoKyon
{
    public static function Kyon($two_overviews,$date,$model){

        $two_brake = AllBrakeWithAmount::select('amount')->where('type', '2D')->first();

        foreach($two_overviews as $two_overview) {
            //$two_kyon_am = ($two_overview->amount - $two_overview->new_amount) - ($two_brake ? $two_brake->amount : 0);

            $exist = $model::where('two', $two_overview->two)->where('date', $date)->exists();
            if ($exist) {
                $two_kyons = $model::where('two', $two_overview->two);


                $two_kyons->update([
                    'amount' => $two_overview->amount > ($two_brake ? $two_brake->amount : 99999999999999999999999) ? ($two_overview->amount - ($two_brake ? $two_brake->amount : 0)) : 0,
                    'new_amount' => $two_overview->new_amount
                ]);



            } else {
                $two_kyons = new $model();
                $two_kyons->admin_user_id = Auth::guard('adminuser')->user()->id;
                $two_kyons->two = $two_overview->two;
                $two_kyons->new_amount = $two_overview->new_amount;
                $two_kyons->amount = $two_overview->amount > ($two_brake ? $two_brake->amount : 99999999999999999999999) ? ($two_overview->amount - ($two_brake ? $two_brake->amount : 0)) : 0;
                $two_kyons->date = $date;
                $two_kyons->save();
            }
        }
    }
}
