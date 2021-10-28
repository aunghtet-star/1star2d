@extends('backend.layouts.app')
@section('3D-over-history','mm-active')
@section('main')
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-display2 icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div>3D Overview Dashboard
                    <div class="page-title-subheading">1Start2DMM
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container p-0">
        <div class="row mb-3 ml-2">
            <div class="col-6">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text type-padding">Date</label>
                    </div>
                    <input type="text" class="form-control date" value="{{now()->format('Y-m-d').'-'.now()->format('Y-m-d')}}" placeholder="All">
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="three-history-table"></div>
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
                    "showCustomRangeLabel": false,
                    "startDate": moment().startOf('day'),
                    "endDate": moment().startOf('day').add(7, 'day'),
                    "locale" : {
                        format : 'YYYY-MM-DD'
                    }
                }, );

                    $('.date').on('apply.daterangepicker', function(ev, picker) {
                    var startdate = picker.startDate.format('YYYY-MM-DD');
                    var enddate = picker.endDate.format('YYYY-MM-DD');
                
                    $.ajax({
                        url : `/admin/three-overview/three-history-table?startdate=${startdate}&enddate=${enddate}`,
                        type : 'GET',
                        success : function(res){
                            $('.three-history-table').html(res);
                        }
                    })
                });
                    
    
                    //  $('.date').on('apply.daterangepicker',function(event,picker){
                    //     $(this).val(picker.startDate.format('YYYY-MM-DD'));
                    //         threeHistoryTable();
                    //  })
       });
    
</script>
@endsection