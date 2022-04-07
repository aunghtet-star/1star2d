<?php

namespace App\Http\Controllers\frontend;

use App\Three;
use App\Wallet;
use App\ShowHide;
use App\AdminUser;
use Carbon\Carbon;
use App\BetHistory;
use App\Amountbreak;
use App\Transaction;
use App\WalletHistory;
use App\AllBrakeWithAmount;
use Illuminate\Http\Request;
use App\Helpers\UUIDGenerator;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ThreeController extends Controller
{
    public function index()
    {
        $threeform = ShowHide::where('name', 'threeform')->first();

        return view('frontend.three.index', compact('threeform'));
    }

    public function threeconfirm(Request $request)
    {
        $closed_three = Amountbreak::select('closed_number')->where('type', '3D')->where('admin_user_id', Auth()->user()->admin_user_id)->get();

        $from_account_wallet = Auth()->user()->user_wallet;
        $to_account = AdminUser::where('id', Auth()->user()->admin_user_id)->first();
        $to_account_wallet = Wallet::where('admin_user_id', $to_account->id)->where('status', 'admin')->first();
        $total = 0;

        foreach ($request->amount as $amount) {
            $total += $amount;
            if ($from_account_wallet->amount < $total) {
                return redirect('/three')->withErrors(['fail' => 'You have no sufficient balance']);
            }
        }

        // $sum_three_totals =  Three::select('three', DB::raw('SUM(amount) as total'))->where('admin_user_id', Auth()->user()->admin_user_id)->whereIn('three', $closed_three)->groupBy('three')->get();
        
        // $allbreakwithamountthrees = Three::select('three', DB::raw('SUM(amount) as total'))->where('admin_user_id', Auth()->user()->admin_user_id)->groupBy('three')->get();
       
        // foreach ($allbreakwithamountthrees as $allbreakwithamountthree) {
        //     $allBreakWithAmount = AllBrakeWithAmount::select('amount')->where('type', '3D')->where('admin_user_id', Auth()->user()->admin_user_id)->first();
            
        //     if ($allBreakWithAmount) {
        //         for ($i=0;$i<count($request->three);$i++) {
        //             if ($allbreakwithamountthree->three == $request->three[$i]) {
        //                 $need =  $allbreakwithamountthree->total+ $request->amount[$i];
        //                 $lo_at_amount = $allBreakWithAmount->amount - $allbreakwithamountthree->total;
                        
        //                 if ($need >  $allBreakWithAmount->amount) {
        //                     return redirect(url('three'))->withErrors([
        //                     $request->three[$i].' သည် ကန့်သတ်ထားသော ဂဏန်းဖြစ်ပါသည်
        //                     '.'ဤဂဏန်းသည် ကန့်သတ်ပမာဏ ရောက်ရှိရန် '. $lo_at_amount .'ကျပ်လိုပါသေးသည်'
        //                 ]);
        //                 }
        //             }
        //         }
        //     }
        // }

        // for ($i=0;$i<count($request->three);$i++) {
        //     $emptybreak = AllBrakeWithAmount::where('type', '3D')->where('admin_user_id', Auth()->user()->admin_user_id)->first();
            
        //     if ($emptybreak) {
        //         if ($request->amount[$i] > $emptybreak->amount) {
        //             return redirect(url('three'))->withErrors([
        //                 $request->three[$i].' သည် ကန့်သတ်ထားသော ဂဏန်းဖြစ်ပါသည်
        //                 '.'ဤဂဏန်းသည် ကန့်သတ်ပမာဏ ရောက်ရှိရန် '.$emptybreak->amount .'ကျပ်လိုပါသေးသည်'
        //             ]);
        //         }
        //     }
        // }

        // foreach ($sum_three_totals as $sum_three_total) {
        //     $closed_amount =  Amountbreak::select('amount')->where('closed_number', $sum_three_total->three)->where('admin_user_id', Auth()->user()->admin_user_id)->first();
            
        //     $closed_number = Amountbreak::select('closed_number')->where('closed_number', $sum_three_total->three)->where('type', '3D')->where('admin_user_id', Auth()->user()->admin_user_id)->first();
        //     $needAmount = $closed_amount->amount - $sum_three_total->total ;
        //     for ($i=0;$i<count($request->three);$i++) {
        //         $real_total = $sum_three_total->total + $request->amount[$i];
        //         if ($request->three[$i] == $closed_number->closed_number) {
        //             if ($real_total > $closed_amount->amount) {
        //                 return back()->withErrors([
        //                     $closed_number->closed_number.' သည် ကန့်သတ်ထားသော ဂဏန်းဖြစ်ပါသည်
        //                     '.'ဤဂဏန်းသည် ကန့်သတ်ပမာဏ ရောက်ရှိရန် '. $needAmount .'ကျပ်လိုပါသေးသည်'
        //                 ]);
        //             }
        //         }
        //     }
        // }

        // for ($i=0;$i<count($request->three);$i++) {
        //     $emptybreak = Amountbreak::where('closed_number', $request->three[$i])->where('type', '3D')->where('admin_user_id', Auth()->user()->admin_user_id)->first();
            
        //     if ($emptybreak) {
        //         if ($request->amount[$i] > $emptybreak->amount) {
        //             return redirect(url('three'))->withErrors([
        //                 $emptybreak->closed_number.' သည် ကန့်သတ်ထားသော ဂဏန်းဖြစ်ပါသည်
        //                 '.'ဤဂဏန်းသည် ကန့်သတ်ပမာဏ ရောက်ရှိရန် '.$emptybreak->amount .'ကျပ်လိုပါသေးသည်'
        //             ]);
        //         }
        //     }
        // }
        
        $threes = $request->three;
        $amount = $request->amount;
       
        return view('frontend.three.threeconfirm', compact('threes', 'amount'));
    }

    public function three(Request $request)
    {
        // $closed_three = Amountbreak::select('closed_number')->where('type', '3D')->where('admin_user_id', Auth()->user()->admin_user_id)->get();

        // $sum_three_totals =  Three::select('three', DB::raw('SUM(amount) as total'))->where('admin_user_id', Auth()->user()->admin_user_id)->whereIn('three', $closed_three)->groupBy('three')->get();
        // foreach ($sum_three_totals as $sum_three_total) {
        //     $closed_amount =  Amountbreak::select('amount')->where('closed_number', $sum_three_total->three)->where('admin_user_id', Auth()->user()->admin_user_id)->first();
            
        //     $closed_number = Amountbreak::select('closed_number')->where('closed_number', $sum_three_total->three)->where('type', '3D')->where('admin_user_id', Auth()->user()->admin_user_id)->first();
        //     $needAmount = $closed_amount->amount - $sum_three_total->total ;
        //     for ($i=0;$i<count($request->three);$i++) {
        //         $real_total = $sum_three_total->total + $request->amount[$i];
        //         if ($request->three[$i] == $closed_number->closed_number) {
        //             if ($real_total > $closed_amount->amount) {
        //                 return back()->withErrors([
        //                     $closed_number->closed_number.' သည် ကန့်သတ်ထားသော ဂဏန်းဖြစ်ပါသည်
        //                     '.'ဤဂဏန်းသည် ကန့်သတ်ပမာဏ ရောက်ရှိရန် '. $needAmount .'ကျပ်လိုပါသေးသည်'
        //                 ]);
        //             }
        //         }
        //     }
        // }

        // for ($i=0;$i<count($request->three);$i++) {
        //     $emptybreak = Amountbreak::where('closed_number', $request->three[$i])->where('type', '3D')->where('admin_user_id', Auth()->user()->admin_user_id)->first();
            
        //     if ($emptybreak) {
        //         if ($request->amount[$i] > $emptybreak->amount) {
        //             return redirect(url('three'))->withErrors([
        //                 $emptybreak->closed_number.' သည် ကန့်သတ်ထားသော ဂဏန်းဖြစ်ပါသည်
        //                 '.'ဤဂဏန်းသည် ကန့်သတ်ပမာဏ ရောက်ရှိရန် '.$emptybreak->amount .'ကျပ်လိုပါသေးသည်'
        //             ]);
        //         }
        //     }
        // }

        $from_account_wallet = Auth()->user()->user_wallet;
        $to_account = AdminUser::where('id', Auth()->user()->admin_user_id)->first();
        $to_account_wallet = Wallet::where('admin_user_id', $to_account->id)->where('status', 'admin')->first();
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

            $history = new WalletHistory();
            $history->admin_user_id = Auth()->user()->admin_user_id;
            $history->user_id = Auth()->user()->id;
            $history->trx_id = UUIDGenerator::TrxId();
            $history->amount = $total;
            $history->is_deposit = 'bet';
            $history->status = 'user';
            $history->date = now()->format('Y-m-d H:i:s');
            $history->save();

            $bet_history = new BetHistory();
            $bet_history->admin_user_id = Auth()->user()->admin_user_id;
            $bet_history->user_id = Auth()->user()->id;
            $bet_history->trx_id = UUIDGenerator::TrxId();
            $bet_history->is_deposit = 'bet';
            $bet_history->type = '3D';
            $bet_history->amount = $total;
            $bet_history->date =  now()->format('Y-m-d H:i:s');
            $bet_history->save();

            // $ref_no = UUIDGenerator::RefNumber();

            // $transactions = new Transaction();
            // $transactions->ref_no = $ref_no;
            // $transactions->trx_id = UUIDGenerator::TrxId();
            // $transactions->user_id = Auth()->user()->id;
            // $transactions->source_id = $to_account_wallet->id;
            // $transactions->type = 2;
            // $total = 0;
            // foreach ($request->amount as $amount) {
            //     $total+= $amount;
            // }
            // $transactions->amount = $total;
            // $transactions->save();
            

            // $transactions = new Transaction();
            // $transactions->ref_no = $ref_no;
            // $transactions->trx_id = UUIDGenerator::TrxId();
            // $transactions->user_id = $to_account_wallet->id;
            // $transactions->source_id = Auth()->user()->id;
            // $transactions->type = 1;
            // $total = 0;
            // foreach ($request->amount as $amount) {
            //     $total+= $amount;
            // }
            // $transactions->amount = $total;
            // $transactions->save();
            
            DB::commit();
            return redirect('three')->with('create', 'Done');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/three')->withErrors(['fail' => 'Something wrong']);
        }
    }

    public function history()
    {
        return view('frontend.three.history');
    }

    public function historyThree(Request $request)
    {
        $date = $request->date;
        $time = $request->time;
        
        if ($time == 'all') {
            $threetotals = Three::where('user_id', Auth()->user()->id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'23:59:00')])->sum('amount');
            $users = Three::where('user_id', Auth()->user()->id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'23:59:00')])->get();
        }
        
        if ($time == 'true') {
            $threetotals = Three::where('user_id', Auth()->user()->id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'11:59:00')])->sum('amount');
            $users = Three::where('user_id', Auth()->user()->id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'11:59:00')])->get();
        }
        
        if ($time == 'false') {
            $threetotals = Three::where('user_id', Auth()->user()->id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'12:00:00'),Carbon::parse($date.' '.'23:59:00')])->sum('amount');
            $users = Three::where('user_id', Auth()->user()->id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'12:00:00'),Carbon::parse($date.' '.'23:59:00')])->get();
        }

        
        return view('frontend.components.history', compact('users', 'threetotals'))->render();
    }
}
