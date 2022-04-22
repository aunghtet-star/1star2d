<?php

namespace App\Http\Controllers\backend;

use App\AllBrakeWithAmount;
use App\DubaiTwo;
use App\DubaiTwoOverview11am;
use App\DubaiTwoOverview1pm;
use App\DubaiTwoOverview3pm;
use App\DubaiTwoOverview5pm;
use App\DubaiTwoOverview7pm;
use App\DubaiTwoOverview9pm;
use App\FakeNumber;
use App\Helpers\ForTwoOverview;
use App\Helpers\PermissionChecker;
use App\Http\Controllers\Controller;
use App\TwoOverviewPM;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DubaiTwoOverviewController extends Controller
{
    public function twoOverview_11am(Request $request)
    {
        PermissionChecker::CheckPermission('two_overview');
        $date = $request->date ?? now()->format('Y-m-d');

        $two_brake = AllBrakeWithAmount::select('amount')->first();

        $twos = DubaiTwo::select('two', DB::raw('SUM(amount) as total'))->groupBy('two')->groupBy('two')->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'10:59:00')])->get();

        ForTwoOverview::Overview($twos,$date,new DubaiTwoOverview11am);

        //to store two overview table if exist to update
        $two_overviews = DubaiTwoOverview11am::whereDate('date', $date)->orderBy('two','asc')->get();

        //TwoOverview Total Amount for am
        $overview_total = ForTwoOverview::OverviewTotal(new DubaiTwoOverview11am,$date);

        $amount_total = $overview_total['amount'];
        $new_amount_total = $overview_total['new_amount'];
        $kyon_amount_total = $overview_total['kyon_amount'];

        $fake_number = FakeNumber::first();

        return view('backend.dubai_two_overview.11am_overview', compact('date','two_overviews', 'amount_total','new_amount_total', 'kyon_amount_total', 'two_brake','fake_number'));
    }

    public function twoOverview_1pm(Request $request)
    {
        PermissionChecker::CheckPermission('two_overview');

        $date = $request->date ?? now()->format('Y-m-d');

        $two_brake = AllBrakeWithAmount::select('amount')->first();

        $twos = DubaiTwo::select('two', DB::raw('SUM(amount) as total'))->groupBy('two')->groupBy('two')->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'11:00:00'),Carbon::parse($date.' '.'12:59:00')])->get();

        //to store two overview table if exist to update
        ForTwoOverview::Overview($twos,$date,new DubaiTwoOverview1pm);

        $two_overviews = DubaiTwoOverview1pm::whereDate('date', $date)->orderBy('two','asc')->get();

        //TwoOverview Total Amount for pm
        $overview_total = ForTwoOverview::OverviewTotal(new DubaiTwoOverview1pm,$date);

        $amount_total = $overview_total['amount'];
        $new_amount_total = $overview_total['new_amount'];
        $kyon_amount_total = $overview_total['kyon_amount'];

        $fake_number = FakeNumber::first();

        return view('backend.dubai_two_overview.1pm_overview', compact('two_overviews', 'amount_total','new_amount_total','kyon_amount_total', 'date', 'two_brake','fake_number'));
    }

    public function twoOverview_3pm(Request $request)
    {
        PermissionChecker::CheckPermission('two_overview');

        $date = $request->date ?? now()->format('Y-m-d');

        $two_brake = AllBrakeWithAmount::select('amount')->first();

        $twos = DubaiTwo::select('two', DB::raw('SUM(amount) as total'))->groupBy('two')->groupBy('two')->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'13:00:00'),Carbon::parse($date.' '.'14:59:00')])->get();

        //to store two overview table if exist to update
        ForTwoOverview::Overview($twos,$date,new DubaiTwoOverview3pm);

        $two_overviews = DubaiTwoOverview3pm::whereDate('date', $date)->orderBy('two','asc')->get();

        //TwoOverview Total Amount for pm
        $overview_total = ForTwoOverview::OverviewTotal(new DubaiTwoOverview3pm,$date);

        $amount_total = $overview_total['amount'];
        $new_amount_total = $overview_total['new_amount'];
        $kyon_amount_total = $overview_total['kyon_amount'];

        $fake_number = FakeNumber::first();

        return view('backend.dubai_two_overview.3pm_overview', compact('two_overviews', 'amount_total','new_amount_total','kyon_amount_total', 'date', 'two_brake','fake_number'));
    }

    public function twoOverview_5pm(Request $request)
    {
        PermissionChecker::CheckPermission('two_overview');

        $date = $request->date ?? now()->format('Y-m-d');

        $two_brake = AllBrakeWithAmount::select('amount')->first();

        $twos = DubaiTwo::select('two', DB::raw('SUM(amount) as total'))->groupBy('two')->groupBy('two')->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'15:00:00'),Carbon::parse($date.' '.'16:59:00')])->get();

        //to store two overview table if exist to update
        ForTwoOverview::Overview($twos,$date,new DubaiTwoOverview5pm);

        $two_overviews = DubaiTwoOverview5pm::whereDate('date', $date)->orderBy('two','asc')->get();

        //TwoOverview Total Amount for pm
        $overview_total = ForTwoOverview::OverviewTotal(new DubaiTwoOverview5pm,$date);

        $amount_total = $overview_total['amount'];
        $new_amount_total = $overview_total['new_amount'];
        $kyon_amount_total = $overview_total['kyon_amount'];

        $fake_number = FakeNumber::first();

        return view('backend.dubai_two_overview.5pm_overview', compact('two_overviews', 'amount_total','new_amount_total','kyon_amount_total', 'date', 'two_brake','fake_number'));
    }

    public function twoOverview_7pm(Request $request)
    {
        PermissionChecker::CheckPermission('two_overview');

        $date = $request->date ?? now()->format('Y-m-d');

        $two_brake = AllBrakeWithAmount::select('amount')->first();

        $twos = DubaiTwo::select('two', DB::raw('SUM(amount) as total'))->groupBy('two')->groupBy('two')->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'17:00:00'),Carbon::parse($date.' '.'18:59:00')])->get();

        //to store two overview table if exist to update
        ForTwoOverview::Overview($twos,$date,new DubaiTwoOverview7pm);

        $two_overviews = DubaiTwoOverview7pm::whereDate('date', $date)->orderBy('two','asc')->get();

        //TwoOverview Total Amount for pm
        $overview_total = ForTwoOverview::OverviewTotal(new DubaiTwoOverview7pm,$date);

        $amount_total = $overview_total['amount'];
        $new_amount_total = $overview_total['new_amount'];
        $kyon_amount_total = $overview_total['kyon_amount'];

        $fake_number = FakeNumber::first();

        return view('backend.dubai_two_overview.7pm_overview', compact('two_overviews', 'amount_total','new_amount_total','kyon_amount_total', 'date', 'two_brake','fake_number'));
    }

    public function twoOverview_9pm(Request $request)
    {
        PermissionChecker::CheckPermission('two_overview');

        $date = $request->date ?? now()->format('Y-m-d');

        $two_brake = AllBrakeWithAmount::select('amount')->first();

        $twos = DubaiTwo::select('two', DB::raw('SUM(amount) as total'))->groupBy('two')->groupBy('two')->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'19:00:00'),Carbon::parse($date.' '.'23:59:00')])->get();

        //to store two overview table if exist to update
        ForTwoOverview::Overview($twos,$date,new DubaiTwoOverview9pm);

        $two_overviews = DubaiTwoOverview9pm::whereDate('date', $date)->orderBy('two','asc')->get();

        //TwoOverview Total Amount for pm
        $overview_total = ForTwoOverview::OverviewTotal(new DubaiTwoOverview9pm,$date);

        $amount_total = $overview_total['amount'];
        $new_amount_total = $overview_total['new_amount'];
        $kyon_amount_total = $overview_total['kyon_amount'];

        $fake_number = FakeNumber::first();

        return view('backend.dubai_two_overview.9pm_overview', compact('two_overviews', 'amount_total','new_amount_total','kyon_amount_total', 'date', 'two_brake','fake_number'));
    }
}
