@extends('backend.layouts.app')
@section('3D-over-history','mm-active')
@section('main')
    <h5 class="text-center mt-3" style="font-weight: 700">3D ထိုးထားသူများစာရင်း</h5>
    <div class="card m-3">
        <div class="card-body">
            @foreach ($threepouts as $threepout)
            <p>{{$threepout->users ? $threepout->users->name : '_'}} => <span>{{number_format($threepout->total)}}</span></p>
            
            @endforeach
        </div>
    </div>
@endsection