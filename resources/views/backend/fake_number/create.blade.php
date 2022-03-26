@extends('backend.layouts.app')
@section('fake_number','mm-active')
@section('main')
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-display2 icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div>FakeNumber Create Page
                    <div class="page-title-subheading">1Star2DMM
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        @include('frontend.flash')
        <div class="card">
            <div class="card-body">
                <form action="{{url('admin/fake_number')}}" method="POST" id="create">
                    @csrf
                    <div class="form-group">
                        <label for="">Number</label>
                        <input type="text" name="number" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-sm btn-primary">Confirm</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')

<script>
    $(document).ready(function() {
    })
    
</script>
@endsection