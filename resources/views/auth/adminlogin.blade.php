@extends('backend.layouts.app_plain')
@section('extra_css')
    <style>
        .custom-font{
            font-family: 'Staatliches', cursive;
        }
        
        form i {
            cursor: pointer;
            top: 5px;
            right: 28px;
            position: absolute;
        }

        .myButton {
            background:linear-gradient(to bottom, #7892c2 5%, #476e9e 100%);
            background-color:#7892c2;
            border-radius:11px;
            border: none;
            outline: none;
            display:inline-block;
            cursor:pointer;
            color:#ffffff;
            font-family:Times New Roman;
            font-size:17px;
            font-weight:bold;
            padding:2px 13px;
            text-decoration:none;
        }
        .myButton:hover {
            background:linear-gradient(to bottom, #476e9e 5%, #7892c2 100%);
            background-color:#476e9e;
            border: none;
            outline: none;
        }
        .myButton:active {
            position:relative;
            top:1px;
            border: none;
            outline: none;
        }

        .card{
            padding: 30px;
            border-radius: 48px;
            background: #e2dfdf;
            box-shadow: inset -8px -8px 13px #959393,
                        inset 8px 8px 13px #ffffff;
        }

    </style>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-md-6">
            <h4 class="text-center custom-font font-weight-bolder mb-2">AGENCY SYSTEM</h4>
            <div class="card">

                <div class="card-body">
                    <form method="POST" action="{{route('admin.login')}}">
                        @csrf

                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">Phone</label>

                            <div class="col-md-6">
                                <input id="phone" type="phone" class="form-control @error('phone') is-invalid @enderror"
                                    name="phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus>

                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password')
                                }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="current-password">
                                    <i class="bi bi-eye-slash" id="togglePassword"></i>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{
                                        old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="myButton">
                                    Login
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click',function(){
            //toggle the password
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type',type);

            //toggle eye
            this.classList.toggle('bi-eye');

        })
    </script>
@endsection