<?php

namespace App\Http\Controllers\backend;

use App\DubaiTwoKyon11am;
use App\DubaiTwoKyon1pm;
use App\DubaiTwoKyon3pm;
use App\DubaiTwoKyon5pm;
use App\DubaiTwoKyon7pm;
use App\DubaiTwoKyon9pm;
use App\DubaiTwoOverview11am;
use App\DubaiTwoOverview1pm;
use App\DubaiTwoOverview3pm;
use App\DubaiTwoOverview5pm;
use App\DubaiTwoOverview7pm;
use App\DubaiTwoOverview9pm;
use App\FakeNumber;
use App\Helpers\ForTwoKyon;
use App\Helpers\PermissionChecker;
use App\Http\Controllers\Controller;
use App\twoKyonAM;
use App\twoKyonPM;
use App\TwoOverviewPM;
use Illuminate\Http\Request;

class DubaiTwoKyonController extends Controller
{
    public function twoKyon_11am(Request $request)
    {
        PermissionChecker::CheckPermission('two_kyon');

        $date = $request->date ?? now()->format('Y-m-d');
        $two_overviews = DubaiTwoOverview11am::whereDate('date', $date)->orderBy('two','asc')->get();

        //To Store Two kyon table 11am
        ForTwoKyon::Kyon($two_overviews,$date,new DubaiTwoKyon11am);

        $two_kyons = DubaiTwoKyon11am::where('date',$date)->orderBy('two','asc')->get();

        $fake_number = FakeNumber::first();

        return view('backend.dubai_two_kyon.11am_two_kyon', compact( 'date','two_kyons','fake_number'));
    }

    public function twoKyon_1pm(Request $request)
    {
        PermissionChecker::CheckPermission('two_kyon');

        $date = $request->date ?? now()->format('Y-m-d');
        $two_overviews = DubaiTwoOverview1pm::whereDate('date', $date)->orderBy('two','asc')->get();

        //To Store Two kyon table 1pm
        ForTwoKyon::Kyon($two_overviews,$date,new DubaiTwoKyon1pm);

        $two_kyons = DubaiTwoKyon1pm::where('date',$date)->orderBy('two','asc')->get();

        $fake_number = FakeNumber::first();

        return view('backend.dubai_two_kyon.1pm_two_kyon', compact( 'date','two_kyons','fake_number'));
    }

    public function twoKyon_3pm(Request $request)
    {
        PermissionChecker::CheckPermission('two_kyon');

        $date = $request->date ?? now()->format('Y-m-d');
        $two_overviews = DubaiTwoOverview3pm::whereDate('date', $date)->orderBy('two','asc')->get();

        //To Store Two kyon table 3pm
        ForTwoKyon::Kyon($two_overviews,$date,new DubaiTwoKyon3pm);

        $two_kyons = DubaiTwoKyon3pm::where('date',$date)->orderBy('two','asc')->get();

        $fake_number = FakeNumber::first();

        return view('backend.dubai_two_kyon.3pm_two_kyon', compact( 'date','two_kyons','fake_number'));
    }

    public function twoKyon_5pm(Request $request)
    {
        PermissionChecker::CheckPermission('two_kyon');

        $date = $request->date ?? now()->format('Y-m-d');
        $two_overviews = DubaiTwoOverview5pm::whereDate('date', $date)->orderBy('two','asc')->get();

        //To Store Two kyon table 5pm
        ForTwoKyon::Kyon($two_overviews,$date,new DubaiTwoKyon5pm);

        $two_kyons = DubaiTwoKyon5pm::where('date',$date)->orderBy('two','asc')->get();

        $fake_number = FakeNumber::first();

        return view('backend.dubai_two_kyon.5pm_two_kyon', compact( 'date','two_kyons','fake_number'));
    }

    public function twoKyon_7pm(Request $request)
    {
        PermissionChecker::CheckPermission('two_kyon');

        $date = $request->date ?? now()->format('Y-m-d');
        $two_overviews = DubaiTwoOverview7pm::whereDate('date', $date)->orderBy('two','asc')->get();

        //To Store Two kyon table 7pm
        ForTwoKyon::Kyon($two_overviews,$date,new DubaiTwoKyon7pm);

        $two_kyons = DubaiTwoKyon7pm::where('date',$date)->orderBy('two','asc')->get();

        $fake_number = FakeNumber::first();

        return view('backend.dubai_two_kyon.7pm_two_kyon', compact( 'date','two_kyons','fake_number'));
    }

    public function twoKyon_9pm(Request $request)
    {
        PermissionChecker::CheckPermission('two_kyon');

        $date = $request->date ?? now()->format('Y-m-d');
        $two_overviews = DubaiTwoOverview9pm::whereDate('date', $date)->orderBy('two','asc')->get();

        //To Store Two kyon table 9pm
        ForTwoKyon::Kyon($two_overviews,$date,new DubaiTwoKyon9pm);

        $two_kyons = DubaiTwoKyon9pm::where('date',$date)->orderBy('two','asc')->get();

        $fake_number = FakeNumber::first();

        return view('backend.dubai_two_kyon.9pm_two_kyon', compact( 'date','two_kyons','fake_number'));
    }

}
