@if($three_transactions)
@foreach($three_transactions as $three_transaction)
<tr>
    <td>{{ $three_transaction->three}} </td>
    <td>{{ $three_transaction->total }}</td>
</tr>
@endforeach
@endif