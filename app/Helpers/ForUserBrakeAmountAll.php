<?php

namespace App\Helpers;

use App\UserBrakeAmountAll;
use Illuminate\Support\Facades\DB;

class ForUserBrakeAmountAll
{
    public static function AllBrake($two,$amount,$total_amount_from_table,$fromModel){
         foreach ($total_amount_from_table as $user_brake_amount_all) {
             $brake_amount_from_table = $fromModel::select('amount')->where('type', '2D')->first();

             if ($brake_amount_from_table) {
                 for ($i=0;$i<count($two);$i++) {
                     if ($user_brake_amount_all->two == $two[$i]) {
                         $need =  $user_brake_amount_all->total+ $amount[$i];

                         $lo_at_amount = $brake_amount_from_table->amount - $user_brake_amount_all->total;

                         if ($need >  $brake_amount_from_table->amount) {
                             return ['two' => $two[$i],'need_amount' =>  $lo_at_amount];
                         }
                     }
                 }
             }
         }

         for ($i=0;$i<count($two);$i++) {
             $emptybreak = $fromModel::where('type', '2D')->first();

             if ($emptybreak) {
                 if ($amount[$i] > $emptybreak->amount) {
                     return ['two' => $two[$i],'need_amount' =>  $emptybreak->amount];
                 }
             }
         }
    }

    public static function AllBrakeThreeR($three,$amount,$total_amount_from_table,$fromModel){
        foreach ($total_amount_from_table as $user_brake_amount_all) {
            $brake_amount_from_table = $fromModel::select('amount')->where('type', '3D')->first();

            if ($brake_amount_from_table) {
                for ($i=0;$i<count($three);$i++) {
                    if ($user_brake_amount_all->three == $three[$i]) {
                        $need =  $user_brake_amount_all->total+ $amount;

                        $lo_at_amount = $brake_amount_from_table->amount - $user_brake_amount_all->total;

                        if ($need >  $brake_amount_from_table->amount) {
                            return ['three' => $three[$i],'need_amount' =>  $lo_at_amount];
                        }
                    }
                }
            }
        }

        for ($i=0;$i<count($three);$i++) {
            $emptybreak = $fromModel::where('type', '3D')->first();

            if ($emptybreak) {
                if ($amount > $emptybreak->amount) {
                    return ['three' => $three[$i],'need_amount' =>  $emptybreak->amount];
                }
            }
        }
    }

    public static function AllBrakeThree($three,$amount,$total_amount_from_table,$fromModel){
        foreach ($total_amount_from_table as $user_brake_amount_all) {
            $brake_amount_from_table = $fromModel::select('amount')->where('type', '3D')->first();

            if ($brake_amount_from_table) {
                for ($i=0;$i<count($three);$i++) {
                    if ($user_brake_amount_all->three == $three[$i]) {
                        $need =  $user_brake_amount_all->total+ $amount[$i];

                        $lo_at_amount = $brake_amount_from_table->amount - $user_brake_amount_all->total;

                        if ($need >  $brake_amount_from_table->amount) {
                            return ['three' => $three[$i],'need_amount' =>  $lo_at_amount];
                        }
                    }
                }
            }
        }

        for ($i=0;$i<count($three);$i++) {
            $emptybreak = $fromModel::where('type', '3D')->first();

            if ($emptybreak) {
                if ($amount[$i] > $emptybreak->amount) {
                    return ['three' => $three[$i],'need_amount' =>  $emptybreak->amount];
                }
            }
        }
    }


}
