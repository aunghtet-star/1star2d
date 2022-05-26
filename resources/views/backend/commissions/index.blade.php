@extends('backend.layouts.app')
@section('commissions','mm-active')
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
                    <div>Commission Dashboard
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
                        <h4 class="mbg-3">Thai 2D</h4>
                        <h5 class="text-success mb-4" style="font-weight: 700">Total amount AM => {{number_format($commissions_am)}} </h5>
                        <h5 class="text-success mb-4" style="font-weight: 700">Total amount PM =>  {{number_format($commissions_pm)}} </h5>
                        <h4 class="mbg-3">Dubai 2D</h4>
                        <h5 class="text-success mb-4" style="font-weight: 700">Total amount 11AM => {{number_format($commissions_11am)}}</h5>
                        <h5 class="text-success mb-4" style="font-weight: 700">Total amount 1PM => {{number_format($commissions_1pm)}} </h5>
                        <h5 class="text-success mb-4" style="font-weight: 700">Total amount 3PM => {{number_format($commissions_3pm)}}</h5>
                        <h5 class="text-success mb-4" style="font-weight: 700">Total amount 5PM => {{number_format($commissions_5pm)}}</h5>
                        <h5 class="text-success mb-4" style="font-weight: 700">Total amount 7PM => {{number_format($commissions_7pm)}}</h5>
                        <h5 class="text-success mb-4" style="font-weight: 700">Total amount 9PM => {{number_format($commissions_9pm)}}</h5>
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
