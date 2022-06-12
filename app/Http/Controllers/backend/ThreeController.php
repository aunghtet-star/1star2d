<?php

namespace App\Http\Controllers\backend;

use App\FakeNumber;
use App\Helpers\ForThreeKyon;
use App\Helpers\ForThreeOverview;
use App\Helpers\ForTwoOverview;
use App\ThreeKyon;
use App\ThreeOverview;
use App\TwoOverview;
use App\User;
use App\Three;
use Carbon\Carbon;
use App\AllBrakeWithAmount;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Requests\StoreThree;
use App\Helpers\PermissionChecker;
use App\Http\Requests\UpdateThree;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ThreeController extends Controller
{
    public function index()
    {
        PermissionChecker::CheckPermission('three');
        $numbers = Three::where('admin_user_id', Auth()->user()->id)->get();
        return view('backend.three.index', compact('numbers'));
    }

    public function ssd()
    {
        if(Auth::guard('adminuser')->user()->hasRole('Admin')){
            $threes = Three::query();
        }else{
            $threes = Three::where('admin_user_id', Auth()->user()->id)->limit(10);
        }
        return Datatables::of($threes)
        ->addColumn('name', function ($each) {
            return $each->users ? $each->users->name : '_';
        })
        ->editColumn('updated_at', function ($each) {
            return Carbon::parse($each->updated_at)->format('d-m-Y h:i:s A');
        })
        ->addColumn('action', function ($each) {
            $edit_icon = '<a href="'.url('admin/three/'.$each->id.'/edit').'" class="text-warning"><i class="fas fa-user-edit"></i></a>';
            $delete_icon = '<a href="'.url('admin/three/'.$each->id).'" data-id="'.$each->id.'"  data-three="'.$each->three.'" data-amount="'.$each->amount.'"  class="text-danger" id="delete"><i class="fas fa-trash"></i></a>';


            return '<div class="action-icon">'.$edit_icon . $delete_icon.'</div>';
        })
        ->make(true);
    }

    public function create()
    {
        PermissionChecker::CheckPermission('three');
        $users = User::where('admin_user_id', Auth()->user()->id)->get();
        return view('backend.three.create', compact('users'));
    }

    public function store(StoreThree $request)
    {
        $number = new Three();
        $number->user_id = $request->user_id;
        $number->admin_user_id = Auth::guard('adminuser')->user()->id;
        $number->date = now();
        $number->three = $request->three;
        $number->amount = $request->amount;
        $number->save();

        return redirect('admin/three')->with('create', 'Created Successfully');
    }

    public function edit($id)
    {
        PermissionChecker::CheckPermission('three');
        $number = Three::findOrFail($id);
        $users = User::where('admin_user_id', Auth()->user()->id)->get();

        return view('backend.three.edit', compact('number', 'users'));
    }

    public function update(UpdateThree $request, $id)
    {
        $number = Three::findOrFail($id);

        $number->user_id = $request->user_id;
        $number->admin_user_id = Auth::guard('adminuser')->user()->id;
        $number->date = now();
        $number->three = $request->three;
        $number->amount = $request->amount;
        $number->update();

        return redirect('admin/three')->with('update', 'Updated Successfully');
    }

    public function destroy($id)
    {
        $number = Three::findOrFail($id);
        $number->delete();

        return 'success';
    }

    public function threeHistory(Request $request)
    {
        PermissionChecker::CheckPermission('three_overview');

        if (now()->format('Y-m-d')  < Carbon::now()->startOfMonth()->addDays(15)->format('Y-m-d')){
            $from = $request->startdate ?? Carbon::now()->startOfMonth()->addDays(1);
            $to = $request->enddate ?? Carbon::now()->startOfMonth()->addDays(15);
        }else{
            $from = $request->startdate ?? Carbon::now()->startOfMonth()->addDays(16);
            $to = $request->enddate ?? Carbon::now()->endOfMonth()->addDays(1);
        }

        $from = $from->format('Y-m-d');
        $to = $to->format('Y-m-d');


        $three_brake = AllBrakeWithAmount::select('amount')->where('type', '3D')->first();

        $threes = Three::select('three', DB::raw('SUM(amount) as total'))->groupBy('three')->whereBetween('date', [$from,$to])->paginate(144);

        ForThreeOverview::Overview($threes,$from,new ThreeOverview);

        //to store three overview table if exist to update
        $three_overviews = ThreeOverview::whereDate('date', $from)->orderBy('three','asc')->get();

        //ThreeOverview Total Amount
        $overview_total = ForThreeOverview::OverviewTotal(new ThreeOverview,$from);

        $amount_total = $overview_total['amount'];
        $new_amount_total = $overview_total['new_amount'];
        $kyon_amount_total = $overview_total['kyon_amount'];

        $threes->withPath('/admin/three-overview/history?startdate='.$from.'&enddate='.$to);


       // $threes_total = Three::select('amount')->whereBetween('date', [$from,$to])->sum('amount');

        $fake_number = FakeNumber::first();

        return view('backend.three_overview.history', compact('threes','three_overviews', 'three_brake', 'from', 'to','fake_number','amount_total','new_amount_total','kyon_amount_total'));
    }

    public function threeKyon(Request $request)
    {
        PermissionChecker::CheckPermission('three_kyon');
        if (now()->format('Y-m-d') < Carbon::now()->startOfMonth()->addDays(15)->format('Y-m-d')){
            $from = $request->startdate ?? Carbon::now()->startOfMonth()->addDays(1);
            $to = $request->enddate ?? Carbon::now()->startOfMonth()->addDays(15);
        }else{
            //dd(Carbon::now()->startOfMonth()->addDays(15)->format('Y-m-d'));
            $from = $request->startdate ?? Carbon::now()->startOfMonth()->addDays(15);
            $to = $request->enddate ?? Carbon::now()->endOfMonth()->addDays(1);
        }

        $from = $from->format('Y-m-d');
        $to = $to->format('Y-m-d');

        $three_brake = AllBrakeWithAmount::select('amount')->where('type', '3D')->first();

        $three_overviews = ThreeOverview::whereDate('date', $from)->orderBy('three','asc')->get();

        //To Store Three kyon table
        ForThreeKyon::Kyon($three_overviews,$from,new ThreeKyon);

        $three_kyons = ThreeKyon::where('date',$from)->get();

        return view('backend.three_overview.threekyon', compact('three_kyons', 'three_brake', 'from', 'to'));
    }
}
