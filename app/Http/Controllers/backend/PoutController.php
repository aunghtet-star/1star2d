<?php

namespace App\Http\Controllers\backend;

use App\Helpers\ForWalletAndBetHistory;
use App\Two;
use App\User;
use App\Three;
use App\AdminUser;
use App\BetHistory;
use App\UserWallet;
use Illuminate\Http\Request;
use App\Helpers\UUIDGenerator;
use App\Helpers\PermissionChecker;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Notifications\AddAndWithdraw;
use Illuminate\Support\Facades\Notification;

class PoutController extends Controller
{
    public function twoPout(Request $request, $two)
    {
        PermissionChecker::CheckPermission('pout');
        $twopouts = Two::select('user_id', DB::raw('SUM(amount) as total'))->groupBy('user_id')->where('two', $two)->whereDate('date', $request->date)->get();

        return view('backend.two_overview.twopout', compact('twopouts',));
    }

    public function twoBet(Request $request){
        $user_id = $request->user_id;
        $amount = $request->amount;

        $to_account = User::where('id',$user_id)->firstOrFail();

        $user_wallet = UserWallet::where('user_id',$user_id)->firstOrFail();
        $user_wallet->increment('amount',$amount);
        $user_wallet->update();

        $trx_id = UUIDGenerator::TrxId();

        ForWalletAndBetHistory::Slip(new BetHistory,Auth::guard('adminuser')->user()->id,$user_id,$trx_id,$amount,'win','2D');

        $title = 'ငွေအလျော်လက်ခံရရှိပါသည်';
        $message =  '+'. number_format($amount). 'Ks';
        $transaction_id = $trx_id;
        $sourceable_id = $request->user_id;
        $sourceable_type = Admin::class;

        Notification::send([$to_account], new AddAndWithdraw($title, $message, $transaction_id,$sourceable_id, $sourceable_type));

        return response([
            'status' => 'success',
            'msg' => 'Done'
        ]);
    }



    public function threePout(Request $request, $three)
    {
        PermissionChecker::CheckPermission('pout');
        $threepouts = Three::select('user_id', DB::raw('SUM(amount) as total'))->groupBy('user_id')->where('three', $three)->whereBetween('date', [$request->from,$request->to])->get();
        return view('backend.three_overview.threepout', compact('threepouts'));
    }

    public function threeBet(Request $request){
        $user_id = $request->user_id;
        $amount = $request->amount;

        $to_account = User::where('id',$user_id)->firstOrFail();

        $user_wallet = UserWallet::where('user_id',$user_id)->firstOrFail();
        $user_wallet->increment('amount',$amount);
        $user_wallet->update();

        $trx_id = UUIDGenerator::TrxId();

        ForWalletAndBetHistory::Slip(new BetHistory,Auth::guard('adminuser')->user()->id,$user_id,$trx_id,$amount,'win','3D');

        $title = 'ငွေအလျော်လက်ခံရရှိပါသည်';
        $message =  '+'. number_format($amount). 'Ks';
        $transaction_id = $trx_id;
        $sourceable_id = $request->user_id;
        $sourceable_type = Admin::class;

        Notification::send([$to_account], new AddAndWithdraw($title, $message, $transaction_id,$sourceable_id, $sourceable_type));

        return response([
            'status' => 'success',
            'msg' => 'Done'
        ]);
    }
}
