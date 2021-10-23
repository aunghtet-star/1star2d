@extends('backend.layouts.app')
@section('2D','mm-active')
@section('main')
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-display2 icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div>2D Edit Page
                    <div class="page-title-subheading">1Star2DMM
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="{{url('admin/two/'.$number->id)}}" method="POST" id="update">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="">Name</label>
                        <select name="user_id" class="form-control">
                            <option value="">Select User</option>
                            @foreach ($users as $user)
                            <option value="{{$user->id}}" @if($user->id == $number->user_id) selected @endif>{{$user->name}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">2D</label>
                        <input type="text" name="two" class="form-control" value="{{$number->two}}">
                    </div>
                    <div class="form-group">
                        <label for="">Amount</label>
                        <input type="amount" name="amount" class="form-control" value="{{$number->amount}}">
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