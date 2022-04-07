<?php

namespace App\Http\Controllers\backend;

use App\TwoOverview;
use App\TwoOverviewPM;
use App\AllBrakeWithAmount;
use Illuminate\Http\Request;
use App\Helpers\PermissionChecker;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RealNumberController extends Controller
{
    public function realNumber(Request $request){

        PermissionChecker::CheckPermission('real_number');
        $date = $request->date ?? now()->format('Y-m-d');


        $two_brake = AllBrakeWithAmount::select('amount')->where('type', '2D')->first();
        $two_amount_total_am = TwoOverview::select('amount')->where('admin_user_id', Auth::guard('adminuser')->user()->id)->whereDate('date', $date)->sum('amount');
        $new_amount_total_am = TwoOverview::select('new_amount')->where('admin_user_id', Auth::guard('adminuser')->user()->id)->whereDate('date', $date)->sum('new_amount');
        $kyon_amount_total_am = TwoOverview::select('kyon_amount')->where('admin_user_id', Auth::guard('adminuser')->user()->id)->whereDate('date', $date)->sum('kyon_amount');

        $two_amount_total_pm = TwoOverviewPM::select('amount')->where('admin_user_id', Auth::guard('adminuser')->user()->id)->whereDate('date', $date)->sum('amount');
        $new_amount_total_pm = TwoOverviewPM::select('new_amount')->where('admin_user_id', Auth::guard('adminuser')->user()->id)->whereDate('date', $date)->sum('new_amount');
        $kyon_amount_total_pm = TwoOverviewPM::select('kyon_amount')->where('admin_user_id', Auth::guard('adminuser')->user()->id)->whereDate('date', $date)->sum('kyon_amount');
    
        return view('backend.realnumber.index',compact('two_amount_total_am','new_amount_total_am','kyon_amount_total_am','two_amount_total_pm','new_amount_total_pm','kyon_amount_total_pm','two_brake'));
    }
}
