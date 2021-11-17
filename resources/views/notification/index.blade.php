@extends('frontend.layouts.app')
@section('notification','active')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        
        <div class="col-md-8">
            <div class="scrolling-pagination">
                @foreach ($notifications as $notification)
                <div class="card mb-2">
                    <div class="card-body ">
                        <div class="d-flex justify-content-between">
                            <p class="mb-1">နေ့စွဲနှင့်အချိန်</p>
                            <p class="mb-1 small"> mark as read</p>
                        </div>
                        <small class="mb-3 text-muted">{{$notification->created_at->format('Y-m-d h:i:s A')}}</small>
                        <p class="mb-2 text-muted text-center">{{$notification->data['title']}}</p>
                        <p class="mb-1 text-center">{{$notification->data['message']}}</p>
                    </div>
                </div>
                @endforeach
                {{$notifications->links()}}
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