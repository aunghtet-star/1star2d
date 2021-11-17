@extends('backend.layouts.app')
@section('admin-users','mm-active')
@section('main')
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-display2 icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div>Admin Dashboard
                    <div class="page-title-subheading">1Star2DMM
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if('create_admin')
    @can('create_admin')
    <a href="{{url('admin/create')}}" class="btn btn-success mb-3 ml-3"><i class="fas fa-circle-plus"></i> Create</a>
    @endcan
    @endif
    <div class="container p-0">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-hover" id="adminusers-table">
                        <thead>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>ရာထူး</th>
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
            var table = $('#adminusers-table').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "ajax": "admin/admin/datatables/ssd",
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
                                data : "email",
                                name : "email",
                            },
                            {
                                data : "role",
                                name : "role",
                            },
                            {
                                data : "action",
                                name : "action",
                            }
                        ]
                    });

                    $(document).on('click','#delete',function(e){
                        e.preventDefault();
                        var id = $(this).data('id');

                        const swalWithBootstrapButtons = Swal.mixin({
                                customClass: {
                                    confirmButton: 'btn btn-success',
                                    cancelButton: 'btn btn-danger'
                                },
                                buttonsStyling: false
                                })

                                swalWithBootstrapButtons.fire({
                                title: 'Are you sure?',
                                text: "You want to delete!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Yeah',
                                cancelButtonText: 'Nope !',
                                reverseButtons: true
                                }).then((result) => {
                                if (result.isConfirmed) {
                                    $.ajax({
                                        url : "admin/delete/"+id,
                                        type : "DELETE",
                                        success : function(){
                                            table.ajax.reload();
                                        }
                                    });
                                } else if (
                                    /* Read more about handling dismissals below */
                                    result.dismiss === Swal.DismissReason.cancel
                                ) {
                                    swalWithBootstrapButtons.fire(
                                    'Cancelled'
                                    )
                                }
                                })
                      });    
       });
    
</script>
@endsection