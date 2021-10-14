@extends('backend.layouts.app')
@section('2D-over','mm-active')
@section('main')
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-display2 icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div>2D Overview Dashboard
                    <div class="page-title-subheading">Royal
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-hover" id="two-over-table">
                        <thead>
                            <th>Id</th>
                            <th>2D</th>
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
            var table = $('#two-over-table').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "ajax": "/admin/two-overview/datatables/ssd",
                        "columns" : [
                            {
                                data : "id",
                                name : "id",
                            },
                            {
                                data : "two",
                                name : "two",
                            },
                            {
                                data : "amount",
                                name : "amount",
                            },
                            {
                                data : "updated_at",
                                name : "updated_at",
                            },
                        ],
                        order : [3 , "desc"]
                    });

                    
       });
    
</script>
@endsection