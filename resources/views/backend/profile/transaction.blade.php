@extends('backend.layouts.app')

@section('main')
<div class="container mt-2">
    <div class="row justify-content-center">
        <div class="col-md-8 ">
            <div class="scrolling-pagination">
                @foreach ($transactions as $transaction)
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <p class="mb-1">နေ့စွဲနှင့်အချိန်</p>
                                <p class="mb-1 small "> @if($transaction->type == 1) ငွေလက်ခံရရှိခြင်း @else ငွေထုတ်ယူခြင်း @endif</p>
                            </div>
                            <small class="mb-3 text-muted ">{{$transaction->created_at->format('Y-m-d h:i:s A')}}</small>
                            <p class="mb-1 text-center ">@if($transaction->type == 1) မှ @else သို့ @endif{{$transaction->users ? $transaction->users->name :'_' }}</p>
                            <p class="mb-2  text-center @if($transaction->type == 1) text-success @else text-danger @endif "  >@if($transaction->type == 1) + @else - @endif  {{number_format($transaction->amount)}} Kyat</p>
                            <p class="mb-1 text-center ">Transaction ID : {{$transaction->ref_no}}</p>
                        </div>
                    </div>
                    @endforeach
                    {{$transactions->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
{{-- {!! JsValidator::formRequest('App\Http\Requests\StoreUserTwoD') !!} --}}

<script>
    $(document).ready(function(){
        $('ul.pagination').hide();
        $(function() {
        $('.scrolling-pagination').jscroll({
            autoTrigger: true,
            padding: 0,
            nextSelector: '.pagination li.active + li a',
            contentSelector: 'div.scrolling-pagination',
            callback: function() {
                $('ul.pagination').remove();
            }
        });
    });
    });
</script>

@endsection