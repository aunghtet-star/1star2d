<?php

namespace App\Http\Controllers\backend;

use App\DubaiTwo;
use App\Helpers\ForUserDetail;
use App\Two;
use App\User;
use App\Three;
use Exception;
use App\Wallet;
use Carbon\Carbon;
use App\UserWallet;
use App\Transaction;
use App\WalletHistory;
use Illuminate\Http\Request;
use App\Helpers\UUIDGenerator;
use App\Http\Requests\StoreUser;
use Yajra\Datatables\Datatables;
use App\Http\Requests\UpdateUser;
use App\Helpers\PermissionChecker;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        PermissionChecker::CheckPermission('user');
        $users = User::where('admin_user_id', Auth()->user()->id)->get();

        return view('backend.users.index', compact('users'));
    }

    public function ssd()
    {
        $users = User::where('admin_user_id', Auth()->user()->id)->get();
        return Datatables::of($users)

        ->addColumn('action', function ($each) {
            $edit_icon = '<a href="'.url('/admin/users/'.$each->id.'/edit').'" class="text-warning"><i class="fas fa-user-edit"></i></a>';
            //$delete_icon = '<a href="'.url('/admin/users/'.$each->id).'" data-id="'.$each->id.'" class="text-danger" id="delete"><i class="fas fa-trash"></i></a>';
            $detail_icon = '<a href="'.url('/admin/users/'.$each->id).'"  data-id="'.$each->id.'" id="show" onclick="show()" ><i class="fas fa-eye"></i></a>';

            return '<div class="action-icon">'.$edit_icon .$detail_icon.'</div>';
        })
        ->make(true);
    }

    public function create()
    {
        PermissionChecker::CheckPermission('user');
        return view('backend.users.create');
    }

    public function store(StoreUser $request)
    {
        DB::beginTransaction();

        try {
            $users = new User();
            $users->name = $request->name;
            $users->admin_user_id = Auth::guard('adminuser')->user()->id;
            $users->phone = $request->phone;
            $users->password = Hash::make($request->password);
            $users->save();

            UserWallet::firstorCreate(
                [
                'user_id' => $users->id
                ],
                [
                'admin_user_id' => Auth::guard('adminuser')->user()->id,
                'account_numbers' => UUIDGenerator::AccountNumber(),
                'amount' => 0,
                ]
            );



            DB::commit();

            return redirect('admin/users')->with('create', 'Created Successfully');
        } catch (Exception $e) {
            DB::rollBack();

            return back()->withErrors(['fail' => 'something wrong'.$e->getMessage()])->withInput();
        }
    }

    public function show($id, Request $request)
    {
        PermissionChecker::CheckPermission('user');
        $date = $request->date ?? now()->format('Y-m-d');
        $user = User::findOrFail($id);

        //Wallet
        $user_wallet = UserWallet::where('user_id', $user->id)->first();

        //Transaction History
        $user_transactions = WalletHistory::where('user_id', $user->id)->where('type','user')->whereDate('created_at', $date. ' '.'00:00:00')->orderBy('created_at', 'DESC')->get();


        //For Two
        $two = ForUserDetail::Digit(new Two,$user,$date);
        $two_users_am = $two['am'];
        $two_users_pm = $two['pm'];

        //For Three
        $three = ForUserDetail::Digit(new Three,$user,$date);
        $three_users_am = $three['am'];
        $three_users_pm = $three['pm'];

        //For Dubai Two
        $dubai_twos = ForUserDetail::DubaiDigit(new DubaiTwo,$user,$date);
        $dubai_twos_11am = $dubai_twos['am_11'];
        $dubai_twos_1pm = $dubai_twos['pm_1'];
        $dubai_twos_3pm = $dubai_twos['pm_3'];
        $dubai_twos_5pm = $dubai_twos['pm_5'];
        $dubai_twos_7pm = $dubai_twos['pm_7'];
        $dubai_twos_9pm = $dubai_twos['pm_9'];

        // Two Total Sum
        $two_am = ForUserDetail::Total(new Two,$user,$date);
        $two_users_am_sum = $two_am['am_sum'];
        $two_users_pm_sum = $two_am['pm_sum'];

        // Three Total Sum
        $three_am = ForUserDetail::Total(new Three,$user,$date);
        $three_users_am_sum = $three_am['am_sum'];
        $three_users_pm_sum = $three_am['pm_sum'];

        // Dubai Two Total Sum

        $dubai_twos_sum = ForUserDetail::Total(new DubaiTwo,$user,$date);
        $dubai_twos_11am_sum = $dubai_twos_sum['am_11_sum'];
        $dubai_twos_1pm_sum = $dubai_twos_sum['pm_1_sum'];
        $dubai_twos_3pm_sum = $dubai_twos_sum['pm_3_sum'];
        $dubai_twos_5pm_sum = $dubai_twos_sum['pm_5_sum'];
        $dubai_twos_7pm_sum = $dubai_twos_sum['pm_7_sum'];
        $dubai_twos_9pm_sum = $dubai_twos_sum['pm_9_sum'];

        return view('backend.users.detail', compact('user', 'two_users_am', 'two_users_pm', 'two_users_am_sum', 'two_users_pm_sum', 'three_users_am', 'three_users_pm', 'three_users_am_sum', 'three_users_pm_sum','dubai_twos_11am_sum','dubai_twos_1pm_sum','dubai_twos_3pm_sum','dubai_twos_5pm_sum','dubai_twos_7pm_sum','dubai_twos_9pm_sum' ,'dubai_twos_11am','dubai_twos_1pm','dubai_twos_3pm','dubai_twos_5pm','dubai_twos_7pm','dubai_twos_9pm' ,'user_wallet', 'user_transactions'));
    }


    public function edit($id)
    {
        PermissionChecker::CheckPermission('user');
        $user = User::findOrFail($id);
        return view('backend.users.edit', compact('user'));
    }

    public function update(UpdateUser $request, $id)
    {
        DB::beginTransaction();

        try {
            $user = User::findOrFail($id);

            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->admin_user_id = Auth::guard('adminuser')->user()->id;
            $user->password = $request->password ? Hash::make($request->password) : $user->password ;
            $user->update();


            UserWallet::firstorCreate(
                [
                'user_id' => $user->id
                ],
                [
                'admin_user_id' => Auth::guard('adminuser')->user()->id,
                'account_numbers' => UUIDGenerator::AccountNumber(),
                'amount' => 0,
            ]
            );

            DB::commit();
            return redirect('admin/users')->with('update', 'Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['fali' => 'something wrong'])->withInput();
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return 'success';
    }
}
