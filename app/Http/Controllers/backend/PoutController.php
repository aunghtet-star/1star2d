<?php

namespace App\Http\Controllers\backend;

use App\Helpers\ForTwoPoutForeach;
use App\Helpers\ForTwoPoutStatusUpdate;
use App\Helpers\ForWalletAndBetHistory;
use App\Two;
use App\TwoPoutAm;
use App\TwoPoutPm;
use App\User;
use App\Three;
use App\AdminUser;
use App\BetHistory;
use App\UserWallet;
use Carbon\Carbon;
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
    public function twoPoutAm($two, $date)
    {
        PermissionChecker::CheckPermission('pout');

        $twopouts = Two::select('user_id', DB::raw('SUM(amount) as total'))->groupBy('user_id')->where('two', $two)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'11:59:00')])->get();

        ForTwoPoutForeach::UpdateOrCreate(new TwoPoutAm,$twopouts,$date,$two);

        $pouts = TwoPoutAm::where('two',$two)->where('date',$date)->get();

        return view('backend.two_pout.two_pout_am', compact('twopouts','pouts','two'));
    }

    public function twoPoutPm($two, $date)
    {
        PermissionChecker::CheckPermission('pout');

        $twopouts = Two::select('user_id', DB::raw('SUM(amount) as total'))->groupBy('user_id')->where('two', $two)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'12:00:00'),Carbon::parse($date.' '.'23:59:00')])->get();

        ForTwoPoutForeach::UpdateOrCreate(new TwoPoutPm,$twopouts,$date,$two);

        $pouts = TwoPoutPm::where('two',$two)->where('date',$date)->get();

        return view('backend.two_pout.two_pout_pm', compact('twopouts','pouts','two'));
    }

    public function twoBetAm(Request $request){

        $user_id = $request->user_id;
        $amount = $request->amount;
        $date = $request->date;
        $two = $request->two;

        $to_account = User::where('id',$user_id)->firstOrFail();

            $user_wallet = UserWallet::where('user_id',$user_id)->firstOrFail();
            $user_wallet->increment('amount',$amount);
            $user_wallet->update();

            ForTwoPoutStatusUpdate::UpdateStatus(new TwoPoutAm,$user_id,$date,$two);

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

    public function twoBetPm(Request $request){

        $user_id = $request->user_id;
        $amount = $request->amount;
        $date = $request->date;
        $two = $request->two;

        $to_account = User::where('id',$user_id)->firstOrFail();

        $user_wallet = UserWallet::where('user_id',$user_id)->firstOrFail();
        $user_wallet->increment('amount',$amount);
        $user_wallet->update();

        ForTwoPoutStatusUpdate::UpdateStatus(new TwoPoutPm,$user_id,$date,$two);

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

}
