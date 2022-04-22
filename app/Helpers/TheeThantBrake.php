<?php

namespace App\Helpers;

use App\Amountbreak;

class TheeThantBrake
{
    public static function DigitBrake($datas,$digits,$amount){
        foreach ($datas as $data) {
            if (strlen($data) == '2' ){
                $break_amount = Amountbreak::select('amount')->where('closed_number', $data->two)->where('type','2D')->first();
                $break_number = Amountbreak::select('closed_number')->where('closed_number', $data->two)->where('type','2D')->first();
            }else{
                $break_amount = Amountbreak::select('amount')->where('closed_number', $data->three)->where('type','3D')->first();
                $break_number = Amountbreak::select('closed_number')->where('closed_number', $data->three)->where('type','3D')->first();
            }


            for ($i=0;$i<count($digits);$i++) {

                if ($break_number->closed_number == $digits[$i]) {

                    $breakTwo = $data->total + $amount[$i];
                    $needAmount =$break_amount->amount - $data->total;
                    if ($breakTwo > $break_amount->amount) {
                        return ['closed_number' => $break_number->closed_number,'need_amount' => $needAmount];
                    }
                }
            }
        }
    }

    public static function NoExistDigitBrake($digits,$amount){

        for ($i=0;$i<count($digits);$i++) {

            if (strlen($digits[$i]) == '2'){
                $emptybreak = Amountbreak::where('closed_number', $digits[$i])->where('type', '2D')->first();

            }else{
                $emptybreak = Amountbreak::where('closed_number', $digits[$i])->where('type', '3D')->first();
            }
            if ($emptybreak) {
                if ($amount[$i] > $emptybreak->amount) {
                    return ['closed_number' => $emptybreak->closed_number , 'need_amount' => $emptybreak->amount];
                }
            }
        }
    }

    public static function DigitDubaiBrake($datas,$digits,$amount){
        foreach ($datas as $data) {

            $break_amount = Amountbreak::select('amount')->where('closed_number', $data->two)->where('type','Dubai_2D')->first();
            $break_number = Amountbreak::select('closed_number')->where('closed_number', $data->two)->where('type','Dubai_2D')->first();

            for ($i=0;$i<count($digits);$i++) {

                if ($break_number->closed_number == $digits[$i]) {

                    $breakTwo = $data->total + $amount[$i];
                    $needAmount =$break_amount->amount - $data->total;
                    if ($breakTwo > $break_amount->amount) {
                        return ['closed_number' => $break_number->closed_number,'need_amount' => $needAmount];
                    }
                }
            }
        }
    }

    public static function NoExistDigitDubaiBrake($digits,$amount){

        for ($i=0;$i<count($digits);$i++) {
                $emptybreak = Amountbreak::where('closed_number', $digits[$i])->where('type', 'Dubai_2D')->first();

            if ($emptybreak) {
                if ($amount[$i] > $emptybreak->amount) {
                    return ['closed_number' => $emptybreak->closed_number , 'need_amount' => $emptybreak->amount];
                }
            }
        }
    }
}

// ===========================  ==================== All brake number for two limit code ================= ========================

//  $allbreakwithamounttwos = Two::select('two', DB::raw('SUM(amount) as total'))->where('admin_user_id', Auth()->user()->admin_user_id)->whereDate('date', now()->format('Y-m-d'))->groupBy('two')->get();

// foreach ($allbreakwithamounttwos as $allbreakwithamounttwo) {
//     $allBreakWithAmount = AllBrakeWithAmount::select('amount')->where('type', '2D')->where('admin_user_id', Auth()->user()->admin_user_id)->first();
//     if ($allBreakWithAmount) {
//         for ($i=0;$i<count($request->two);$i++) {
//             if ($allbreakwithamounttwo->two == $request->two[$i]) {
//                 $need =  $allbreakwithamounttwo->total+ $request->amount[$i];

//                 $lo_at_amount = $allBreakWithAmount->amount - $allbreakwithamounttwo->total;

//                 if ($need >  $allBreakWithAmount->amount) {
//                     return redirect(url('two'))->withErrors([
//                 $request->two[$i].' သည် ကန့်သတ်ထားသော ဂဏန်းဖြစ်ပါသည်
//                 '.'ဤဂဏန်းသည် ကန့်သတ်ပမာဏ ရောက်ရှိရန် '. $lo_at_amount .'ကျပ်လိုပါသေးသည်'
//             ]);
//                 }
//             }
//         }
//     }
// }

// for ($i=0;$i<count($request->two);$i++) {
//     $emptybreak = AllBrakeWithAmount::where('type', '2D')->where('admin_user_id', Auth()->user()->admin_user_id)->first();

//     if ($emptybreak) {
//         if ($request->amount[$i] > $emptybreak->amount) {
//             return redirect(url('two'))->withErrors([
//                 $request->two[$i].' သည် ကန့်သတ်ထားသော ဂဏန်းဖြစ်ပါသည်
//                 '.'ဤဂဏန်းသည် ကန့်သတ်ပမာဏ ရောက်ရှိရန် '.$emptybreak->amount .'ကျပ်လိုပါသေးသည်'
//             ]);
//         }
//     }
// }

//=========================================== All brake number for three limit code

//         $allbreakwithamountthrees = Three::select('three', DB::raw('SUM(amount) as total'))->where('admin_user_id', Auth()->user()->admin_user_id)->groupBy('three')->get();
//
//         foreach ($allbreakwithamountthrees as $allbreakwithamountthree) {
//             $allBreakWithAmount = AllBrakeWithAmount::select('amount')->where('type', '3D')->where('admin_user_id', Auth()->user()->admin_user_id)->first();
//
//             if ($allBreakWithAmount) {
//                 for ($i=0;$i<count($request->three);$i++) {
//                     if ($allbreakwithamountthree->three == $request->three[$i]) {
//                         $need =  $allbreakwithamountthree->total+ $request->amount[$i];
//                         $lo_at_amount = $allBreakWithAmount->amount - $allbreakwithamountthree->total;
//
//                         if ($need >  $allBreakWithAmount->amount) {
//                             return redirect(url('three'))->withErrors([
//                             $request->three[$i].' သည် ကန့်သတ်ထားသော ဂဏန်းဖြစ်ပါသည်
//                             '.'ဤဂဏန်းသည် ကန့်သတ်ပမာဏ ရောက်ရှိရန် '. $lo_at_amount .'ကျပ်လိုပါသေးသည်'
//                         ]);
//                         }
//                     }
//                 }
//             }
//         }
//
//         for ($i=0;$i<count($request->three);$i++) {
//             $emptybreak = AllBrakeWithAmount::where('type', '3D')->where('admin_user_id', Auth()->user()->admin_user_id)->first();
//
//             if ($emptybreak) {
//                 if ($request->amount[$i] > $emptybreak->amount) {
//                     return redirect(url('three'))->withErrors([
//                         $request->three[$i].' သည် ကန့်သတ်ထားသော ဂဏန်းဖြစ်ပါသည်
//                         '.'ဤဂဏန်းသည် ကန့်သတ်ပမာဏ ရောက်ရှိရန် '.$emptybreak->amount .'ကျပ်လိုပါသေးသည်'
//                     ]);
//                 }
//             }
//         }
