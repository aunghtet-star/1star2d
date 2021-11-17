@extends('backend.layouts.app')
@section('2D-over-history','mm-active')
@section('main')
    <h5 class="text-center mt-3" style="font-weight: 700">2D ထိုးထားသူများစာရင်း</h5>
    <div class="card m-3">
        <div class="card-body">
            @foreach ($twopouts as $twopout)
            <p>{{$twopout->users ? $twopout->users->name : '_'}} => <span>{{number_format($twopout->total)}}</span></p>
            
            @endforeach
        </div>
    </div>
@endsection