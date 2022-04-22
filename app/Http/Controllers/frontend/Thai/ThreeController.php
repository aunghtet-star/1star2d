<?php

namespace App\Http\Controllers\frontend\Thai;

use App\AdminUser;
use App\AllBrakeWithAmount;
use App\Amountbreak;
use App\BetHistory;
use App\Helpers\ForWalletAndBetHistory;
use App\Helpers\TheeThantBrake;
use App\Helpers\UUIDGenerator;
use App\Http\Controllers\Controller;
use App\ShowHide;
use App\Three;
use App\Wallet;
use App\WalletHistory;
use Illuminate\Http\Request;
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
        $from_account_wallet = Auth()->user()->user_wallet;

        $total = 0;

        foreach ($request->amount as $amount){
            $total += $amount;
        }

        // insufficient balance condition
        if ($from_account_wallet->amount < $total) {
            return redirect('/three')->withErrors(['fail' => 'You have no sufficient balance']);
        }

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


        $threes = $request->three;
        $amount = $request->amount;

        return view('frontend.three.threeconfirm', compact('threes', 'amount','total'));
    }

    public function three(Request $request)
    {
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

        $from_account_wallet = Auth()->user()->user_wallet;


        $total = 0;
        foreach ($request->amount as $amount) {
            $total += $amount;
            if ($from_account_wallet->amount < $total) {
                return redirect('/three')->withErrors(['fail' => 'You have no sufficient balance']);
            }
        }


        DB::beginTransaction();

        try {
            foreach ($request->amount as $amount) {
                $from_account_wallet->decrement('amount', $amount);
                $from_account_wallet->update();
            }


            foreach ($request->three as $key=>$threed) {
                $three = new Three();
                $three->user_id = Auth()->user()->id;
                $three->admin_user_id = Auth()->user()->admin_user_id;
                $three->date = now()->format('Y-m-d');
                $three->three = $threed;
                $three->amount = $request->amount[$key];
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
