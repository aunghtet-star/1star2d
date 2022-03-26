<?php

namespace App\Http\Controllers;

use App\TwoOverview;
use App\TwoOverviewPM;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RealNumberController extends Controller
{
    public function realNumber(Request $request){

        $date = $request->date ?? now()->format('Y-m-d');


        $two_transactions_total_am = TwoOverview::select('amount')->where('admin_user_id', Auth::guard('adminuser')->user()->id)->whereDate('date', $date)->sum('amount');
        $new_amount_total_am = TwoOverview::select('new_amount')->where('admin_user_id', Auth::guard('adminuser')->user()->id)->whereDate('date', $date)->sum('new_amount');


        $two_transactions_total_pm = TwoOverviewPM::select('amount')->where('admin_user_id', Auth::guard('adminuser')->user()->id)->whereDate('date', $date)->sum('amount');
        $new_amount_total_pm = TwoOverviewPM::select('new_amount')->where('admin_user_id', Auth::guard('adminuser')->user()->id)->whereDate('date', $date)->sum('new_amount');
    
        return view('backend.realnumber.index',compact('two_transactions_total_am','new_amount_total_am','two_transactions_total_pm','new_amount_total_pm'));
    }
}
