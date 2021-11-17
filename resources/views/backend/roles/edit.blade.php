@extends('backend.layouts.app')
@section('roles','mm-active')
@section('main')
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-display2 icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div>Role Edit Page
                    <div class="page-title-subheading">1Star2DMM
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="{{url('admin/roles',$role->id)}}" method="POST" id="update">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" name="name" class="form-control" value="{{$role->name}}">
                    </div>
                    
                    <div class="row">
                        @foreach ($permissions as $permission)
                        <div class="col-md-3">
                            <div class="form-check mb-3">
                                <input type="checkbox" class="form-check-input" value="{{$permission->name}}" name="permissions[]" 
                                id="name_{{$permission->id}}" @if(in_array($permission->name,$old_permissions)) checked @endif>
                                <label class="form-check-label" for="name_{{$permission->id}}"  >{{$permission->name}}</label>
                            </div>
                        </div>
                        @endforeach
                    </div>


                    <button type="submit" class="btn btn-sm btn-primary">Confirm</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\UpdateRole','#update') !!}

<script>
    $(document).ready(function() {
    })
    
</script>
@endsection