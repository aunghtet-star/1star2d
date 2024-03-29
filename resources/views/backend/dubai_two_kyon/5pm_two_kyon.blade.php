@extends('backend.layouts.app')
@section('dubai-kyon-5pm','mm-active')
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
                    <div>Dubai 2D ကျွံ Dashboard 5PM
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
                        <div class="column" >
                            @php
                                $total = 0;
                            @endphp
                            @foreach($two_kyons as $two_kyon)
                                <div class="d-flex" style="width:100px">
                                    @if (($two_kyon->amount - $two_kyon->new_amount - $two_kyon->kyon_amount) > 0)
                                        <p class="mb-2 mr-3 ">{{$two_kyon->two}} </p> => <span class="ml-2 ">
                                    {{number_format( $two_kyon->amount - $two_kyon->new_amount - $two_kyon->kyon_amount) }}
                                    </span>
                                        @php
                                            $total += $two_kyon->amount - $two_kyon->new_amount - $two_kyon->kyon_amount;
                                        @endphp
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <h5 class="text-success" style="font-weight: 700">Total amount => {{number_format($fake_number ? $fake_number->number : $total)}}</h5>
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
