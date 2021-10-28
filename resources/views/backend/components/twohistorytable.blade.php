<style>
    .column {
    display: flex;
    flex-direction: column;
    flex-wrap: wrap;
    margin-right: 150px;
    width: 400px;
    height: 80vh;
}
.column p {
    display: flex;
}
</style>

@if($two_transactions)
    <div class="column" >
        @foreach($two_transactions as $two_transaction)
        <div class="d-flex">
            <p class="mb-2 mr-3">{{$two_transaction->two}} </p> => <span class="ml-2">{{number_format($two_transaction->total)}}</span>
        </div>
    @endforeach
    </div>
@endif

<h5 class="text-success" style="font-weight: 700">Total amount => {{$two_transactions_total}}</h5>
<script>
    
    $(document).ready(function() {
        
    })
</script>


