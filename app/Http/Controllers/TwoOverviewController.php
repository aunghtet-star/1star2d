<?php

namespace App\Http\Controllers;

use App\Two;
use Carbon\Carbon;
use App\TwoOverview;
use App\TwoOverviewPM;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TwoOverviewController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->date ?? now()->format('Y-m-d');
        $two_transactions = Two::select('two', DB::raw('SUM(amount) as total'))->groupBy('two')->groupBy('two')->where('admin_user_id', Auth::guard('adminuser')->user()->id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'23:59:00')])->get();
        
        foreach($two_transactions as $two_transaction){
            $exist = TwoOverview::where('two',$two_transaction->two)->where('date',now()->format('Y-m-d'))->exists();
            if($exist){
                $two_overview = TwoOverview::where('two',$two_transaction->two);
                $two_overview->update([
                    'amount' => $two_transaction->total
                ]);
            }else{
            $two_overview = new TwoOverview();
                $two_overview->date = $date;
                $two_overview->two =  $two_transaction->two;
                $two_overview->amount = $two_transaction->total;
                $two_overview->save();
            }
            
        }
        //return view('backend.two_overview.index');
    }


    public function NewAmount(Request $request){
        $new_amount = $request->new_amount;
        $two_d = $request->two_d;
        $id = $request->id;

        $two_over_pm = TwoOverview::where('two',$two_d)->where('id',$id);
        $two_over_pm->increment('new_amount',$new_amount);

        return 'success';
    }

    public function pmNewAmount(Request $request){
        $new_amount = $request->new_amount;
        $two_d = $request->two_d;
        $id = $request->id;

        $two_over_pm = TwoOverviewPM::where('two',$two_d)->where('id',$id);
        $two_over_pm->increment('new_amount',$new_amount);

        return 'success';
    }
}
