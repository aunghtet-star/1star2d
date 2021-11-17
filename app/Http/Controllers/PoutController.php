<?php

namespace App\Http\Controllers;

use App\Two;
use App\Three;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PoutController extends Controller
{
    public function twoPout(Request $request, $two)
    {
        $twopouts = Two::select('user_id', DB::raw('SUM(amount) as total'))->groupBy('user_id')->where('two', $two)->where('admin_user_id', Auth::guard('adminuser')->user()->id)->whereDate('date', $request->date)->get();
        return view('backend.two_overview.twopout', compact('twopouts'));
    }

    public function threePout(Request $request, $three)
    {
        $threepouts = Three::select('user_id', DB::raw('SUM(amount) as total'))->groupBy('user_id')->where('three', $three)->where('admin_user_id', Auth::guard('adminuser')->user()->id)->whereBetween('date', [$request->from,$request->to])->get();
        return view('backend.three_overview.threepout', compact('threepouts'));
    }
}
