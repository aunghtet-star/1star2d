<?php

namespace App\Http\Controllers;

use App\ShowHide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShowHideController extends Controller
{
    public function TwoShowHide()
    {
        $twoform = ShowHide::where('name', 'twoform')->where('admin_user_id', Auth::guard('adminuser')->user()->id)->first();

        if ($twoform->status == 'show') {
            $twoform->update([
            'status' => 'hide'
        ]);
        } else {
            $twoform->update([
                'status' => 'show'
            ]);
        }

        return back();
    }

    public function HtaitPaitShowHide()
    {
        $htaitpaitform = ShowHide::where('name', 'htaitpaitform')->where('admin_user_id', Auth::guard('adminuser')->user()->id)->first();

        if ($htaitpaitform->status == 'show') {
            $htaitpaitform->update([
            'status' => 'hide'
        ]);
        } else {
            $htaitpaitform->update([
                'status' => 'show'
            ]);
        }

        return back();
    }

    public function ThreeShowHide()
    {
        $threeform = ShowHide::where('name', 'threeform')->where('admin_user_id', Auth::guard('adminuser')->user()->id)->first();

        if ($threeform->status == 'show') {
            $threeform->update([
            'status' => 'hide'
        ]);
        } else {
            $threeform->update([
                'status' => 'show'
            ]);
        }

        return back();
    }
}
