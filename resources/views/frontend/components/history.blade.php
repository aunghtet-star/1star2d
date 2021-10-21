<div class="d-flex justify-content-between mb-3">
    <p class="mb-0">2D</p> <span>Amount</span>
</div>
@foreach($users as $user)
<div class="d-flex justify-content-between mb-2">
    <p class="mb-0">{{$user->two}}</p> <span>{{$user->amount}}</span>
</div>
@endforeach
{{-- <div class="d-flex justify-content-between mb-2">
    <p class="mb-0">Amount</p> <span>{{$user->amount}}</span>
</div> --}}

<hr>
<div class="d-flex justify-content-between mb-2">
    <p class="mb-0">Total Amount</p> 
    <span> {{$totals}}</span>
</div>