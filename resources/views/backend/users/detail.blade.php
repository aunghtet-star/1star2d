@extends('backend.layouts.app')
@section('users','mm-active')
@section('main')
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-display2 icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div>User Dashboard
                    <div class="page-title-subheading">1Star2DMM
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container p-0">
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
                    <p class="mb-0">{{$user->name}}</p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
@section('scripts')
<script>
    
    $(document).ready(function() {

       
        $('.date').daterangepicker({
                        "singleDatePicker": true,
                        "autoApply": true,
                        "autoUpdateInput" :false,
                        "locale": {
                            "format": "YYYY/MM/DD",
                    },
                    });


                    function twoHistoryTable(){
                        var date = $('.date').val();
                        var time = $('.time').val();

                        $.ajax({
                            url : `/admin/users/detail?date=${date}&time=${time}`,
                            type : 'GET',
                            success : function(res){
                                $('.history-user-detail').html(res);
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
                    
       });
    
</script>
@endsection