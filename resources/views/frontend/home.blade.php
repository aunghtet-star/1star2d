@extends('frontend.layouts.app')
@section('extra_css')
   <style>
       .error{
           color: red;
           border-color: red;
       }
    </style> 
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <span id="message_error"></span>
            
            <div class="card">
                <div class="d-flex justify-content-end">
                    <a href="" class="btn btn-success mt-3 btn-sm add-btn" style="margin-bottom: -16px; margin-right:23px"><i class="fas fa-plus-circle"></i> Add </a>
                </div>
                <div class="card-body">
                    <form id="validate" action="{{url('two/confirm')}}" method="POST" id="">
                        @csrf
                        <div class="row" >
                            <div class="col-3">
                                <div class="form-group" id="inputs">
                                    <label for="">2D</label>
                                    <input type="number" name="two[]" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="form-group" id="inputs">
                                    <label for="">Amount</label>
                                    <input type="number" name="amount[]" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="test"></div>
                        <button type="submit" id="submit" class="btn btn-primary m-0 btn-sm">Confirm</button>
                </div>
                </form>
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
                    'two[]' : 'Please fill 2D',
                    'amount[]' : 'Please fill amount'
                }
        });

        $('.add-btn').on('click',function(e){
            e.preventDefault();
             var form = '<div class="row">'+
                            '<div class="col-3">'+
                                '<div class="form-group">'+
                                    '<label for="">2D</label>'+
                                    '<input type="number" name="two[]" class="form-control " required>'+
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