{{-- ---------------------Dubai 2d ---------------------- --}}

<h5 class="text-center text-muted text-success mb-3" style="font-weight: 700">Dubai 2D မှတ်တမ်း</h5>
<div class="d-flex justify-content-between mb-3">
    <p class="mb-0 text-muted">2D</p>
    <span class="text-muted">Amount</span>
    <span class="text-muted">ထိုးခဲ့သည့်အချိန်</span>
</div>
@foreach($dubai_twousers as $user)
    <div class="d-flex justify-content-between mb-2">
        <p class="mb-0">{{$user->two}}</p>
        <span>{{$user->amount}}</span>
        <small class="text-muted">{{ $user->created_at->format('h:i:s A')}}</small>
    </div>
    <hr>
@endforeach


<hr>
<div class="d-flex justify-content-between mb-2">
    <p class="mb-0">Total Amount</p>
    <span> {{$dubai_twototals}}</span>
</div>
