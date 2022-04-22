<?php

namespace App\Http\Controllers\backend;

use App\agent;
use App\Wallet;
use App\AdminUser;
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

            //$delete_icon = '<a href="'.url('admin/agent/'.$each->id).'" data-id="'.$each->id.'" class="text-danger" id="delete"><i class="fas fa-trash"></i></a>';

            return '<div class="action-icon">'.$edit_icon .'</div>';
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
    public function show($id)
    {
        //
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
