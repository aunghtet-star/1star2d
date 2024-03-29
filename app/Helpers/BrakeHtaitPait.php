<?php
namespace App\Helpers;

use App\DubaiTwo;
use App\Two;
use App\Amountbreak;

use App\UserBrakeAmountAll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrakeHtaitPait
{
    public static function AllBrake($two, $amount)
    {
        //$user_brake_amount_alls = Two::select('two', DB::raw('SUM(amount) as total'))->where('admin_user_id', Auth()->user()->admin_user_id)->whereDate('date', now()->format('Y-m-d'))->groupBy('two')->get();

        $user_brake_amount_all_am = Two::select('two', DB::raw('SUM(amount) as total'))->whereBetween('created_at', [now()->format('Y-m-d'). ' 00:00:00',now()->format('Y-m-d'). ' 12:00:00'])->groupBy('two')->get();
        $user_brake_amount_all_pm = Two::select('two', DB::raw('SUM(amount) as total'))->whereBetween('created_at', [now()->format('Y-m-d'). ' 12:00:00',now()->format('Y-m-d'). ' 23:59:00'])->groupBy('two')->get();

        if(now()->format('Y-m-d H:i:s') < now()->format('Y-m-d') .' 12:00:00'){
            $total_amount_from_table = $user_brake_amount_all_am;
        }else{
            $total_amount_from_table = $user_brake_amount_all_pm;
        }

        $breaks = [];
        $lo_at_amount = [];
        foreach ($total_amount_from_table as $user_brake_amount_all) {
            $brake_amount_from_table = UserBrakeAmountAll::select('amount')->where('type', '2D')->first();
            if ($brake_amount_from_table) {
                for ($i=0;$i<count($two);$i++) {
                    if ($user_brake_amount_all->two == $two[$i]) {
                        $need =  $user_brake_amount_all->total+ $amount;

                        $lo_at_amount = $brake_amount_from_table->amount - $user_brake_amount_all->total;

                        if ($need >  $brake_amount_from_table->amount) {
                            array_push($breaks, $user_brake_amount_all->two);
                        }
                    }
                }
            }
        }

        for ($i=0;$i<count($two);$i++) {
            $emptybreak = UserBrakeAmountAll::where('type', '2D')->first();
            if ($emptybreak) {
                $lo_at_amount = $emptybreak->amount;
                if ($amount > $emptybreak->amount) {
                    $two = $two->toArray();
                    return ['breaks'=>$two,'lo_at_amount'=>$lo_at_amount];
                }
            }
        }

        if (!is_null($breaks)) {
            return ['breaks'=>$breaks,'lo_at_amount'=>$lo_at_amount];
        } else {
            return null;
        }
    }

    public static function OnlyBrake($two, $amount)
    {
        $breakNumbers = Amountbreak::select('closed_number')->where('type', '2D')->get();

        $break_twos_am = Two::select('two', DB::raw('SUM(amount) as total'))->whereIn('two', $breakNumbers)->whereBetween('created_at', [now()->format('Y-m-d').' '.'00:00:00',now()->format('Y-m-d').' '.'12:00:00'])->groupBy('two')->get();
        $break_twos_pm = Two::select('two', DB::raw('SUM(amount) as total'))->whereIn('two', $breakNumbers)->whereBetween('created_at', [now()->format('Y-m-d'). ' '.'12:00:00',now()->format('Y-m-d').' '.'23:59:00'])->groupBy('two')->get();

        $breaks = [];
        $needAmount = null;

        if(now()->format('Y-m-d H:i:s') < now()->format('Y-m-d') .' 12:00:00'){
            foreach ($break_twos_am as $break_two) {
                $break_amount = Amountbreak::select('amount')->where('closed_number', $break_two->two)->where('type','2D')->first();
                $break_number = Amountbreak::select('closed_number')->where('closed_number', $break_two->two)->where('type','2D')->first();

                for ($i=0;$i<count($two);$i++) {
                    if ($break_number->closed_number == $two[$i]) {
                        $breakTwo = $break_two->total + $amount;
                        $needAmount[] = $break_amount->amount - $break_two->total;

                        if ($breakTwo > $break_amount->amount) {
                            array_push($breaks, $break_number->closed_number);
                        }
                    }
                }
            }
        }else{
            foreach ($break_twos_pm as $break_two) {
                $break_amount = Amountbreak::select('amount')->where('closed_number', $break_two->two)->where('type','2D')->first();
                $break_number = Amountbreak::select('closed_number')->where('closed_number', $break_two->two)->where('type','2D')->first();
                for ($i=0;$i<count($two);$i++) {
                    if ($break_number->closed_number == $two[$i]) {
                        $breakTwo = $break_two->total + $amount;
                        $needAmount[] = $break_amount->amount - $break_two->total;

                        if ($breakTwo > $break_amount->amount) {
                            array_push($breaks, $break_number->closed_number);
                        }
                    }
                }
            }
        }




        for ($i=0;$i<count($two);$i++) {
            $emptybreak = Amountbreak::where('closed_number', $two[$i])->where('type','2D')->first();
            if ($emptybreak) {
                $lo_at_amount[] = $emptybreak->amount;

                if ($amount > $emptybreak->amount) {
                    $breaknumber[] = $emptybreak->closed_number;
                    return ['breaks'=>$breaknumber,'lo_at_amount'=>$lo_at_amount];
                }
            }
        }

        if (!is_null($breaks)) {
            return ['breaks'=>$breaks ,'needAmount'=>$needAmount];
        }
    }

    public static function DubaiOnlyBrake($two, $amount)
    {
        $breakNumbers = Amountbreak::select('closed_number')->where('type','Dubai_2D')->get();

        $break_twos = DubaiTwo::select('two', DB::raw('SUM(amount) as total'))->whereIn('two', $breakNumbers)->whereBetween('created_at', [now()->format('Y-m-d').' '.'00:00:00',now()->format('Y-m-d').' '.'23:59:00'])->groupBy('two')->get();

        $breaks = [];
        $needAmount = null;

            foreach ($break_twos as $break_two) {
                $break_amount = Amountbreak::select('amount')->where('closed_number', $break_two->two)->where('type','Dubai_2D')->first();
                $break_number = Amountbreak::select('closed_number')->where('closed_number', $break_two->two)->where('type','Dubai_2D')->first();

                for ($i=0;$i<count($two);$i++) {
                    if ($break_number->closed_number == $two[$i]) {
                        $breakTwo = $break_two->total + $amount;
                        $needAmount[] = $break_amount->amount - $break_two->total;

                        if ($breakTwo > $break_amount->amount) {
                            array_push($breaks, $break_number->closed_number);
                        }
                    }
                }
            }


            for ($i=0;$i<count($two);$i++) {
                $emptybreak = Amountbreak::where('closed_number', $two[$i])->where('type','Dubai_2D')->first();
                if ($emptybreak) {
                    $lo_at_amount[] = $emptybreak->amount;

                    if ($amount > $emptybreak->amount) {
                        $breaknumber[] = $emptybreak->closed_number;
                        return ['breaks'=>$breaknumber,'lo_at_amount'=>$lo_at_amount];
                    }
                }
            }

        if (!is_null($breaks)) {
            return ['breaks'=>$breaks ,'needAmount'=>$needAmount];
        }
    }
}
