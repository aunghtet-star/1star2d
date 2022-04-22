@extends('frontend.layouts.app')
@section('dubai-history','active')
@section('extra_css')
@endsection
@section('content')
<div class="container">
    <div class="col-12">
        <div class="row mb-3 ml-0">
            <div class="col-8 pl-0">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text type-padding p-1">Date</label>
                    </div>
                    <input type="text" class="form-control date" value="{{request()->date ?? now()->format('Y-m-d')}}" placeholder="All">
                </div>
            </div>
            <div class="col-4" style="padding-right: 13px">
                <select name="" class="form-control time">
                    <option value="{{ 'all'}}">All</option>
                    <option value="{{'11am'}}">11AM</option>
                    <option value="{{ '1pm'}}">1PM</option>
                    <option value="{{ '3pm'}}">3PM</option>
                    <option value="{{ '5pm'}}">5PM</option>
                    <option value="{{ '7pm'}}">7PM</option>
                    <option value="{{ '9pm'}}">9PM</option>
                </select>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="dubai-two-history-user"></div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
{{-- {!! JsValidator::formRequest('App\Http\Requests\StoreUserTwoD') !!} --}}

<script>
    $(document).ready(function(){

                    $('.date').daterangepicker({
                        "singleDatePicker": true,
                        "autoApply": true,
                        "autoUpdateInput" :false,
                        "locale": {
                            "format": "YYYY/MM/DD",
                    },
                    });

                    DubaiTwoHistoryTable();

                    function DubaiTwoHistoryTable(){
                        var date = $('.date').val();
                        var time = $('.time').val();

                        $.ajax({
                            url : `/user/dubai-history-two?date=${date}&time=${time}`,
                            type : 'GET',
                            success : function(res){
                                $('.dubai-two-history-user').html(res);
                            }
                        })
                     }

                     $('.date').on('apply.daterangepicker',function(event,picker){
                        $(this).val(picker.startDate.format('YYYY-MM-DD'));
                         DubaiTwoHistoryTable();
                     })

                     $('.time').on('change',function(){
                         DubaiTwoHistoryTable();
                     })
    })
</script>

@endsection
