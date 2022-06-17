<?php

namespace App\Http\Controllers\backend;

use App\Helpers\ForWalletAndBetHistory;
use App\Http\Requests\WalletRequest;
use App\User;
use App\Wallet;
use App\AdminUser;
use Carbon\Carbon;
use App\UserWallet;
use App\Transaction;
use App\WalletHistory;
use Illuminate\Http\Request;
use App\Helpers\UUIDGenerator;
use App\Http\Requests\StoreTwo;
use Yajra\DataTables\DataTables;
use App\Helpers\PermissionChecker;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Notifications\AddAndWithdraw;
use Yajra\DataTables\Contracts\DataTable;
use Spatie\Backup\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use Google\Service\MyBusinessAccountManagement\Admin;

class WalletController extends Controller
{
    public function index()
    {
        PermissionChecker::CheckPermission('view_wallet');
        if(Auth::guard('adminuser')->user()->hasRole('Admin')){
            $user_wallet = null;
        }else{
            $user_wallet = Wallet::where('user_id',Auth::guard('adminuser')->user()->id)->firstOrFail();
        }
        return view('backend.wallet.index',compact('user_wallet'));
    }

    public function ssd()
    {
        if(Auth::guard('adminuser')->user()->hasRole('Admin')){
            $data = Wallet::where('admin_user_id', Auth::guard('adminuser')->user()->id)->where('status','master')->get();
        }

        if(Auth::guard('adminuser')->user()->hasRole('Master')){
            $data = Wallet::where('admin_user_id', Auth::guard('adminuser')->user()->id)->where('status','agent')->get();
        }

        if(Auth::guard('adminuser')->user()->hasRole('Agent')){
            $data = UserWallet::where('admin_user_id', Auth::guard('adminuser')->user()->id)->get();
        }


        return DataTables::of($data)
        ->editColumn('user_id', function ($each) {
            return $each->getNameAttribute();
        })
        ->editColumn('amount', function ($each) {
            return number_format($each->amount);
        })

        ->editColumn('created_at', function ($each) {
            return Carbon::parse($each->created_at)->format('Y-m-d h:i:s A');
        })
        ->make(true);
    }

    public function add()
    {

            PermissionChecker::CheckPermission('add_wallet');
            $masters = AdminUser::role('Master')->where('user_id',Auth::guard('adminuser')->user()->id)->get();
            $agents = AdminUser::role('Agent')->where('user_id',Auth::guard('adminuser')->user()->id)->get();
            $users = User::where('admin_user_id',Auth::guard('adminuser')->user()->id)->get();
            return view('backend.wallet.add', compact('masters','agents','users'));

    }

    public function store(WalletRequest $request)
    {
        $user = Auth::guard('adminuser')->user();

        if($user->hasRole('Master') || $user->hasRole('Agent')){
            $from_account = Wallet::where('user_id',Auth::guard('adminuser')->user()->id)->firstOrFail();
        }

        if($user->hasRole('Admin') || $user->hasRole('Master') ){
            $to_account = AdminUser::with('wallet')->where('id', $request->user_id)->firstOrFail();
        }

        if($user->hasRole('Agent')){
            $to_account = User::where('id',$request->user_id)->firstOrFail();

        }


        DB::beginTransaction();

        try {

            if($user->hasRole('Admin')){
                $to_account->wallet->increment('amount', $request->amount);
                $to_account->wallet->update();
            }

            if($user->hasRole('Master') ){

                if($request->amount > $from_account->amount){
                    return back()->withErrors(['amount'=>'Your amount is not sufficient']);
                }

                $from_account->decrement('amount',$request->amount);
                $from_account->update();

                $to_account->wallet->increment('amount', $request->amount);
                $to_account->wallet->update();
            }

            if($user->hasRole('Agent')){

                if($request->amount > $from_account->amount){
                    return back()->withErrors(['amount'=>'Your amount is not sufficient']);
                }

                $from_account->decrement('amount',$request->amount);
                $from_account->update();

                $to_account->user_wallet->increment('amount', $request->amount);
                $to_account->user_wallet->update();
            }


            $trx_id = UUIDGenerator::TrxId();

            ForWalletAndBetHistory::Slip(new WalletHistory,$user->id,$request->user_id,$trx_id,$request->amount,'deposit','user');


            $title = 'ငွေလက်ခံရရှိပါသည်';
            $message =  '+'. number_format($request->amount). 'Ks';
            $transaction_id = $trx_id;
            $sourceable_id = $request->user_id;
            $sourceable_type = Admin::class;

            Notification::send([$to_account], new AddAndWithdraw($title, $message, $transaction_id,$sourceable_id, $sourceable_type));
            DB::commit();
            return redirect('admin/wallet')->with('create', 'Added successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('admin/wallet/add')->withErrors(['fail' => 'Something wrong'])->withInput();
        }
    }

    public function substract()
    {
        PermissionChecker::CheckPermission('substract_wallet');
        $masters = AdminUser::role('Master')->where('user_id',Auth::guard('adminuser')->user()->id)->get();
        $agents = AdminUser::role('Agent')->where('user_id',Auth::guard('adminuser')->user()->id)->get();
        $users = User::where('admin_user_id',Auth::guard('adminuser')->user()->id)->get();
        return view('backend.wallet.substract', compact('masters','agents','users'));

    }

    public function remove(WalletRequest $request)
    {


        //dd($request->all());
        $user = Auth::guard('adminuser')->user();

        if($user->hasRole('Master') || $user->hasRole('Agent')){
            $from_account = Wallet::where('user_id',Auth::guard('adminuser')->user()->id)->firstOrFail();
        }

        if($user->hasRole('Admin') || $user->hasRole('Master') ){
            $to_account = AdminUser::with('wallet')->where('id', $request->user_id)->firstOrFail();
        }

        if($user->hasRole('Agent')){
            $to_account = User::where('id',$request->user_id)->firstOrFail();
        }

        //dd('hi');
        if($user->hasRole('Admin') || $user->hasRole('Master') ){
            $to_account = AdminUser::with('wallet')->where('id', $request->user_id)->firstOrFail();

            if($request->amount > $to_account->wallet->amount){
                return back()->withErrors(['amount'=>'This user amount is not sufficient']);
            }

        }

        if($user->hasRole('Agent')){
            $to_account = User::where('id',$request->user_id)->firstOrFail();


            if($request->amount > $to_account->user_wallet->amount){
                return back()->withErrors(['amount'=>'This user amount is not sufficient']);
            }
        }



        DB::beginTransaction();
        try {

            if($user->hasRole('Admin')){
                $to_account->wallet->decrement('amount', $request->amount);
                $to_account->wallet->update();
            }

            if($user->hasRole('Master') ){

                $from_account->increment('amount',$request->amount);
                $from_account->update();

                $to_account->wallet->decrement('amount', $request->amount);
                $to_account->wallet->update();
            }

            if($user->hasRole('Agent')){
                $from_account->increment('amount',$request->amount);
                $from_account->update();

                $to_account->user_wallet->decrement('amount', $request->amount);
                $to_account->user_wallet->update();
            }

            $trx_id = UUIDGenerator::TrxId();

            ForWalletAndBetHistory::Slip(new WalletHistory,$user->id,$request->user_id,$trx_id,$request->amount,'withdraw','user');

            $title = 'ငွေထုတ်ယူခြင်း';
            $message =  '-'. number_format($request->amount). 'Ks';
            $transaction_id = $trx_id;
            $sourceable_id = $request->user_id;
            $sourceable_type = Admin::class;

            Notification::send([$to_account], new AddAndWithdraw($title, $message, $transaction_id,$sourceable_id, $sourceable_type));
            DB::commit();


            return redirect('admin/wallet')->with('create', 'Remove successfully');
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect('admin/wallet/substract')->withErrors(['fail' => 'Something wrong'. $e->getMessage()])->withInput();
        }
    }
}
