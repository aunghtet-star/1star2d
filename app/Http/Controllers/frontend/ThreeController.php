<?php

namespace App\Http\Controllers\frontend;

use App\Amountbreak;
use App\Three;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ThreeController extends Controller
{
    public function index()
    {
        return view('frontend.three.index');
    }

    public function threeconfirm(Request $request)
    {
        $closed_three = Amountbreak::select('closed_number')->where('type', '3D')->get();

        $sum_three_totals =  Three::select('three', DB::raw('SUM(amount) as total'))->whereIn('three', $closed_three)->groupBy('three')->get();
        foreach ($sum_three_totals as $sum_three_total) {
            $closed_amount =  Amountbreak::select('amount')->where('closed_number', $sum_three_total->three)->first();
            
            $closed_number = Amountbreak::select('closed_number')->where('closed_number', $sum_three_total->three)->where('type', '3D')->first();
            $needAmount = $closed_amount->amount - $sum_three_total->total ;
            for ($i=0;$i<count($request->three);$i++) {
                $real_total = $sum_three_total->total + $request->amount[$i];
                if ($request->three[$i] == $closed_number->closed_number) {
                    if ($real_total > $closed_amount->amount) {
                        return back()->withErrors([
                            $closed_number->closed_number.' သည် ကန့်သတ်ထားသော ဂဏန်းဖြစ်ပါသည်
                            '.'ဤဂဏန်းသည် ကန့်သတ်ပမာဏ ရောက်ရှိရန် '. $needAmount .'ကျပ်လိုပါသေးသည်'
                        ]);
                    }
                }
            }
        }

        $threes = $request->three;
        $amount = $request->amount;
       
        return view('frontend.three.threeconfirm', compact('threes', 'amount'));
    }

    public function three(Request $request)
    {
        $closed_three = Amountbreak::select('closed_number')->where('type', '3D')->get();

        $sum_three_totals =  Three::select('three', DB::raw('SUM(amount) as total'))->whereIn('three', $closed_three)->groupBy('three')->get();
        foreach ($sum_three_totals as $sum_three_total) {
            $closed_amount =  Amountbreak::select('amount')->where('closed_number', $sum_three_total->three)->first();
            
            $closed_number = Amountbreak::select('closed_number')->where('closed_number', $sum_three_total->three)->where('type', '3D')->first();
            $needAmount = $closed_amount->amount - $sum_three_total->total ;
            for ($i=0;$i<count($request->three);$i++) {
                $real_total = $sum_three_total->total + $request->amount[$i];
                if ($request->three[$i] == $closed_number->closed_number) {
                    if ($real_total > $closed_amount->amount) {
                        return back()->withErrors([
                            $closed_number->closed_number.' သည် ကန့်သတ်ထားသော ဂဏန်းဖြစ်ပါသည်
                            '.'ဤဂဏန်းသည် ကန့်သတ်ပမာဏ ရောက်ရှိရန် '. $needAmount .'ကျပ်လိုပါသေးသည်'
                        ]);
                    }
                }
            }
        }


        foreach ($request->three as $key=>$threed) {
            $three = new Three();
            $three->user_id = Auth()->user()->id;
            $three->date = now()->format('Y-m-d');
            $three->three = $threed;
            $three->amount = $request->amount[$key];
            $three->save();
        }

        return redirect('three')->with('create', 'Done');
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
