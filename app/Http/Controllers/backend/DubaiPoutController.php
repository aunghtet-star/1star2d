<?php

namespace App\Http\Controllers\backend;

use App\BetHistory;
use App\DubaiTwo;
use App\DubaiTwoPout11Am;
use App\DubaiTwoPout1Pm;
use App\DubaiTwoPout3Pm;
use App\DubaiTwoPout5Pm;
use App\DubaiTwoPout7Pm;
use App\DubaiTwoPout9Pm;
use App\Helpers\ForTwoPoutForeach;
use App\Helpers\ForTwoPoutStatusUpdate;
use App\Helpers\ForWalletAndBetHistory;
use App\Helpers\PermissionChecker;
use App\Helpers\UUIDGenerator;
use App\Http\Controllers\Controller;
use App\Notifications\AddAndWithdraw;
use App\Three;
use App\Two;
use App\TwoPoutAm;
use App\TwoPoutPm;
use App\User;
use App\UserWallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class DubaiPoutController extends Controller
{

    public function DubaiTwoPout11Am($two, $date)
    {
        PermissionChecker::CheckPermission('pout');

        $twopouts = DubaiTwo::select('user_id', DB::raw('SUM(amount) as total'))->groupBy('user_id')->where('two', $two)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'11:59:00')])->get();

        ForTwoPoutForeach::UpdateOrCreate(new DubaiTwoPout11Am,$twopouts,$date,$two);

        $pouts = DubaiTwoPout11Am::where('two',$two)->where('date',$date)->get();

        return view('backend.dubai_two_pout.dubai_pout_11am', compact('twopouts','pouts','two'));
    }

    public function DubaiTwoPout1Pm($two, $date)
    {
        PermissionChecker::CheckPermission('pout');

        $twopouts = DubaiTwo::select('user_id', DB::raw('SUM(amount) as total'))->groupBy('user_id')->where('two', $two)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'11:00:00'),Carbon::parse($date.' '.'12:59:00')])->get();

        ForTwoPoutForeach::UpdateOrCreate(new DubaiTwoPout1Pm,$twopouts,$date,$two);

        $pouts = DubaiTwoPout1Pm::where('two',$two)->where('date',$date)->get();

        return view('backend.dubai_two_pout.dubai_pout_1pm', compact('twopouts','pouts','two'));
    }

    public function DubaiTwoPout3Pm($two, $date)
    {
        PermissionChecker::CheckPermission('pout');

        $twopouts = DubaiTwo::select('user_id', DB::raw('SUM(amount) as total'))->groupBy('user_id')->where('two', $two)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'13:00:00'),Carbon::parse($date.' '.'14:59:00')])->get();

        ForTwoPoutForeach::UpdateOrCreate(new DubaiTwoPout3Pm,$twopouts,$date,$two);

        $pouts = DubaiTwoPout3Pm::where('two',$two)->where('date',$date)->get();

        return view('backend.dubai_two_pout.dubai_pout_3pm', compact('twopouts','pouts','two'));
    }

    public function DubaiTwoPout5Pm($two, $date)
    {
        PermissionChecker::CheckPermission('pout');

        $twopouts = DubaiTwo::select('user_id', DB::raw('SUM(amount) as total'))->groupBy('user_id')->where('two', $two)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'15:00:00'),Carbon::parse($date.' '.'16:59:00')])->get();

        ForTwoPoutForeach::UpdateOrCreate(new DubaiTwoPout5Pm,$twopouts,$date,$two);

        $pouts = DubaiTwoPout5Pm::where('two',$two)->where('date',$date)->get();

        return view('backend.dubai_two_pout.dubai_pout_5pm', compact('twopouts','pouts','two'));
    }

    public function DubaiTwoPout7Pm($two, $date)
    {
        PermissionChecker::CheckPermission('pout');

        $twopouts = DubaiTwo::select('user_id', DB::raw('SUM(amount) as total'))->groupBy('user_id')->where('two', $two)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'17:00:00'),Carbon::parse($date.' '.'18:59:00')])->get();

        ForTwoPoutForeach::UpdateOrCreate(new DubaiTwoPout7Pm,$twopouts,$date,$two);

        $pouts = DubaiTwoPout7Pm::where('two',$two)->where('date',$date)->get();

        return view('backend.dubai_two_pout.dubai_pout_7pm', compact('twopouts','pouts','two'));
    }

    public function DubaiTwoPout9Pm($two, $date)
    {
        PermissionChecker::CheckPermission('pout');

        $twopouts = DubaiTwo::select('user_id', DB::raw('SUM(amount) as total'))->groupBy('user_id')->where('two', $two)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'19:00:00'),Carbon::parse($date.' '.'23:59:00')])->get();

        ForTwoPoutForeach::UpdateOrCreate(new DubaiTwoPout9Pm,$twopouts,$date,$two);

        $pouts = DubaiTwoPout9Pm::where('two',$two)->where('date',$date)->get();

        return view('backend.dubai_two_pout.dubai_pout_9pm', compact('twopouts','pouts','two'));
    }

    public function DubaiTwoBet11Am(Request $request){

        $user_id = $request->user_id;
        $amount = $request->amount;
        $date = $request->date;
        $two = $request->two;

        $to_account = User::where('id',$user_id)->firstOrFail();

        $user_wallet = UserWallet::where('user_id',$user_id)->firstOrFail();

        $user_wallet->increment('amount',$amount);
        $user_wallet->update();

        ForTwoPoutStatusUpdate::UpdateStatus(new DubaiTwoPout11Am,$user_id,$date,$two);

        $trx_id = UUIDGenerator::TrxId();

        ForWalletAndBetHistory::Slip(new BetHistory,Auth::guard('adminuser')->user()->id,$user_id,$trx_id,$amount,'win','Dubai 2D');

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

    public function DubaiTwoBet1Pm(Request $request){

        $user_id = $request->user_id;
        $amount = $request->amount;
        $date = $request->date;
        $two = $request->two;

        $to_account = User::where('id',$user_id)->firstOrFail();

        $user_wallet = UserWallet::where('user_id',$user_id)->firstOrFail();

        $user_wallet->increment('amount',$amount);
        $user_wallet->update();

        ForTwoPoutStatusUpdate::UpdateStatus(new DubaiTwoPout1Pm,$user_id,$date,$two);

        $trx_id = UUIDGenerator::TrxId();

        ForWalletAndBetHistory::Slip(new BetHistory,Auth::guard('adminuser')->user()->id,$user_id,$trx_id,$amount,'win','Dubai 2D');

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

    public function DubaiTwoBet3Pm(Request $request){

        $user_id = $request->user_id;
        $amount = $request->amount;
        $date = $request->date;
        $two = $request->two;

        $to_account = User::where('id',$user_id)->firstOrFail();

        $user_wallet = UserWallet::where('user_id',$user_id)->firstOrFail();

        $user_wallet->increment('amount',$amount);
        $user_wallet->update();

        ForTwoPoutStatusUpdate::UpdateStatus(new DubaiTwoPout3Pm,$user_id,$date,$two);

        $trx_id = UUIDGenerator::TrxId();

        ForWalletAndBetHistory::Slip(new BetHistory,Auth::guard('adminuser')->user()->id,$user_id,$trx_id,$amount,'win','Dubai 2D');

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

    public function DubaiTwoBet5Pm(Request $request){

        $user_id = $request->user_id;
        $amount = $request->amount;
        $date = $request->date;
        $two = $request->two;

        $to_account = User::where('id',$user_id)->firstOrFail();

        $user_wallet = UserWallet::where('user_id',$user_id)->firstOrFail();

        $user_wallet->increment('amount',$amount);
        $user_wallet->update();

        ForTwoPoutStatusUpdate::UpdateStatus(new DubaiTwoPout5Pm,$user_id,$date,$two);

        $trx_id = UUIDGenerator::TrxId();

        ForWalletAndBetHistory::Slip(new BetHistory,Auth::guard('adminuser')->user()->id,$user_id,$trx_id,$amount,'win','Dubai 2D');

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

    public function DubaiTwoBet7Pm(Request $request){

        $user_id = $request->user_id;
        $amount = $request->amount;
        $date = $request->date;
        $two = $request->two;

        $to_account = User::where('id',$user_id)->firstOrFail();

        $user_wallet = UserWallet::where('user_id',$user_id)->firstOrFail();

        $user_wallet->increment('amount',$amount);
        $user_wallet->update();

        ForTwoPoutStatusUpdate::UpdateStatus(new DubaiTwoPout7Pm,$user_id,$date,$two);

        $trx_id = UUIDGenerator::TrxId();

        ForWalletAndBetHistory::Slip(new BetHistory,Auth::guard('adminuser')->user()->id,$user_id,$trx_id,$amount,'win','Dubai 2D');

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

    public function DubaiTwoBet9Pm(Request $request){

        $user_id = $request->user_id;
        $amount = $request->amount;
        $date = $request->date;
        $two = $request->two;

        $to_account = User::where('id',$user_id)->firstOrFail();

        $user_wallet = UserWallet::where('user_id',$user_id)->firstOrFail();

        $user_wallet->increment('amount',$amount);
        $user_wallet->update();

        ForTwoPoutStatusUpdate::UpdateStatus(new DubaiTwoPout9Pm,$user_id,$date,$two);

        $trx_id = UUIDGenerator::TrxId();

        ForWalletAndBetHistory::Slip(new BetHistory,Auth::guard('adminuser')->user()->id,$user_id,$trx_id,$amount,'win','Dubai 2D');

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
