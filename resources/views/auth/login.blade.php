@extends('frontend.layouts.app_plain')
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

    .form-control:focus {
        caret-color: red !important;
        color: #495057;
        background-color: #fff;
        border-color: transparent !important;
        outline: 0 !important;
        box-shadow: 0 0 0 0.2rem rgb(43 38 5 /17%) !important;
    }

    .card {
        background-color: transparent !important;

    }
 </style>
@endsection
@section('content')
<div class="container mt-4">
    <marquee class="mb-5"><span class="font-weight-bolder text-light h3">နှစ်သစ်မှာ ရွှင်လန်းချမ်းမြေ့ပါစေ</span> </marquee>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h4 class="custom-font text-center font-weight-bolder text-light">1 Star <span class="text-danger">2D</span></h4>
            <div class="card rounded border-light">
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-light text-md-right">Phone</label>

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
                            <label for="password" class="col-md-4 col-form-label text-light text-md-right">{{ __('Password')
                                }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="current-password" ><i class="bi bi-eye-slash" id="togglePassword"></i>

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

                                    <label class="form-check-label text-light" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-sm btn-outline-light">
                                    {{ __('Login') }}
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
         const togglePassword = document.querySelector("#togglePassword");
         const password = document.querySelector("#password");

          togglePassword.addEventListener("click", function () {
            // toggle the type attribute
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);

            // toggle the icon
            this.classList.toggle("bi-eye");
        });
    </script>
@endsection
