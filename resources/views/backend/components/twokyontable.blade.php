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
  @php
      $total = 0;
  @endphp
      <div class="column" >
          @foreach($two_transactions as $two_transaction)
          <div class="d-flex" style="width:100px">
                @if($two_brake->amount < $two_transaction->total)
                    @php
                    $total += $two_transaction->total - $two_brake->amount;
                    @endphp
                    <p class="mb-2 mr-3 ">{{$two_transaction->two}} </p> => <span class="ml-2 ">
                   {{number_format($two_transaction->total - $two_brake->amount) }} 
                   </span>
                @endif
          </div>
      @endforeach
      </div>
  @endif
  
  <h5 class="text-success" style="font-weight: 700">Total amount => {{number_format($total)}}</h5>
  <script>
      
      $(document).ready(function() {
          
      })
  </script>
  
  
  