@extends('frontend.layouts.app')
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
                    <option value="{{ 'true'}}" >AM</option>
                    <option value="{{ 'false'}}">PM</option>
                </select>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="two-history-user"></div>
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

                    twoHistoryTable();

                    function twoHistoryTable(){
                        var date = $('.date').val();
                        var time = $('.time').val();

                        $.ajax({
                            url : `/user/history-two?date=${date}&time=${time}`,
                            type : 'GET',
                            success : function(res){
                                $('.two-history-user').html(res);
                            }
                        })
                     }

                     $('.date').on('apply.daterangepicker',function(event,picker){
                        $(this).val(picker.startDate.format('YYYY-MM-DD'));
                            twoHistoryTable();
                     })

                     $('.time').on('change',function(){
                        twoHistoryTable();
                     })
    })
</script>

@endsection