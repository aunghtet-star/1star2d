<?php

namespace App\Http\Controllers;

use App\User;
use App\Three;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Requests\UpdateThree;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreThree;

class ThreeController extends Controller
{
    public function index()
    {
        $numbers = Three::all();
        return view('backend.three.index', compact('numbers'));
    }

    public function ssd()
    {
        return Datatables::of(Three::with('users'))
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
            $edit_icon = '<a href="'.url('admin/three/'.$each->id.'/edit').'" class="text-warning"><i class="fas fa-user-edit"></i></a>';
            $delete_icon = '<a href="'.url('admin/three/'.$each->id).'" data-id="'.$each->id.'" class="text-danger" id="delete"><i class="fas fa-trash"></i></a>';
            
           
            return '<div class="action-icon">'.$edit_icon . $delete_icon.'</div>';
        })
        ->make(true);
    }
    
    public function create()
    {
        $users = User::all();
        return view('backend.three.create', compact('users'));
    }

    public function store(StoreThree $request)
    {
        $number = new Three();
        $number->user_id = $request->user_id;
        $number->date = now();
        $number->three = $request->three;
        $number->amount = $request->amount;
        $number->save();

        return redirect('admin/three')->with('create', 'Created Successfully');
    }

    public function edit($id)
    {
        $number = Three::findOrFail($id);
        $users = User::all();

        return view('backend.three.edit', compact('number', 'users'));
    }

    public function update(UpdateThree $request, $id)
    {
        $number = Three::findOrFail($id);

        $number->user_id = $request->user_id;
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
        // $startDay = Carbon::parse('2021-10-21 00:00:00');
        // $midDay = Carbon::parse($startDay)->midDay()->format('Y-m-d H:i:s');

        // $period = Carbon::parse('2021-10-21 13:00:00')->between($startDay, $midDay);
    
        return view('backend.three_overview.history');
    }

    public function ThreeHistoryTable(Request $request)
    {
        $date = $request->date;
        $time = $request->time;
        
        if ($time == 'all') {
            $three_transactions = Three::select('three', DB::raw('SUM(amount) as total'))->groupBy('three')->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'23:59:00')])->get();
        }
        

        if ($time == 'true') {
            $three_transactions = Three::select('three', DB::raw('SUM(amount) as total'))->groupBy('three')->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'11:59:00')])->get();
        }
        
        if ($time == 'false') {
            $three_transactions = Three::select('three', DB::raw('SUM(amount) as total'))->groupBy('three')->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'12:00:00'),Carbon::parse($date.' '.'23:59:00')])->get();
        }

        return view('backend.components.threehistorytable', compact('three_transactions'))->render();
    }
}