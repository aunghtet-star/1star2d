<?php

namespace App\Http\Controllers\backend;

use App\agent;
use App\DubaiTwo;
use App\Three;
use App\Two;
use App\Wallet;
use App\AdminUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Helpers\UUIDGenerator;
use Yajra\Datatables\Datatables;
use App\Http\Requests\StoreAgent;
use App\Helpers\PermissionChecker;
use App\Http\Requests\UpdateAgent;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreAdminUser;
use App\Http\Requests\UpdateAdminUser;
use Spatie\Permission\Models\Permission;

class AgentController extends Controller
{
    protected $model;

    protected $rView = 'backend.agent.';

    public function __construct(AdminUser $model)
    {
        return $this->model = $model;
    }

    public function index()
    {
        PermissionChecker::CheckPermission('agent');

        return view($this->rView.'index');
    }

    public function ssd()
    {
        $agents = AdminUser::role('Agent')->where('user_id',Auth::guard('adminuser')->user()->id)->limit(10);
        return Datatables::of($agents)
        ->addColumn('action', function ($each) {
            $edit_icon = "";
            $delete_icon = "";

            $edit_icon = '<a href="'.url('admin/agent/'.$each->id.'/edit').'" class="text-warning"><i class="fas fa-user-edit"></i></a>';

            $show_icon = '<a href="'.url('admin/agent/'.$each->id).'" class="text-primary"><i class="fas fa-eye"></i></a>';

            //$delete_icon = '<a href="'.url('admin/agent/'.$each->id).'" data-id="'.$each->id.'" class="text-danger" id="delete"><i class="fas fa-trash"></i></a>';

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
        PermissionChecker::CheckPermission('agent');
        return view($this->rView . 'create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAgent $request)
    {

        $admin_user_id = Auth::guard('adminuser')->user()->id;
        $agent = $this->model->create([
            'user_id' => $admin_user_id,
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => Hash::make($request->password)
        ])->assignRole('agent');

        Wallet::firstOrCreate([
            'user_id' => $agent->id
        ], [
            'admin_user_id' => $admin_user_id,
            'account_numbers' => UUIDGenerator::AccountNumber(),
            'amount' => 0,
            'status' => 'agent'
        ]);

        return redirect('/admin/agent')->with('create', 'Created Successfully');
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

        $commissions_am = Two::select('amount')->where('admin_user_id',$id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'11:59:00')])->sum('amount');
        $commissions_pm = Two::select('amount')->where('admin_user_id',$id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'12:00:00'),Carbon::parse($date.' '.'23:59:00')])->sum('amount');

        $commissions_11am = DubaiTwo::select('amount')->where('admin_user_id',$id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'10:59:00')])->sum('amount');
        $commissions_1pm = DubaiTwo::select('amount')->where('admin_user_id',$id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'11:00:00'),Carbon::parse($date.' '.'12:59:00')])->sum('amount');
        $commissions_3pm = DubaiTwo::select('amount')->where('admin_user_id',$id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'13:00:00'),Carbon::parse($date.' '.'14:59:00')])->sum('amount');
        $commissions_5pm = DubaiTwo::select('amount')->where('admin_user_id',$id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'15:00:00'),Carbon::parse($date.' '.'16:59:00')])->sum('amount');
        $commissions_7pm = DubaiTwo::select('amount')->where('admin_user_id',$id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'17:00:00'),Carbon::parse($date.' '.'18:59:00')])->sum('amount');
        $commissions_9pm = DubaiTwo::select('amount')->where('admin_user_id',$id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'19:00:00'),Carbon::parse($date.' '.'23:59:00')])->sum('amount');

        if (now()->format('Y-m-d')  < Carbon::now()->startOfMonth()->addDays(15)->format('Y-m-d')){
            $from = $request->startdate ?? Carbon::now()->startOfMonth()->addDays(1);
            $to = $request->enddate ?? Carbon::now()->startOfMonth()->addDays(15);
        }else{
            $from = $request->startdate ?? Carbon::now()->startOfMonth()->addDays(16);
            $to = $request->enddate ?? Carbon::now()->endOfMonth()->addDays(1);
        }

        $from = $from->format('Y-m-d');
        $to = $to->format('Y-m-d');

        $commissions_three = Three::select('amount')->where('admin_user_id',$id)->whereBetween('date',[$from,$to])->sum('amount');

        return view('backend.commissions.index',compact('commissions_am','commissions_pm','commissions_11am','commissions_1pm','commissions_3pm','commissions_5pm','commissions_7pm','commissions_9pm','commissions_three'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        PermissionChecker::CheckPermission('agent');
        $agent = $this->model->find($id);

        return view($this->rView.'edit',compact('agent'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAgent $request, $id)
    {

        $admin_user_id = Auth::guard('adminuser')->user()->id;

        $agent = $this->model->find($id);
        $agent->update([
            'user_id' => $admin_user_id,
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => $request->password ? Hash::make($request->password) : $agent->password
        ]);

        Wallet::firstOrCreate([
            'user_id' => $agent->id
        ], [
            'admin_user_id' => $admin_user_id,
            'account_numbers' => UUIDGenerator::AccountNumber(),
            'amount' => 0,
            'status' => 'agent'
        ]);

        return redirect('/admin/agent')->with('update', 'Updated Successfully');
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
