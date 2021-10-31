@extends('frontend.layouts.app')
@section('htaitpait','active')
    
@section('extra_css')
   <style>
       .error{
           color: red;
           border-color: red;
       }

       .css-column{
           width: 100%;
           min-height: 20px;
           display: flex;
       }
       


    </style> 
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body ">
                    <p class="text-danger text-center" style="font-size: 20px ; font-weight:700">သင်ထိုးထားတာတွေဟုတ်ပါသလား ?</p>
                    <div class="row text-center css-column">
                        <form action="{{url('two/htaitpait/store')}}" method="POST">
                            @csrf
                            @php 
                                $total = 0;

                            @endphp
                            <div class="mb-3">
                                @if($zerohtaits)
                                <h6 class="pr-3">0 ထိပ်</h6>
                                @foreach ($zerohtaits as $zerohtait)
                                    <input type="hidden" name="zerohtaits[]" value="{{$zerohtait}}">
                                    <input type="hidden" name="amount" value="{{$amount}}">
                                    @php
                                    $total += $amount;
                                    @endphp
                                    <p class="mb-1">{{$zerohtait}}  <span>=>{{$amount}}</span></p> 
                                @endforeach
                                @endif
                            </div>
                            
                            <div class="mb-3">
                                @if($onehtaits)
                                <h6 class="pr-3">1 ထိပ်</h6>
                                @foreach ($onehtaits as $onehtait)
                                    <input type="hidden" name="onehtaits[]" value="{{$onehtait}}">
                                    <input type="hidden" name="amount" value="{{$amount}}">
                                    <p class="mb-1">{{$onehtait}}  <span>=>{{$amount}}</span></p>
                                    @php
                                    $total += $amount;
                                    @endphp
                                    @endforeach
                                @endif
                            </div>
                                
                            <div class="mb-3">
                                @if($twohtaits)
                                <h6 class="pr-3">2 ထိပ်</h6>
                                @foreach ($twohtaits as $twohtait)
                                    <input type="hidden" name="twohtaits[]" value="{{$twohtait}}">
                                    <input type="hidden" name="amount" value="{{$amount}}"> 
                                    <p class="mb-1">{{$twohtait}}  <span>=>{{$amount}}</span></p>
                                    @php
                                    $total += $amount;
                                    @endphp
                                @endforeach
                                @endif
                            </div>
                                
                            <div class="mb-3">
                                @if($threehtaits)
                                <h6 class="pr-3">3 ထိပ်</h6>
                                @foreach ($threehtaits as $threehtait)
                                    <input type="hidden" name="threehtaits[]" value="{{$threehtait}}">
                                    <input type="hidden" name="amount" value="{{$amount}}">
                                    <p class="mb-1">{{$threehtait}} => <span>{{$amount}}</span></p>
                                    @php
                                    $total += $amount;
                                    @endphp
                                @endforeach
                                @endif 
                            </div>
                                
                            <div class="mb-3">
                                @if($fourhtaits)
                                <h6 class="pr-3">4 ထိပ်</h6>
                                @foreach ($fourhtaits as $fourhtait)
                                    <input type="hidden" name="fourhtaits[]" value="{{$fourhtait}}">
                                    <input type="hidden" name="amount" value="{{$amount}}">
                                    <p class="mb-1">{{$fourhtait}} => <span>{{$amount}}</span></p>
                                    @php
                                    $total += $amount;
                                    @endphp
                                @endforeach
                                @endif
                            </div>
                                
                            <div class="mb-3">
                                @if($fivehtaits)
                                <h6 class="pr-3">5 ထိပ်</h6>
                                @foreach ($fivehtaits as $fivehtait)
                                    <input type="hidden" name="fivehtaits[]" value="{{$fivehtait}}">
                                    <input type="hidden" name="amount" value="{{$amount}}">
                                    <p class="mb-1">{{$fivehtait}} => <span>{{$amount}}</span></p>
                                    @php
                                    $total += $amount;
                                    @endphp
                                @endforeach
                                @endif
                            </div>
                                
                            <div class="mb-3">
                                @if($sixhtaits)
                                <h6 class="pr-3">6 ထိပ်</h6>
                                @foreach ($sixhtaits as $sixhtait)
                                    <input type="hidden" name="sixhtaits[]" value="{{$sixhtait}}">
                                    <input type="hidden" name="amount" value="{{$amount}}">
                                    <p class="mb-1">{{$sixhtait}} => <span>{{$amount}}</span></p>
                                    @php
                                    $total += $amount;
                                    @endphp
                                @endforeach
                                @endif
                            </div>
                                
                            <div class="mb-3">
                                @if($sevenhtaits)
                                <h6 class="pr-3">7 ထိပ်</h6>
                                @foreach ($sevenhtaits as $sevenhtait)
                                    <input type="hidden" name="sevenhtaits[]" value="{{$sevenhtait}}">
                                    <input type="hidden" name="amount" value="{{$amount}}">
                                    <p class="mb-1">{{$sevenhtait}} => <span>{{$amount}}</span></p>
                                    @php
                                    $total += $amount;
                                    @endphp
                                @endforeach
                                @endif
                            </div>
                                
                            <div class="mb-3">
                                @if($eighthtaits)
                                <h6 class="pr-3">8 ထိပ်</h6>
                                @foreach ($eighthtaits as $eighthtait)
                                    <input type="hidden" name="eighthtaits[]" value="{{$eighthtait}}">
                                    <input type="hidden" name="amount" value="{{$amount}}">
                                    <p class="mb-1">{{$eighthtait}} => <span>{{$amount}}</span></p>
                                    @php
                                    $total += $amount;
                                    @endphp
                                @endforeach
                                @endif
                            </div>
                                
                            <div class="mb-3">
                                @if($ninehtaits)
                                <h6 class="pr-3">9 ထိပ်</h6>
                                @foreach ($ninehtaits as $ninehtait)
                                    <input type="hidden" name="ninehtaits[]" value="{{$ninehtait}}">
                                    <input type="hidden" name="amount" value="{{$amount}}">
                                    <p class="mb-1">{{$ninehtait}} => <span>{{$amount}}</span></p>
                                    @php
                                    $total += $amount;
                                    @endphp
                                @endforeach
                                @endif
                            </div>
                                
                    {{-- ====================== pait ========================= --}}
                            
                    <div class="mb-3">
                                @if($zeropaits)
                                <h6 class="pr-3">0 အပိတ်</h6>
                                @foreach ($zeropaits as $zeropait)
                                    <input type="hidden" name="zeropaits[]" value="{{$zeropait}}">
                                    <input type="hidden" name="amount" value="{{$amount}}">
                                    <p class="mb-1">{{$zeropait}}  <span>=>{{$amount}}</span></p> 
                                    @php
                                    $total += $amount;
                                    @endphp
                                @endforeach
                                @endif
                            </div>
                            
                            <div class="mb-3">
                                @if($onepaits)
                                <h6 class="pr-3">1 အပိတ်</h6>
                                @foreach ($onepaits as $onepait)
                                    <input type="hidden" name="onepaits[]" value="{{$onepait}}">
                                    <input type="hidden" name="amount" value="{{$amount}}">
                                    <p class="mb-1">{{$onepait}}  <span>=>{{$amount}}</span></p>
                                    @php
                                    $total += $amount;
                                    @endphp
                                @endforeach
                                @endif
                            </div>
                                
                            <div class="mb-3">
                                @if($twopaits)
                                <h6 class="pr-3">2 အပိတ်</h6>
                                @foreach ($twopaits as $twopait)
                                    <input type="hidden" name="twopaits[]" value="{{$twopait}}">
                                    <input type="hidden" name="amount" value="{{$amount}}"> 
                                    <p class="mb-1">{{$twopait}}  <span>=>{{$amount}}</span></p>
                                    @php
                                    $total += $amount;
                                    @endphp
                                @endforeach
                                @endif
                            </div>
                                
                            <div class="mb-3">
                                @if($threepaits)
                                <h6 class="pr-3">3 အပိတ်</h6>
                                @foreach ($threepaits as $threepait)
                                    <input type="hidden" name="threepaits[]" value="{{$threepait}}">
                                    <input type="hidden" name="amount" value="{{$amount}}">
                                    <p class="mb-1">{{$threepait}} => <span>{{$amount}}</span></p>
                                    @php
                                    $total += $amount;
                                    @endphp
                                @endforeach
                                @endif 
                            </div>
                                
                            <div class="mb-3">
                                @if($fourpaits)
                                <h6 class="pr-3">4 အပိတ်</h6>
                                @foreach ($fourpaits as $fourpait)
                                    <input type="hidden" name="fourpaits[]" value="{{$fourpait}}">
                                    <input type="hidden" name="amount" value="{{$amount}}">
                                    <p class="mb-1">{{$fourpait}} => <span>{{$amount}}</span></p>
                                    @php
                                    $total += $amount;
                                    @endphp
                                @endforeach
                                @endif
                            </div>
                                
                            <div class="mb-3">
                                @if($fivepaits)
                                <h6 class="pr-3">5 အပိတ်</h6>
                                @foreach ($fivepaits as $fivepait)
                                    <input type="hidden" name="fivepaits[]" value="{{$fivepait}}">
                                    <input type="hidden" name="amount" value="{{$amount}}">
                                    <p class="mb-1">{{$fivepait}} => <span>{{$amount}}</span></p>
                                    @php
                                    $total += $amount;
                                    @endphp
                                @endforeach
                                @endif
                            </div>
                                
                            <div class="mb-3">
                                @if($sixpaits)
                                <h6 class="pr-3">6 အပိတ်</h6>
                                @foreach ($sixpaits as $sixpait)
                                    <input type="hidden" name="sixpaits[]" value="{{$sixpait}}">
                                    <input type="hidden" name="amount" value="{{$amount}}">
                                    <p class="mb-1">{{$sixpait}} => <span>{{$amount}}</span></p>
                                    @php
                                    $total += $amount;
                                    @endphp
                                @endforeach
                                @endif
                            </div>
                                
                            <div class="mb-3">
                                @if($sevenpaits)
                                <h6 class="pr-3">7 အပိတ်</h6>
                                @foreach ($sevenpaits as $sevenpait)
                                    <input type="hidden" name="sevenpaits[]" value="{{$sevenpait}}">
                                    <input type="hidden" name="amount" value="{{$amount}}">
                                    <p class="mb-1">{{$sevenpait}} => <span>{{$amount}}</span></p>
                                    @php
                                    $total += $amount;
                                    @endphp
                                @endforeach
                                @endif
                            </div>
                                
                            <div class="mb-3">
                                @if($eightpaits)
                                <h6 class="pr-3">8 အပိတ်</h6>
                                @foreach ($eightpaits as $eightpait)
                                    <input type="hidden" name="eightpaits[]" value="{{$eightpait}}">
                                    <input type="hidden" name="amount" value="{{$amount}}">
                                    <p class="mb-1">{{$eightpait}} => <span>{{$amount}}</span></p>
                                    @php
                                    $total += $amount;
                                    @endphp
                                @endforeach
                                @endif
                            </div>
                                
                            <div class="mb-3">
                                @if($ninepaits)
                                <h6 class="pr-3">9 အပိတ်</h6>
                                @foreach ($ninepaits as $ninepait)
                                    <input type="hidden" name="ninepaits[]" value="{{$ninepait}}">
                                    <input type="hidden" name="amount" value="{{$amount}}">
                                    <p class="mb-1">{{$ninepait}} => <span>{{$amount}}</span></p>
                                    @php
                                    $total += $amount;
                                    @endphp
                                @endforeach
                                @endif
                            </div>
                
          {{-- ==================== brake ==============================--}}

                            <div class="mb-3">
                                @if($zerobrakes)
                                <h6 class="pr-3">0 ဘရိတ်</h6>
                                @foreach ($zerobrakes as $zerobrake)
                                    <input type="hidden" name="zerobrakes[]" value="{{$zerobrake}}">
                                    <input type="hidden" name="amount" value="{{$amount}}">
                                    <p class="mb-1">{{$zerobrake}}  <span>=>{{$amount}}</span></p> 
                                    @php
                                    $total += $amount;
                                    @endphp
                                @endforeach
                                @endif
                            </div>
                            
                            <div class="mb-3">
                                @if($onebrakes)
                                <h6 class="pr-3">1 ဘရိတ်</h6>
                                @foreach ($onebrakes as $onebrake)
                                    <input type="hidden" name="onebrakes[]" value="{{$onebrake}}">
                                    <input type="hidden" name="amount" value="{{$amount}}">
                                    <p class="mb-1">{{$onebrake}}  <span>=>{{$amount}}</span></p>
                                    @php
                                    $total += $amount;
                                    @endphp
                                @endforeach
                                @endif
                            </div>
                                
                            <div class="mb-3">
                                @if($twobrakes)
                                <h6 class="pr-3">2 ဘရိတ်</h6>
                                @foreach ($twobrakes as $twobrake)
                                    <input type="hidden" name="twobrakes[]" value="{{$twobrake}}">
                                    <input type="hidden" name="amount" value="{{$amount}}"> 
                                    <p class="mb-1">{{$twobrake}}  <span>=>{{$amount}}</span></p>
                                    @php
                                    $total += $amount;
                                    @endphp
                                @endforeach
                                @endif
                            </div>
                                
                            <div class="mb-3">
                                @if($threebrakes)
                                <h6 class="pr-3">3 ဘရိတ်</h6>
                                @foreach ($threebrakes as $threebrake)
                                    <input type="hidden" name="threebrakes[]" value="{{$threebrake}}">
                                    <input type="hidden" name="amount" value="{{$amount}}">
                                    <p class="mb-1">{{$threebrake}} => <span>{{$amount}}</span></p>
                                    @php
                                    $total += $amount;
                                    @endphp
                                @endforeach
                                @endif 
                            </div>
                                
                            <div class="mb-3">
                                @if($fourbrakes)
                                <h6 class="pr-3">4 ဘရိတ်</h6>
                                @foreach ($fourbrakes as $fourbrake)
                                    <input type="hidden" name="fourbrakes[]" value="{{$fourbrake}}">
                                    <input type="hidden" name="amount" value="{{$amount}}">
                                    <p class="mb-1">{{$fourbrake}} => <span>{{$amount}}</span></p>
                                    @php
                                    $total += $amount;
                                    @endphp
                                @endforeach
                                @endif
                            </div>
                                
                            <div class="mb-3">
                                @if($fivebrakes)
                                <h6 class="pr-3">5 ဘရိတ်</h6>
                                @foreach ($fivebrakes as $fivebrake)
                                    <input type="hidden" name="fivebrakes[]" value="{{$fivebrake}}">
                                    <input type="hidden" name="amount" value="{{$amount}}">
                                    <p class="mb-1">{{$fivebrake}} => <span>{{$amount}}</span></p>
                                    @php
                                    $total += $amount;
                                    @endphp
                                @endforeach
                                @endif
                            </div>
                                
                            <div class="mb-3">
                                @if($sixbrakes)
                                <h6 class="pr-3">6 ဘရိတ်</h6>
                                @foreach ($sixbrakes as $sixbrake)
                                    <input type="hidden" name="sixbrakes[]" value="{{$sixbrake}}">
                                    <input type="hidden" name="amount" value="{{$amount}}">
                                    <p class="mb-1">{{$sixbrake}} => <span>{{$amount}}</span></p>
                                    @php
                                    $total += $amount;
                                    @endphp
                                @endforeach
                                @endif
                            </div>
                                
                            <div class="mb-3">
                                @if($sevenbrakes)
                                <h6 class="pr-3">7 ဘရိတ်</h6>
                                @foreach ($sevenbrakes as $sevenbrake)
                                    <input type="hidden" name="sevenbrakes[]" value="{{$sevenbrake}}">
                                    <input type="hidden" name="amount" value="{{$amount}}">
                                    <p class="mb-1">{{$sevenbrake}} => <span>{{$amount}}</span></p>
                                    @php
                                    $total += $amount;
                                    @endphp
                                @endforeach
                                @endif
                            </div>
                                
                            <div class="mb-3">
                                @if($eightbrakes)
                                <h6 class="pr-3">8 ဘရိတ်</h6>
                                @foreach ($eightbrakes as $eightbrake)
                                    <input type="hidden" name="eightbrakes[]" value="{{$eightbrake}}">
                                    <input type="hidden" name="amount" value="{{$amount}}">
                                    <p class="mb-1">{{$eightbrake}} => <span>{{$amount}}</span></p>
                                    @php
                                    $total += $amount;
                                    @endphp
                                @endforeach
                                @endif
                            </div>
                                
                            <div class="mb-3">
                                @if($ninebrakes)
                                <h6 class="pr-3">9 ဘရိတ်</h6>
                                @foreach ($ninebrakes as $ninebrake)
                                    <input type="hidden" name="ninebrakes[]" value="{{$ninebrake}}">
                                    <input type="hidden" name="amount" value="{{$amount}}">
                                    <p class="mb-1">{{$ninebrake}} => <span>{{$amount}}</span></p>
                                    @php
                                    $total += $amount;
                                    @endphp
                                @endforeach
                                @endif
                            </div>

 {{-- ========================= apar =========================== --}}
                        
                            <div class="mb-3">
                                @if($zeropars)
                                <h6 class="pr-3">0 အပါ</h6>
                                @foreach ($zeropars as $zeropar)
                                    <input type="hidden" name="zeropars[]" value="{{$zeropar}}">
                                    <input type="hidden" name="amount" value="{{$amount}}">
                                    <p class="mb-1">{{$zeropar}}  <span>=>{{$amount}}</span></p> 
                                    @php
                                    $total += $amount;
                                    @endphp
                                @endforeach
                                @endif
                            </div>

                            <div class="mb-3">
                                @if($onepars)
                                <h6 class="pr-3">1 အပါ</h6>
                                @foreach ($onepars as $onepar)
                                    <input type="hidden" name="onepars[]" value="{{$onepar}}">
                                    <input type="hidden" name="amount" value="{{$amount}}">
                                    <p class="mb-1">{{$onepar}}  <span>=>{{$amount}}</span></p>
                                    @php
                                    $total += $amount;
                                    @endphp
                                @endforeach
                                @endif
                            </div>
                                
                            <div class="mb-3">
                                @if($twopars)
                                <h6 class="pr-3">2 အပါ</h6>
                                @foreach ($twopars as $twopar)
                                    <input type="hidden" name="twopars[]" value="{{$twopar}}">
                                    <input type="hidden" name="amount" value="{{$amount}}"> 
                                    <p class="mb-1">{{$twopar}}  <span>=>{{$amount}}</span></p>
                                    @php
                                    $total += $amount;
                                    @endphp
                                @endforeach
                                @endif
                            </div>
                                
                            <div class="mb-3">
                                @if($threepars)
                                <h6 class="pr-3">3 အပါ</h6>
                                @foreach ($threepars as $threepar)
                                    <input type="hidden" name="threepars[]" value="{{$threepar}}">
                                    <input type="hidden" name="amount" value="{{$amount}}">
                                    <p class="mb-1">{{$threepar}} => <span>{{$amount}}</span></p>
                                    @php
                                    $total += $amount;
                                    @endphp
                                @endforeach
                                @endif 
                            </div>
                                
                            <div class="mb-3">
                                @if($fourpars)
                                <h6 class="pr-3">4 အပါ</h6>
                                @foreach ($fourpars as $fourpar)
                                    <input type="hidden" name="fourpars[]" value="{{$fourpar}}">
                                    <input type="hidden" name="amount" value="{{$amount}}">
                                    <p class="mb-1">{{$fourpar}} => <span>{{$amount}}</span></p>
                                    @php
                                    $total += $amount;
                                    @endphp
                                @endforeach
                                @endif
                            </div>
                                
                            <div class="mb-3">
                                @if($fivepars)
                                <h6 class="pr-3">5 အပါ</h6>
                                @foreach ($fivepars as $fivepar)
                                    <input type="hidden" name="fivepars[]" value="{{$fivepar}}">
                                    <input type="hidden" name="amount" value="{{$amount}}">
                                    <p class="mb-1">{{$fivepar}} => <span>{{$amount}}</span></p>
                                    @php
                                    $total += $amount;
                                    @endphp
                                @endforeach
                                @endif
                            </div>
                                
                            <div class="mb-3">
                                @if($sixpars)
                                <h6 class="pr-3">6 အပါ</h6>
                                @foreach ($sixpars as $sixpar)
                                    <input type="hidden" name="sixpars[]" value="{{$sixpar}}">
                                    <input type="hidden" name="amount" value="{{$amount}}">
                                    <p class="mb-1">{{$sixpar}} => <span>{{$amount}}</span></p>
                                    @php
                                    $total += $amount;
                                    @endphp
                                @endforeach
                                @endif
                            </div>
                                
                            <div class="mb-3">
                                @if($sevenpars)
                                <h6 class="pr-3">7 အပါ</h6>
                                @foreach ($sevenpars as $sevenpar)
                                    <input type="hidden" name="sevenpars[]" value="{{$sevenpar}}">
                                    <input type="hidden" name="amount" value="{{$amount}}">
                                    <p class="mb-1">{{$sevenpar}} => <span>{{$amount}}</span></p>
                                    @php
                                    $total += $amount;
                                    @endphp
                                @endforeach
                                @endif
                            </div>
                                
                            <div class="mb-3">
                                @if($eightpars)
                                <h6 class="pr-3">8 အပါ</h6>
                                @foreach ($eightpars as $eightpar)
                                    <input type="hidden" name="eightpars[]" value="{{$eightpar}}">
                                    <input type="hidden" name="amount" value="{{$amount}}">
                                    <p class="mb-1">{{$eightpar}} => <span>{{$amount}}</span></p>
                                    @php
                                    $total += $amount;
                                    @endphp
                                @endforeach
                                @endif
                            </div>
                                
                            <div class="mb-3">
                                @if($ninepars)
                                <h6 class="pr-3">9 အပါ</h6>
                                @foreach ($ninepars as $ninepar)
                                    <input type="hidden" name="ninepars[]" value="{{$ninepar}}">
                                    <input type="hidden" name="amount" value="{{$amount}}">
                                    <p class="mb-1">{{$ninepar}} => <span>{{$amount}}</span></p>
                                    @php
                                    $total += $amount;
                                    @endphp
                                @endforeach
                                @endif
                            </div>

                            {{-- ================== a puu ================= --}}
                            <div class="mb-3">
                                @if($apuus)
                                <h6 class="pr-3">အပူး</h6>
                                @foreach ($apuus as $apuu)
                                    <input type="hidden" name="apuus[]" value="{{$apuu}}">
                                    <input type="hidden" name="amount" value="{{$amount}}">
                                    <p class="mb-1">{{$apuu}} => <span>{{$amount}}</span></p>
                                    @php
                                    $total += $amount;
                                    @endphp
                                @endforeach
                                @endif
                            </div>

                            {{-- ===================== ten ========================== --}}
                            <div class="mb-3">
                                @if($tens)
                                <h6 class="pr-3">ဆယ်ပြည့်</h6>
                                @foreach ($tens as $ten)
                                    <input type="hidden" name="tens[]" value="{{$ten}}">
                                    <input type="hidden" name="amount" value="{{$amount}}">
                                    <p class="mb-1">{{$ten}} => <span>{{$amount}}</span></p>
                                    @php
                                    $total += $amount;
                                    @endphp
                                @endforeach
                                @endif
                            </div>

                            {{-- ===================== power ============================== --}}

                            <div class="mb-3">
                                @if($powers)
                                <h6 class="pr-3">ပါဝါ</h6>
                                @foreach ($powers as $power)
                                    <input type="hidden" name="powers[]" value="{{$power}}">
                                    <input type="hidden" name="amount" value="{{$amount}}">
                                    <p class="mb-1">{{$power}} => <span>{{$amount}}</span></p>
                                    @php
                                    $total += $amount;
                                    @endphp
                                @endforeach
                                @endif
                            </div>


                            {{-- ========================= natkhat =============================== --}}
                            
                            <div class="mb-3">
                                @if($natkhats)
                                <h6 class="pr-3">နက္ခတ်</h6>
                                @foreach ($natkhats as $natkhat)
                                    <input type="hidden" name="natkhats[]" value="{{$natkhat}}">
                                    <input type="hidden" name="amount" value="{{$amount}}">
                                    <p class="mb-1">{{$natkhat}} => <span>{{$amount}}</span></p>
                                    @php
                                    $total += $amount;
                                    @endphp
                                @endforeach
                                @endif
                            </div>

                            {{-- ===================== brother ========================== --}}
                            
                            <div class="mb-3">
                                @if($brothers)
                                <h6 class="pr-3">ညီအကို</h6>
                                @foreach ($brothers as $brother)
                                    <input type="hidden" name="brothers[]" value="{{$brother}}">
                                    <input type="hidden" name="amount" value="{{$amount}}">
                                    <p class="mb-1">{{$brother}} => <span>{{$amount}}</span></p>
                                    @php
                                    $total += $amount;
                                    @endphp
                                @endforeach
                                @endif
                            </div>



                            <p>သင်၏ကျသင့်ငွေမှာ @php
                                  
                               echo $total 
                             @endphp  ကျပ်ဖြစ်ပါသည် ဆက်လက်လုပ်ဆောင်လိုပါသလား</p>
                            <button type="button" class="btn btn-danger btn-sm cancel-btn">မလုပ်ပါ</button>
                            <button type="submit" class="btn btn-primary btn-sm">ထိုးမည်</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            $('.cancel-btn').on('click',function(){
                window.history.go(-1);
                return false;
            })

            @if(session('create'))
            Toast.fire({
            icon: 'success',
            title: '{{session('create')}}'
            })
            @endif()
        })
    </script>
@endsection