@extends('backend.layouts.app')
@section('3D','mm-active')
@section('main')
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-display2 icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div>3D Dashboard
                    <div class="page-title-subheading">1Star2DMM
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a href="{{url('admin/three/create')}}" class="btn btn-success mb-3 ml-3"><i class="fas fa-circle-plus"></i>
        Create</a>
    <div class="container p-0">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-hover" id="three-table">
                        <thead>
                            <th>Name</th>
                            <th>3D</th>
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
            var table = $('#three-table').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "ajax": "/admin/three/datatables/ssd",
                        "columns" : [
                            {
                                data : "name",
                                name : "name",
                            },
                            {
                                data : "three",
                                name : "three",
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
                        order : [3 , "desc"]
                    });

                    $(document).on('click','#delete',function(e){
                        e.preventDefault();
                        var id = $(this).data('id');
                        var three = $(this).data('three');
                        var amount = $(this).data('amount');
                        const swalWithBootstrapButtons = Swal.mixin({
                                customClass: {
                                    confirmButton: 'btn btn-success',
                                    cancelButton: 'btn btn-danger'
                                },
                                buttonsStyling: false
                                })

                                swalWithBootstrapButtons.fire({
                                title: three+ " => "+amount+" ကိုဖျက်မှာသေချာပါသလား ",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'လုပ်မည်',
                                cancelButtonText: 'မလုပ်ပါ',
                                reverseButtons: true
                                }).then((result) => {
                                if (result.isConfirmed) {
                                    $.ajax({
                                        url : "/admin/three/"+id,
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