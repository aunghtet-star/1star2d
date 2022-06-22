<?php

namespace App\Http\Controllers\backend;

use App\AllBrakeWithAmount;
use App\Helpers\PermissionChecker;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAllBreakWithAmount;
use App\Http\Requests\UpdateAllBreakWithAmount;
use App\UserBrakeAmountAll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class UserBrakeAmountAllController extends Controller
{
    protected $model;

    protected $rView = 'backend.user_brake_amount_all.';

    public function __construct(UserBrakeAmountAll $model){
        return $this->model = $model;
    }

    public function index()
    {
        PermissionChecker::CheckPermission('brake');

        return view($this->rView.'index');
    }

    public function ssd()
    {
        $user_brake_amount_all = $this->model::query();

        return Datatables::of($user_brake_amount_all)
            ->addColumn('action', function ($each) {
                $edit_icon = '<a href="'.url('admin/user_brake_amount_all/'.$each->id.'/edit').'" class="text-warning"><i class="fas fa-user-edit"></i></a>';
                $delete_icon = '<a href="'.url('admin/user_brake_amount_all/'.$each->id).'" data-id="'.$each->id.'" class="text-danger" id="delete"><i class="fas fa-trash"></i></a>';


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

        return redirect('admin/user_brake_amount_all')->with('create', 'Created Successfully');
    }

    public function edit($id)
    {
        PermissionChecker::CheckPermission('brake');
        $user_brake_amount_all = $this->model::findOrFail($id);
        $numbers = $this->model::where('admin_user_id', Auth::guard('adminuser')->user()->id)->get();


        return view($this->rView.'edit', compact('user_brake_amount_all', 'numbers'));
    }

    public function update(UpdateAllBreakWithAmount $request, $id)
    {
        $data = $request->except('proengsoft_jsvalidation');
        $data['admin_user_id'] = Auth::guard('adminuser')->user()->id;
        $this->model::findOrFail($id)->update($data);

        return redirect('admin/user_brake_amount_all')->with('update', 'Updated Successfully');
    }

    public function destroy($id)
    {
        $this->model::findOrFail($id)->delete();

        return 'success';
    }
}
