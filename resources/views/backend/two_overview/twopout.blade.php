@extends('backend.layouts.app')
@section('2D-over-history', 'mm-active')
@section('main')
    <h5 class="text-center mt-3" style="font-weight: 700">2D ထိုးထားသူများစာရင်း</h5>
    <div class="card m-3">
        <div class="card-body">
            @foreach ($twopouts as $twopout)
                <p>{{ $twopout->users ? $twopout->users->name : '_' }} => <span>{{ number_format($twopout->total) }}</span>
                        <a href="#" onclick="bet({{$twopout->users->id}},{{ $twopout->total }},'{{$twopout->users->name}}')"><i class="fa-solid fa-coins pl-3"></i></a></p>
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

            let bet = prompt("Please enter Bet Amount to " + name, amount * 80);


            $.ajax({
                url: `/admin/two-pout/${user_id}`,
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
                    },2000)
                }
            })
        }
    </script>
@endsection
