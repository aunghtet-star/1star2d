@extends('frontend.layouts.app')
@section('3d','active')

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
            @foreach($errors->all() as $error)
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{$error}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            @endforeach
            <div class="card">
                <div class="d-flex justify-content-between">
                    <h5 class="" style="margin-top: 16px; margin-left:23px">3D ထိုးရန်</h5>
                    <a href="" class="btn btn-success mt-3 btn-sm add-btn" style="margin-bottom: -16px; margin-right:23px ; height:30px ;font-weight:900"><i class="fas fa-plus-circle"></i> ထပ်ထည့်ရန် </a>
                </div>
                <div class="card-body">
                    <form id="validate" action="{{url('three/confirm')}}" method="POST" id="">
                        @csrf
                        <div class="row" >
                            <div class="col-3"> 
                                <div class="form-group" id="inputs">
                                    <label for="">3D</label>
                                    <input type="number" name="three[]" class="form-control" required>
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
                        <button type="submit" id="submit" class="btn btn-primary m-0 btn-sm" style="font-weight:700">ထိုးမည်</button>
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
                    'three[]' : 'Please fill 3D',
                    'amount[]' : 'Please fill amount'
                }
        });

        $('.add-btn').on('click',function(e){
            e.preventDefault();
             var form = '<div class="row">'+
                            '<div class="col-3">'+
                                '<div class="form-group">'+
                                    '<label for="">3D</label>'+
                                    '<input type="number" name="three[]" class="form-control " required>'+
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