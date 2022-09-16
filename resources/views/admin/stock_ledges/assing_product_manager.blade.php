@extends('admin.layouts.admin')

@section('main-content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Assign Manager</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active"> Product Manager </li>
            </ol>
        </div>
        </div>
    </div>
</section>

<section class="container">
    <div class="card border-info mb-3">
        {!! Form::open(array('route' => 'products-managers.store', 'method'=>'POST', 'class' => 'form-horizontal' )) !!}
            {{ csrf_field() }}
            <input type="hidden" name="product_id" value="{{$product->id}}">
            <div class="card-header bg-transparent border-info">Assign Manager for {!! $product->product_name !!}</div>
            <div class="card-body">
                <div class="form-group row">
                    <label for="select" class="col-sm-2 col-form-label">Product Managers</label>
                    <div class="col-sm-10">
                        {!! Form::select('user_id', $users , null, ['id' => 'user_id', 'placeholder' => 'Please Select', 'class' => 'form-control', 'data-live-search' => 'true' ]) !!}
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-info">
                <div class="form-group row">
                    <div class="col-md-6"><a href="{{ route('products-managers.index') }}" class="btn btn-success"> <i class="fa fa-close"></i> Back</a></div>
                    <div class="col-md-6 "><button type="submit" class="btn btn-primary pull-right"> <i class="fa fa-send"></i> Submit</button></div>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</section>
@endsection
