{{-- --------------------- 2d ---------------------- --}}

<h5 class="text-center text-muted text-success">2D မှတ်တမ်း</h5>
<div class="d-flex justify-content-between mb-3">
    <p class="mb-0 text-muted">2D</p> <span class="text-muted">Amount</span>
</div>
@foreach($twousers as $user)
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
    <span> {{$twototals}}</span>
</div>


{{-- --------------------- 3d ---------------------- --}}
<hr>


<h5 class="text-center text-muted text-danger mt-5">3D မှတ်တမ်း</h5>

<div class="d-flex justify-content-between mb-3">
    <p class="mb-0 text-muted">3D</p> <span class="text-muted">Amount</span>
</div>
@foreach($threeusers as $user)
<div class="d-flex justify-content-between mb-2">
    <p class="mb-0">{{$user->three}}</p> <span>{{$user->amount}}</span>
</div>
@endforeach
{{-- <div class="d-flex justify-content-between mb-2">
    <p class="mb-0">Amount</p> <span>{{$user->amount}}</span>
</div> --}}

<hr>
<div class="d-flex justify-content-between mb-2">
    <p class="mb-0">Total Amount</p> 
    <span> {{$threetotals}}</span>
</div>