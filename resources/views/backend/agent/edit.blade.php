@extends('backend.layouts.app')
@section('agent','mm-active')
@section('main')
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-display2 icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div>Agent Edit Page
                    <div class="page-title-subheading">1Star2DMM
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="{{route('agent.update',$agent->id)}}" method="POST" id="update">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" name="name" value="{{$agent->name }}"
                            class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Phone</label>
                        <input type="text" name="phone" value="{{ $agent->phone }}"
                            class="form-control">
                    </div>

                    {{-- <div class="form-group">
                        <label for="">ရာထူး</label>
                        <select name="roles[]" class="form-control select-role" multiple>
                            <option value="">Select Role</option>
                            @foreach ($roles as $role)
                            <option value="{{$role->name}}" @if(in_array($role->name,$old_roles)) selected @endif>{{$role->name}} 
                            </option>
                            @endforeach
                        </select>
                    </div> --}}

                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\UpdateAdminUser','#update') !!}

<script>
    $(document).ready(function() {
            
    })
</script>
@endsection