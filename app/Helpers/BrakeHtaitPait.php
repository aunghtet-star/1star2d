<?php
namespace App\Helpers;

use App\Two;
use App\Amountbreak;

use App\AllBrakeWithAmount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrakeHtaitPait
{
    public static function AllBrake($data, $amount)
    {
        $allbreakwithamounttwos = Two::select('two', DB::raw('SUM(amount) as total'))->where('admin_user_id', Auth()->user()->admin_user_id)->whereDate('date', now()->format('Y-m-d'))->groupBy('two')->get();
        
        $breaks = [];
        $lo_at_amount = [];
        foreach ($allbreakwithamounttwos as $allbreakwithamounttwo) {
            $allBreakWithAmount = AllBrakeWithAmount::select('amount')->where('type', '2D')->where('admin_user_id', Auth()->user()->admin_user_id)->first();
            if ($allBreakWithAmount) {
                for ($i=0;$i<count($data);$i++) {
                    if ($allbreakwithamounttwo->two == $data[$i]) {
                        $need =  $allbreakwithamounttwo->total+ $amount;
                    
                        $lo_at_amount = $allBreakWithAmount->amount - $allbreakwithamounttwo->total;
                    
                        if ($need >  $allBreakWithAmount->amount) {
                            array_push($breaks, $allbreakwithamounttwo->two);
                        }
                    }
                }
            }
        }
        
        for ($i=0;$i<count($data);$i++) {
            $emptybreak = AllBrakeWithAmount::where('type', '2D')->where('admin_user_id', Auth()->user()->admin_user_id)->first();
            if ($emptybreak) {
                $lo_at_amount = $emptybreak->amount;
                if ($amount > $emptybreak->amount) {
                    $data = $data->toArray();
                    return ['breaks'=>$data,'lo_at_amount'=>$lo_at_amount];
                }
            }
        }

        if (!is_null($breaks)) {
            return ['breaks'=>$breaks,'lo_at_amount'=>$lo_at_amount];
        } else {
            return null;
        }
    }

    public static function OnlyBrake($data, $amount)
    {
        $breakNumbers = Amountbreak::select('closed_number')->where('type', '2D')->where('admin_user_id', Auth()->user()->admin_user_id)->get();
        $break_twos = Two::select('two', DB::raw('SUM(amount) as total'))->whereIn('two', $breakNumbers)->where('admin_user_id', Auth()->user()->admin_user_id)->whereDate('date', now()->format('Y-m-d'))->groupBy('two')->get();
        
        
        $breaks = [];
        $needAmount = null;
        foreach ($break_twos as $break_two) {
            $break_amount = Amountbreak::select('amount')->where('closed_number', $break_two->two)->where('admin_user_id', Auth()->user()->admin_user_id)->first();
            $break_number = Amountbreak::select('closed_number')->where('closed_number', $break_two->two)->where('admin_user_id', Auth()->user()->admin_user_id)->first();
            for ($i=0;$i<count($data);$i++) {
                if ($break_number->closed_number == $data[$i]) {
                    $breakTwo = $break_two->total + $amount;
                    $needAmount[] =$break_amount->amount - $break_two->total;
                   
                    if ($breakTwo > $break_amount->amount) {
                        array_push($breaks, $break_number->closed_number);
                    }
                }
            }
        }
        
        
        
        for ($i=0;$i<count($data);$i++) {
            $emptybreak = Amountbreak::where('closed_number', $data[$i])->where('admin_user_id', Auth()->user()->admin_user_id)->first();
            
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
