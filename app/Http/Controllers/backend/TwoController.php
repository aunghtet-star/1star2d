<?php

namespace App\Http\Controllers\backend;

use App\Two;
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

        $two_brake = AllBrakeWithAmount::select('amount')->first();
      
        $twos = Two::select('two', DB::raw('SUM(amount) as total'))->groupBy('two')->groupBy('two')->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'11:59:00')])->get();
        
        foreach($twos as $two){
            $exist = TwoOverview::where('two',$two->two)->where('date',$date)->exists();
            if($exist){
                $two_overviews = TwoOverview::where('two',$two->two);
                $two_overviews = $two_overviews->update([
                    'amount' => $two->total
                ]);
            }else{
            $two_overviews = new TwoOverview();
            $two_overviews->admin_user_id = Auth::guard('adminuser')->user()->id;
            $two_overviews->two =  $two->two;
            $two_overviews->amount = $two->total;
            $two_overviews->date = $date;
            $two_overviews->save();
            }
        }

        $two_overviews_am = TwoOverview::whereDate('date', $date)->orderBy('two','asc')->get();

        $two_amount_total = TwoOverview::select('amount')->whereDate('date', $date)->sum('amount');
        $new_amount_total = TwoOverview::select('new_amount')->whereDate('date', $date)->sum('new_amount');
        $kyon_amount_total = TwoOverviewPM::select('kyon_amount')->whereDate('date', $date)->sum('kyon_amount');

        $fake_number = FakeNumber::first();
        
        return view('backend.two_overview.am_history', compact('two_overviews_am', 'two_amount_total','new_amount_total', 'kyon_amount_total', 'two_brake','fake_number'));
    }

    public function twoHistoryPM(Request $request)
    {
        PermissionChecker::CheckPermission('two_overview');

        $date = $request->date ?? now()->format('Y-m-d');
        
        $two_brake = AllBrakeWithAmount::select('amount')->first();
        
        $twos = Two::select('two', DB::raw('SUM(amount) as total'))->groupBy('two')->groupBy('two')->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'12:00:00'),Carbon::parse($date.' '.'23:59:00')])->get();
        

        foreach($twos as $two_transaction){
            $exist = TwoOverviewPM::where('two',$two_transaction->two)->where('date',$date)->exists();
            if($exist){
                $two_overviews = TwoOverviewPM::where('two',$two_transaction->two);
                $two_overviews = $two_overviews->update([
                    'amount' => $two_transaction->total
                ]);
            }else{
            $two_overviews = new TwoOverviewPM();
            $two_overviews->admin_user_id = Auth::guard('adminuser')->user()->id;
            $two_overviews->two =  $two_transaction->two;
            $two_overviews->amount = $two_transaction->total;
            $two_overviews->date = $date;
            $two_overviews->save();
            }
        }

        $two_overviews_pm = TwoOverviewPM::whereDate('date', $date)->orderBy('two','asc')->get();

        $two_amount_total = TwoOverviewPM::select('amount')->whereDate('date', $date)->sum('amount');
        $new_amount_total = TwoOverviewPM::select('new_amount')->whereDate('date', $date)->sum('new_amount');
        $kyon_amount_total = TwoOverviewPM::select('kyon_amount')->whereDate('date', $date)->sum('kyon_amount');
        
        
        

        $fake_number = FakeNumber::first();

        return view('backend.two_overview.pm_history', compact('two_overviews_pm', 'two_amount_total','new_amount_total','kyon_amount_total', 'date', 'two_brake','fake_number'));
    }


    public function twoKyonAM(Request $request)
    {
        PermissionChecker::CheckPermission('two_kyon');

        $date = $request->date ?? now()->format('Y-m-d');
        $two_overviews_am = TwoOverview::whereDate('date', $date)->orderBy('two','asc')->get();
        
        $two_brake = AllBrakeWithAmount::select('amount')->where('type', '2D')->first();

        //for Two kyon table am
        foreach($two_overviews_am as $two_overview_am){
            $two_kyon_am = ($two_overview_am->amount - $two_overview_am->new_amount) - $two_brake->amount;
        
            $exist = twoKyonAM::where('two',$two_overview_am->two)->where('date',$date)->exists();
            if($exist){
                $two_kyons_am = twoKyonAM::where('two',$two_overview_am->two);
                $two_kyons_am = $two_kyons_am->update([
                    'amount' => $two_overview_am->amount > $two_brake->amount ? ($two_overview_am->amount - $two_brake->amount) : 0,
                    'new_amount' => $two_overview_am->new_amount
                ]);
            }else{
            $two_kyons_am = new twoKyonAM();
            $two_kyons_am->admin_user_id = Auth::guard('adminuser')->user()->id;
            $two_kyons_am->two =  $two_overview_am->two;
            $two_kyons_am->new_amount =  $two_overview_am->new_amount;
            $two_kyons_am->amount = $two_overview_am->amount > $two_brake->amount ? ($two_overview_am->amount - $two_brake->amount) : 0;
            $two_kyons_am->date = $date;
            $two_kyons_am->save();
        
        }

    }
        
        $two_kyons_am = twoKyonPM::where('date',$date)->get();
        $two_kyons_am_total = twoKyonPM::select('amount')->where('date',$date)->sum('amount');
        $two_kyons_new_amount_am_total = twoKyonPM::select('new_amount')->where('date',$date)->sum('new_amount');
        $two_kyons_new_kyon_am_total = twoKyonPM::select('new_kyon_amount')->where('date',$date)->sum('new_kyon_amount');
        
        $fake_number = FakeNumber::first();

        return view('backend.two_overview.am_twokyon', compact('two_overviews_am', 'date', 'two_brake','two_kyons_am','two_kyons_am_total','two_kyons_new_kyon_am_total','two_kyons_new_amount_am_total','fake_number'));
    }

    public function twoKyonPM(Request $request)
    {
        PermissionChecker::CheckPermission('two_kyon');
        
        $date = $request->date ?? now()->format('Y-m-d');

        $two_overviews_pm = TwoOverviewPM::whereDate('date', $date)->orderBy('two','asc')->get();
        $two_brake = AllBrakeWithAmount::select('amount')->where('type', '2D')->first();
        
        //for Two kyon table pm

        foreach($two_overviews_pm as $two_overview_pm){
            $two_kyon_pm = ($two_overview_pm->amount - $two_overview_pm->new_amount) - $two_brake->amount;
        
            $exist = twoKyonPM::where('two',$two_overview_pm->two)->where('date',$date)->exists();
            if($exist){
                $two_kyons_pm = twoKyonPM::where('two',$two_overview_pm->two);
                $two_kyons_pm = $two_kyons_pm->update([
                    'amount' => $two_overview_pm->amount > $two_brake->amount ? ($two_overview_pm->amount - $two_brake->amount) : 0,
                    'new_amount' => $two_overview_pm->new_amount
                ]);
            }else{
            $two_kyons_pm = new twoKyonPM();
            $two_kyons_pm->admin_user_id = Auth::guard('adminuser')->user()->id;
            $two_kyons_pm->two =  $two_overview_pm->two;
            $two_kyons_pm->new_amount =  $two_overview_pm->new_amount;
            $two_kyons_pm->amount = $two_overview_pm->amount > $two_brake->amount ? ($two_overview_pm->amount - $two_brake->amount) : 0;
            $two_kyons_pm->date = $date;
            $two_kyons_pm->save();
        
        }

    }
        
        $two_kyons_pm = twoKyonPM::where('date',$date)->get();
        $two_kyons_pm_total = twoKyonPM::select('amount')->where('date',$date)->sum('amount');
        $two_kyons_new_amount_pm_total = twoKyonPM::select('new_amount')->where('date',$date)->sum('new_amount');
        $two_kyons_new_kyon_pm_total = twoKyonPM::select('new_kyon_amount')->where('date',$date)->sum('new_kyon_amount');
        

        $fake_number = FakeNumber::first();

        return view('backend.two_overview.pm_twokyon', compact('two_overviews_pm', 'date', 'two_brake','two_kyons_pm','two_kyons_pm_total','two_kyons_new_kyon_pm_total','two_kyons_new_amount_pm_total','fake_number'));
    }
}
