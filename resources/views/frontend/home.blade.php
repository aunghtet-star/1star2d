@extends('frontend.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{url('two/create')}}" method="POST" id="create">
                        @csrf

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">2D</label>
                                    <input type="number" name="two" class="form-control">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Amount</label>
                                    <input type="number" name="amount" class="form-control">
                                </div>
                            </div>
                        </div>


                        <button class="btn btn-primary m-0">Confirm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\StoreUserTwoD','#create') !!}


@endsection