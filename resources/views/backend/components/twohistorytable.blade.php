@if($two_transactions)
@foreach($two_transactions as $two_transaction)
<tr>
    <td>{{$two_transaction->two}}</td>
    <td>{{ $two_transaction->total}}</td>
</tr>
@endforeach
@endif