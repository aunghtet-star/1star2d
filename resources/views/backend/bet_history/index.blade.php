@extends('backend.layouts.app')
@section('bet-history','mm-active')

@section('main')
   <div class="container pt-3">
       <h5 class="text-center" style="font-weight: 800px">Bet History</h5>
       <div class="card">
           <div class="card-body">
               <div class="col-md-12">
                   <table class="table table-bordered table-hover" id="bet-history-table" style="width: 100%">
                       <thead>
                           <th>Username</th>
                           <th>Transaction Id</th>
                           <th>Type</th>
                           <th>2D/3D</th>
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
            let table = $('#bet-history-table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: "/admin/two-pout/history-datatables-ssd",
                columns : [
                    {  data : 'user_id' , name : 'user_id' },
                    {  data : 'trx_id' , name : 'trx_id' },
                    {  data : 'is_deposit' , name : 'is_deposit' },
                    {  data : 'type' , name : 'type' },
                    {  data : 'amount' , name : 'amount' },
                    {  data : 'updated_at' , name : 'updated_at' },
                ],
                order : [5,"desc"]
            });

           
        })
    </script>
@endsection