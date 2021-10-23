<?php

namespace App\Http\Controllers\frontend;

use App\Three;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ThreeController extends Controller
{
    public function index()
    {
        return view('frontend.three.index');
    }

    public function three(Request $request)
    {
        foreach ($request->three as $key=>$threed) {
            $three = new Three();
            $three->user_id = Auth()->user()->id;
            $three->date = now()->format('Y-m-d');
            $three->three = $threed;
            $three->amount = $request->amount[$key];
            $three->save();
        }

       
        
        // $three_overview = threeOverview::where('three', $request->three)->exists();
        // if ($three_overview) {
        //     $total = three::where('three', $request->three)->get();
        
        //     $total = $total->pluck('amount')->toArray();
    
        //     $total = array_sum($total);
            
        //     threeOverview::where('three', $request->three)->update([
        //         'amount' => $total
        //    ]);
        // } else {
        //     $three_overview = new threeOverview();
        //     $three_overview->three = $request->three;
        //     $three_overview->amount = $request->amount;
        //     $three_overview->save();
        // }

        return back()->with('create', 'Done');
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
