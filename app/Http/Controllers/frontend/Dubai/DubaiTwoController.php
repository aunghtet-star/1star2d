<?php

namespace App\Http\Controllers\frontend\Dubai;

use App\Amountbreak;
use App\BetHistory;
use App\DubaiTwo;
use App\Helpers\ForUserHistory;
use App\Helpers\ForWalletAndBetHistory;
use App\Helpers\TheeThantBrake;
use App\Helpers\UUIDGenerator;
use App\Http\Controllers\Controller;
use App\ShowHide;
use App\WalletHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DubaiTwoController extends Controller
{
    public function index()
    {
        $twoform = ShowHide::where('name', 'dubai_twoform')->first();

        return view('frontend.dubai-two.index', compact('twoform'));
    }

    public function twoconfirm(Request $request)
    {
        $from_account_wallet = Auth()->user()->user_wallet;

        // R ဂဏန်းများ function
        $total = 0;
        $reverse_two = [];

        if (!is_null($request->r)) {
            foreach ($request->r as $r) {
                foreach ($request->two as $key=>$two) {
                    if ($key == $r) {
                        $reverse_two[] .= strrev((string)$two);
                    }
                }
            }
        }

        foreach ($request->amount as $key=>$amount) {
            if (!is_null($request->r)) {
                foreach ($request->r as $r) {
                    if ($key == $r) {
                        $total += $amount;
                    }
                }
            }

            $total += $amount;

            // insufficient balance condition
            if ($from_account_wallet->amount < $total) {
                return redirect('/two')->withErrors(['fail' => 'You have no sufficient balance']);
            }
        }

        //for post method to two method
        $user_id = Auth()->user()->id;
        $date = now()->format('Y-m-d');
        $twos = $request->two;
        $amount = $request->amount;
        $r_keys = $request->r;
        $total;

        $r_amount = [];
        foreach ($r_keys ?? [] as $r_key){
            $r_amount[] = $amount[$r_key];
        }

        //brake number condition

        $breakNumbers = Amountbreak::select('closed_number')->where('type', 'Dubai_2D')->get();
        $break_twos_am = DubaiTwo::select('two', DB::raw('SUM(amount) as total'))->whereIn('two', $breakNumbers)->whereBetween('created_at', [now()->format('Y-m-d'). ' 00:00:00',now()->format('Y-m-d'). ' 12:00:00'])->groupBy('two')->get();
        $break_twos_pm = DubaiTwo::select('two', DB::raw('SUM(amount) as total'))->whereIn('two', $breakNumbers)->whereBetween('created_at', [now()->format('Y-m-d'). ' 12:00:00',now()->format('Y-m-d'). ' 23:59:00'])->groupBy('two')->get();

        if(now()->format('Y-m-d H:i:s') < now()->format('Y-m-d') .' 12:00:00'){
            //Thee thant brake number AM
            $am = TheeThantBrake::DigitDubaiBrake($break_twos_am,$twos,$amount);
            if($am){
                return back()->withErrors([
                    $am['closed_number'].' သည် ကန့်သတ်ထားသော ဂဏန်းဖြစ်ပါသည်
                             '.'ဤဂဏန်းသည် ကန့်သတ်ပမာဏ ရောက်ရှိရန် '.$am['need_amount'].' ကျပ်လိုပါသေးသည်'
                ])->withInput();
            }

        }else{

            // Thee thant brake number PM
            $pm = TheeThantBrake::DigitDubaiBrake($break_twos_pm,$twos,$amount);
            if($pm){
                return back()->withErrors([
                    $pm['closed_number'].' သည် ကန့်သတ်ထားသော ဂဏန်းဖြစ်ပါသည်
                             '.'ဤဂဏန်းသည် ကန့်သတ်ပမာဏ ရောက်ရှိရန် '.$pm['need_amount'].' ကျပ်လိုပါသေးသည်'
                ])->withInput();
            }
        }

        // if db has no two number exists in the thee thant number table
        $db_has_no_two_number = TheeThantBrake::NoExistDigitDubaiBrake($twos,$amount);
        if ($db_has_no_two_number){

            return back()->withErrors([
                $db_has_no_two_number['closed_number'].'သည် ကန့်သတ်ထားသော ဂဏန်းဖြစ်ပါသည်
                         '.'ဤဂဏန်းသည် ကန့်သတ်ပမာဏ ရောက်ရှိရန် '.$db_has_no_two_number['need_amount'].' ကျပ်လိုပါသေးသည်'
            ])->withInput();
        }


        if(now()->format('Y-m-d H:i:s') < now()->format('Y-m-d') .' 12:00:00'){
            // R ဂဏန်းများ အတွက် brake number am

            $am_r = TheeThantBrake::DigitDubaiBrake($break_twos_am,$reverse_two,$amount);

            if($am_r){
                return back()->withErrors([
                    $am_r['closed_number'].' သည် ကန့်သတ်ထားသော ဂဏန်းဖြစ်ပါသည်
                             '.'ဤဂဏန်းသည် ကန့်သတ်ပမာဏ ရောက်ရှိရန် '.$am_r['need_amount'].' ကျပ်လိုပါသေးသည်'
                ])->withInput();
            }
        }else{
            // R ဂဏန်းများ အတွက် brake number pm

            $pm_r = TheeThantBrake::DigitDubaiBrake($break_twos_pm,$reverse_two,$amount);
            if($pm_r){
                return back()->withErrors([
                    $pm_r['closed_number'].' သည် ကန့်သတ်ထားသော ဂဏန်းဖြစ်ပါသည်
                             '.'ဤဂဏန်းသည် ကန့်သတ်ပမာဏ ရောက်ရှိရန် '.$pm_r['need_amount'].' ကျပ်လိုပါသေးသည်'
                ])->withInput();
            }
        }

        // if db has no two-r number exists in the thee thant number table

        $db_has_no_two_number_r = TheeThantBrake::NoExistDigitDubaiBrake($reverse_two,$amount);

        if ($db_has_no_two_number_r){
            return back()->withErrors([
                $db_has_no_two_number_r['closed_number'].'သည် ကန့်သတ်ထားသော ဂဏန်းဖြစ်ပါသည်
                         '.'ဤဂဏန်းသည် ကန့်သတ်ပမာဏ ရောက်ရှိရန် '.$db_has_no_two_number_r['need_amount'].' ကျပ်လိုပါသေးသည်'
            ])->withInput();
        }

        return view('frontend.dubai-two.twoconfirm', compact('user_id', 'date', 'twos', 'amount', 'total', 'reverse_two', 'r_keys','r_amount'));

    }

    public function two(Request $request)
    {
        $from_account_wallet = Auth()->user()->user_wallet;

        $total = 0;


        foreach ($request->amount ?? [] as $key=>$amount) {
            $total += $amount;
        }

        foreach ($request->r_amount ?? [] as $key=>$amount) {
            $total += $amount;
        }


        if ($from_account_wallet->amount < $total) {
            return redirect('/dubai-two')->withErrors(['fail' => 'You have no sufficient balance']);
        }


        DB::beginTransaction();

        try {
            foreach ($request->two as $key=>$twod) {
                $two = new DubaiTwo();
                $two->user_id = Auth()->user()->id;
                $two->master_id = Auth()->user()->master_id;
                $two->admin_user_id = Auth()->user()->admin_user_id;
                $two->date = now()->format('Y-m-d');
                $two->two = $twod;
                $two->amount = $request->amount[$key];
                $two->save();
            }

            foreach ($request->r_two ?? [] as $key=>$twor) {
                $two = new DubaiTwo();
                $two->user_id = Auth()->user()->id;
                $two->master_id = Auth()->user()->master_id;
                $two->admin_user_id = Auth()->user()->admin_user_id;
                $two->date = now()->format('Y-m-d');
                $two->two = $twor;
                $two->amount = $request->r_amount[$key];
                $two->save();
            }

            $from_account_wallet->decrement('amount', $total);
            $from_account_wallet->update();

            $trx_id = UUIDGenerator::TrxId();

            ForWalletAndBetHistory::Slip(new WalletHistory,Auth()->user()->admin_user_id,Auth()->user()->id,$trx_id,$total,'bet','user');

            ForWalletAndBetHistory::Slip(new BetHistory,Auth()->user()->admin_user_id,Auth()->user()->id,$trx_id,$total,'bet','Dubai 2D');

            DB::commit();
            return redirect('dubai-two')->with('create', 'Done');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/dubai-two')->withErrors(['fail' => 'Something wrong']);
        }

    }


    public function history()
    {
        return view('frontend.user.history');
    }

    public function historyTwo(Request $request)
    {
        $date = $request->date;
        $time = $request->time;

        if ($time == 'all'){
            $two = ForUserHistory::Two($date,'00:00:00','23:59:00');
            $twototals = $two['two_totals'];
            $twousers = $two['two_users'];

            $three = ForUserHistory::Three($date,'00:00:00','23:59:00');
            $threetotals = $three['three_totals'];
            $threeusers = $three['three_users'];

        }

        if ($time == 'true') {

            $two = ForUserHistory::Two($date,'00:00:00','11:59:00');
            $twototals = $two['two_totals'];
            $twousers = $two['two_users'];

            $three = ForUserHistory::Three($date,'00:00:00','11:59:00');
            $threetotals = $three['three_totals'];
            $threeusers = $three['three_users'];

        }

        if ($time == 'false') {

            $two = ForUserHistory::Two($date,'11:59:00','23:59:00');
            $twototals = $two['two_totals'];
            $twousers = $two['two_users'];

            $three = ForUserHistory::Three($date,'11:59:00','23:59:00');
            $threetotals = $three['three_totals'];
            $threeusers = $three['three_users'];
        }


        return view('frontend.components.history', compact('twousers', 'twototals', 'threeusers', 'threetotals'))->render();
    }
}
