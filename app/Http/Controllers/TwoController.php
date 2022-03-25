<?php

namespace App\Http\Controllers;

use App\AllBrakeWithAmount;
use App\Two;

use App\User;
use stdClass;
use Carbon\Carbon;
use App\TwoOverview;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTwo;
use App\Http\Requests\UpdateTwo;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TwoController extends Controller
{
    public function index()
    {
        $numbers = Two::where('admin_user_id', Auth::guard('adminuser')->user()->id);
        return view('backend.two.index', compact('numbers'));
    }

    public function ssd()
    {
        $twos = Two::where('admin_user_id', Auth::guard('adminuser')->user()->id)->limit(10);
        return Datatables::of($twos)
        ->addColumn('name', function ($each) {
            return $each->users ? $each->users->name : '_';
        })
        ->editColumn('updated_at', function ($each) {
            return Carbon::parse($each->updated_at)->format('d-m-Y H:i:s A');
        })
        ->addColumn('action', function ($each) {
            $edit_icon = '<a href="'.url('admin/two/'.$each->id.'/edit').'" class="text-warning"><i class="fas fa-user-edit"></i></a>';
            $delete_icon = '<a href="'.url('admin/two/'.$each->id).'" data-id="'.$each->id.'" data-two="'.$each->two.'" data-amount="'.$each->amount.'" class="text-danger" id="delete"><i class="fas fa-trash"></i></a>';
            
           
            return '<div class="action-icon">'.$edit_icon . $delete_icon.'</div>';
        })
        ->make(true);
    }
    
    public function create()
    {
        $users = User::where('admin_user_id', Auth::guard('adminuser')->user()->id)->get();
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
        $date = $request->date ?? now()->format('Y-m-d');

        $two_brake = AllBrakeWithAmount::select('amount')->where('admin_user_id', Auth::guard('adminuser')->user()->id)->first();
      
        $two_transactions = Two::select('two', DB::raw('SUM(amount) as total'))->groupBy('two')->groupBy('two')->where('admin_user_id', Auth::guard('adminuser')->user()->id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'11:59:00')])->get();
        
        foreach($two_transactions as $two_transaction){
            $exist = TwoOverview::where('two',$two_transaction->two)->where('date',$date)->exists();
            if($exist){
                $two_overviews = TwoOverview::where('two',$two_transaction->two);
                $two_overviews = $two_overviews->update([
                    'amount' => $two_transaction->total
                ]);
            }else{
            $two_overviews = new TwoOverview();
            $two_overviews->admin_user_id = Auth::guard('adminuser')->user()->id;
            $two_overviews->two =  $two_transaction->two;
            $two_overviews->amount = $two_transaction->total;
            $two_overviews->date = $date;
            $two_overviews->save();
            }
        }

        $two_overviews_am = TwoOverview::where('admin_user_id', Auth::guard('adminuser')->user()->id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'11:59:00')])->get();

        $two_transactions_total = TwoOverview::select('amount')->where('admin_user_id', Auth::guard('adminuser')->user()->id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'11:59:00')])->sum('amount');
        $new_amount_total = TwoOverview::select('new_amount')->where('admin_user_id', Auth::guard('adminuser')->user()->id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'11:59:00')])->sum('new_amount');
        
        return view('backend.two_overview.am_history', compact('two_overviews_am', 'two_transactions_total','new_amount_total', 'date', 'two_brake'));
    }

    public function twoHistoryPM(Request $request)
    {
        $date = $request->date ?? now()->format('Y-m-d');
        
        $two_brake = AllBrakeWithAmount::select('amount')->where('admin_user_id', Auth::guard('adminuser')->user()->id)->first();
        
        $two_transactions = Two::select('two', DB::raw('SUM(amount) as total'))->groupBy('two')->groupBy('two')->where('admin_user_id', Auth::guard('adminuser')->user()->id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'12:00:00'),Carbon::parse($date.' '.'23:59:00')])->get();
        
        foreach($two_transactions as $two_transaction){
            $exist = TwoOverview::where('two',$two_transaction->two)->where('date',$date)->exists();
            if($exist){
                $two_overviews = TwoOverview::where('two',$two_transaction->two);
                $two_overviews = $two_overviews->update([
                    'amount' => $two_transaction->total
                ]);
            }else{
            $two_overviews = new TwoOverview();
            $two_overviews->admin_user_id = Auth::guard('adminuser')->user()->id;
            $two_overviews->two =  $two_transaction->two;
            $two_overviews->amount = $two_transaction->total;
            $two_overviews->date = $date;
            $two_overviews->save();
            }
        }

        $two_overviews_pm = TwoOverview::where('admin_user_id', Auth::guard('adminuser')->user()->id)->whereDate('date', $date)->get();

        $two_transactions_total = TwoOverview::select('amount')->where('admin_user_id', Auth::guard('adminuser')->user()->id)->whereDate('date', $date)->sum('amount');
        $new_amount_total = TwoOverview::select('new_amount')->where('admin_user_id', Auth::guard('adminuser')->user()->id)->whereDate('date', $date)->sum('new_amount');
        
        return view('backend.two_overview.pm_history', compact('two_overviews_pm', 'two_transactions_total','new_amount_total', 'date', 'two_brake'));
    }


    public function twoKyonAM(Request $request)
    {
        $date = $request->date ?? now()->format('Y-m-d');
        $two_transactions = TwoOverview::where('admin_user_id', Auth::guard('adminuser')->user()->id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'11:59:00')])->get();
        $two_transactions_total = TwoOverview::select('amount')->where('admin_user_id', Auth::guard('adminuser')->user()->id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'11:59:00')])->sum('amount');
        
        $two_brake = AllBrakeWithAmount::select('amount')->where('admin_user_id', Auth::guard('adminuser')->user()->id)->where('type', '2D')->first();
        return view('backend.two_overview.am_twokyon', compact('two_transactions', 'two_transactions_total', 'date', 'two_brake'));
    }

    public function twoKyonPM(Request $request)
    {
        $date = $request->date ?? now()->format('Y-m-d');

        $two_transactions = TwoOverview::where('admin_user_id', Auth::guard('adminuser')->user()->id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'11:59:00'),Carbon::parse($date.' '.'23:59:00')])->get();
        $two_transactions_total = TwoOverview::select('amount')->where('admin_user_id', Auth::guard('adminuser')->user()->id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'12:00:00'),Carbon::parse($date.' '.'23:59:00')])->sum('amount');
        
        $two_brake = AllBrakeWithAmount::select('amount')->where('admin_user_id', Auth::guard('adminuser')->user()->id)->where('type', '2D')->first();
        return view('backend.two_overview.pm_twokyon', compact('two_transactions', 'two_transactions_total', 'date', 'two_brake'));
    }
}
