<?php

namespace App\Http\Controllers;

use App\Two;
use Carbon\Carbon;
use App\TwoOverview;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;
use Yajra\Datatables\Datatables;

class TwoOverviewController extends Controller
{
    public function index(Request $request)
    {
        for ($i=0;$i<100;$i++) {
            $amounts[] = Two::where('two', $i)->whereDate('created_at', now()->format('Y-m-d'))->whereTime('created_at', '>=', Carbon::parse('00:00:00'))->whereTime('created_at', '<=', Carbon::parse('11:59:00'))->sum('amount');
        }

        foreach ($amounts as $key=>$amount) {
            $exist1 = TwoOverview::where('two', $key)->whereDate('date', now()->format('Y-m-d'))->whereTime('created_at', '>=', Carbon::parse('00:00:00'))->whereTime('created_at', '<=', Carbon::parse('11:59:00'))->exists();
            $exist2 = TwoOverview::where('two', $key)->whereDate('date', now()->format('Y-m-d'))->whereTime('created_at', '>=', Carbon::parse('12:00:00'))->whereTime('created_at', '<=', Carbon::parse('23:59:00'))->exists();
            
            if ($exist1) {
                TwoOverview::where('two', $key)->where('date', now()->format('Y-m-d'))->update([
                        'date' => now(),
                        'amount' => $amount,
                     ]);
            } elseif ($exist2) {
                TwoOverview::where('two', $key)->where('date', now()->format('Y-m-d'))->update([
                    'date' => now(),
                    'amount' => $amount,
                 ]);
            } else {
                TwoOverview::where('two', $key)->where('date', now()->format('Y-m-d'))->create([
                    'date' => now(),
                    'two' => $key,
                    'amount' => $amount,
                 ]);
            }
        }

        
        return view('backend.two_overview.index');
    }

    public function ssd()
    {
        return Datatables::of(TwoOverview::query())
        
        ->editColumn('updated_at', function ($each) {
            return Carbon::parse($each->updated_at)->format('d-m-Y h:i:s A');
        })
        ->make(true);
    }
}
