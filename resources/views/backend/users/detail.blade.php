@extends('backend.layouts.app')
@section('users','mm-active')
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
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="card" style="height : 70vh">
                        <div class="card-body">
                            <h6 class="text-center">AM</h6>
                            @foreach($two_users_am as $two_user)
                            <div class="row">
                                <div class="col-6 pl-5">
                                    <p class="mb-1">{{ $two_user->two }} => <span>{{$two_user->amount}} </span></p>
                                </div>
                                <div class="col-6 text-center">
                                    <p class="mb-1">{{$two_user->created_at->format('h:i:s A')}}</p>
                                </div>
                            </div>
                            @endforeach

                            @foreach($three_users_am as $three_user)
                            <div class="row">
                                <div class="col-6 pl-5">
                                    <p class="mb-1">{{ $three_user->three }} => <span>{{$three_user->amount}} </span></p>
                                </div>
                                <div class="col-6 text-center">
                                    <p class="mb-1">{{$three_user->created_at->format('h:i:s A')}}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card" style="height : 70vh">
                        <div class="card-body">
                            <h6 class="text-center">PM</h6>
                            @foreach($two_users_pm as $two_user)
                            <div class="row">
                                <div class="col-6 pl-5">
                                    <p class="mb-1">{{ $two_user->two }} => <span>{{$two_user->amount}} </span></p>
                                </div>
                                <div class="col-6 text-center">
                                    <p class="mb-1">{{$two_user->created_at->format('h:i:s A')}}</p>
                                </div>
                            </div>
                            @endforeach

                            @foreach($three_users_pm as $three_user)
                            <div class="row">
                                <div class="col-6 pl-5">
                                    <p class="mb-1">{{ $three_user->three }} => <span>{{$three_user->amount}} </span></p>
                                </div>
                                <div class="col-6 text-center">
                                    <p class="mb-1">{{$three_user->created_at->format('h:i:s A')}}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-0 text-success">Total amount => <span>{{number_format($two_users_am_sum + $three_users_am_sum)}}</span></p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-0 text-success">Total amount => <span>{{number_format($two_users_pm_sum + $three_users_pm_sum)}}</span></p>
                        </div>
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
                                </tbody>
                                @endforeach
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