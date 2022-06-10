<?php

namespace App\Http\Controllers\backend;

use App\BetHistory;
use App\Helpers\ForThreePoutForeach;
use App\Helpers\ForThreePoutStatusUpdate;
use App\Helpers\ForTwoPoutForeach;
use App\Helpers\ForWalletAndBetHistory;
use App\Helpers\PermissionChecker;
use App\Helpers\UUIDGenerator;
use App\Http\Controllers\Controller;
use App\Notifications\AddAndWithdraw;
use App\Three;
use App\ThreePout;
use App\TwoPoutAm;
use App\User;
use App\UserWallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class ThreePoutController extends Controller
{
    public function threePout($three,$from,$to)
    {
        PermissionChecker::CheckPermission('pout');
        $threepouts = Three::select('user_id', DB::raw('SUM(amount) as total'))->groupBy('user_id')->where('three', $three)->whereBetween('date', [$from,$to])->get();

        ForThreePoutForeach::UpdateOrCreate(new ThreePout,$threepouts,$from,$three);

        $pouts = ThreePout::where('three',$three)->where('date',$from)->get();

        return view('backend.three_overview.threepout', compact('pouts'));
    }

    public function threeBet(Request $request){

        $three = $request->three;
        $user_id = $request->user_id;
        $date = $request->date;
        $amount = $request->amount;

        $to_account = User::where('id',$user_id)->firstOrFail();

        $user_wallet = UserWallet::where('user_id',$user_id)->firstOrFail();
        $user_wallet->increment('amount',$amount);
        $user_wallet->update();

        ForThreePoutStatusUpdate::UpdateStatus(new ThreePout,$user_id,$date,$three);
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
