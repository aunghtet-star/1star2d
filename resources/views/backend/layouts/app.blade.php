<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>1Star2DMM</title>
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="csrf-token" content="{{csrf_token()}}">

    
    <link href="{{asset('backend/css/main.css')}}" rel="stylesheet">
    
    {{-- ================== Font awesome ================= --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"
    integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- ================== Datatable ================= --}}
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
    
    {{-- Date ranger picker --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


    {{-- ================== Custom CSS ================= --}}

    <link href="{{asset('backend/css/style.css')}}" rel="stylesheet">

</head>

<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        @include('backend.layouts.header')
        <div class="app-main">
            @include('backend.layouts.side')
            <div class="app-main__outer">
                @yield('main')

                <div class="app-wrapper-footer">
                    <div class="app-footer">
                        <div class="app-footer__inner text-center">
                            <p class="mb-0">Copyright &copy; by Aung Htet Thu</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript" src="{{asset('backend/scripts/main.js')}}"></script>

    <!-- Javascript Requirements Validation -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>

    {{-- Sweet Alert2 --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Date range picker --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>

    @yield('scripts')
    <script>
        $(document).ready(function(){
        let token = document.head.querySelector('meta[name="csrf-token"]');

        if(token){
            $.ajaxSetup({
            headers : {
                'X-CSRF_TOKEN' : token.content  
            }
        })
        }
        

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
    });
    </script>
</body>

</html>