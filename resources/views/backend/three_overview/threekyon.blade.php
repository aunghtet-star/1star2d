@extends('backend.layouts.app')
@section('3D-over-kyon','mm-active')
@section('extra_css')
    <style>
        .column {
        display: flex;
        flex-direction: column;
        flex-wrap: wrap;
        margin-right: 150px;
        height: 80vh;
}
    </style>
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
                <div>3D ကျွံ Dashboard
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
{{--                    @if(request()->startdate && request()->enddate)--}}
{{--                    <input type="text" class="form-control date" value="{{  request()->startdate  . ' - ' . request()->enddate  }}   " placeholder="All">--}}
{{--                    @else--}}
                    <input type="text" class="form-control date" disabled value="{{  $from  . ' - ' . $to  }}   " placeholder="All">
{{--                    @endif--}}
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body refresh" >
                    <div class="column">
                        @if($three_kyons)
                        @php
                        $total = 0;
                        @endphp
{{--                        @foreach($three_kyons as $three_kyon)--}}
{{--                                <div class="d-flex " style="width:100px; margin-right : 70px">--}}
{{--                                    @if(($three_brake ? $three_brake->amount : 99999999999999999999) < $three_kyon->total)--}}
{{--                                    <p class="mb-2 mr-3">{{$three_kyon->three}} </p> => <span class="ml-2">--}}
{{--                                         @php--}}
{{--                                             $total += $three_kyon->total - $three_brake->amount--}}
{{--                                         @endphp--}}
{{--                                         {{number_format($three_kyon->total - $three_brake->amount) }}--}}

{{--                                         </span>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            @endforeach--}}

                            @foreach($three_kyons as $three_kyon)
                                <div class="d-flex" style="width:95px;margin-right: 20px">
                                    @if (($three_kyon->amount - $three_kyon->new_amount - $three_kyon->kyon_amount) > 0)
                                        <p class="mb-2 mr-3 ">{{$three_kyon->three}} </p> => <span class="ml-2 ">
                                    {{number_format( $three_kyon->amount - $three_kyon->new_amount - $three_kyon->kyon_amount) }}
                                    </span>
                                        @php
                                            $total += $three_kyon->amount - $three_kyon->new_amount - $three_kyon->kyon_amount;
                                        @endphp
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>

                <h5 class="text-success" style="font-weight: 700">Total amount => {{number_format($total)}}</h5>

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
                    "showCustomRangeLabel": true,
                    "autoUpdateInput" :false,
                    "locale" : {
                        format : 'YYYY-MM-DD'
                    }
                }, );

                    $('.date').on('apply.daterangepicker', function(ev, picker) {
                    var startdate = picker.startDate.format('YYYY-MM-DD');
                    var enddate = picker.endDate.format('YYYY-MM-DD');

                    history.pushState(null,'',`?startdate=${startdate}&enddate=${enddate}`);

                    window.location.reload();


                });


                // window.setInterval(() => {
                //         $('.refresh').load(`/admin/three-overview/history`);
                //     }, 2000);


       });

</script>
@endsection
