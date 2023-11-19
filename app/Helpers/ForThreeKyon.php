<?php

namespace App\Helpers;

use App\AllBrakeWithAmount;
use Illuminate\Support\Facades\Auth;

class ForThreeKyon
{
    public static function Kyon($three_overviews,$date,$model){


        $three_brake = AllBrakeWithAmount::select('amount')->where('type', '3D')->first();

        $count = $model::select('amount','date')->where('amount',0)->where('date', $date)->count();

        $three_overviews->chunk(100,function ($tows)  use($model,$date,$three_brake,$count){
            foreach($tows as $three_overview) {

                $three_kyon_am = ($three_overview->amount - $three_overview->new_amount) - ($three_brake ? $three_brake->amount : 0);

                $exist = $model::where('three', $three_overview->three)->where('new_amount',$three_overview->new_amount)
                    ->where('date', $date)->updateOrCreate(
                        [
                            'three' => $three_overview->three,
                            'date' => $date
                        ],
                        [
                            'admin_user_id' => Auth::guard('adminuser')->user()->id,
                            'three' =>   $three_overview->three,
                            'amount' => $three_overview->amount > ($three_brake ? $three_brake->amount : 99999999999999999999999) ? ($three_overview->amount - ($three_brake ? $three_brake->amount : 0)) : 0,
                            'new_amount' => $three_overview->new_amount,
                            'date' => $date,
                        ]);

               // dd($three_overview->new_amount);



            }



        });



    }
}
