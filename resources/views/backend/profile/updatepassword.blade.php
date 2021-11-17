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
    <div class="col-md-8 mt-5">
        @include('frontend.flash')
        <div class="card mt-3">
            <div class="card-body">
                <div class="text-center mb-5">
                    <img src="{{asset('backend/images/secure.png')}}" alt="">
                </div>
                <form action="{{url('admin/profile/updatepassword/store')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="">Old password</label>
                        <input type="password" name="oldpassword" class="form-control" id="">
                    </div>
                    
                    <div class="form-group">
                        <label for="">New password</label>
                        <input type="password" name="newpassword" class="form-control" id="">
                    </div>

                    <button class="btn btn-primary mt-2">Submit</button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\UpdatePassword') !!}
@endsection