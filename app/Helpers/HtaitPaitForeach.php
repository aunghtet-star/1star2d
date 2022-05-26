<?php
namespace App\Helpers;

use App\DubaiTwo;
use App\Two;
use Illuminate\Support\Facades\Auth;

class HtaitPaitForeach
{
    public static function htaitpait($datas, $amount)
    {
        foreach ($datas as $key=>$data) {
            $htaitpait = new Two();
            $htaitpait->user_id = Auth()->user()->id;
            $htaitpait->master_id = Auth()->user()->master_id;
            $htaitpait->admin_user_id = Auth()->user()->admin_user_id;
            $htaitpait->date = now()->format('Y-m-d');
            $htaitpait->two = $data;
            $htaitpait->amount = $amount;
            $htaitpait->save();
        }

        return $datas;
    }

    public static function DubaiHtaitPait($datas, $amount){
        foreach ($datas as $key=>$data) {
            $htaitpait = new DubaiTwo();
            $htaitpait->user_id = Auth()->user()->id;
            $htaitpait->master_id = Auth()->user()->master_id;
            $htaitpait->admin_user_id = Auth()->user()->admin_user_id;
            $htaitpait->date = now()->format('Y-m-d');
            $htaitpait->two = $data;
            $htaitpait->amount = $amount;
            $htaitpait->save();
        }

        return $datas;
    }

    public static function Brake($datas, $amount)
    {
//        $datas = collect($datas);
//        $allbreak = BrakeHtaitPait::AllBrake($datas, $amount);
        $onlybreak = BrakeHtaitPait::OnlyBrake($datas, $amount);


//        if ($allbreak) {
//            $disallowedall = $allbreak['breaks'];
//            $datas = array_diff($datas->toArray(), $disallowedall);
//        }

        if ($onlybreak) {
            $disallowedonly = $onlybreak['breaks'];
            $datas = array_diff($datas, $disallowedonly);
        }
        return $datas;
    }

    public static function DubaiBrake($datas, $amount)
    {

        $onlybreak = BrakeHtaitPait::DubaiOnlyBrake($datas, $amount);

        if ($onlybreak) {
            $disallowedonly = $onlybreak['breaks'];
            $datas = array_diff($datas, $disallowedonly);
        }
        return $datas;
    }
}
