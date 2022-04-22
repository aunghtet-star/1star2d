{{-- --------------------- 2d ---------------------- --}}

<h5 class="text-center text-muted text-success mb-3" style="font-weight: 700">2D မှတ်တမ်း</h5>
<div class="d-flex justify-content-between mb-3">
    <p class="mb-0 text-muted">2D</p>
    <span class="text-muted">Amount</span>
    <span class="text-muted">ထိုးခဲ့သည့်အချိန်</span>
</div>
@foreach($twousers as $user)
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
    <span> {{$twototals}}</span>
</div>

{{-- --------------------- 3d ---------------------- --}}
<hr>


<h5 class="text-center text-muted text-danger mt-5 mb-3" style="font-weight: 700">3D မှတ်တမ်း</h5>

<div class="d-flex justify-content-between mb-3">
    <p class="mb-0 text-muted">3D</p>
    <span class="text-muted">Amount</span>
    <span class="text-muted">ထိုးခဲ့သည့်အချိန်</span>
</div>
@foreach($threeusers as $user)
<div class="d-flex justify-content-between mb-2">
    <p class="mb-0">{{$user->three}}</p>
     <span>{{$user->amount}}</span>
     <small class="text-muted">{{ $user->created_at->format('h:i:s A')}}</small>
</div>
<hr>
@endforeach

<hr>
<div class="d-flex justify-content-between mb-2">
    <p class="mb-0">Total Amount</p>
    <span> {{$threetotals}}</span>
</div>
