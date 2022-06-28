<?php

namespace App\Http\Controllers\backend;

use App\AdminUser;
use App\BetHistory;
use App\DubaiTwo;
use App\FixMoneyFromAdmin;
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

class MasterDashboardController extends Controller
{
    public function index()
    {
        PermissionChecker::CheckPermission('view_admin');
        return view('backend.master-dashboard.index');
    }

    public function ssd()
    {
        $users = AdminUser::role('Master')->get();

        return Datatables::of($users)
            ->addColumn('amount',function ($each){
                return $each->wallet ? number_format($each->wallet->amount) : '-';
            })
            ->addColumn('action', function ($each) {
                $edit_icon = '<a href="'.url('/admin/master-dashboard/'.$each->id.'/edit').'" class="text-warning"><i class="fas fa-user-edit"></i></a>';
                //$delete_icon = '<a href="'.url('/admin/master-dashboard/'.$each->id).'" data-id="'.$each->id.'" class="text-danger" id="delete"><i class="fas fa-trash"></i></a>';
                $detail_icon = '<a href="'.url('/admin/master-dashboard/'.$each->id).'"  data-id="'.$each->id.'" id="show" onclick="show()" ><i class="fas fa-eye"></i></a>';

                $add_icon = '<a href="'.url('admin/master-dashboard/'.$each->id.'/add').'" class="text-success"><i class="fas fa-circle-plus"></i></a>';

                $substract_icon = '<a href="'.url('admin/master-dashboard/'.$each->id.'/subtract').'" class="text-danger" ><i class="fas fa-circle-minus"></i></a>';

                return '<div class="action-icon">'.$edit_icon .$detail_icon.$add_icon.$substract_icon.'</div>';
            })
            ->make(true);
    }

    public function edit($id)
    {
        PermissionChecker::CheckPermission('view_admin');
        $user = AdminUser::findOrFail($id);
        return view('backend.master-dashboard.edit', compact('user'));
    }

    public function update(UpdateUserDashboard $request, $id)
    {
            $user = AdminUser::findOrFail($id);

            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->password = $request->password ? Hash::make($request->password) : $user->password ;
            $user->update();

            return redirect('admin/master-dashboard')->with('update', 'Updated Successfully');

    }

    public function show($id, Request $request)
    {
        PermissionChecker::CheckPermission('view_admin');
        $date = $request->date ?? now()->format('Y-m-d');
        $user = AdminUser::findOrFail($id);

        //WalletRequest
        $user_wallet = Wallet::where('user_id', $user->id)->first();

        //Transaction History
        $user_transactions = WalletHistory::where('type','master')->where('user_id', $id)->whereDate('created_at', $date. ' '.'00:00:00')->orderBy('created_at', 'DESC')->get();

        $fix_money_from_admins = FixMoneyFromAdmin::where('user_id',$id)->whereDate('created_at', $date. ' '.'00:00:00')->orderBy('created_at', 'DESC')->get();
        return view('backend.master-dashboard.detail', compact('user', 'user_wallet', 'user_transactions','fix_money_from_admins'));
    }

    public function add($id)
    {

        PermissionChecker::CheckPermission('view_admin');

        $user = AdminUser::find($id);
        return view('backend.master-dashboard.add', compact('user'));

    }

    public function store(WalletRequest $request)
    {
        $user = Auth::guard('adminuser')->user();

        $to_account = AdminUser::where('id',$request->user_id)->first();

        DB::beginTransaction();

        try {


            $to_account->wallet->increment('amount', $request->amount);
            $to_account->wallet->update();

            $trx_id = UUIDGenerator::TrxId();

            ForWalletAndBetHistory::AdminSlip(new FixMoneyFromAdmin,$to_account->user_id,$request->user_id,$trx_id,$request->amount,'deposit','deposit');

//            $title = 'Admin ဘက်မှပြင်ဆင်ခြင်း';
//            $message =  '+'. number_format($request->amount). 'Ks';
//            $transaction_id = $trx_id;
//            $sourceable_id = $request->user_id;
//            $sourceable_type = Admin::class;
//
//            Notification::send([$to_account], new AddAndWithdraw($title, $message, $transaction_id,$sourceable_id, $sourceable_type));
            DB::commit();
            return redirect('admin/master-dashboard')->with('create', 'Added successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('admin/master-dashboard')->withErrors(['fail' => 'Something wrong'])->withInput();
        }
    }

    public function subtract($id)
    {
        PermissionChecker::CheckPermission('view_admin');

        $user = AdminUser::find($id);
        return view('backend.master-dashboard.subtract', compact('user'));

    }

    public function remove(WalletRequest $request)
    {

        //dd($request->all());
        $user = Auth::guard('adminuser')->user();

        $to_account = AdminUser::where('id',$request->user_id)->firstOrFail();

        if($request->amount > $to_account->wallet->amount){
            return back()->withErrors(['amount'=>'This user amount is not sufficient']);
        }


        DB::beginTransaction();
        try {

            $to_account->wallet->decrement('amount', $request->amount);
            $to_account->wallet->update();

            $trx_id = UUIDGenerator::TrxId();

            ForWalletAndBetHistory::AdminSlip(new FixMoneyFromAdmin,$to_account->user_id,$request->user_id,$trx_id,$request->amount,'withdraw','withdraw');

//            $title = 'Admin ဘက်မှပြင်ဆင်ခြင်း';
//            $message =  '-'. number_format($request->amount). 'Ks';
//            $transaction_id = $trx_id;
//            $sourceable_id = $request->user_id;
//            $sourceable_type = Admin::class;
//
//            Notification::send([$to_account], new AddAndWithdraw($title, $message, $transaction_id,$sourceable_id, $sourceable_type));
            DB::commit();


            return redirect('admin/master-dashboard')->with('create', 'Remove successfully');
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect('admin/master-dashboard')->withErrors(['fail' => 'Something wrong'. $e->getMessage()])->withInput();
        }
    }
}
