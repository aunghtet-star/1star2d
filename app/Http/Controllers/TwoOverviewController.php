<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\TwoOverview;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;
use Yajra\Datatables\Datatables;

class TwoOverviewController extends Controller
{
    public function index()
    {
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

    public function totaltwo(Request $request)
    {
        TwoOverview::firstOrCreate([
            'two' => $request->two,
            'amount' => $request->amount,
        ]);
    }
}
