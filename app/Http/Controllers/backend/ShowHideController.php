<?php

namespace App\Http\Controllers\backend;

use App\Helpers\ForShowHideStatus;
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
        ForShowHideStatus::Status('twoform');
        return back();
    }

    public function HtaitPaitShowHide()
    {
        PermissionChecker::CheckPermission('show_hide');
        ForShowHideStatus::Status('htaitpaitform');

        return back();
    }

    public function ThreeShowHide()
    {
        PermissionChecker::CheckPermission('show_hide');
        ForShowHideStatus::Status('threeform');
        return back();
    }

    public function DubaiTwoShowHide()
    {
        PermissionChecker::CheckPermission('show_hide');
        ForShowHideStatus::Status('dubai_twoform');
        return back();
    }

    public function DubaiHtaitPaitShowHide()
    {
        PermissionChecker::CheckPermission('show_hide');
        ForShowHideStatus::Status('dubai_htaitpaitform');
        return back();
    }
}
