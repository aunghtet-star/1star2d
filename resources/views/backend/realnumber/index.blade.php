@extends('backend.layouts.app')
@section('real_number','mm-active')
@section('extra_css')
@endsection
@section('main')
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-display2 icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div>2D RealNumber Dashboard AM
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
                    <input type="text" class="form-control date" value="{{request()->date ?? now()->format('Y-m-d')}}" placeholder="All">
                </div>
            </div>
            
        </div>
        <div class="col">
            <div class="card overview">
                <div class="card-body">
                <h5 class="text-success mb-5" style="font-weight: 700">Total amount AM => {{number_format($two_transactions_total_am - $new_amount_total_am)}}</h5>
                <h5 class="text-success" style="font-weight: 700">Total amount PM => {{number_format($two_transactions_total_pm - $new_amount_total_pm)}}</h5>
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

                    $('.date').on('apply.daterangepicker', function(ev, picker) {
                        $(this).val(picker.startDate.format('YYYY-MM-DD'));
                        var date = $('.date').val();
                        history.pushState(null, '' , `?date=${date}`);
                        window.location.reload();
                    }); 

       });
    
</script>
@endsection