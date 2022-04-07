<?php

namespace App\Http\Controllers\backend;

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
        $from = $request->startdate ?? now()->format('Y-m-d');
        $to = $request->enddate ?? date('Y-m-d', strtotime(now(). '+10 days'));
        
        $three_brake = AllBrakeWithAmount::select('amount')->where('type', '3D')->first();

        $three_transactions = Three::select('three', DB::raw('SUM(amount) as total'))->groupBy('three')->whereBetween('date', [$from,$to])->paginate(144);
        $three_transactions->withPath('/admin/three-overview/history?startdate='.$from.'&enddate='.$to);
        
        $three_transactions_total = Three::select('amount')->whereBetween('date', [$from,$to])->sum('amount');

        return view('backend.three_overview.history', compact('three_transactions', 'three_transactions_total', 'three_brake', 'from', 'to'));
    }

    public function threeKyon(Request $request)
    {
        PermissionChecker::CheckPermission('three_kyon');
        $from = $request->startdate ?? now()->format('Y-m-d');
        $to = $request->enddate ?? date('Y-m-d', strtotime(now(). '+10 days'));
        
        $three_brake = AllBrakeWithAmount::select('amount')->where('type', '3D')->first();
        
        $three_transactions = Three::select('three', DB::raw('SUM(amount) as total'))->groupBy('three')->whereBetween('date', [$from,$to])->get();
        //$three_transactions->withPath('/admin/three-overview/history?startdate='.$from.'&enddate='.$to);
        
        $three_transactions_total = Three::select('amount')->whereBetween('date', [$from,$to])->sum('amount');

        return view('backend.three_overview.threekyon', compact('three_transactions', 'three_transactions_total', 'three_brake', 'from', 'to'));
    }
}