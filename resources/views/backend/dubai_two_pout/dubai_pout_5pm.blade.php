@extends('backend.layouts.app')
@section('dubai-2D-overview-5pm', 'mm-active')
@section('main')
    <h5 class="text-center mt-3" style="font-weight: 700">Dubai 2D ထိုးထားသူများစာရင်း</h5>
    <div class="card m-3">
        <h4 class="text-center text-success mt-3">{{$two}}</h4>
        <div class="card-body">
            @foreach ($pouts as $pout)
                <p>{{ $pout->users ? $pout->users->name : '_' }} => <span>{{ number_format($pout->amount) }}</span>
                    <a href="#" onclick="bet({{$pout->user_id}},'{{$pout->two}}',{{ $pout->amount }},'{{$pout->users->name}}','{{$pout->date}}')"><i class="fa-solid fa-coins pl-3 @if($pout->status == 'done') text-danger @endif"></i></a></p>
            @endforeach
        </div>
    </div>
@endsection
@section('scripts')
    <script>

        function bet(user_id,two,amount,name,date) {

            let bet = prompt("Please enter Bet Amount to " + name, amount * 80);


            $.ajax({
                url: `/admin/dubai-twopout-5pm/${user_id}`,
                method: 'post',
                data: {
                    two : two,
                    amount: bet,
                    user_id: user_id,
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
