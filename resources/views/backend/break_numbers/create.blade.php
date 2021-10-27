@extends('backend.layouts.app')
@section('break_numbers','mm-active')
@section('main')
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-display2 icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div>ဘရိတ်နံပါတ် Create Page
                    <div class="page-title-subheading">1Star2DMM
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="{{url('admin/amountbreaks')}}" method="POST" id="create">
                    @csrf
                    <div class="form-group">
                        <label for="">ပိတ်မည့်အမျိုးအမည်</label>
                        <select name="type" class="form-control">
                            <option value="">Select Number</option>
                            <option value="2D">2D</option>
                            <option value="3D">3D</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">ပိတ်မည့်ဂဏန်း</label>
                        <input type="text" name="closed_number" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Amount</label>
                        <input type="amount" name="amount" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-sm btn-primary">Confirm</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\StoreBreakNumber','#create') !!}

<script>
    $(document).ready(function() {
    })
    
</script>
@endsection