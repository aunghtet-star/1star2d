@extends('backend.layouts.app')
@section('3D-over-history','mm-active')
@section('main')
    <h5 class="text-center mt-3" style="font-weight: 700">3D ထိုးထားသူများစာရင်း</h5>
    <div class="card m-3">
        <div class="card-body">
            @foreach ($threepouts as $threepout)
            <p>{{$threepout->users ? $threepout->users->name : '_'}} => <span>{{number_format($threepout->total)}}</span>
                <a href="#" onclick="bet({{$threepout->users->id}},{{ $threepout->total }},'{{$threepout->users->name}}')"><i class="fa-solid fa-coins pl-3"></i></a>
            </p>

            @endforeach
        </div>
    </div>
@endsection
@section('scripts')
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

        function bet(user_id,amount,name) {

            let bet = prompt("Please enter Bet Amount to " + name, amount * 550);

            $.ajax({
                url: `/admin/three-pout/${user_id}`,
                method: 'post',
                data: {
                    amount: bet,
                    user_id: user_id,
                },
                success: function(res) {

                    if(res.status == 'success') {
                        Toast.fire({
                            icon: 'success',
                            title: res.msg
                        });
                    }
                    setTimeout(() => {
                        window.location.reload();
                    },2000);

                }
            })
        }
    </script>
@endsection
