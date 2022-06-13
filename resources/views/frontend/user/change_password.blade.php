@extends('frontend.layouts.app')
@section('password-change','active')

@section('extra_css')
@endsection
@section('content')
    <div class="container">
        <div class="d-flex justify-content-center p-4" >
            <div class="col-md-6 ">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('change-password')}}" method="POST" id="change-password">
                            @csrf
                            <div class="form-group">
                                <label for="">Old Password</label>
                                <input type="text" class="form-control" name="old_password">
                            </div>

                            <div class="form-group">
                                <label for="">New Password</label>
                                <input type="text" class="form-control" name="new_password">
                            </div>

                            <button type="submit" class="btn btn-dark btn-sm mt-3">Confirm</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\ChangePassword', '#change-password'); !!}

    <script>
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

        @if(session('update'))
        Toast.fire({
            icon: 'success',
            title: '{{session('update')}}'
        })
        @endif()

        @if(session('error'))
        Toast.fire({
            icon: 'error',
            title: '{{session('error')}}'
        })
        @endif()
    </script>
@endsection
