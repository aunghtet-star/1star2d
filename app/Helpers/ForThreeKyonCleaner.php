<?php

namespace App\Helpers;

use App\AllBrakeWithAmount;

class ForThreeKyonCleaner
{
    public static function newAmount($model,$new_amount,$three_d,$date){

        $three_over = $model::where('three',$three_d)->where('date',$date);
        $three_over->increment('new_amount',$new_amount);

        return 'success';
    }

    public static function kyonAmount($overviewModel,$kyonModel,$date){
        $three_brake = AllBrakeWithAmount::where('type','3D')->first();

        $three_kyons = $kyonModel::where('date',$date)->get();

        foreach($three_kyons as $three_kyon){
            $three_overview = $overviewModel::where('three',$three_kyon->three)->where('date',$date)->first();

            $three_kyon_each_value = $kyonModel::where('three',$three_kyon->three)->where('date',$date)->first();
            $if_three_kyon_exist_in_overview = $overviewModel::where('three',$three_kyon->three)->where('date',$date)->exists();

            if($if_three_kyon_exist_in_overview){

                if (($three_overview->amount- $three_overview->new_amount - $three_overview->kyon_amount)> ($three_brake ? $three_brake->amount : 99999999999999999999)) {
                    $three_overview->update([
                        'kyon_amount' => $three_kyon->amount,
                        'new_amount' => 0
                    ]);


                    $three_kyon_each_value->update([
                        'kyon_amount' => $three_kyon->amount,
                        'new_amount' => 0
                    ]);
                }
            }
        }

        return 'success';
    }
}
