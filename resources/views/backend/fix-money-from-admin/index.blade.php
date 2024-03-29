@extends('backend.layouts.app')
@section('fix-money-from-admin','mm-active')

@section('main')
   <div class="container pt-3">
       <h5 class="text-center" style="font-weight: 800">Admin Fix History</h5>
       <div class="card">
           <div class="card-body">
               <div class="col-md-12">
                   <table class="table table-bordered table-hover" id="fix-money-table" style="width: 100%">
                       <thead>
                           <th>Username</th>
                           <th>Transaction Id</th>
                           <th>Type</th>
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
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            let table = $('#fix-money-table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: "/admin/fix-money-from-admin/datatables-ssd",
                columns : [
                    {  data : 'user_id' , name : 'user_id' },
                    {  data : 'trx_id' , name : 'trx_id' },
                    {  data : 'is_deposit' , name : 'is_deposit' },
                    {  data : 'amount' , name : 'amount' },
                    {  data : 'updated_at' , name : 'updated_at' },
                ],
                order : [4,"desc"]
            });


        })
    </script>
@endsection
