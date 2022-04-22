<?php

namespace App\Http\Controllers\backend;

use App\BetHistory;
use App\DubaiTwo;
use App\Helpers\PermissionChecker;
use App\Helpers\UUIDGenerator;
use App\Http\Controllers\Controller;
use App\Notifications\AddAndWithdraw;
use App\Three;
use App\Two;
use App\User;
use App\UserWallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class DubaiPoutController extends Controller
{
    public function twoPout(Request $request, $two){

        PermissionChecker::CheckPermission('pout');
        $twopouts = DubaiTwo::select('user_id', DB::raw('SUM(amount) as total'))->groupBy('user_id')->where('two', $two)->whereDate('date', $request->date)->get();

        if($twopouts){
            foreach($twopouts as $twopout){
                $bet_historys = BetHistory::where('user_id',$twopout->user_id)->get();
            }
        }

        return view('backend.dubai_two_overview.dubai_twopout', compact('twopouts','bet_historys'));
    }

    public function twoBet(Request $request){

        $user_id = $request->user_id;
        $amount = $request->amount;

        $to_account = User::where('id',$user_id)->firstOrFail();

        $user_wallet = UserWallet::where('user_id',$user_id)->firstOrFail();
        $user_wallet->increment('amount',$amount);
        $user_wallet->update();

        $trx_id = UUIDGenerator::TrxId();
        $bet_history = new BetHistory();
        $bet_history->admin_user_id = Auth::guard('adminuser')->user()->id;
        $bet_history->user_id = $user_id;
        $bet_history->trx_id = $trx_id;
        $bet_history->is_deposit = 'win';
        $bet_history->type = 'Dubai 2D';
        $bet_history->amount = $amount;
        $bet_history->date =  now()->format('Y-m-d H:i:s');
        $bet_history->save();


        $title = 'ငွေအလျော်လက်ခံရရှိပါသည်';
        $message =  '+'. number_format($amount). 'Ks';
        $transaction_id = $trx_id;
        $sourceable_id = $request->user_id;
        $sourceable_type = Admin::class;

        Notification::send([$to_account], new AddAndWithdraw($title, $message, $transaction_id,$sourceable_id, $sourceable_type));

        return 'success';
    }
}
