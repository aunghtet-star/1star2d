<?php

namespace App\Http\Controllers\backend;

use App\DubaiTwoOverview11am;
use App\DubaiTwoOverview1pm;
use App\DubaiTwoOverview3pm;
use App\DubaiTwoOverview5pm;
use App\DubaiTwoOverview7pm;
use App\DubaiTwoOverview9pm;
use App\Helpers\ForRealNumber;
use App\TwoOverview;
use App\TwoOverviewPM;
use App\AllBrakeWithAmount;
use Illuminate\Http\Request;
use App\Helpers\PermissionChecker;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RealNumberController extends Controller
{
    public function realNumber(Request $request){

        PermissionChecker::CheckPermission('real_number');
        $date = $request->date ?? now()->format('Y-m-d');


        $two_brake = AllBrakeWithAmount::select('amount')->where('type', '2D')->first();
        $two_am = ForRealNumber::AmountTotal(new TwoOverview,$date);
        $two_amount_total_am = $two_am['amount_total'];
        $new_amount_total_am = $two_am['new_amount_total'];
        $kyon_amount_total_am = $two_am['kyon_amount_total'];

        $two_pm = ForRealNumber::AmountTotal(new TwoOverviewPM,$date);
        $two_amount_total_pm = $two_pm['amount_total'];
        $new_amount_total_pm = $two_pm['new_amount_total'];
        $kyon_amount_total_pm = $two_pm['kyon_amount_total'];

        $two_11am = ForRealNumber::AmountTotal(new DubaiTwoOverview11am,$date);
        $two_amount_total_11am = $two_11am['amount_total'];
        $new_amount_total_11am = $two_11am['new_amount_total'];
        $kyon_amount_total_11am = $two_11am['kyon_amount_total'];

        $two_1pm = ForRealNumber::AmountTotal(new DubaiTwoOverview1pm,$date);
        $two_amount_total_1pm = $two_1pm['amount_total'];
        $new_amount_total_1pm = $two_1pm['new_amount_total'];
        $kyon_amount_total_1pm = $two_1pm['kyon_amount_total'];

        $two_3pm = ForRealNumber::AmountTotal(new DubaiTwoOverview3pm,$date);
        $two_amount_total_3pm = $two_3pm['amount_total'];
        $new_amount_total_3pm = $two_3pm['new_amount_total'];
        $kyon_amount_total_3pm = $two_3pm['kyon_amount_total'];

        $two_5pm = ForRealNumber::AmountTotal(new DubaiTwoOverview5pm,$date);
        $two_amount_total_5pm = $two_5pm['amount_total'];
        $new_amount_total_5pm = $two_5pm['new_amount_total'];
        $kyon_amount_total_5pm = $two_5pm['kyon_amount_total'];

        $two_7pm = ForRealNumber::AmountTotal(new DubaiTwoOverview7pm,$date);
        $two_amount_total_7pm = $two_7pm['amount_total'];
        $new_amount_total_7pm = $two_7pm['new_amount_total'];
        $kyon_amount_total_7pm = $two_7pm['kyon_amount_total'];

        $two_9pm = ForRealNumber::AmountTotal(new DubaiTwoOverview9pm,$date);
        $two_amount_total_9pm = $two_9pm['amount_total'];
        $new_amount_total_9pm = $two_9pm['new_amount_total'];
        $kyon_amount_total_9pm = $two_9pm['kyon_amount_total'];


        return view('backend.realnumber.index',
            compact('two_amount_total_am','new_amount_total_am','kyon_amount_total_am',
            'two_amount_total_pm','new_amount_total_pm','kyon_amount_total_pm',
            'two_amount_total_11am','new_amount_total_11am','kyon_amount_total_11am',
            'two_amount_total_1pm','new_amount_total_1pm','kyon_amount_total_1pm',
            'two_amount_total_3pm','new_amount_total_3pm','kyon_amount_total_3pm',
            'two_amount_total_5pm','new_amount_total_5pm','kyon_amount_total_5pm',
            'two_amount_total_7pm','new_amount_total_7pm','kyon_amount_total_7pm',
            'two_amount_total_9pm','new_amount_total_9pm','kyon_amount_total_9pm',
             'two_brake'));
    }
}
