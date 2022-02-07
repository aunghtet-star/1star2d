@extends('backend.layouts.app')
@section('3D','mm-active')
@section('main')
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-display2 icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div>3D Edit Page
                    <div class="page-title-subheading">1Star2DMM
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="{{url('admin/three/'.$number->id)}}" method="POST" id="update">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="">Name</label>
                        <select name="user_id" class="form-control select-role">
                            <option value="">Select User</option>
                            @foreach ($users as $user)
                            <option value="{{$user->id}}" @if($user->id == $number->user_id) selected @endif>{{$user->name}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">3D</label>
                        <input type="text" name="three" class="form-control" value="{{$number->three}}">
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
{!! JsValidator::formRequest('App\Http\Requests\UpdateThree','#update') !!}

<script>
    $(document).ready(function() {
            
    
</script>
@endsection