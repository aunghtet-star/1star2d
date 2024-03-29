<?php

namespace App\Http\Controllers\backend;

use App\AllBrakeWithAmount;use Illuminate\Http\Request;
use App\all_break_with_amount;
use Yajra\Datatables\Datatables;
use App\Helpers\PermissionChecker;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreBreakNumber;
use App\Http\Requests\UpdateBreakNumber;
use App\Http\Requests\StoreAllBreakWithAmount;
use App\Http\Requests\UpdateAllBreakWithAmount;

class AllBreakWithAmountController extends Controller
{
    protected $model;

    protected $rView = 'backend.all_break_with_amount.';

    public function __construct(AllBrakeWithAmount $model){
        return $this->model = $model;
    }

    public function index()
    {
        PermissionChecker::CheckPermission('brake');

        return view($this->rView.'index');
    }

    public function ssd()
    {
        $all_break_with_amounts = $this->model::query();

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
        PermissionChecker::CheckPermission('brake');
        return view($this->rView.'create');
    }

    public function store(StoreAllBreakWithAmount $request)
    {
        $data = $request->except('proengsoft_jsvalidation');
        $data['admin_user_id'] = Auth::guard('adminuser')->user()->id;
        $this->model->create($data);

        return redirect('admin/allbreakwithamount')->with('create', 'Created Successfully');
    }

    public function edit($id)
    {
        PermissionChecker::CheckPermission('brake');
        $all_break_with_amount = $this->model::findOrFail($id);
        $numbers = $this->model::where('admin_user_id', Auth::guard('adminuser')->user()->id)->get();


        return view($this->rView.'edit', compact('all_break_with_amount', 'numbers'));
    }

    public function update(UpdateAllBreakWithAmount $request, $id)
    {
        $data = $request->except('proengsoft_jsvalidation');
        $data['admin_user_id'] = Auth::guard('adminuser')->user()->id;
        $this->model::findOrFail($id)->update($data);

        return redirect('admin/allbreakwithamount')->with('update', 'Updated Successfully');
    }

    public function destroy($id)
    {
        $this->model::findOrFail($id)->delete();

        return 'success';
    }
}
