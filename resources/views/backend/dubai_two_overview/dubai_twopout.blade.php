@extends('backend.layouts.app')
@section('dubai-2D-overview-11am', 'mm-active')
@section('main')
    <h5 class="text-center mt-3" style="font-weight: 700">2D ထိုးထားသူများစာရင်း</h5>
    <div class="card m-3">
        <div class="card-body">
            @foreach ($twopouts as $twopout)
                <p>{{ $twopout->users ? $twopout->users->name : '_' }} => <span>{{ number_format($twopout->total) }}</span>
                    <a href="#" id="bet"  onclick="bet({{$twopout->users->id}},{{ $twopout->total }},'{{$twopout->users->name}}')"><i class="fa-solid fa-coins pl-3"></i></a></p>
            @endforeach
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function bet(user_id,amount,name) {
           // const bet_name = document.getElementById('bet');

            let bet = prompt("Please enter Bet Amount to " + name, amount * 80);


            $.ajax({
                url: `/admin/dubai-two-pout/${user_id}`,
                method: 'post',
                data: {
                    amount: bet,
                    user_id: user_id,
                },
                success: function(res) {
                    window.location.reload();
                }
            })
        }
    </script>
@endsection
