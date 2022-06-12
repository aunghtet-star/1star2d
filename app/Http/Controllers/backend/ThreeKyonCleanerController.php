<?php

namespace App\Http\Controllers\backend;

use App\Helpers\ForThreeKyonCleaner;
use App\Http\Controllers\Controller;
use App\ThreeKyon;
use App\ThreeOverview;
use Illuminate\Http\Request;

class ThreeKyonCleanerController extends Controller
{
    // For New Amount   i.e edit button in two overview page
    public function NewAmount(Request $request){
        ForThreeKyonCleaner::newAmount(new ThreeOverview,$request->new_amount,$request->three_d,$request->date);
    }

    // For Kyon Cleaner   i.e clear button in two overview page
    public function KyonAmount(Request $request){
        ForThreeKyonCleaner::kyonAmount(new ThreeOverview,new ThreeKyon,$request->date);
    }
}
