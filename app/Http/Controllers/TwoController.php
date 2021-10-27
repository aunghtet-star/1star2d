<?php

namespace App\Http\Controllers;

use App\Two;

use App\User;
use Carbon\Carbon;
use App\TwoOverview;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTwo;
use App\Http\Requests\UpdateTwo;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use stdClass;

class TwoController extends Controller
{
    public function index()
    {
        $numbers = Two::all();
        return view('backend.two.index', compact('numbers'));
    }

    public function ssd()
    {
        return Datatables::of(Two::with('users'))
        ->filterColumn('name', function ($query, $keyword) {
            $query->whereHas('users', function ($q1) use ($keyword) {
                $q1->where('name', 'like', '%'.$keyword.'%');
            });
        })
        ->addColumn('name', function ($each) {
            return $each->users ? $each->users->name : '_';
        })
        ->editColumn('updated_at', function ($each) {
            return Carbon::parse($each->updated_at)->format('d-m-Y h:i:s A');
        })
        ->addColumn('action', function ($each) {
            $edit_icon = '<a href="'.url('admin/two/'.$each->id.'/edit').'" class="text-warning"><i class="fas fa-user-edit"></i></a>';
            $delete_icon = '<a href="'.url('admin/two/'.$each->id).'" data-id="'.$each->id.'" class="text-danger" id="delete"><i class="fas fa-trash"></i></a>';
            
           
            return '<div class="action-icon">'.$edit_icon . $delete_icon.'</div>';
        })
        ->make(true);
    }
    
    public function create()
    {
        $users = User::all();
        return view('backend.two.create', compact('users'));
    }

    public function store(StoreTwo $request)
    {
        $number = new Two();
        $number->user_id = $request->user_id;
        $number->date = now();
        $number->two = $request->two;
        $number->amount = $request->amount;
        $number->save();

        return redirect('admin/two')->with('create', 'Created Successfully');
    }

    public function edit($id)
    {
        $number = Two::findOrFail($id);
        $users = User::all();

        return view('backend.two.edit', compact('number', 'users'));
    }

    public function update(UpdateTwo $request, $id)
    {
        $number = Two::findOrFail($id);

        $number->user_id = $request->user_id;
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

    public function twoHistory(Request $request)
    {
        // $startDay = Carbon::parse('2021-10-21 00:00:00');
        // $midDay = Carbon::parse($startDay)->midDay()->format('Y-m-d H:i:s');

        // $period = Carbon::parse('2021-10-21 13:00:00')->between($startDay, $midDay);
    
        return view('backend.two_overview.history');
    }

    public function twoHistoryTable(Request $request)
    {
        $date = $request->date;
        $time = $request->time;
        

        
        if ($time == 'all') {
            $two_transactions = Two::select('two', DB::raw('SUM(amount) as total'))->groupBy('two')->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'23:59:00')])->get();
        }
        

        if ($time == 'true') {
            $two_transactions = Two::select('two', DB::raw('SUM(amount) as total'))->groupBy('two')->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'11:59:00')])->get();
        }
        
        if ($time == 'false') {
            $two_transactions = Two::select('two', DB::raw('SUM(amount) as total'))->groupBy('two')->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'12:00:00'),Carbon::parse($date.' '.'23:59:00')])->get();
        }

        // $array = [['two'=>'01','total'=>'0'],['two'=>'02','amount'=>'0']];
        
        
        
        
        // $array = ['2D'=>'01','amount'=>'0','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31','32','33','34','35','36','37','38','39','40','41','42','43','44','45','46','47','48','49','50','51'] ;
        // $two_transactions = $two_transactions->toArray();
        // $two_transactions =  array_merge($two_transactions, $array);

        // $two_transactions = collect($two_transactions);
        return view('backend.components.twohistorytable', compact('two_transactions'))->render();
    }

    public function twoHistoryAutoreload()
    {
        return view('backend.two_overview.history');
    }
}
