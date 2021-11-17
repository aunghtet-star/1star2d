@extends('backend.layouts.app')
@section('profile','mm-active')
@section('title','profile')
@section('extra_css')
    <style>
        a{
            text-decoration: none;
            color: #000;
        }
        a:hover{
            color: #000;
            text-decoration: none;
        }
    </style>
@endsection
@section('main')
<div class="d-flex justify-content-center">
    <div class="col-md-8">
        <div class="card mt-3">
            <div class="card-body">
                <div class="text-center mb-5">
                    <img width="80" class="rounded-circle" src="https://eu.ui-avatars.com/api/?name={{Auth::guard('adminuser')->user()->name}}" alt="">
                    <h5 class="mb-2 mt-3" style="text-transform: uppercase;font-weight:700">{{Auth::guard('adminuser')->user()->name}}</h5>
                    <p class="mb-1">{{number_format($admin_wallet->amount)}} Kyat</p>
                    <p class="mb-1 badge badge-pill badge-primary">{{$admin_wallet->status}}</p>
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <p class="mb-1">Phone</p>
                    <p class="mb-1">{{Auth::guard('adminuser')->user()->phone}}</p>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-3">
                    <p class="mb-1">Email</p>
                    <p class="mb-1">{{Auth::guard('adminuser')->user()->email}}</p>
                </div>
                <hr>
                <a href="{{url('admin/profile/transactions')}}">
                    <div class="d-flex justify-content-between mb-3">
                        <p class="mb-1">Transaction History</p>
                        <p class="mb-1"><i class="fas fa-chevron-right"></i></p>
                    </div>
                </a>
                @if('view_updatepassword')
                @can('view_updatepassword')
                <hr>
                <a href="{{url('admin/profile/updatepassword')}}">
                    <div class="d-flex justify-content-between mb-3">
                        <p class="mb-1">Update Password</p>
                        <p class="mb-1"><i class="fas fa-chevron-right"></i></p>
                    </div>
                </a>
                @endcan
                @endif

            </div>
        </div>
    </div>
</div>
@endsection