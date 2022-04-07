@extends('backend.layouts.app')
@section('2D-over-kyon-am','mm-active')
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
                <div>2D ကျွံ Dashboard AM
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
                    @if($two_overviews_am)
                        <div class="column" >
                            @foreach($two_kyons_am as $two_kyon_am)
                            <div class="d-flex" style="width:100px">
                                @if (($two_kyon_am->amount - $two_kyon_am->new_amount - $two_kyon_am->new_kyon_amount) > 0)
                                    <p class="mb-2 mr-3 ">{{$two_kyon_am->two}} </p> => <span class="ml-2 ">
                                    {{number_format( $two_kyon_am->amount - $two_kyon_am->new_amount - $two_kyon_am->new_kyon_amount) }} 
                                    </span>
                                @endif  
                            </div>
                        @endforeach
                        </div>
                    @endif
                
                <h5 class="text-success" style="font-weight: 700">Total amount => {{number_format($fake_number ? $fake_number->number : ($two_kyons_am_total - $two_kyons_new_amount_am_total - $two_kyons_new_kyon_am_total))}}</h5>
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