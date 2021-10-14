@extends('backend.layouts.app')
@section('2D','mm-active')
@section('main')
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-display2 icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div>2D Dashboard
                    <div class="page-title-subheading">Royal
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a href="{{url('admin/two/create')}}" class="btn btn-success mb-3 ml-3"><i class="fas fa-circle-plus"></i>
        Create</a>
    <div class="container">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-hover" id="two-table">
                        <thead>
                            <th>Id</th>
                            <th>Name</th>
                            <th>2D</th>
                            <th>Amount</th>
                            <th>Date</th>
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
            var table = $('#two-table').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "ajax": "/admin/two/datatables/ssd",
                        "columns" : [
                            {
                                data : "id",
                                name : "id",
                            },
                            {
                                data : "name",
                                name : "name",
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
                            {
                                data : "action",
                                name : "action",
                            },
                        ],
                        order : [4 , "desc"]
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
                                        url : "/admin/two/"+id,
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