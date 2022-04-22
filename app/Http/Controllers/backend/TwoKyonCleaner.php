<?php

namespace App\Http\Controllers\backend;

use App\AllBrakeWithAmount;
use App\Helpers\ForTwoKyonCleaner;
use App\Two;
use App\twoKyonAM;
use App\twoKyonPM;
use Carbon\Carbon;
use App\TwoOverview;
use App\TwoOverviewPM;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TwoKyonCleaner extends Controller
{
    public function NewAmount(Request $request){
        ForTwoKyonCleaner::newAmount(new TwoOverview,$request->new_amount,$request->two_d,$request->date);
    }

    public function pmNewAmount(Request $request){
        ForTwoKyonCleaner::newAmount(new TwoOverviewPM,$request->new_amount,$request->two_d,$request->date);
    }

    public function kyonAmountAm(Request $request){
       ForTwoKyonCleaner::kyonAmount(new TwoOverview,new twoKyonAM,$request->date);
    }

    public function kyonAmountPm(Request $request){
        ForTwoKyonCleaner::kyonAmount(new TwoOverviewPM,new twoKyonPM,$request->date);
    }
}
