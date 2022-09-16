@extends('admin.layouts.admin')

@section('main-content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>ward</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">ward</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="container">

    <div class="card border-info mb-3">
        <form class="form-horizontal" method="POST" action="{{ route('wards.update', $ward->id) }}">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            <div class="card-header bg-transparent border-info">{{ __('ward') }}</div>
            <div class="card-body">
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">{{ __('Name') }}</label>
                        <div class="col-sm-10">
                            <input type="text" id="ward_name" class="form-control" name="ward_name" value="{{ (old('ward_name')) ? old('ward_name') : $ward->ward_name }}" placeholder="ward Name">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="reorder_alert" class="col-sm-2 col-form-label">{{ __('Description') }}</label>

                        <div class="col-sm-10">
                            <input id="description" type="text" class="form-control" name="description" value="{{ (old('description')) ? old('description') : $ward->description }}" placeholder="description">
                        </div>
                    </div>
                     <div class="form-group row">
                        <label for="select" class="col-sm-2 col-form-label">Visible</label>
                        <div class="col-sm-10">
                            <select id="visible" name="visible" class="form-control">
                                <option value="">--Select--</option>
                                <option value="0" {{ ($ward->visible == 0) ? "selected='selected'" : '' }}>No</option>
                                <option value="1" {{ ($ward->visible == 1) ? "selected='selected'" : '' }}>Yes</option>

                            </select>
                        </div>
                    </div>

                  

            </div>
            <div class="card-footer bg-transparent border-info">
                <div class="form-group row">
                    <div class="col-md-6"><a href="{{ route('wards.index') }}" class="btn btn-success"> <i class="fa fa-close"></i> Back</a></div>
                    <div class="col-md-6 "><button type="submit" class="btn btn-primary pull-right"> <i class="fa fa-send"></i> Submit</button></div>
                </div>
            </div>
        {!! Form::close() !!}
    </div>

</section>


@endsection
