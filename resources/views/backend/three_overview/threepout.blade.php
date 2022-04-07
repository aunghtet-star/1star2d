@extends('backend.layouts.app')
@section('3D-over-history','mm-active')
@section('main')
    <h5 class="text-center mt-3" style="font-weight: 700">3D ထိုးထားသူများစာရင်း</h5>
    <div class="card m-3">
        <div class="card-body">
            @foreach ($threepouts as $threepout)
            <p>{{$threepout->users ? $threepout->users->name : '_'}} => <span>{{number_format($threepout->total)}}</span>
                <a href="#" id="bet" data-id="{{ $threepout->users->id }}" data-name="{{ $threepout->users->name }}" onclick="bet({{ $threepout->total }})"><i class="fa-solid fa-coins pl-3"></i></a>
            </p>
            
            @endforeach
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function bet(amount) {
            const bet_name = document.getElementById('bet');
            const toBet = document.getElementById('toBet');
            let name = bet_name.dataset.name;
            let user_id = bet_name.dataset.id;
            let bet = prompt("Please enter Bet Amount to " + name, amount * 500);


            $.ajax({
                url: `/admin/three-pout/${user_id}`,
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