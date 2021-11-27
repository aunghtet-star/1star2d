<?php

namespace App\Http\Controllers;

use App\AllBrakeWithAmount;
use Illuminate\Http\Request;
use App\all_break_with_amount;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreBreakNumber;
use App\Http\Requests\UpdateBreakNumber;
use App\Http\Requests\StoreAllBreakWithAmount;
use App\Http\Requests\UpdateAllBreakWithAmount;

class AllBreakWithAmountController extends Controller
{
    public function index()
    {
        $all_break_with_amounts = AllBrakeWithAmount::where('admin_user_id', Auth()->user()->id)->get();
        return view('backend.all_break_with_amount.index', compact('all_break_with_amounts'));
    }

    public function ssd()
    {
        $all_break_with_amounts = AllBrakeWithAmount::where('admin_user_id', Auth()->user()->id)->limit(10);

        return Datatables::of($all_break_with_amounts)
        ->addColumn('action', function ($each) {
            $edit_icon = '<a href="'.url('admin/allbreakwithamount/'.$each->id.'/edit').'" class="text-warning"><i class="fas fa-user-edit"></i></a>';
            $delete_icon = '<a href="'.url('admin/allbreakwithamount/'.$each->id).'" data-id="'.$each->id.'" class="text-danger" id="delete"><i class="fas fa-trash"></i></a>';
            
           
            return '<div class="action-icon">'.$edit_icon . $delete_icon.'</div>';
        })
        ->make(true);
    }
    
    public function create()
    {
        return view('backend.all_break_with_amount.create');
    }

    public function store(StoreAllBreakWithAmount $request)
    {
        $all_break_with_amount = new AllBrakeWithAmount();
        $all_break_with_amount->type = $request->type;
        $all_break_with_amount->admin_user_id = Auth::guard('adminuser')->user()->id;
        $all_break_with_amount->amount = $request->amount;
        $all_break_with_amount->save();

        return redirect('admin/allbreakwithamount')->with('create', 'Created Successfully');
    }

    public function edit($id)
    {
        $all_break_with_amount = AllBrakeWithAmount::findOrFail($id);
        $numbers = AllBrakeWithAmount::where('admin_user_id', Auth::guard('adminuser')->user()->id)->get();

       
        return view('backend.all_break_with_amount.edit', compact('all_break_with_amount', 'numbers'));
    }

    public function update(UpdateAllBreakWithAmount $request, $id)
    {
        $all_break_with_amount = AllBrakeWithAmount::findOrFail($id);

        $all_break_with_amount->type = $request->type;
        $all_break_with_amount->admin_user_id = Auth::guard('adminuser')->user()->id;
        $all_break_with_amount->amount = $request->amount;
        $all_break_with_amount->update();

        return redirect('admin/allbreakwithamount')->with('update', 'Updated Successfully');
    }

    public function destroy($id)
    {
        $all_break_with_amount = AllBrakeWithAmount::findOrFail($id);
        $all_break_with_amount->delete();

        return 'success';
    }
}
