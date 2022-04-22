<?php

namespace App\Http\Controllers\backend;

use App\AllBrakeWithAmount;
use App\DubaiTwoKyon11am;
use App\DubaiTwoKyon1pm;
use App\DubaiTwoKyon3pm;
use App\DubaiTwoKyon5pm;
use App\DubaiTwoKyon7pm;
use App\DubaiTwoKyon9pm;
use App\DubaiTwoOverview11am;
use App\DubaiTwoOverview1pm;
use App\DubaiTwoOverview3pm;
use App\DubaiTwoOverview5pm;
use App\DubaiTwoOverview7pm;
use App\DubaiTwoOverview9pm;
use App\Helpers\ForTwoKyonCleaner;
use App\Http\Controllers\Controller;
use App\twoKyonAM;
use App\twoKyonPM;
use App\TwoOverview;
use App\TwoOverviewPM;
use Illuminate\Http\Request;

class DubaiTwoKyonCleaner extends Controller
{

    // For New Amount   i.e edit button in two overview page
    public function NewAmount_11am(Request $request){
        ForTwoKyonCleaner::newAmount(new DubaiTwoOverview11am,$request->new_amount,$request->two_d,$request->date);
    }

    public function NewAmount_1pm(Request $request){
        ForTwoKyonCleaner::newAmount(new DubaiTwoOverview1pm,$request->new_amount,$request->two_d,$request->date);
    }

    public function NewAmount_3pm(Request $request){
        ForTwoKyonCleaner::newAmount(new DubaiTwoOverview3pm,$request->new_amount,$request->two_d,$request->date);
    }

    public function NewAmount_5pm(Request $request){
        ForTwoKyonCleaner::newAmount(new DubaiTwoOverview5pm,$request->new_amount,$request->two_d,$request->date);
    }

    public function NewAmount_7pm(Request $request){
        ForTwoKyonCleaner::newAmount(new DubaiTwoOverview7pm,$request->new_amount,$request->two_d,$request->date);
    }

    public function NewAmount_9pm(Request $request){
        ForTwoKyonCleaner::newAmount(new DubaiTwoOverview9pm,$request->new_amount,$request->two_d,$request->date);
    }

    // For Kyon Cleaner   i.e clear button in two overview page

    public function kyonAmount_11am(Request $request){
        ForTwoKyonCleaner::kyonAmount(new DubaiTwoOverview11am,new DubaiTwoKyon11am,$request->date);
    }

    public function kyonAmount_1pm(Request $request){
        ForTwoKyonCleaner::kyonAmount(new DubaiTwoOverview1pm,new DubaiTwoKyon1pm,$request->date);
    }

    public function kyonAmount_3pm(Request $request){
        ForTwoKyonCleaner::kyonAmount(new DubaiTwoOverview3pm,new DubaiTwoKyon3pm,$request->date);
    }

    public function kyonAmount_5pm(Request $request){
        ForTwoKyonCleaner::kyonAmount(new DubaiTwoOverview5pm,new DubaiTwoKyon5pm,$request->date);
    }

    public function kyonAmount_7pm(Request $request){
        ForTwoKyonCleaner::kyonAmount(new DubaiTwoOverview7pm,new DubaiTwoKyon7pm,$request->date);
    }

    public function kyonAmount_9pm(Request $request){
        ForTwoKyonCleaner::kyonAmount(new DubaiTwoOverview9pm,new DubaiTwoKyon9pm,$request->date);
    }

}
