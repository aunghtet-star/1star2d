<?php

namespace App\Http\Controllers\backend;

use App\BetHistory;
use Illuminate\Http\Request;
use App\Helpers\PermissionChecker;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;

class BetHistoryController extends Controller
{
    public function index()
    {
        PermissionChecker::CheckPermission('bet_history');

        return view('backend.bet_history.index');
    }

    public function ssd()
    {
        $user = Auth::guard('adminuser')->user();

        $bet_hisotry = BetHistory::query();

        $data = Datatables::of($bet_hisotry)
        ->filterColumn('user_id', function ($query, $keyword) {
            $query->whereHas('user', function ($q1) use ($keyword) {
                $q1->where('name', 'like', '%'.$keyword.'%');
            });
        });

        return $data->editColumn('is_deposit', function ($each) {
            if ($each->is_deposit == 'deposit' || $each->is_deposit == 'bet') {
                return '<span class="badge badge-success p-2"> '.$each->is_deposit.'</span>';
            }elseif ($each->is_deposit == 'fix'){
                return '<span class="badge badge-warning p-2"> '.$each->is_deposit.'</span>';
            } else {
                return '<span class="badge badge-danger p-2"> '.$each->is_deposit.'</span>';
            }
        })
        ->editColumn('user_id', function ($each) {
            return $each->getNameAttribute();
        })
        ->editColumn('amount', function ($each) {
            if ($each->is_deposit == 'deposit' || $each->is_deposit == 'bet') {
                return '<p class="text-success"> + '.number_format($each->amount).'</p>';
            }elseif ($each->type == 'from admin'){
                return '<p class="text-success"> + '.number_format($each->amount).'</p>';
            }elseif ($each->type == 'to admin'){
                return '<p class="text-danger"> - '.number_format($each->amount).'</p>';
            } else {
                return '<p class="text-danger"> - '.number_format($each->amount).'</p>';
            }
        })
        ->editColumn('updated_at', function ($each) {
            return $each->updated_at->format('Y-m-d h:i:s A');
        })
        ->rawColumns(['amount','action', 'is_deposit'])
        ->make(true);
    }
}
