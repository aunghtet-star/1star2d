<?php

namespace App\Http\Controllers\backend;

use App\DubaiTwo;
use App\Master;
use App\Two;
use App\Wallet;
use App\AdminUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Helpers\UUIDGenerator;
use Yajra\Datatables\Datatables;
use App\Helpers\PermissionChecker;
use App\Http\Requests\StoreMaster;
use Spatie\Permission\Models\Role;
use App\Http\Requests\UpdateMaster;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreAdminUser;
use App\Http\Requests\UpdateAdminUser;
use Spatie\Permission\Models\Permission;

class MasterController extends Controller
{
    protected $model;

    protected $rView = 'backend.master.';

    public function __construct(AdminUser $model)
    {
        return $this->model = $model;
    }

    public function index()
    {
        PermissionChecker::CheckPermission('master');

        return view($this->rView.'index');
    }

    public function ssd()
    {
        $masters = AdminUser::role('Master')->get();
        return Datatables::of($masters)
        ->addColumn('action', function ($each) {
            $edit_icon = "";
            $delete_icon = "";
            $show_icon = "";

            $edit_icon = '<a href="'.url('admin/master/'.$each->id.'/edit').'" class="text-warning"><i class="fas fa-user-edit"></i></a>';
            $show_icon = '<a href="'.url('admin/master/'.$each->id).'" class="text-primary"><i class="fas fa-eye"></i></a>';

            //$delete_icon = '<a href="'.url('admin/master/'.$each->id).'" data-id="'.$each->id.'" class="text-danger" id="delete"><i class="fas fa-trash"></i></a>';

            return '<div class="action-icon">'.$edit_icon.$show_icon .'</div>';
        })

        ->rawColumns(['action'])
        ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        PermissionChecker::CheckPermission('master');
        return view($this->rView . 'create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMaster $request)
    {

        $admin_user_id = Auth::guard('adminuser')->user()->id;
        $master = $this->model->create([
            'user_id' => $admin_user_id,
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => Hash::make($request->password)
        ])->assignRole('Master');

        Wallet::firstOrCreate([
            'user_id' => $master->id
        ], [
            'admin_user_id' => $admin_user_id,
            'account_numbers' => UUIDGenerator::AccountNumber(),
            'amount' => 0,
            'status' => 'master'
        ]);

        return redirect('/admin/master')->with('create', 'Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,Request $request)
    {
        $date = $request->date ?? now()->format('Y-m-d');

        $commissions_am = Two::select('amount')->where('master_id',$id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'11:59:00')])->sum('amount');
        $commissions_pm = Two::select('amount')->where('master_id',$id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'12:00:00'),Carbon::parse($date.' '.'23:59:00')])->sum('amount');

        $commissions_11am = DubaiTwo::select('amount')->where('master_id',$id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'10:59:00')])->sum('amount');
        $commissions_1pm = DubaiTwo::select('amount')->where('master_id',$id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'11:00:00'),Carbon::parse($date.' '.'12:59:00')])->sum('amount');
        $commissions_3pm = DubaiTwo::select('amount')->where('master_id',$id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'13:00:00'),Carbon::parse($date.' '.'14:59:00')])->sum('amount');
        $commissions_5pm = DubaiTwo::select('amount')->where('master_id',$id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'15:00:00'),Carbon::parse($date.' '.'16:59:00')])->sum('amount');
        $commissions_7pm = DubaiTwo::select('amount')->where('master_id',$id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'17:00:00'),Carbon::parse($date.' '.'18:59:00')])->sum('amount');
        $commissions_9pm = DubaiTwo::select('amount')->where('master_id',$id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'19:00:00'),Carbon::parse($date.' '.'23:59:00')])->sum('amount');

        return view('backend.commissions.index',compact('commissions_am','commissions_pm','commissions_11am','commissions_1pm','commissions_3pm','commissions_5pm','commissions_7pm','commissions_9pm'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        PermissionChecker::CheckPermission('master');
        $master = $this->model->find($id);

        return view($this->rView.'edit',compact('master'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMaster $request, $id)
    {
        $admin_user_id = Auth::guard('adminuser')->user()->id;

        $master = $this->model->find($id);;
        $master->update([
            'user_id' => Auth::guard('adminuser')->user()->id,
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => $request->password ? Hash::make($request->password) : $master->password
        ]);

        Wallet::firstOrCreate([
            'user_id' => $master->id
        ], [
            'admin_user_id' => $admin_user_id,
            'account_numbers' => UUIDGenerator::AccountNumber(),
            'amount' => 0,
            'status' => 'master'
        ]);

        return redirect('/admin/master')->with('update', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $match = AdminUser::findOrFail($id);
        $match->delete();

        return 'success';
    }
}
