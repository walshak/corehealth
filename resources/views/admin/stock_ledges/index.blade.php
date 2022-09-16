@extends('admin.layouts.admin')

@section('main-content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>{{ __('Find Product Ledger') }}</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">{{ __('Find Product Ledger') }}</li>
        </ol>
      </div>
    </div>
  </div>
</section>


<section class="container">
    <div class="card border-info mb-3">
        {!! Form::open(array('route' => 'findLedge', 'method'=>'POST', 'class' => 'form-horizontal' )) !!}
            @csrf
            <div class="card-header bg-transparent border-info">
                <ul>
                    <li>Pick a product from the dropdown or date to search for a product ledger</li>
                </ul>
            </div>

            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="product_name" class="col-md-4 col-form-label text-md-right">{{ __('Product Name') }}</label>
                    </div>

                    <div class="col-md-6 ">
                        <label for="ledge_date" class="col-md-4 col-form-label text-md-right">{{ __('Ledger Date') }}</label>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        {!! Form::select('products', $products , null, ['id' => 'product', 'placeholder' => ' Select Product', 'class' => 'form-control', 'data-live-search' => 'true' ]) !!}
                    </div>

                    <div class="col-md-6 ">
                        <input id="ledge_date" type="date" class="form-control" name="ledge_date" value="{{ old('ledge_date') }}"  autofocus >
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

