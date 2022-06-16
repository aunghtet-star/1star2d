@extends('backend.layouts.app')
@section('3D-over-history','mm-active')
@section('extra_css')
    <style>
        .column {
        display: flex;
        flex-direction: column;
        flex-wrap: wrap;
        margin-right: 100px;
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
{{--                    @if(request()->startdate && request()->enddate)--}}
{{--                    <input type="text" class="form-control date" value="{{  request()->startdate  . ' - ' . request()->enddate  }}   " placeholder="All">--}}
{{--                    @else--}}
                    <input type="text" class="form-control date" disabled value="{{  $from  . ' - ' . $to  }}" data-date="{{$from}}"  placeholder="All">
{{--                    @endif--}}
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body refresh" >
                    <div class="column">
                        @if($three_overviews)
                        @foreach($three_overviews as $three)
{{--                                <div class="d-flex " style="width:100px; margin-right : 70px">--}}
{{--                                    <p class="mb-2 mr-3">{{$three->three}} </p> => <span class="ml-2 @if( ($three_brake ? $three_brake->amount : 99999999999999999999) < $three->total)  text-danger @endif">{{number_format($three->total)}}</span>--}}
{{--                                    <a href="{{url('/admin/three-overview/threepout/'.$three->three.'/'.$from.'/'.$to)}}"><span class="ml-3"><i class="fas fa-eye"></i></span></a>--}}
{{--                                </div>--}}

                                <div class="d-flex" style="width:180px;margin-right: 20px">

                                    <p class="mb-2">{{ $three->three }} </p> => <span
                                        class="ml-2
                                        @if (($three_brake ? $three_brake->amount : 9999999999999999999999) < ($three->amount - $three->new_amount - $three->kyon_amount)) text-danger @endif">
                                            {{ number_format(($three->amount - $three->new_amount - $three->kyon_amount)) }}</span>

                                    <a href="#" id="data_id" data-id="{{ $three->id }}" onclick="newAmount('{{ $three->three }}')"><span><i
                                                class="fas fa-edit ml-3"></i></span></a>

                                    <a href="{{ url('/admin/three-overview/threepout/'.$three->three.'/'.$from.'/'.$to) }}"><span><i
                                                class="fas fa-eye ml-3"></i></span></a>


                                </div>
                            @endforeach
                        @endif
                    </div>

{{--                <h5 class="text-success" style="font-weight: 700">Total amount => {{number_format($threes_total)}}</h5>--}}

                    <div class="d-flex justify-content-between">
                        <h5 class="text-success" style="font-weight: 700">Total amount => {{number_format($fake_number ? $fake_number->number : ( $amount_total - $new_amount_total - $kyon_amount_total))}}</h5>
                        <a href="#" class="btn btn-dark" onclick="kyonAmount()">Clear</a>
                    </div>

                {{$three_overviews->links()}}
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

       });

            function newAmount(id){
                let new_amount = prompt(`Enter Amount ${id}`);
                var date = $('.date').data('date') ?? moment('YYYY-MM-DD');

                $.ajax({
                    url : `/admin/three-overview/new_amount/${date}/${id}`,
                    method : 'post',
                    data : {
                        new_amount : new_amount,
                        three_d : id,
                        date : date
                    },
                    success : function(res){
                        window.location.reload();
                    }

                });
            }

            function kyonAmount(){

                var date = $('.date').data('date') ?? moment('YYYY-MM-DD');

                $.ajax({
                    url : '/admin/three/kyon_amount',
                    method : 'post',
                    data : {
                        date : date
                    },
                    success : function(res){
                        window.location.reload();
                    }
                })
            }

</script>
@endsection
