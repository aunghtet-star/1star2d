<?php

namespace App\Http\Controllers\backend;

use App\AllBrakeWithAmount;
use App\DubaiTwo;
use App\DubaiTwoOverview11am;
use App\DubaiTwoOverview1pm;
use App\DubaiTwoOverview3pm;
use App\FakeNumber;
use App\Helpers\ForTwoKyon;
use App\Helpers\ForTwoOverview;
use App\Helpers\PermissionChecker;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTwo;
use App\Http\Requests\UpdateTwo;
use App\Two;
use App\twoKyonAM;
use App\twoKyonPM;
use App\TwoOverview;
use App\TwoOverviewPM;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DubaiTwoController extends Controller
{
    protected $r_view = 'backend.dubai_two.';

    public function index()
    {
        PermissionChecker::CheckPermission('two');
        return view($this->r_view.'index');
    }

    public function ssd()
    {
        if(Auth::guard('adminuser')->user()->hasRole('Admin')){
            $twos = DubaiTwo::query();
        }else{
            $twos = DubaiTwo::where('admin_user_id', Auth::guard('adminuser')->user()->id)->limit(10);
        }
        return Datatables::of($twos)
            ->addColumn('name', function ($each) {
                return $each->users ? $each->users->name : '_';
            })
            ->editColumn('updated_at', function ($each) {
                return Carbon::parse($each->updated_at)->format('d-m-Y H:i:s A');
            })
            ->addColumn('action', function ($each) {
                $edit_icon = '<a href="'.url('admin/dubai-two/'.$each->id.'/edit').'" class="text-warning"><i class="fas fa-user-edit"></i></a>';
                //$delete_icon = '<a href="'.url('admin/dubai-two/'.$each->id).'" data-id="'.$each->id.'" data-two="'.$each->two.'" data-amount="'.$each->amount.'" class="text-danger" id="delete"><i class="fas fa-trash"></i></a>';


                return '<div class="action-icon">'.$edit_icon .'</div>';
            })
            ->make(true);
    }

    public function create()
    {
        PermissionChecker::CheckPermission('two');
        $users = User::query();
        return view($this->r_view.'create', compact('users'));
    }

    public function store(StoreTwo $request)
    {
        $number = new DubaiTwo();
        $number->user_id = $request->user_id;
        $number->admin_user_id = Auth::guard('adminuser')->user()->id;
        $number->date = now();
        $number->two = $request->two;
        $number->amount = $request->amount;
        $number->save();

        return redirect('admin/two')->with('create', 'Created Successfully');
    }

    public function edit($id)
    {
        PermissionChecker::CheckPermission('two');
        $number = DubaiTwo::findOrFail($id);
        $users = User::where('admin_user_id', Auth::guard('adminuser')->user()->id)->get();

        return view($this->r_view.'edit', compact('number', 'users'));
    }

    public function update(UpdateTwo $request, $id)
    {
        $number = DubaiTwo::findOrFail($id);

        $number->user_id = $request->user_id;
        $number->admin_user_id = Auth::guard('adminuser')->user()->id;
        $number->date = now();
        $number->two = $request->two;
        $number->amount = $request->amount;
        $number->update();

        return redirect('admin/two')->with('update', 'Updated Successfully');
    }

    public function destroy($id)
    {
        $number = DubaiTwo::findOrFail($id);
        $number->delete();

        return 'success';
    }

}
