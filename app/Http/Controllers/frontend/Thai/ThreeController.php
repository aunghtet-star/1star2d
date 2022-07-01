<?php

namespace App\Http\Controllers\frontend\Thai;

use App\AdminUser;
use App\AllBrakeWithAmount;
use App\Amountbreak;
use App\BetHistory;
use App\Helpers\ForUserBrakeAmountAll;
use App\Helpers\ForWalletAndBetHistory;
use App\Helpers\TheeThantBrake;
use App\Helpers\UUIDGenerator;
use App\Http\Controllers\Controller;
use App\ShowHide;
use App\Three;
use App\Two;
use App\UserBrakeAmountAll;
use App\Wallet;
use App\WalletHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use MyanLottery\Lottery\Threed;

class ThreeController extends Controller
{
    public function index()
    {
        $threeform = ShowHide::where('name', 'threeform')->first();

        return view('frontend.three.index', compact('threeform'));
    }

    public function threeconfirm(Request $request)
    {



        $total = 0;
        $threeRs = null;

        if (!is_null($request->r)) {
            $threeR = new Threed();
            $threeR = $threeR->r_no_origin_array($request->three)->getData();
            $threeRs = $threeR->data;


            foreach ($threeRs as $key=>$three){
                    foreach ($request->amount ?? []  as $amount){
                        $total += $amount;
                    }
            }
        }

        foreach ($request->amount ?? []  as $amount){
            $total += $amount;
        }

        $from_account_wallet = Auth()->user()->user_wallet;


        // insufficient balance condition
        if ($from_account_wallet->amount < $total) {
            return redirect('/three')->withErrors(['fail' => 'You have no sufficient balance']);
        }



//            if (now()->format('Y-m-d') < Carbon::now()->startOfMonth()->addDays(16)->format('Y-m-d')){
//                $from =  Carbon::now()->startOfMonth()->addDays(1);
//                $to =  Carbon::now()->startOfMonth()->addDays(15);
//            }else{
//                //dd(Carbon::now()->startOfMonth()->addDays(15)->format('Y-m-d'));
//                $from =  Carbon::now()->startOfMonth()->addDays(16);
//                $to =  Carbon::now()->endOfMonth()->addDays(1);
//            }

        if (now()->format('Y-m-d') < Carbon::now()->startOfMonth()->addDays(16)->format('Y-m-d')){
            if (Carbon::now()->format('Y-m-d H:i:s') < Carbon::now()->startOfMonth()->format('Y-m-d 23:00:00')){
                $from = $request->startdate ?? Carbon::now()->subMonths(1)->addDays(16);
                $to = $request->enddate ?? Carbon::now()->startOfMonth();
            }else{
                $from = $request->startdate ?? Carbon::now()->startOfMonth()->addDays(1);
                $to = $request->enddate ?? Carbon::now()->startOfMonth()->addDays(15);
            }
        }else{
            //dd(Carbon::now()->startOfMonth()->addDays(15)->format('Y-m-d'));
            $from = $request->startdate ?? Carbon::now()->startOfMonth()->addDays(16);
            $to = $request->enddate ?? Carbon::now()->endOfMonth()->addDays(1);
        }

            $from = $from->format('Y-m-d');
            $to = $to->format('Y-m-d');


        $closed_three = Amountbreak::select('closed_number')->where('type', '3D')->get();
        $three_brakes =  Three::select('three', DB::raw('SUM(amount) as total'))->whereIn('three', $closed_three)->whereBetween('date',[$from,$to])->groupBy('three')->get();


        //All limit feature for 3D function

        $three_brakes_all =  Three::select('three', DB::raw('SUM(amount) as total'))->whereBetween('date',[$from,$to])->groupBy('three')->get();


        //All brake Number Condition

        if (!is_null($request->r)){
            $threeBrake = ForUserBrakeAmountAll::AllBrakeThreeR($threeRs,$amount,$three_brakes_all,new UserBrakeAmountAll);
        }else{
            $threeBrake = ForUserBrakeAmountAll::AllBrakeThree($request->three,$request->amount,$three_brakes_all,new UserBrakeAmountAll);
        }

        if ($threeBrake){
            return back()->withErrors([
                $threeBrake['three'].' သည် ကန့်သတ်ထားသော ဂဏန်းဖြစ်ပါသည်
                             '.'ဤဂဏန်းသည် ကန့်သတ်ပမာဏ ရောက်ရှိရန် '.$threeBrake['need_amount'].' ကျပ်လိုပါသေးသည်'
            ])->withInput();
        }

        // limit feature for 3D function
        $three_d = TheeThantBrake::DigitBrake($three_brakes,$request->three,$request->amount);

        if($three_d){
            return back()->withErrors([
                $three_d['closed_number'].' သည် ကန့်သတ်ထားသော ဂဏန်းဖြစ်ပါသည်
                             '.'ဤဂဏန်းသည် ကန့်သတ်ပမာဏ ရောက်ရှိရန် '.$three_d['need_amount'].' ကျပ်လိုပါသေးသည်'
            ])->withInput();
        }

        $db_has_no_three_number = TheeThantBrake::NoExistDigitBrake($request->three,$request->amount);

        if ($db_has_no_three_number){

            return back()->withErrors([
                $db_has_no_three_number['closed_number'].'သည် ကန့်သတ်ထားသော ဂဏန်းဖြစ်ပါသည်
                         '.'ဤဂဏန်းသည် ကန့်သတ်ပမာဏ ရောက်ရှိရန် '.$db_has_no_three_number['need_amount'].' ကျပ်လိုပါသေးသည်'
            ])->withInput();
        }


        // limit feature for 3D R function
        if (!is_null($request->r)){
            $three_r = TheeThantBrake::DigitBrake($three_brakes,$threeRs,$request->amount);

            if($three_r){
                return back()->withErrors([
                    $three_r['closed_number'].' သည် ကန့်သတ်ထားသော ဂဏန်းဖြစ်ပါသည်
                             '.'ဤဂဏန်းသည် ကန့်သတ်ပမာဏ ရောက်ရှိရန် '.$three_r['need_amount'].' ကျပ်လိုပါသေးသည်'
                ])->withInput();
            }

            $db_has_no_three_r_number = TheeThantBrake::NoExistDigitBrake($threeRs,$request->amount);

            if ($db_has_no_three_r_number){

                return back()->withErrors([
                    $db_has_no_three_r_number['closed_number'].'သည် ကန့်သတ်ထားသော ဂဏန်းဖြစ်ပါသည်
                         '.'ဤဂဏန်းသည် ကန့်သတ်ပမာဏ ရောက်ရှိရန် '.$db_has_no_three_r_number['need_amount'].' ကျပ်လိုပါသေးသည်'
                ])->withInput();
            }
        }

        $threes = $request->three;
        $amount = $request->amount;
        $r_keys = $request->r;



        return view('frontend.three.threeconfirm', compact('threes','threeRs', 'amount','total','r_keys'));
    }

    public function three(Request $request)
    {



        if (Three::where('user_id',Auth::user()->id)->exists()){
            $threes = $request->only(['three','three_r']);

            $equal2 = [];
            foreach ($threes as $three){
                foreach ($three as $t){
                    array_push($equal2,$t);
                }
            }

            $batch = Three::where('user_id',Auth::user()->id)->orderBy('batch','desc')->first();

            $equal1 = Three::where('batch',$batch->batch)->pluck('three');


            $equation = $equal1->diff($equal2);

            if ($equation->isEmpty()){
                return redirect('/three')->withErrors(['Error' => 'အရင်ထိုးခဲ့သောအကွက်များနှင့်တူနေသဖြင့်အကွက်များအားနေရာပြောင်း၍ပြန်ထိုးပါ']);
            }
        }

        $from_account_wallet = Auth()->user()->user_wallet;
        $total = 0;


        foreach ($request->r_amount ?? []  as $amount){
            $total += $amount;
        }

        foreach ($request->amount as $amount) {
            $total += $amount;
        }


        if ($from_account_wallet->amount < $total) {
            return redirect('/three')->withErrors(['fail' => 'You have no sufficient balance']);
        }

        // limit feature for 3D function

        $closed_three = Amountbreak::select('closed_number')->where('type', '3D')->get();
        $three_brakes =  Three::select('three', DB::raw('SUM(amount) as total'))->whereIn('three', $closed_three)->where('date',now()->format('Y-m-d'))->groupBy('three')->get();


        $three_d = TheeThantBrake::DigitBrake($three_brakes,$request->three,$request->amount);

        if($three_d){
            return back()->withErrors([
                $three_d['closed_number'].' သည် ကန့်သတ်ထားသော ဂဏန်းဖြစ်ပါသည်
                             '.'ဤဂဏန်းသည် ကန့်သတ်ပမာဏ ရောက်ရှိရန် '.$three_d['need_amount'].' ကျပ်လိုပါသေးသည်'
            ])->withInput();
        }

        $db_has_no_three_number = TheeThantBrake::NoExistDigitBrake($request->three,$request->amount);

        if ($db_has_no_three_number){

            return back()->withErrors([
                $db_has_no_three_number['closed_number'].'သည် ကန့်သတ်ထားသော ဂဏန်းဖြစ်ပါသည်
                         '.'ဤဂဏန်းသည် ကန့်သတ်ပမာဏ ရောက်ရှိရန် '.$db_has_no_three_number['need_amount'].' ကျပ်လိုပါသေးသည်'
            ])->withInput();
        }

        // limit feature for 3D R function
        if (!is_null($request->r)){
            $three_r = TheeThantBrake::DigitBrake($three_brakes,$request->three_r,$request->amount);
            if($three_r){
                return back()->withErrors([
                    $three_r['closed_number'].' သည် ကန့်သတ်ထားသော ဂဏန်းဖြစ်ပါသည်
                             '.'ဤဂဏန်းသည် ကန့်သတ်ပမာဏ ရောက်ရှိရန် '.$three_r['need_amount'].' ကျပ်လိုပါသေးသည်'
                ])->withInput();
            }

            $db_has_no_three_r_number = TheeThantBrake::NoExistDigitBrake($request->three_r,$request->amount);

            if ($db_has_no_three_r_number){

                return back()->withErrors([
                    $db_has_no_three_r_number['closed_number'].'သည် ကန့်သတ်ထားသော ဂဏန်းဖြစ်ပါသည်
                         '.'ဤဂဏန်းသည် ကန့်သတ်ပမာဏ ရောက်ရှိရန် '.$db_has_no_three_r_number['need_amount'].' ကျပ်လိုပါသေးသည်'
                ])->withInput();
            }
        }


        DB::beginTransaction();

        $batch_id = UUIDGenerator::ThreeBatch();

        try {
                $from_account_wallet->decrement('amount', $total);
                $from_account_wallet->update();

            foreach ($request->three as $key=>$threed) {
                $three = new Three();
                $three->user_id = Auth()->user()->id;
                $three->master_id = Auth()->user()->master_id;
                $three->admin_user_id = Auth()->user()->admin_user_id;
                $three->date = now()->format('Y-m-d');
                $three->three = $threed;
                $three->batch = $batch_id;
                $three->amount = $request->amount[$key];
                $three->save();
            }

            foreach ($request->three_r ?? [] as $key=>$threed) {
                $three = new Three();
                $three->user_id = Auth()->user()->id;
                $three->master_id = Auth()->user()->master_id;
                $three->admin_user_id = Auth()->user()->admin_user_id;
                $three->date = now()->format('Y-m-d');
                $three->three = $threed;
                $three->batch = $batch_id;
                $three->amount = $request->r_amount[$key];
                $three->save();
            }

            $trx_id = UUIDGenerator::TrxId();

            ForWalletAndBetHistory::Slip(new WalletHistory,Auth()->user()->admin_user_id,Auth()->user()->id,$trx_id,$total,'bet','user');

            ForWalletAndBetHistory::Slip(new BetHistory,Auth()->user()->admin_user_id,Auth()->user()->id,$trx_id,$total,'bet','3D');

            DB::commit();
            return redirect('three')->with('create', 'Done');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/three')->withErrors(['fail' => 'Something wrong']);
        }
    }

}
