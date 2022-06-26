@extends('backend.layouts.app')
@section('user-dashboard','mm-active')
@section('main')
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-display2 icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div>User Dashboard
                    <div class="page-title-subheading">1Star2DMM
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container p-0">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-hover" id="users-table">
                        <thead>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Action</th>
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
            var table = $('#users-table').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "ajax": "/admin/user-dashboard/datatables/ssd",
                        "columns" : [

                            {
                                data : "name",
                                name : "name",
                            },
                            {
                                data : "phone",
                                name : "phone",
                            },
                            {
                                data : "action",
                                name : "action",
                            },
                        ]
                    });



       });

</script>
@endsection
