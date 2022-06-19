@extends('frontend.layouts.app')
@section('normal-3d','active')

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
                @if($threeform->status == 'show')
                    <div class="card">
                        <div class="d-flex justify-content-between">
                            <h5 class="" style="margin-top: 16px; margin-left:23px">3D ထိုးရန်</h5>
                            <a href="" class="btn btn-success mt-3 btn-sm add-btn" style="margin-bottom: -16px; margin-right:23px ; height:30px ;font-weight:900"><i class="fas fa-plus-circle"></i> ထပ်ထည့်ရန် </a>
                        </div>

                        <div class="card-body">
                            <form id="validate" action="{{url('normal-three/confirm')}}" method="POST" id="">
                                @csrf
                                <div class="row" >
                                    <div class="col-4">
                                        <div class="form-group" id="inputs">
                                            <label for="">3D</label>
                                            <input type="number" name="three[]" class="form-control" id="three" required>
                                        </div>
                                    </div>

                                    <div class="col-4 col-md-6">
                                        <div class="form-group" id="inputs">
                                            <label for="">Amount</label>
                                            <input type="number" name="amount[]" class="form-control" id="amount"  required>
                                        </div>
                                    </div>
                                    <div class="col-3 col-md-1" style="margin-top:5px">
                                        <label for=""></label>
                                        <div class="" >
                                            <a href="" class="btn btn-danger btn-sm remove-btn " style="font-weight:900;"><i class="fas fa-minus-circle"></i></a>
                                        </div>
                                    </div>

                                </div>
                                <div class="test"></div>
                                <button type="submit" id="submit" class="btn btn-primary m-0 btn-sm" style="font-weight:700">ထိုးမည်</button>
                        </div>
                        </form>
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
@section('scripts')
    {{-- {!! JsValidator::formRequest('App\Http\Requests\StoreUserTwoD') !!} --}}

    <script>
        $(document).ready(function(){

            $('#validate').validate({
                rules : {
                    'three[]' : {
                        required : true,
                        minlength : 3,
                        maxlength :3
                    },
                    'amount[]' : {
                        required :true,
                        min : 50
                    },
                },
                messages : {
                    'three[]' : '3D ဖြည့်ပါ',
                    'amount[]' : 'Amount ဖြည့်ပါ'
                }
            });

            var i = 0;
            $('.add-btn').on('click',function(e){
                e.preventDefault();
                var three = $('#three').val();
                i++;
                var form = `<div class="row" id="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="">3D</label>
                                    <input type="number" name="three[]" class="form-control"  required>
                                </div>
                            </div>

                             <div class="col-4 col-md-6">
                                <div class="form-group" id="inputs">
                                    <label for="">Amount</label>
                                    <input type="number" name="amount[]" class="form-control" id="amount"  required>
                                </div>
                            </div>
                            <div class="col-3 col-md-1" style="margin-top:5px">
                                <label for=""></label>
                                <div class="" >
                                    <a href="" class="btn btn-danger btn-sm remove-btn " style="font-weight:900;"><i class="fas fa-minus-circle"></i></a>
                                </div>
                            </div>
                        </div>`

                $('.test').append(form);

                $(document).on('click','.remove-btn',function(e){
                    e.preventDefault();
                    $(this).parents('#row').remove();
                })

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
