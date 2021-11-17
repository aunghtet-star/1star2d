<?php

namespace App\Http\Controllers;

use App\Amountbreak;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreBreakNumber;
use App\Http\Requests\UpdateBreakNumber;

class BreakNumberController extends Controller
{
    public function index()
    {
        $amountbreaks = Amountbreak::where('admin_user_id', Auth()->user()->id)->get();
        return view('backend.break_numbers.index', compact('amountbreaks'));
    }

    public function ssd()
    {
        $amountbreaks = Amountbreak::where('admin_user_id', Auth()->user()->id)->limit(10);

        return Datatables::of($amountbreaks)
        ->addColumn('action', function ($each) {
            $edit_icon = '<a href="'.url('admin/amountbreaks/'.$each->id.'/edit').'" class="text-warning"><i class="fas fa-user-edit"></i></a>';
            $delete_icon = '<a href="'.url('admin/amountbreaks/'.$each->id).'" data-id="'.$each->id.'" class="text-danger" id="delete"><i class="fas fa-trash"></i></a>';
            
           
            return '<div class="action-icon">'.$edit_icon . $delete_icon.'</div>';
        })
        ->make(true);
    }
    
    public function create()
    {
        return view('backend.break_numbers.create');
    }

    public function store(StoreBreakNumber $request)
    {
        $amountbreak = new Amountbreak();
        $amountbreak->type = $request->type;
        $amountbreak->admin_user_id = Auth::guard('adminuser')->user()->id;
        $amountbreak->closed_number = $request->closed_number;
        $amountbreak->amount = $request->amount;
        $amountbreak->save();

        return redirect('admin/amountbreaks')->with('create', 'Created Successfully');
    }

    public function edit($id)
    {
        $amountbreak = Amountbreak::findOrFail($id);
        $numbers = Amountbreak::where('admin_user_id', Auth::guard('adminuser')->user()->id)->get();

        return view('backend.break_numbers.edit', compact('amountbreak', 'numbers'));
    }

    public function update(UpdateBreakNumber $request, $id)
    {
        $amountbreak = Amountbreak::findOrFail($id);

        $amountbreak->type = $request->type;
        $amountbreak->admin_user_id = Auth::guard('adminuser')->user()->id;
        $amountbreak->closed_number = $request->closed_number;
        $amountbreak->amount = $request->amount;
        $amountbreak->update();

        return redirect('admin/amountbreaks')->with('update', 'Updated Successfully');
    }

    public function destroy($id)
    {
        $amountbreak = Amountbreak::findOrFail($id);
        $amountbreak->delete();

        return 'success';
    }
}
