@extends('frontend.layouts.app')
@section('copy-2d','active')

@section('extra_css')
    <style>

        .error{
            color: red;
            border-color: red;
            font-size: 10px;
            font-weight: 600;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('frontend.flash')
                @if($twoform->status == 'show')
                    <div class="card">
                        <div class="d-flex justify-content-between">
                            <h5 class="" style="margin-top: 16px; margin-left:23px">2D Copy ရန်</h5>
                        </div>

                        <div class="card-body">
                            <form action="{{'copy-paste-two/confirm'}}" method="POST">
                                @csrf
                                <textarea name="two" class="form-control" required rows="25"></textarea>
                                <button type="submit" id="submit" class="btn btn-primary m-3 float-right btn-sm" style="font-weight:700">ထိုးမည်</button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="d-flex justify-content-center align-items-center" style="height:100vh">
                        <h4 class="text-center text-danger" style="font-weight: 700;">ပိတ်ထားပါသည်</h4>
                    </div>
                @endif
            </div>
        </div>
    </div>
    </div>
@endsection

