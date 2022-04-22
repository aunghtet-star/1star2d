<?php

namespace App\Http\Controllers\backend;

use App\WalletHistory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Helpers\PermissionChecker;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WalletHistoryController extends Controller
{
    public function index()
    {
        PermissionChecker::CheckPermission('wallet_history');

        return view('backend.history.index');
    }

    public function ssd()
    {
        $user = Auth::guard('adminuser')->user();

        if($user->hasRole('Admin') ){
            $wallet_hisotry = WalletHistory::where('type','master')->where('admin_user_id',Auth::guard('adminuser')->user()->id)->limit(10);
        }

        if($user->hasRole('Master') ){
            $wallet_hisotry = WalletHistory::where('type','agent')->where('admin_user_id',Auth::guard('adminuser')->user()->id)->limit(10);
        }

        if($user->hasRole('Agent') ){
            $wallet_hisotry = WalletHistory::where('type','user')->where('admin_user_id',Auth::guard('adminuser')->user()->id)->limit(10);
        }

        if($user->hasRole('Admin') || $user->hasRole('Master') ){
           $data = Datatables::of($wallet_hisotry)
            ->filterColumn('user_id', function ($query, $keyword) {
                $query->whereHas('adminuser', function ($q1) use ($keyword) {
                    $q1->where('name', 'like', '%'.$keyword.'%');
                });
            });
        }

        if($user->hasRole('Agent')){
            $data = Datatables::of($wallet_hisotry)
            ->filterColumn('user_id', function ($query, $keyword) {
                $query->whereHas('user', function ($q1) use ($keyword) {
                    $q1->where('name', 'like', '%'.$keyword.'%');
                });
            });
        }

        return $data->addColumn('type', function ($each) {
            if ($each->is_deposit == 'deposit' || $each->is_deposit == 'bet') {
                return '<span class="badge badge-success p-2"> '.$each->is_deposit.'</span>';
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
            } else {
                return '<p class="text-danger"> - '.number_format($each->amount).'</p>';
            }
        })
        ->editColumn('updated_at', function ($each) {
            return $each->updated_at->format('Y-m-d h:i:s A');
        })
        ->rawColumns(['amount','action', 'type'])
        ->make(true);
    }
}
