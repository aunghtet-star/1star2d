<?php

namespace App\Helpers;

use App\WalletHistory;
use Illuminate\Support\Facades\Auth;

class ForWalletAndBetHistory
{
    public static function Slip($model,$admin_user_id,$user_id,$trx_id,$amount,$is_deposit,$type){

        $user = Auth::guard('adminuser')->user();

        $history = new $model();
        $history->admin_user_id = $admin_user_id;
        $history->user_id = $user_id;
        $history->trx_id = $trx_id;
        $history->amount = $amount;
        $history->is_deposit = $is_deposit;

        if ($user && ($history->is_deposit == 'deposit' || $history->is_deposit == 'withdraw')){
            if($user->hasRole('Admin')){
                $history->type = 'master';
            }

            if($user->hasRole('Master')){
                $history->type = 'agent';
            }

            if($user->hasRole('Agent')){
                $history->type = 'user';
            }
        }else{
            $history->type = $type;
        }

        $history->date = now()->format('Y-m-d H:i:s');
        $history->save();
    }
}
