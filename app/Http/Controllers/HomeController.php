<?php

namespace App\Http\Controllers;

use App\DubaiTwo;
use App\Helpers\ForUserBrakeAmountAll;
use App\Helpers\ForUserHistory;
use App\Helpers\ForWalletAndBetHistory;
use App\Helpers\TheeThantBrake;
use App\Two;
use App\TwoOverviewPM;
use App\User;
use App\Three;
use App\UserBrakeAmountAll;
use Exception;
use App\Wallet;
use App\ShowHide;
use App\AdminUser;
use Carbon\Carbon;
use App\BetHistory;
use App\Amountbreak;
use App\Transaction;
use App\TwoOverview;
use App\WalletHistory;
use Faker\Core\Number;
use App\AllBrakeWithAmount;
use Illuminate\Http\Request;
use App\Helpers\UUIDGenerator;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreUserTwoD;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Symfony\Component\VarDumper\VarDumper;

class HomeController extends Controller
{
    public function home()
    {
        $am_response = Http::get('https://script.googleusercontent.com/macros/echo?user_content_key=R7HG-0BT8iQRqPeFrkb5lvyOk8tNYN3n6xyjSvuh32gFliP6tXp1Eia5TlvHF2bWp37Xxv68Bh_W2wdQh1kvpPt2uCIXHhTVm5_BxDlH2jW0nuo2oDemN9CCS2h10ox_1xSncGQajx_ryfhECjZEnBhMKdr3mjZlOgpWGgftRlCZZJ-qd3lNGu_IBuGnyapFnqJ7rg5NvOFWn12Fp1Dxq7d8MAdYOYtX&lib=MYSvdm741KiQvKD1gOuNd9lc8OvjxXfAZ');
        $AmtwoDs = json_decode($am_response->body());
        $AmtwoDs = $AmtwoDs->twoD;

        $pm_response = Http::get('https://script.googleusercontent.com/macros/echo?user_content_key=ZGszFeS4kLVhqAibEdp6d_LSJ02GtSml-MC1kOf4_F2DS-W6X-85AWrAoJrZZbtA8j5ajZkraMjYAFo0BP1yoYlfhGykH_HUm5_BxDlH2jW0nuo2oDemN9CCS2h10ox_1xSncGQajx_ryfhECjZEnA7wpYBcbC8hS8Zu_VBreS6KtPupjXSgETgIjyauKKelwsQVRMwQshXOk5PE_R0eujOmbnRGq-tk&lib=MZI6bu7bMuCZFcGtLMvcWq-02rlMmUn9c');
        $PmtwoDs = json_decode($pm_response->body());

        $PmtwoDs = $PmtwoDs->twoD;

        return view('frontend.home', compact('AmtwoDs', 'PmtwoDs'));
    }

    public function index()
    {
        $twoform = ShowHide::where('name', 'twoform')->first();

        return view('frontend.two.index', compact('twoform'));
    }

    public function twoconfirm(Request $request)
    {
        //dd($request->all());
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

        $breakNumbers = Amountbreak::select('closed_number')->where('type', '2D')->get();
        $break_twos_am = Two::select('two', DB::raw('SUM(amount) as total'))->whereIn('two', $breakNumbers)->whereBetween('created_at', [now()->format('Y-m-d'). ' 00:00:00',now()->format('Y-m-d'). ' 12:00:00'])->groupBy('two')->get();
        $break_twos_pm = Two::select('two', DB::raw('SUM(amount) as total'))->whereIn('two', $breakNumbers)->whereBetween('created_at', [now()->format('Y-m-d'). ' 12:00:00',now()->format('Y-m-d'). ' 23:59:00'])->groupBy('two')->get();

        $user_brake_amount_all_am = Two::select('two', DB::raw('SUM(amount) as total'))->whereBetween('created_at', [now()->format('Y-m-d'). ' 00:00:00',now()->format('Y-m-d'). ' 12:00:00'])->groupBy('two')->get();
        $user_brake_amount_all_pm = Two::select('two', DB::raw('SUM(amount) as total'))->whereBetween('created_at', [now()->format('Y-m-d'). ' 12:00:00',now()->format('Y-m-d'). ' 23:59:00'])->groupBy('two')->get();

        if(now()->format('Y-m-d H:i:s') < now()->format('Y-m-d') .' 12:00:00'){

            //For User Amount Brake All
            $user_brake_amount_all = ForUserBrakeAmountAll::AllBrake($twos,$amount,$user_brake_amount_all_am,new UserBrakeAmountAll);

            if ($user_brake_amount_all){
                return redirect(url('two'))->withErrors([
                    $user_brake_amount_all['two'].' သည် ကန့်သတ်ထားသော ဂဏန်းဖြစ်ပါသည်
            '.'ဤဂဏန်းသည် ကန့်သတ်ပမာဏ ရောက်ရှိရန် '. $user_brake_amount_all['need_amount'] .'ကျပ်လိုပါသေးသည်'
                ]);
            }

            //Thee thant brake number AM
            $am = TheeThantBrake::DigitBrake($break_twos_am,$twos,$amount);
           if($am){
                return back()->withErrors([
                     $am['closed_number'].' သည် ကန့်သတ်ထားသော ဂဏန်းဖြစ်ပါသည်
                             '.'ဤဂဏန်းသည် ကန့်သတ်ပမာဏ ရောက်ရှိရန် '.$am['need_amount'].' ကျပ်လိုပါသေးသည်'
                ])->withInput();
            }

        }else{

            //For User Amount Brake All

            $user_brake_amount_all = ForUserBrakeAmountAll::AllBrake($twos,$amount,$user_brake_amount_all_pm,new UserBrakeAmountAll);

            if ($user_brake_amount_all){
                return redirect(url('two'))->withErrors([
                    $user_brake_amount_all['two'].' သည် ကန့်သတ်ထားသော ဂဏန်းဖြစ်ပါသည်
            '.'ဤဂဏန်းသည် ကန့်သတ်ပမာဏ ရောက်ရှိရန် '. $user_brake_amount_all['need_amount'] .'ကျပ်လိုပါသေးသည်'
                ]);
            }

        // Thee thant brake number PM
            $pm = TheeThantBrake::DigitBrake($break_twos_pm,$twos,$amount);
            if($pm){
                return back()->withErrors([
                     $pm['closed_number'].' သည် ကန့်သတ်ထားသော ဂဏန်းဖြစ်ပါသည်
                             '.'ဤဂဏန်းသည် ကန့်သတ်ပမာဏ ရောက်ရှိရန် '.$pm['need_amount'].' ကျပ်လိုပါသေးသည်'
                ])->withInput();
            }
        }

        // if db has no two number exists in the thee thant number table
        $db_has_no_two_number = TheeThantBrake::NoExistDigitBrake($twos,$amount);
        if ($db_has_no_two_number){

            return back()->withErrors([
                 $db_has_no_two_number['closed_number'].'သည် ကန့်သတ်ထားသော ဂဏန်းဖြစ်ပါသည်
                         '.'ဤဂဏန်းသည် ကန့်သတ်ပမာဏ ရောက်ရှိရန် '.$db_has_no_two_number['need_amount'].' ကျပ်လိုပါသေးသည်'
            ])->withInput();
        }


        if(now()->format('Y-m-d H:i:s') < now()->format('Y-m-d') .' 12:00:00'){
            $user_brake_amount_all = ForUserBrakeAmountAll::AllBrake($reverse_two,$amount,$user_brake_amount_all_am,new UserBrakeAmountAll);

            if ($user_brake_amount_all){
                return redirect(url('two'))->withErrors([
                    $user_brake_amount_all['two'].' သည် ကန့်သတ်ထားသော ဂဏန်းဖြစ်ပါသည်
            '.'ဤဂဏန်းသည် ကန့်သတ်ပမာဏ ရောက်ရှိရန် '. $user_brake_amount_all['need_amount'] .'ကျပ်လိုပါသေးသည်'
                ]);
            }

            // R ဂဏန်းများ အတွက် brake number am

           $am_r = TheeThantBrake::DigitBrake($break_twos_am,$reverse_two,$amount);

            if($am_r){
                return back()->withErrors([
                    $am_r['closed_number'].' သည် ကန့်သတ်ထားသော ဂဏန်းဖြစ်ပါသည်
                             '.'ဤဂဏန်းသည် ကန့်သတ်ပမာဏ ရောက်ရှိရန် '.$am_r['need_amount'].' ကျပ်လိုပါသေးသည်'
                ])->withInput();
            }
        }else{
            // R ဂဏန်းများ အတွက် brake number pm

            $user_brake_amount_all = ForUserBrakeAmountAll::AllBrake($reverse_two,$amount,$user_brake_amount_all_pm,new UserBrakeAmountAll);

            if ($user_brake_amount_all){
                return redirect(url('two'))->withErrors([
                    $user_brake_amount_all['two'].' သည် ကန့်သတ်ထားသော ဂဏန်းဖြစ်ပါသည်
            '.'ဤဂဏန်းသည် ကန့်သတ်ပမာဏ ရောက်ရှိရန် '. $user_brake_amount_all['need_amount'] .'ကျပ်လိုပါသေးသည်'
                ]);
            }

            $pm_r = TheeThantBrake::DigitBrake($break_twos_pm,$reverse_two,$amount);
            if($pm_r){
                return back()->withErrors([
                    $pm_r['closed_number'].' သည် ကန့်သတ်ထားသော ဂဏန်းဖြစ်ပါသည်
                             '.'ဤဂဏန်းသည် ကန့်သတ်ပမာဏ ရောက်ရှိရန် '.$pm_r['need_amount'].' ကျပ်လိုပါသေးသည်'
                ])->withInput();
            }
        }

        // if db has no two-r number exists in the thee thant number table

        $db_has_no_two_number_r = TheeThantBrake::NoExistDigitBrake($reverse_two,$amount);

        if ($db_has_no_two_number_r){
            return back()->withErrors([
                $db_has_no_two_number_r['closed_number'].'သည် ကန့်သတ်ထားသော ဂဏန်းဖြစ်ပါသည်
                         '.'ဤဂဏန်းသည် ကန့်သတ်ပမာဏ ရောက်ရှိရန် '.$db_has_no_two_number_r['need_amount'].' ကျပ်လိုပါသေးသည်'
            ])->withInput();
        }

        return view('frontend.two.twoconfirm', compact('user_id', 'date', 'twos', 'amount', 'total', 'reverse_two', 'r_keys','r_amount'));

    }

    public function two(Request $request)
    {

        //dd($request->all());

        if (Two::where('user_id',Auth::user()->id)->exists()){
            $twos = $request->only(['two','r_two']);

            $equal2 = [];
            foreach ($twos as $two){
                foreach ($two as $t){
                    array_push($equal2,$t);
                }
            }


            $batch = Two::where('user_id',Auth::user()->id)->orderBy('batch','desc')->first();

            $equal1 = Two::where('batch',$batch->batch)->pluck('two');


            $equation = $equal1->diff($equal2);

            if ($equation->isEmpty()){
                return redirect('/two')->withErrors(['Error' => 'အရင်ထိုးခဲ့သောအကွက်များနှင့်တူနေသဖြင့်အကွက်များအားနေရာပြောင်း၍ပြန်ထိုးပါ']);
            }
        }


        $from_account_wallet = Auth()->user()->user_wallet;

        $total = 0;

        foreach ($request->amount ?? [] as $key=>$amount) {
                $total += $amount;
            }

        foreach ($request->r_amount ?? [] as $key=>$amount) {
                $total += $amount;
            }

        if ($from_account_wallet->amount < $total) {
            return redirect('/two')->withErrors(['fail' => 'You have no sufficient balance']);
        }


        DB::beginTransaction();

        $batch_id = UUIDGenerator::batch();

        try {
            foreach ($request->two as $key=>$twod) {
                $two = new Two();
                $two->user_id = Auth()->user()->id;
                $two->master_id = Auth()->user()->master_id;
                $two->admin_user_id = Auth()->user()->admin_user_id;
                $two->date = now()->format('Y-m-d');
                $two->two = $twod;
                $two->batch = $batch_id;
                $two->amount = $request->amount[$key];
                $two->save();
            }

            foreach ($request->r_two ?? [] as $key=>$twor) {
                $two = new Two();
                $two->user_id = Auth()->user()->id;
                $two->master_id = Auth()->user()->master_id;
                $two->admin_user_id = Auth()->user()->admin_user_id;
                $two->date = now()->format('Y-m-d');
                $two->two = $twor;
                $two->batch = $batch_id;
                $two->amount = $request->r_amount[$key];
                $two->save();
            }



            $from_account_wallet->decrement('amount', $total);
            $from_account_wallet->update();

            $trx_id = UUIDGenerator::TrxId();

            ForWalletAndBetHistory::Slip(new WalletHistory,Auth()->user()->admin_user_id,Auth()->user()->id,$trx_id,$total,'bet','user');

            ForWalletAndBetHistory::Slip(new BetHistory,Auth()->user()->admin_user_id,Auth()->user()->id,$trx_id,$total,'bet','2D');

            DB::commit();
            return redirect('two')->with('create', 'Done');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/two')->withErrors(['fail' => 'Something wrong']);
        }

    }



}
