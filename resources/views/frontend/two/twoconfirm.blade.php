@extends('frontend.layouts.app')
@section('2d','active')

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
                    <form action="{{url('two/create')}}" method="POST">
                        @csrf
                        <div>
                            {{-- @php
                            $total = 0;
                            @endphp --}}
                        @foreach($twos ?? [] as $key=>$two)
                            <input type="hidden" name="two[]" value="{{$two}}">
                            <input type="hidden" name="amount[]" value="{{$amount[$key]}}">

                            <p class="mb-1">{{$two}} => <span class="mb-1">{{$amount[$key]}}</span> </p>

                            {{-- @php
                                $total += $amount;
                            @endphp --}}
                        @endforeach
                        @foreach ($r_keys ?? [] as $r_key)
                            <input type="hidden" name="r_key[]" value="{{$r_key}}" >
                        @endforeach

                        @foreach($reverse_two ?? [] as $key=>$r_two)
                        <input type="hidden" name="r_two[]" value="{{$r_two}}" >
                        <p class="mb-1">{{$r_two}} => <span class="mb-1">{{$amount[$key]}}</span> </p>

                        @endforeach

                        </div>
                        <p class="text-success" style="font-size: 20px;font-weight:700">စုစုပေါင်း -
                            @php
                                echo number_format($total);
                            @endphp
                        </p>
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
{{-- {!! JsValidator::formRequest('App\Http\Requests\StoreUserTwoD') !!} --}}

<script>
    $(document).ready(function(){

        $('.cancel-btn').on('click',function(){
            window.history.go(-1);
            return false;
        })

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
            })
            @if(session('create'))
            Toast.fire({
            icon: 'success',
            title: '{{session('create')}}'
            })
            @endif()

            @if(session('update'))
            Toast.fire({
            icon: 'success',
            title: '{{session('update')}}'
            })
            @endif()

            @if(session('delete'))
            Toast.fire({
            icon: 'success',
            title: '{{session('delete')}}'
            })
            @endif()
    })
</script>

@endsection
