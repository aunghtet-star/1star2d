<?php

namespace App\Http\Controllers;

use App\Two;
use App\User;
use App\Three;
use Exception;
use App\Wallet;
use App\ShowHide;
use App\AdminUser;
use Carbon\Carbon;
use App\Amountbreak;
use App\Transaction;
use App\TwoOverview;
use Faker\Core\Number;
use App\AllBrakeWithAmount;
use Illuminate\Http\Request;
use App\Helpers\UUIDGenerator;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreUserTwoD;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\VarDumper\VarDumper;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $twoform = ShowHide::where('name', 'twoform')->where('admin_user_id', Auth::guard('web')->user()->admin_user_id)->first();
        
        return view('frontend.two.index', compact('twoform'));
    }

    public function twoconfirm(Request $request)
    {
        $from_account_wallet = Auth()->user()->wallet;
        $to_account = AdminUser::where('id', Auth()->user()->admin_user_id)->first();
        $to_account_wallet = Wallet::where('admin_user_id', $to_account->id)->where('status', 'admin')->first();
        
        $total = 0;
        $reverse_two = [];
        //dd($request->all());
        if (!is_null($request->r)) {
            foreach ($request->r as $r) {
                foreach ($request->two as $key=>$two) {
                    if ($key == $r) {
                        $reverse_two[] += strrev($two);
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
            
            if ($from_account_wallet->amount < $total) {
                return redirect('/')->withErrors(['fail' => 'You have no sufficient balance']);
            }
        }
        
        $user_id = Auth()->user()->id;
        $date = now()->format('Y-m-d');
        $twos = $request->two;
        $amount = $request->amount;
        $r_keys = $request->r;
        $total;

        // $breakNumbers = Amountbreak::select('closed_number')->where('type', '2D')->where('admin_user_id', Auth()->user()->admin_user_id)->get();
        // $break_twos = Two::select('two', DB::raw('SUM(amount) as total'))->whereIn('two', $breakNumbers)->where('admin_user_id', Auth()->user()->admin_user_id)->whereDate('date', now()->format('Y-m-d'))->groupBy('two')->get();
        // $allbreakwithamounttwos = Two::select('two', DB::raw('SUM(amount) as total'))->where('admin_user_id', Auth()->user()->admin_user_id)->whereDate('date', now()->format('Y-m-d'))->groupBy('two')->get();
        
        
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

        // foreach ($break_twos as $break_two) {
        //     $break_amount = Amountbreak::select('amount')->where('closed_number', $break_two->two)->where('admin_user_id', Auth()->user()->admin_user_id)->first();
        //     $break_number = Amountbreak::select('closed_number')->where('closed_number', $break_two->two)->where('admin_user_id', Auth()->user()->admin_user_id)->first();
            
        //     for ($i=0;$i<count($request->two);$i++) {
        //         if ($break_number->closed_number == $request->two[$i]) {
        //             $breakTwo = $break_two->total + $request->amount[$i];
        //             $needAmount =$break_amount->amount - $break_two->total;
        //             if ($breakTwo > $break_amount->amount) {
        //                 return back()->withErrors([
        //                     $break_number->closed_number.' သည် ကန့်သတ်ထားသော ဂဏန်းဖြစ်ပါသည်
        //                     '.'ဤဂဏန်းသည် ကန့်သတ်ပမာဏ ရောက်ရှိရန် '. $needAmount .'ကျပ်လိုပါသေးသည်'
        //                 ])->withInput();
        //             }
        //         }
        //     }
        // }


        // for ($i=0;$i<count($request->two);$i++) {
        //     $emptybreak = Amountbreak::where('closed_number', $request->two[$i])->where('type', '2D')->where('admin_user_id', Auth()->user()->admin_user_id)->first();
            
        //     if ($emptybreak) {
        //         if ($request->amount[$i] > $emptybreak->amount) {
        //             return redirect(url('two'))->withErrors([
        //                 $emptybreak->closed_number.' သည် ကန့်သတ်ထားသော ဂဏန်းဖြစ်ပါသည်
        //                 '.'ဤဂဏန်းသည် ကန့်သတ်ပမာဏ ရောက်ရှိရန် '. $emptybreak->amount .'ကျပ်လိုပါသေးသည်'
        //             ]);
        //         }
        //     }
        // }

        


        return view('frontend.two.twoconfirm', compact('user_id', 'date', 'twos', 'amount', 'total', 'reverse_two', 'r_keys'));
    }

    public function two(Request $request)
    {
        $from_account_wallet = Auth()->user()->wallet;
        $to_account = AdminUser::where('id', Auth()->user()->admin_user_id)->first();
        $to_account_wallet = Wallet::where('admin_user_id', $to_account->id)->where('status', 'admin')->first();
        $total = 0;
        
        // $reverse_two = [];
        
        
        // if (!is_null($request->r)) {
        //     foreach ($request->r as $r) {
        //         foreach ($request->two as $key=>$two) {
        //             if ($key == $r) {
        //                 $reverse_two[] += strrev($two);
        //             }
        //         }
        //     }
        // }
        //dd($request->all());


        foreach ($request->amount as $key=>$amount) {
            if (!is_null($request->r_key)) {
                foreach ($request->r_key as $r_key) {
                    if ($key == $r_key) {
                        $total += $amount;
                    }
                }
            }
            $total += $amount;
            
            if ($from_account_wallet->amount < $total) {
                return redirect('/')->withErrors(['fail' => 'You have no sufficient balance']);
            }
        }
    
        DB::beginTransaction();

        try {
            foreach ($request->two as $key=>$twod) {
                $two = new Two();
                $two->user_id = Auth()->user()->id;
                $two->admin_user_id = Auth()->user()->admin_user_id;
                $two->date = now()->format('Y-m-d');
                $two->two = $twod;
                $two->amount = $request->amount[$key];
                $two->save();
            }

            foreach ($request->r_two ?? [] as $key=>$twor) {
                $two = new Two();
                $two->user_id = Auth()->user()->id;
                $two->admin_user_id = Auth()->user()->admin_user_id;
                $two->date = now()->format('Y-m-d');
                $two->two = $twor;
                $two->amount = $request->amount[$key];
                $two->save();
            }
            
            $from_account_wallet->decrement('amount', $total);
            $from_account_wallet->update();
        
            $to_account_wallet->increment('amount', $total);
            $to_account_wallet->update();
            
            

            $ref_no = UUIDGenerator::RefNumber();

            $transactions = new Transaction();
            $transactions->ref_no = $ref_no;
            $transactions->trx_id = UUIDGenerator::TrxId();
            $transactions->user_id = Auth()->user()->id;
            $transactions->source_id = $to_account_wallet->id;
            $transactions->type = 2;
            
            $transactions->amount = $total;
            $transactions->save();
            

            $transactions = new Transaction();
            $transactions->ref_no = $ref_no;
            $transactions->trx_id = UUIDGenerator::TrxId();
            $transactions->user_id = $to_account_wallet->id;
            $transactions->source_id = Auth()->user()->id;
            $transactions->type = 1;
            
            $transactions->amount = $total;
            $transactions->save();
            DB::commit();
            return redirect('two')->with('create', 'Done');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/')->withErrors(['fail' => 'Something wrong']);
        }

        // $breakNumbers = Amountbreak::select('closed_number')->where('type', '2D')->where('admin_user_id', Auth()->user()->admin_user_id)->get();

        // $break_twos = Two::select('two', DB::raw('SUM(amount) as total'))->whereIn('two', $breakNumbers)->where('admin_user_id', Auth()->user()->admin_user_id)->whereDate('date', now()->format('Y-m-d'))->groupBy('two')->get();
        // $allbreakwithamounttwos = Two::select('two', DB::raw('SUM(amount) as total'))->where('admin_user_id', Auth()->user()->admin_user_id)->whereDate('date', now()->format('Y-m-d'))->groupBy('two')->get();
        
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

        // foreach ($break_twos as $break_two) {
        //     $break_amount = Amountbreak::select('amount')->where('closed_number', $break_two->two)->where('admin_user_id', Auth()->user()->admin_user_id)->first();
        //     $break_number = Amountbreak::select('closed_number')->where('closed_number', $break_two->two)->where('admin_user_id', Auth()->user()->admin_user_id)->first();
            
        //     for ($i=0;$i<count($request->two);$i++) {
        //         if ($break_number->closed_number == $request->two[$i]) {
        //             $breakTwo = $break_two->total + $request->amount[$i];
        //             $needAmount =$break_amount->amount - $break_two->total;
        //             if ($breakTwo > $break_amount->amount) {
        //                 return back()->withErrors([
        //                     $break_number->closed_number.' သည် ကန့်သတ်ထားသော ဂဏန်းဖြစ်ပါသည်
        //                     '.'ဤဂဏန်းသည် ကန့်သတ်ပမာဏ ရောက်ရှိရန် '. $needAmount .'ကျပ်လိုပါသေးသည်'
        //                 ]);
        //             }
        //         }
        //     }
        // }

        // for ($i=0;$i<count($request->two);$i++) {
        //     $emptybreak = Amountbreak::where('closed_number', $request->two[$i])->where('type', '2D')->where('admin_user_id', Auth()->user()->admin_user_id)->first();
            
        //     if ($emptybreak) {
        //         if ($request->amount[$i] > $emptybreak->amount) {
        //             return redirect(url('two'))->withErrors([
        //                 $emptybreak->closed_number.' သည် ကန့်သတ်ထားသော ဂဏန်းဖြစ်ပါသည်
        //                 '.'ဤဂဏန်းသည် ကန့်သတ်ပမာဏ ရောက်ရှိရန် '. $emptybreak->amount .'ကျပ်လိုပါသေးသည်'
        //             ]);
        //         }
        //     }
        // }
    }


    public function history()
    {
        return view('frontend.user.history');
    }

    public function historyTwo(Request $request)
    {
        $date = $request->date;
        $time = $request->time;
        
        if ($time == 'all') {
            $twototals = Two::where('user_id', Auth()->user()->id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'23:59:00')])->sum('amount');
            $twousers = Two::where('user_id', Auth()->user()->id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'23:59:00')])->get();
            
            $threetotals = Three::where('user_id', Auth()->user()->id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'23:59:00')])->sum('amount');
            $threeusers = Three::where('user_id', Auth()->user()->id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'23:59:00')])->get();
        }
        
        if ($time == 'true') {
            $twototals = Two::where('user_id', Auth()->user()->id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'11:59:00')])->sum('amount');
            $twousers = Two::where('user_id', Auth()->user()->id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'11:59:00')])->get();
        
            $threetotals = Three::where('user_id', Auth()->user()->id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'11:59:00')])->sum('amount');
            $threeusers = Three::where('user_id', Auth()->user()->id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'11:59:00')])->get();
        }
        
        if ($time == 'false') {
            $twototals = Two::where('user_id', Auth()->user()->id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'12:00:00'),Carbon::parse($date.' '.'23:59:00')])->sum('amount');
            $twousers = Two::where('user_id', Auth()->user()->id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'12:00:00'),Carbon::parse($date.' '.'23:59:00')])->get();
        
            $threetotals = Three::where('user_id', Auth()->user()->id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'12:00:00'),Carbon::parse($date.' '.'23:59:00')])->sum('amount');
            $threeusers = Three::where('user_id', Auth()->user()->id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'12:00:00'),Carbon::parse($date.' '.'23:59:00')])->get();
        }

        
        return view('frontend.components.history', compact('twousers', 'twototals', 'threeusers', 'threetotals'))->render();
    }
}
