@extends('backend.layouts.app')
@section('2D-over-history-pm','mm-active')
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
                <div>2D Overview Dashboard AM
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
            <div class="card">
                <div class="card-body">
                    @if($two_transactions)
                    <div class="column" >
                        @foreach($two_transactions as $two_transaction)
                        <div class="d-flex" style="width:100px">
                            <p class="mb-2 mr-3 ">{{$two_transaction->two}} </p> => <span class="ml-2 @if( ($two_brake->amount ?? 9999999999999999999999) < $two_transaction->total)  text-danger @endif">{{number_format($two_transaction->total)}}</span>
                            <a href="{{url('/admin/two-overview/twopout/'.$two_transaction->two.'/date='.$date)}}"><span><i class="fas fa-eye ml-3"></i></span></a>
                        </div>
                    @endforeach
                    </div>
                @endif
                
                <h5 class="text-success" style="font-weight: 700">Total amount => {{number_format($two_transactions_total)}}</h5>
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