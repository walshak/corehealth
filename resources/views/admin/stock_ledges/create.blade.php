@extends('admin.layouts.admin')

@section('main-content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>{{ __('Create Stock Ledge') }}</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">{{ __('Create Stock Ledge') }}</li>
        </ol>
      </div>
    </div>
  </div>
</section>


<section class="container">
    <div class="card border-info mb-3">
        {!! Form::open(array('route' => 'stock-ledge.store', 'method'=>'POST', 'class' => 'form-horizontal' )) !!}
            @csrf
            <div class="card-header bg-transparent border-info">{{ __('Create Stock Ledge') }}</div>

            <div class="card-body">
                <div class="form-group row">
                    <label for="ledge_date" class="col-md-4 col-form-label text-md-right">{{ __('Ledge Date ') }}</label>

                    <div class="col-md-8">
                        <input type="date" id="ledge_date" name="ledge_date" class="form-control" placeholder="Click to Show Date" value="{{ old('ledge_date') }}" required autofocus >
                    </div>
                </div>
            </div>

            <div class="card-footer bg-transparent border-info">
                <div class="form-group row">
                    <div class="col-md-6"><a href="{{ route('products.index') }}" class="btn btn-success"> <i class="fa fa-close"></i> Back</a></div>
                    <div class="col-md-6 "><button type="submit" class="btn btn-primary pull-right"> <i class="fa fa-send"></i> Submit</button></div>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</section>

@endsection
