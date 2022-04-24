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
            @if ($threeform->status == 'show')
            <div class="card">
                <div class="d-flex justify-content-between">
                    <h5 class="" style="margin-top: 16px; margin-left:23px">3D ထိုးရန်</h5>
                </div>
                <div class="card-body">
                    <form id="validate" action="{{url('three/confirm')}}" method="POST" id="">
                        @csrf
                        <div class="row" >
                            <div class="col-3">
                                <div class="form-group" id="inputs">
                                    <label for="">3D</label>
                                    <input type="number" name="three[]" class="form-control" id="three" required>
                                </div>
                            </div>

                            <div class="col-1" >
                                <label for="r" >R</label>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="r[]" id="r" value="0" style="margin-top:13px">
                                </div>
                            </div>

                            <div class="col-7">
                                <div class="form-group" id="inputs">
                                    <label for="">Amount</label>
                                    <input type="number" name="amount[]" class="form-control" id="amount"  required>
                                </div>
                            </div>


                        </div>

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
                    'three[]' : 'Please fill 3D',
                    'amount[]' : 'Please fill amount'
                }
        });



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
