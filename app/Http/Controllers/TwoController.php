<?php

namespace App\Http\Controllers;

use App\Two;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTwo;
use App\Http\Requests\UpdateTwo;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Hash;

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
}
