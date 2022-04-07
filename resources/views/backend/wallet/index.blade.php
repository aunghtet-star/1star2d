@extends('backend.layouts.app')
@section('wallet','mm-active')
@include('frontend.flash')
@section('main')
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-display2 icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div>Wallet Dashboard
                    <div class="page-title-subheading">1Star2DMM
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container p-0">
        <div class="col-md-12">
            <div class="d-flex justify-content-between">
                <div>
                    @can('add_wallet')
                    <a href="{{url('admin/wallet/add')}}" class="btn btn-success btn-sm mb-2" style="font-weight: 700"><i class="fas fa-circle-plus"></i> ငွေထည့်ရန်</a>
                    @endcan
                    @can('substract_wallet')
                    <a href="{{url('admin/wallet/substract')}}" class="btn btn-danger btn-sm mb-2" style="font-weight: 700"><i class="fas fa-circle-minus"></i> ငွေထုတ်ရန်</a>
                    @endcan
                </div>
                <div>
                    @if (Auth::guard('adminuser')->user()->hasRole('Admin'))
                    <p></p>
                    @else
                    <p class="btn btn-outline-dark"><i class="fas fa-coins mr-3"></i>{{number_format($user_wallet->amount)}}</p>
                    @endif
                </div>
            </div>
            
            <div class="card" >
                <div class="card-body">
                    <table class="table table-bordered table-hover" id="two-table" >
                        <thead>
                            <th>Name</th>
                            <th>Account Number</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
            var table = $('#two-table').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "ajax": "/admin/wallet/datatables/ssd",
                        "columns" : [
                            {
                                data : "user_id",
                                name : "user_id",
                            },
                            {
                                data : "account_numbers",
                                name : "account_numbers",
                            },
                            {
                                data : "amount",
                                name : "amount",
                            },
                            {
                                data : "created_at",
                                name : "created_at",
                            }
                        ],
                        order : [3 , "desc"]
                    });

                    
       });
    
</script>
@endsection