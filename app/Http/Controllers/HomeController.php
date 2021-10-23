<?php

namespace App\Http\Controllers;

use App\Two;
use App\Three;
use Carbon\Carbon;
use App\TwoOverview;
use Faker\Core\Number;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreUserTwoD;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('frontend.two.index');
    }

    public function two(Request $request)
    {
        foreach ($request->two as $key=>$twod) {
            $two = new Two();
            $two->user_id = Auth()->user()->id;
            $two->date = now()->format('Y-m-d');
            $two->two = $twod;
            $two->amount = $request->amount[$key];
            $two->save();
        }

       
        
        // $two_overview = TwoOverview::where('two', $request->two)->exists();
        // if ($two_overview) {
        //     $total = Two::where('two', $request->two)->get();
        
        //     $total = $total->pluck('amount')->toArray();
    
        //     $total = array_sum($total);
            
        //     TwoOverview::where('two', $request->two)->update([
        //         'amount' => $total
        //    ]);
        // } else {
        //     $two_overview = new TwoOverview();
        //     $two_overview->two = $request->two;
        //     $two_overview->amount = $request->amount;
        //     $two_overview->save();
        // }

        return back()->with('create', 'Done');
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
