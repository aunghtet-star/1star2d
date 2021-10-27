<?php

namespace App\Http\Controllers;

use App\Amountbreak;
use App\Http\Requests\StoreBreakNumber;
use App\Http\Requests\UpdateBreakNumber;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class BreakNumberController extends Controller
{
    public function index()
    {
        $amountbreaks = Amountbreak::all();
        return view('backend.break_numbers.index', compact('amountbreaks'));
    }

    public function ssd()
    {
        return Datatables::of(Amountbreak::query())
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
        $amountbreak->closed_number = $request->closed_number;
        $amountbreak->amount = $request->amount;
        $amountbreak->save();

        return redirect('admin/amountbreaks')->with('create', 'Created Successfully');
    }

    public function edit($id)
    {
        $amountbreak = Amountbreak::findOrFail($id);
        $numbers = Amountbreak::all();

        return view('backend.break_numbers.edit', compact('amountbreak', 'numbers'));
    }

    public function update(UpdateBreakNumber $request, $id)
    {
        $amountbreak = Amountbreak::findOrFail($id);

        $amountbreak = new Amountbreak();
        $amountbreak->type = $request->type;
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
