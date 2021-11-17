<?php
namespace App\Helpers;

use App\Two;

class HtaitPaitForeach
{
    public static function htaitpait($datas, $amount)
    {
        if ($datas == []) {
            return back()->withErrors(['0 ထိပ်သည် မရတော့ပါ'])->withInput();
        }
        foreach ($datas as $key=>$data) {
            $htaitpait = new Two();
            $htaitpait->user_id = Auth()->user()->id;
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
        $datas = collect($datas);
        $allbreak = BrakeHtaitPait::AllBrake($datas, $amount);
        $onlybreak = BrakeHtaitPait::OnlyBrake($datas, $amount);
        
        
        if ($allbreak) {
            $disallowedall = $allbreak['breaks'];
            $datas = array_diff($datas->toArray(), $disallowedall);
        }
        if ($onlybreak) {
            $disallowedonly = $onlybreak['breaks'];
            $datas = array_diff($datas, $disallowedonly);
        }
        return $datas;
    }
}
