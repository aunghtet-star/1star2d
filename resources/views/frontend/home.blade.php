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
            
            <h6 class="text-center">Updated {{$AmtwoDs[0]->Date}}</h6>

            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="text-center mb-3">12:01 PM</h5>
                    <hr>
                    <div class="d-flex justify-content-between ">
                        <p class="pl-2">SET</p>
                        <p>VALUE</p>
                        <p>2D</p>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        
                        <p>
                            @if($AmtwoDs[0]->Set)
                            @php
                             echo $AmtwoDs[0]->Set;
                            @endphp
                            @else
                                <p>--</p>
                            @endif
                        </p> 
                        <p>
                            @if($AmtwoDs[0]->Value)
                            @php
                             echo $AmtwoDs[0]->Value;
                            @endphp
                            @else
                                <p>--</p>
                            @endif
                        </p> 
                        <p>
                            @if($AmtwoDs[0]->{'No.'})
                            @php
                             echo $AmtwoDs[0]->{'No.'};
                            @endphp
                            @else
                                <p>--</p>
                            @endif
                        </p>
                    </div>
                    
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="text-center mb-3">4:31 PM</h5>
                    <hr>
                    <div class="d-flex justify-content-between ">
                        <p class="pl-2">SET</p>
                        <p>VALUE</p>
                        <p>2D</p>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        
                        <p style="margin-left: 14px">
                            @if($PmtwoDs[0]->Set)
                            @php
                             echo $PmtwoDs[0]->Set;
                            @endphp
                            @endif
                        </p> 
                        <p>
                            @if($PmtwoDs[0]->Value)
                            @php
                             echo $PmtwoDs[0]->Value;
                            @endphp
                            @endif
                        </p> 
                        <p>
                            @if($PmtwoDs[0]->{'No.'})
                            @php
                             echo $PmtwoDs[0]->{'No.'};
                            @endphp
                            @endif
                        </p>
                    </div>
                    
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