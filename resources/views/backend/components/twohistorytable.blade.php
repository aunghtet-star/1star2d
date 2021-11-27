<style>
  .column {
    display: flex;
    flex-direction: column;
    flex-wrap: wrap;
    margin-right: 250px;
    width: 1000px;
    height: 80vh;
}
.column p {
    display: flex;
}
}
</style>

@if($two_transactions)
    <div class="column" >
        @foreach($two_transactions as $two_transaction)
        <div class="d-flex" style="width:100px">
            <p class="mb-2 mr-3 ">{{$two_transaction->two}} </p> => <span class="ml-2 @if($two_brake->amount < $two_transaction->total)  text-danger @endif">{{number_format($two_transaction->total)}}</span>
            <a href="{{url('/admin/two-overview/twopout/'.$two_transaction->two.'/date='.$date)}}"><span><i class="fas fa-eye ml-3"></i></span></a>
        </div>
    @endforeach
    </div>
@endif

<h5 class="text-success" style="font-weight: 700">Total amount => {{number_format($two_transactions_total)}}</h5>
<script>
    
    $(document).ready(function() {
        
    })
</script>


