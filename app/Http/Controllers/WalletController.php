<?php

namespace App\Http\Controllers;

use App\User;
use App\Wallet;
use Carbon\Carbon;
use App\Transaction;
use Illuminate\Http\Request;
use App\Helpers\UUIDGenerator;
use App\Http\Requests\StoreTwo;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
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
        if (Auth::guard('adminuser')->user()->can('view_wallet')) {
            return view('backend.wallet.index');
        } else {
            return abort(404);
        }
    }

    public function ssd()
    {
        $data = Wallet::where('admin_user_id', Auth()->user()->id)->get();
        return DataTables::of($data)
        ->editColumn('user_id', function ($each) {
            return $each->user ? $each->user->name : $each->adminuser->name.'(Admin)';
        })
        ->editColumn('created_at', function ($each) {
            return Carbon::parse($each->created_at)->format('Y-m-d h:i:s A');
        })
        ->make(true);
    }

    public function add()
    {
        if (Auth::guard('adminuser')->user()->can('add_wallet')) {
            $users = User::where('admin_user_id', Auth()->user()->id)->orderBy('name')->get();
            return view('backend.wallet.add', compact('users'));
        }
        return abort(404);
    }

    public function store(Request $request)
    {
        $to_account = User::where('admin_user_id', Auth()->user()->id)->where('id', $request->user_id)->firstOrFail();
        
        DB::beginTransaction();

        try {
            $to_account->wallet->increment('amount', $request->amount);
            $to_account->wallet->update();

            $ref_no = UUIDGenerator::RefNumber();

            $transactions = new Transaction();
            $transactions->ref_no = $ref_no;
            $transactions->trx_id = UUIDGenerator::TrxId();
            $transactions->user_id = Auth::guard('adminuser')->user()->id;
            $transactions->source_id = $request->user_id;
            $transactions->type = 2;
            $transactions->amount = $request->amount;
            $transactions->save();
            

            $transactions = new Transaction();
            $transactions->ref_no = $ref_no;
            $transactions->trx_id = UUIDGenerator::TrxId();
            $transactions->user_id = $request->user_id;
            $transactions->source_id = Auth::guard('adminuser')->user()->id;
            $transactions->type = 1;
            $transactions->amount = $request->amount;
            $transactions->save();

            $title = 'ငွေလက်ခံရရှိပါသည်';
            $message =  '+'. number_format($request->amount). 'Ks';
            $sourceable_id = $request->user_id;
            $sourceable_type = Admin::class;

            Notification::send([$to_account], new AddAndWithdraw($title, $message, $sourceable_id, $sourceable_type));
            DB::commit();
            return redirect('admin/wallet')->with('create', 'Added successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('admin/wallet/add')->withErrors(['fail' => 'Something wrong'])->withInput();
        }
    }

    public function substract()
    {
        if (Auth::guard('adminuser')->user()->can('add_wallet')) {
            $users = User::where('admin_user_id', Auth()->user()->id)->orderBy('name')->get();
            return view('backend.wallet.substract', compact('users'));
        } else {
            return abort(404);
        }
    }

    public function remove(Request $request)
    {
        $to_account = User::where('admin_user_id', Auth()->user()->id)->where('id', $request->user_id)->firstOrFail();
        DB::beginTransaction();

        try {
            $to_account->wallet->decrement('amount', $request->amount);
            $to_account->wallet->update();

            $ref_no = UUIDGenerator::RefNumber();

            $transactions = new Transaction();
            $transactions->ref_no = $ref_no;
            $transactions->trx_id = UUIDGenerator::TrxId();
            $transactions->user_id = $request->user_id;
            $transactions->source_id = Auth::guard('adminuser')->user()->id;
            $transactions->type = 2;
            $transactions->amount = $request->amount;
            $transactions->save();
            

            $transactions = new Transaction();
            $transactions->ref_no = $ref_no;
            $transactions->trx_id = UUIDGenerator::TrxId();
            $transactions->user_id = Auth::guard('adminuser')->user()->id;
            $transactions->source_id = $request->user_id;
            $transactions->type = 1;
            $transactions->amount = $request->amount;
            $transactions->save();


            $title = 'ငွေထုတ်ယူခြင်း';
            $message =  '-'. number_format($request->amount). 'Ks';
            $sourceable_id = $request->user_id;
            $sourceable_type = Admin::class;

            Notification::send([$to_account], new AddAndWithdraw($title, $message, $sourceable_id, $sourceable_type));
            DB::commit();
            return redirect('admin/wallet')->with('create', 'Remove successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('admin/wallet/remove')->withErrors(['fail' => 'Something wrong'])->withInput();
        }
    }
}
