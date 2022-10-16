<?php

namespace App\Http\Controllers\backend;

use App\Helpers\ForTwoKyon;
use App\Helpers\ForTwoOverview;
use App\Two;
use App\twoKyonAM;
use App\User;

use stdClass;
use Carbon\Carbon;
use App\FakeNumber;
use App\TwoOverview;
use App\TwoOverviewPM;
use Carbon\CarbonPeriod;
use App\AllBrakeWithAmount;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTwo;
use App\Http\Requests\UpdateTwo;
use Yajra\Datatables\Datatables;
use App\Helpers\PermissionChecker;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\twoKyonPM;

class TwoController extends Controller
{
    public function index()
    {
        PermissionChecker::CheckPermission('two');
        return view('backend.two.index');
    }

    public function ssd()
    {
        if(Auth::guard('adminuser')->user()->hasRole('Admin')){
            $twos = Two::query();
        }else{
            $twos = Two::where('admin_user_id', Auth::guard('adminuser')->user()->id)->limit(10);
        }
        return Datatables::of($twos)
        ->addColumn('name', function ($each) {
            return $each->users ? $each->users->name : '_';
        })
        ->editColumn('updated_at', function ($each) {
            return Carbon::parse($each->updated_at)->format('d-m-Y H:i:s A');
        })
        ->addColumn('action', function ($each) {
            $edit_icon = '<a href="'.url('admin/two/'.$each->id.'/edit').'" class="text-warning"><i class="fas fa-user-edit"></i></a>';
            //$delete_icon = '<a href="'.url('admin/two/'.$each->id).'" data-id="'.$each->id.'" data-two="'.$each->two.'" data-amount="'.$each->amount.'" class="text-danger" id="delete"><i class="fas fa-trash"></i></a>';


            return '<div class="action-icon">'.$edit_icon .'</div>';
        })
        ->make(true);
    }

    public function create()
    {
        PermissionChecker::CheckPermission('two');
        $users = User::query();
        return view('backend.two.create', compact('users'));
    }

    public function store(StoreTwo $request)
    {
        $number = new Two();
        $number->user_id = $request->user_id;
        $number->admin_user_id = Auth::guard('adminuser')->user()->id;
        $number->date = now();
        $number->two = $request->two;
        $number->amount = $request->amount;
        $number->save();

        return redirect('admin/two')->with('create', 'Created Successfully');
    }

    public function edit($id)
    {
        PermissionChecker::CheckPermission('two');
        $number = Two::findOrFail($id);
        $users = User::where('admin_user_id', Auth::guard('adminuser')->user()->id)->get();

        return view('backend.two.edit', compact('number', 'users'));
    }

    public function update(UpdateTwo $request, $id)
    {
        $number = Two::findOrFail($id);

        $number->user_id = $request->user_id;
        $number->admin_user_id = Auth::guard('adminuser')->user()->id;
        $number->date = now();
        $number->two = $request->two;
        $number->amount = $request->amount;
        $number->update();

        return redirect('admin/two')->with('update', 'Updated Successfully');
    }

    public function destroy($id)
    {
        $number = Two::findOrFail($id);
        $number->delete();

        return 'success';
    }

    public function twoHistoryAM(Request $request)
    {
        PermissionChecker::CheckPermission('two_overview');
        $date = $request->date ?? now()->format('Y-m-d');

        $two_brake = AllBrakeWithAmount::select('amount')->where('type','2D')->first();

        $twos = Two::select('two', DB::raw('SUM(amount) as total'))->groupBy('two')->groupBy('two')->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'11:59:00')])->limit(10);

        ForTwoOverview::Overview($twos,$date,new TwoOverview);

        //to store two overview table if exist to update
        $two_overviews_am = TwoOverview::whereDate('date', $date)->orderBy('two','asc')->get();

        //TwoOverview Total Amount for am
        $overview_total = ForTwoOverview::OverviewTotal(new TwoOverview,$date);

        $amount_total = $overview_total['amount'];
        $new_amount_total = $overview_total['new_amount'];
        $kyon_amount_total = $overview_total['kyon_amount'];

        $fake_number = FakeNumber::first();

        return view('backend.two_overview.am_history', compact('date','two_overviews_am', 'amount_total','new_amount_total', 'kyon_amount_total', 'two_brake','fake_number'));
    }

    public function twoHistoryPM(Request $request)
    {
        PermissionChecker::CheckPermission('two_overview');

        $date = $request->date ?? now()->format('Y-m-d');

        $two_brake = AllBrakeWithAmount::select('amount')->where('type','2D')->first();

        $twos = Two::select('two', DB::raw('SUM(amount) as total'))->groupBy('two')->groupBy('two')->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'12:00:00'),Carbon::parse($date.' '.'23:59:00')])->limit(10);

        //to store two overview table if exist to update
        ForTwoOverview::Overview($twos,$date,new TwoOverviewPM);

        $two_overviews_pm = TwoOverviewPM::whereDate('date', $date)->orderBy('two','asc')->get();

        //TwoOverview Total Amount for pm
        $overview_total = ForTwoOverview::OverviewTotal(new TwoOverviewPM,$date);

        $amount_total = $overview_total['amount'];
        $new_amount_total = $overview_total['new_amount'];
        $kyon_amount_total = $overview_total['kyon_amount'];

        $fake_number = FakeNumber::first();

        return view('backend.two_overview.pm_history', compact('two_overviews_pm', 'amount_total','new_amount_total','kyon_amount_total', 'date', 'two_brake','fake_number'));
    }


    public function twoKyonAM(Request $request)
    {
        PermissionChecker::CheckPermission('two_kyon');

        $date = $request->date ?? now()->format('Y-m-d');
        $two_overviews_am = TwoOverview::whereDate('date', $date)->orderBy('two','asc')->get();

        //To Store Two kyon table am
       ForTwoKyon::Kyon($two_overviews_am,$date,new twoKyonAM);

        $two_kyons_am = twoKyonAM::where('date',$date)->orderBy('two','asc')->get();

        $fake_number = FakeNumber::first();

        return view('backend.two_overview.am_twokyon', compact( 'date','two_kyons_am','fake_number'));
    }

    public function twoKyonPM(Request $request)
    {
        PermissionChecker::CheckPermission('two_kyon');

        $date = $request->date ?? now()->format('Y-m-d');

        $two_overviews_pm = TwoOverviewPM::whereDate('date', $date)->orderBy('two','asc')->get();

        //To Store Two kyon table am
        ForTwoKyon::Kyon($two_overviews_pm,$date,new twoKyonPM);

        $two_kyons_pm = twoKyonPM::where('date',$date)->orderBy('two','asc')->get();


        $fake_number = FakeNumber::first();

        return view('backend.two_overview.pm_twokyon', compact('two_overviews_pm', 'date','two_kyons_pm','fake_number'));
    }
}
