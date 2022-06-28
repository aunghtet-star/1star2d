@extends('backend.layouts.app')
@section('agent-dashboard','mm-active')
@section('main')
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-display2 icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div>User Detail
                    <div class="page-title-subheading">1Star2DMM
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container p-0">
        <div class="col-12">
            <div class="row mb-3 ml-0">
                <div class="col-md-6 pl-0">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text type-padding p-1">Date</label>
                        </div>
                        <input type="text" class="form-control date" value="{{request()->date ?? now()->format('Y-m-d')}}" placeholder="All">
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="text-center">လက်ကျန်ငွေ</h5>
                            <div class="d-flex justify-content-between">
                                <p class="mb-2">Name</p>
                                <p class="mb-2">{{$user->name}}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="mb-2">Phone</p>
                                <p class="mb-2">{{$user->phone}}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="mb-2">Amount</p>
                                <p class="mb-2">{{number_format($user_wallet->amount)}} Kyat</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <div class="card" style="height: 60vh">
                        <div class="card-body">
                            <h5 class="text-center">History</h5>
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Transaction No</th>
                                        <th>Amount</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user_transactions as $user_transaction)
                                    <tr>
                                        <td>{{$user_transaction->trx_id}}</td>
                                        <td class="@if($user_transaction->is_deposit == 'bet' || $user_transaction->is_deposit == 'withdraw' ) text-danger @else text-success  @endif"> @if($user_transaction->is_deposit == 'bet' || $user_transaction->is_deposit == 'withdraw') - @else + @endif {{number_format($user_transaction->amount)}}</td>
                                        <td>{{$user_transaction->created_at->format('h:i:s A')}}</td>
                                    </tr>
                                    @endforeach
                                    @foreach($fix_money_from_admins as $fix_money_from_admin)
                                        <tr>
                                            <td>{{$fix_money_from_admin->trx_id}}</td>
                                            <td class="@if($fix_money_from_admin->is_deposit == 'bet' || $fix_money_from_admin->is_deposit == 'withdraw' ) text-danger @else text-success  @endif"> @if($fix_money_from_admin->is_deposit == 'bet' || $fix_money_from_admin->is_deposit == 'withdraw') - @else + @endif {{number_format($fix_money_from_admin->amount)}}</td>
                                            <td>{{$fix_money_from_admin->created_at->format('h:i:s A')}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>

                            <hr>
                        </div>
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
                        "autoUpdateInput" :true,
                        "locale": {
                            "format": "YYYY/MM/DD",
                    },
                    });



                $('.date').on('apply.daterangepicker',function(event,picker){
                $(this).val(picker.startDate.format('YYYY-MM-DD'));
                var date = $('.date').val();
                history.pushState(null, '' , `?date=${date}`);
                window.location.reload();
        });




       });

</script>
@endsection
