@extends('backend.layouts.app')
@section('dubai-2D-overview-11am','mm-active')
@section('extra_css')
<style>
    .column {
      display: flex;
      flex-direction: column;
      flex-wrap: wrap;
      margin-right: 250px;
      width: 1000px;
      height: 80vh;
  }
  .column p {
      display: flex;
  }
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
                <div>Dubai 2D Overview Dashboard 11AM
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
                    @if ($two_overviews)
                            <div class="column">
                                @foreach ($two_overviews as $two_overview)
                                    <div class="d-flex" style="width:100px">

                                        <p class="mb-2 mr-3 ">{{ $two_overview->two }} </p> => <span
                                            class="ml-2
                                        @if (($two_brake->amount ?? 9999999999999999999999) < ($two_overview->amount - $two_overview->new_amount - $two_overview->kyon_amount)) text-danger @endif">
                                            {{ number_format(($two_overview->amount - $two_overview->new_amount - $two_overview->kyon_amount)) }}</span>

                                        <a href="#" id="data_id" data-id="{{ $two_overview->id }}" onclick="newAmount('{{ $two_overview->two }}')"><span><i
                                                    class="fas fa-edit ml-3"></i></span></a>

                                        <a href="{{ url('/admin/dubai-two-overview/twopout/' . $two_overview->two . '/date=' . $date) }}"><span><i
                                                    class="fas fa-eye ml-3"></i></span></a>


                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="d-flex justify-content-between">
                            <h5 class="text-success" style="font-weight: 700">Total amount => {{number_format($fake_number ? $fake_number->number : ($amount_total < ($two_brake ? $two_brake->amount : 99999999999999999999999999) ? $amount_total :    ( $amount_total - $new_amount_total - $kyon_amount_total)))}}</h5>
                            <a href="#" class="btn btn-dark" onclick="kyonAmount_11Am()">Clear</a>
                        </div>
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

                function newAmount(id){
                        let new_amount = prompt(`Enter Amount ${id}`);
                        var date = $('.date').val() ?? moment('YYYY-MM-DD');

                        $.ajax({
                            url : `/admin/dubai-two-overview-11am/new_amount/${date}/${id}`,
                            method : 'post',
                            data : {
                                new_amount : new_amount,
                                two_d : id,
                                date : date
                            },
                            success : function(res){
                                window.location.reload();
                            }

                    });
                    }

                    function kyonAmount_11Am(){

                    var date = $('.date').val() ?? moment('YYYY-MM-DD');

                    $.ajax({
                        url : '/admin/dubai-two-overview/kyon_amount_11am',
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
