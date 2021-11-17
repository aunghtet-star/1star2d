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
            @include('frontend.flash')
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <p class="mb-0">သင်၏လက်ကျန်ငွေ </p>
                        <p class="mb-0">{{Auth()->user()->wallet ? Auth()->user()->wallet->amount : '_'}} ကျပ် </p>
                    </div>
                </div>
            </div>
            @if($twoform->status == 'show')
            <div class="card">
                <div class="d-flex justify-content-between">
                    <h5 class="" style="margin-top: 16px; margin-left:23px">2D ထိုးရန်</h5>
                    <a href="" class="btn btn-success mt-3 btn-sm add-btn" style="margin-bottom: -16px; margin-right:23px ; height:30px ;font-weight:900"><i class="fas fa-plus-circle"></i> ထပ်ထည့်ရန် </a>
                </div>
                
                <div class="card-body">
                    <form id="validate" action="{{url('two/confirm')}}" method="POST" id="">
                        @csrf
                        <div class="row" >
                            <div class="col-3">
                                <div class="form-group" id="inputs">
                                    <label for="">2D</label>
                                    <input type="number" name="two[]" class="form-control" id="two" required>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="form-group" id="inputs">
                                    <label for="">Amount</label>
                                    <input type="number" name="amount[]" class="form-control" id="amount"  required>
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
                'two[]' : {
                    required : true,
                    minlength : 2,
                    maxlength :2
                },
                'amount[]' : {
                    required :true,
                    min : 50
                },
            },
            messages : {
                    'two[]' : '2D ဖြည့်ပါ',
                    'amount[]' : 'Amount ဖြည့်ပါ'
                }
        });

        $('.add-btn').on('click',function(e){
            e.preventDefault();
             var two = $('#two').val();
             var form = '<div class="row">'+
                            '<div class="col-3">'+
                                '<div class="form-group">'+
                                    '<label for="">2D</label>'+
                                    '<input type="number" name="two[]" class="form-control"  required>'+
                                    '</div>'+
                                    '</div>'+
                                    '<div class="col-9">'+
                                '<div class="form-group">'+
                                    '<label for="">Amount</label>'+
                                    '<input type="number" name="amount[]" class="form-control " required>'+
                                    '</div>'+
                                    '</div>'+
                                    '</div>'
            
            $('.test').append(form);

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