@extends('backend.layouts.app')
@section('allbreakwithamount','mm-active')
@section('main')
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-display2 icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div>ဘရိတ်ပမာဏ Edit Page
                    <div class="page-title-subheading">1Star2DMM
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="{{url('admin/allbreakwithamount/'.$all_break_with_amount->id)}}" method="POST" id="update">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="">ပိတ်မည့်အမျိုးအမည်</label>
                        <select name="type" class="form-control">
                            <option value="">Select Number</option>
                            @foreach($numbers as $number)
                            <option value="{{$number->type}}" @if($number->type == $all_break_with_amount->type) selected @endif>{{$number->type}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Amount</label>
                        <input type="amount" name="amount" class="form-control" value="{{$all_break_with_amount->amount ?? old('amount')}}">
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\UpdateAllBreakWithAmount','#update') !!}

<script>
    $(document).ready(function() {
            
    
</script>
@endsection