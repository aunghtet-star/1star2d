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
                @foreach($errors->all() as $error)
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        {{$error}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endforeach
                <div class="card">
                    <div class="card-body text-center">
                        <p class="text-danger" style="font-size: 20px;font-weight:700">သင်ထိုးထားတာတွေဟုတ်ပါသလား</p>
                        <form action="{{url('/copy-paste-two/create')}}" method="POST">
                            @csrf
                            <div>
                                @foreach($response ?? [] as $two)
                                    <input type="hidden" name="twos[]" value="{{$two[0]}},{{$two[1]}}">


                                    <p class="mb-1">{{$two[0]}} - {{$two[1]}}</p>
                                @endforeach
                                <h5>Total - {{$total}}</h5>
                            </div>

                            <div>
                                <button type="button" class="btn btn-sm btn-danger cancel-btn" style="font-weight:700">မလုပ်ပါ</button>
                                <button type="submit" class="btn btn-sm btn-primary" style="font-weight:700">လုပ်မည်</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('scripts')
    {{-- {!! JsValidator::formRequest('App\Http\Requests\StoreUsertwoD') !!} --}}

    <script>
        $(document).ready(function(){

            $('.cancel-btn').on('click',function(){
                window.history.go(-1);
                return false;
            })


        })
    </script>

@endsection
