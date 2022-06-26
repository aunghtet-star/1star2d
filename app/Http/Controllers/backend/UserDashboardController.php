<?php

namespace App\Http\Controllers\backend;

use App\AdminUser;
use App\BetHistory;
use App\DubaiTwo;
use App\Helpers\ForUserDetail;
use App\Helpers\ForWalletAndBetHistory;
use App\Helpers\PermissionChecker;
use App\Helpers\UUIDGenerator;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdminUser;
use App\Http\Requests\StoreUser;
use App\Http\Requests\UpdateUser;
use App\Http\Requests\UpdateUserDashboard;
use App\Http\Requests\WalletRequest;
use App\Notifications\AddAndWithdraw;
use App\Three;
use App\Two;
use App\User;
use App\UserWallet;
use App\Wallet;
use App\WalletHistory;
use Google\Service\MyBusinessAccountManagement\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Yajra\DataTables\DataTables;

class UserDashboardController extends Controller
{
    public function index()
    {
        PermissionChecker::CheckPermission('view_admin');
        return view('backend.user-dashboard.index');
    }

    public function ssd()
    {
        $users = User::query();
        return Datatables::of($users)
            ->addColumn('amount',function ($each){
                return number_format($each->user_wallet ? $each->user_wallet->amount : '-');
            })
            ->addColumn('action', function ($each) {
                $edit_icon = '<a href="'.url('/admin/user-dashboard/'.$each->id.'/edit').'" class="text-warning"><i class="fas fa-user-edit"></i></a>';
                //$delete_icon = '<a href="'.url('/admin/user-dashboard/'.$each->id).'" data-id="'.$each->id.'" class="text-danger" id="delete"><i class="fas fa-trash"></i></a>';
                $detail_icon = '<a href="'.url('/admin/user-dashboard/'.$each->id).'"  data-id="'.$each->id.'" id="show" onclick="show()" ><i class="fas fa-eye"></i></a>';

                $add_icon = '<a href="'.url('admin/user-dashboard/'.$each->id.'/add').'" class="text-success"><i class="fas fa-circle-plus"></i></a>';

                $substract_icon = '<a href="'.url('admin/user-dashboard/'.$each->id.'/subtract').'" class="text-danger" ><i class="fas fa-circle-minus"></i></a>';

                return '<div class="action-icon">'.$edit_icon .$detail_icon.$add_icon.$substract_icon.'</div>';
            })
            ->make(true);
    }

    public function edit($id)
    {
        PermissionChecker::CheckPermission('view_admin');
        $user = User::findOrFail($id);
        return view('backend.user-dashboard.edit', compact('user'));
    }

    public function update(UpdateUserDashboard $request, $id)
    {
            $user = User::findOrFail($id);

            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->password = $request->password ? Hash::make($request->password) : $user->password ;
            $user->update();

            return redirect('admin/user-dashboard')->with('update', 'Updated Successfully');

    }

    public function show($id, Request $request)
    {
        PermissionChecker::CheckPermission('view_admin');
        $date = $request->date ?? now()->format('Y-m-d');
        $user = User::findOrFail($id);

        //WalletRequest
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

        return view('backend.user-dashboard.detail', compact('user', 'two_users_am', 'two_users_pm', 'two_users_am_sum', 'two_users_pm_sum', 'three_users_am', 'three_users_pm', 'three_users_am_sum', 'three_users_pm_sum','dubai_twos_11am_sum','dubai_twos_1pm_sum','dubai_twos_3pm_sum','dubai_twos_5pm_sum','dubai_twos_7pm_sum','dubai_twos_9pm_sum' ,'dubai_twos_11am','dubai_twos_1pm','dubai_twos_3pm','dubai_twos_5pm','dubai_twos_7pm','dubai_twos_9pm' ,'user_wallet', 'user_transactions'));
    }

    public function add($id)
    {

        PermissionChecker::CheckPermission('view_admin');

        $user = User::find($id);
        return view('backend.user-dashboard.add', compact('user'));

    }

    public function store(WalletRequest $request)
    {
        $user = Auth::guard('adminuser')->user();

        $to_account = User::where('id',$request->user_id)->first();

        DB::beginTransaction();

        try {


            $to_account->user_wallet->increment('amount', $request->amount);
            $to_account->user_wallet->update();

            $trx_id = UUIDGenerator::TrxId();

            ForWalletAndBetHistory::AdminSlip(new BetHistory,$user->id,$request->user_id,$trx_id,$request->amount,'fix','from admin');

            $title = 'Admin ဘက်မှပြင်ဆင်ခြင်း';
            $message =  '+'. number_format($request->amount). 'Ks';
            $transaction_id = $trx_id;
            $sourceable_id = $request->user_id;
            $sourceable_type = Admin::class;

            Notification::send([$to_account], new AddAndWithdraw($title, $message, $transaction_id,$sourceable_id, $sourceable_type));
            DB::commit();
            return redirect('admin/user-dashboard')->with('create', 'Added successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('admin/user-dashboard')->withErrors(['fail' => 'Something wrong'])->withInput();
        }
    }

    public function subtract($id)
    {
        PermissionChecker::CheckPermission('view_admin');

        $user = User::find($id);
        return view('backend.user-dashboard.subtract', compact('user'));

    }

    public function remove(WalletRequest $request)
    {

        //dd($request->all());
        $user = Auth::guard('adminuser')->user();

        $to_account = User::where('id',$request->user_id)->firstOrFail();

        if($request->amount > $to_account->user_wallet->amount){
            return back()->withErrors(['amount'=>'This user amount is not sufficient']);
        }


        DB::beginTransaction();
        try {

            $to_account->user_wallet->decrement('amount', $request->amount);
            $to_account->user_wallet->update();

            $trx_id = UUIDGenerator::TrxId();

            ForWalletAndBetHistory::AdminSlip(new BetHistory,$user->id,$request->user_id,$trx_id,$request->amount,'fix','to admin');

            $title = 'Admin ဘက်မှပြင်ဆင်ခြင်း';
            $message =  '-'. number_format($request->amount). 'Ks';
            $transaction_id = $trx_id;
            $sourceable_id = $request->user_id;
            $sourceable_type = Admin::class;

            Notification::send([$to_account], new AddAndWithdraw($title, $message, $transaction_id,$sourceable_id, $sourceable_type));
            DB::commit();


            return redirect('admin/user-dashboard')->with('create', 'Remove successfully');
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect('admin/user-dashboard/subtract')->withErrors(['fail' => 'Something wrong'. $e->getMessage()])->withInput();
        }
    }
}
