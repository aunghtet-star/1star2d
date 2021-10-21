@if($transactions)
@foreach($transactions as $transaction)
<tr>
    <td>{{$transaction->two}}</td>
    <td>{{ $transaction->total}}</td>
</tr>
@endforeach
@endif