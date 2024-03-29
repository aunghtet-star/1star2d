@extends('backend.layouts.app')
@section('3D-over-history','mm-active')
@section('main')
    <h5 class="text-center mt-3" style="font-weight: 700">3D ထိုးထားသူများစာရင်း</h5>
    <div class="card m-3">
        <div class="card-body">
            @foreach ($pouts as $pout)
                <p>{{ $pout->users ? $pout->users->name : '_' }} => <span>{{ number_format($pout->amount) }}</span>
                    <a href="#" onclick="bet({{$pout->user_id}},'{{$pout->three}}',{{ $pout->amount }},'{{$pout->users->name}}','{{$pout->date}}')"><i class="fa-solid fa-coins pl-3 @if($pout->status == 'done') text-danger @endif"></i></a></p>
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

        function bet(user_id,three,amount,name,date) {

            let bet = prompt("Please enter Bet Amount to " + name, amount * 550);

            $.ajax({
                url: `/admin/three-pout/${user_id}`,
                method: 'post',
                data: {
                    user_id: user_id,
                    amount: bet,
                    three : three,
                    date : date
                },
                success: function(res) {
                    if(res.status == 'success') {
                        Swal.fire(
                            'လျော်ပြီးပါပြီ',
                            'နှိပ်ပါ',
                            'success'
                        ).then((result) => {
                            if(result.isConfirmed){
                                window.location.reload();
                            }
                        })
                    }
                }
            })
        }
    </script>
@endsection
