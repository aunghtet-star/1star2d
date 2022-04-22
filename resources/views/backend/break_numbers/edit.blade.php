@extends('backend.layouts.app')
@section('break_number','mm-active')
@section('main')
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-display2 icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div>ဘရိတ်နံပါတ် Edit Page
                    <div class="page-title-subheading">1Star2DMM
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="{{url('admin/amountbreaks/'.$amountbreak->id)}}" method="POST" id="update">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="">ပိတ်မည့်အမျိုးအမည်</label>
                        <select name="type" class="form-control">
                            <option value="">Select Number</option>
                            @foreach($numbers as $number)
                            <option value="2D" @if($number->type == '2D') selected @endif>2D</option>
                            <option value="Dubai_2D" @if($number->type == 'Dubai_2D') selected @endif>Dubai 2D</option>
                            <option value="3D" @if($number->type == '3D') selected @endif>3D</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">ပိတ်မည့်ဂဏန်း</label>
                        <input type="text" name="closed_number" class="form-control" value="{{$amountbreak->closed_number ?? old('closed_number')}}">
                    </div>
                    <div class="form-group">
                        <label for="">Amount</label>
                        <input type="amount" name="amount" class="form-control" value="{{$amountbreak->amount ?? old('amount')}}">
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\UpdateTwo','#update') !!}

<script>
    $(document).ready(function() {


</script>
@endsection
