<?php

namespace App\Helpers;

use App\AllBrakeWithAmount;
use App\DubaiTwoKyon11am;
use App\DubaiTwoOverview11am;

class ForTwoKyonCleaner
{
    public static function newAmount($model,$new_amount,$two_d,$date){

        $two_over = $model::where('two',$two_d)->where('date',$date);
        $two_over->increment('new_amount',$new_amount);

        return 'success';
    }

    public static function kyonAmount($overviewModel,$kyonModel,$date){
        $two_brake = AllBrakeWithAmount::where('type','2D')->first();

        $two_kyons = $kyonModel::where('date',$date)->get();

        foreach($two_kyons as $two_kyon){
            $two_overview = $overviewModel::where('two',$two_kyon->two)->where('date',$date)->first();

            $two_kyon_each_value = $kyonModel::where('two',$two_kyon->two)->where('date',$date)->first();
            $if_two_kyon_exist_in_overview = $overviewModel::where('two',$two_kyon->two)->where('date',$date)->exists();

            if($if_two_kyon_exist_in_overview){

                if (($two_overview->amount- $two_overview->new_amount - $two_overview->kyon_amount)> ($two_brake ? $two_brake->amount : 99999999999999999999)) {
                    $two_overview->update([
                        'kyon_amount' => $two_kyon->amount,
                        'new_amount' => 0
                    ]);


                    $two_kyon_each_value->update([
                        'kyon_amount' => $two_kyon->amount,
                        'new_amount' => 0
                    ]);
                }
            }
        }

        return 'success';
    }
}
