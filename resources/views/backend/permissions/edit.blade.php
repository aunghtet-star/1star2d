@extends('backend.layouts.app')
@section('permissions','mm-active')
@section('main')
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-display2 icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div>Permission Edit Page
                    <div class="page-title-subheading">1Star2DMM
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="{{url('admin/permissions',$permission->id)}}" method="POST" id="update">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" name="name" class="form-control" value="{{$permission->name}}">
                    </div>
                    
                    <button type="submit" class="btn btn-sm btn-primary">Confirm</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\UpdatePermission','#update') !!}

<script>
    $(document).ready(function() {
    })
    
</script>
@endsection