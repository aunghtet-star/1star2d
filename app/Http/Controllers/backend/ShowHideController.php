<?php

namespace App\Http\Controllers\backend;

use App\ShowHide;
use Illuminate\Http\Request;
use App\Helpers\PermissionChecker;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ShowHideController extends Controller
{
    public function TwoShowHide()
    {
        PermissionChecker::CheckPermission('show_hide');
        $twoform = ShowHide::where('name', 'twoform')->first();

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
        PermissionChecker::CheckPermission('show_hide');
        $htaitpaitform = ShowHide::where('name', 'htaitpaitform')->first();

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
        PermissionChecker::CheckPermission('show_hide');
        $threeform = ShowHide::where('name', 'threeform')->first();

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
