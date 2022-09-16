@extends('admin.layouts.admin')

@section('main-content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>{{$lab->lab_name}}</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Lab Service</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="container">

    <div class="card border-info mb-3">
        {!! Form::open(array('route' => 'lab-services.store', 'method'=>'POST', 'class' => 'form-horizontal' )) !!}
                {{ csrf_field() }}
            <div class="card-header bg-transparent border-info">{{$lab->lab_name}}</div>
            <input type="hidden" name="lab_id" value="{{$lab->id}}">
            <div class="card-body">
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">{{ __('Service Name') }}</label>
                        <div class="col-sm-10">
                            <input type="text" id="lab_service_name" class="form-control" name="lab_service_name" value="{{ old('lab_service_name') }}" placeholder="lab Name">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="reorder_alert" class="col-sm-2 col-form-label">{{ __('Description') }}</label>

                        <div class="col-sm-10">
                            <input id="description" type="text" class="form-control" name="description" value="{{ old('description') }}" placeholder="description">
                        </div>
                    </div>

                  

            </div>
            <div class="card-footer bg-transparent border-info">
                <div class="form-group row">
                    <div class="col-md-6"><a href="{{ route('labs.index') }}" class="btn btn-success"> <i class="fa fa-close"></i> Back</a></div>
                    <div class="col-md-6 "><button type="submit" class="btn btn-primary pull-right"> <i class="fa fa-send"></i> Submit</button></div>
                </div>
            </div>
        {!! Form::close() !!}
    </div>

</section>


@endsection
