@extends('admin.layouts.admin')

@section('main-content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Product Category </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Product Category</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<section class="content">

    <div class="card border-info mb-3">

        <div class="card-header bg-transparent border-info">
            <div class="row">
                <div class="col-sm-6">
                    {{ __('Product Category') }}
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div>
        {!! Form::open(array('route' => 'categories.store', 'method'=>'POST', 'class' => 'form-horizontal' )) !!}
        {{ csrf_field() }}
        <div class="card-body">
            <div class="form-group row">
                <label for="category_name" class="col-sm-2 col-form-label">{{ __('Name') }}</label>
                <div class="col-sm-10">
                    <input type="text" id="category_name" class="form-control" name="category_name"
                        value="{{ old('category_name') }}" placeholder="Category Name">
                </div>
            </div>

            <div class="form-group row">
                <label for="category_code " class="col-sm-2 col-form-label">{{ __('Code') }}</label>
                <div class="col-sm-10">
                    <input type="text" id="category_code" class="form-control" name="category_code"
                        value="{{ old('category_code') }}" placeholder="Category Code">
                </div>
            </div>

            <div class="form-group row">
                <label for="category_description " class="col-sm-2 col-form-label">{{ __('Description') }}</label>
                <div class="col-sm-10">
                    {!! Form::textarea("category_description", null, ['class' => 'form-control',
                    'rows' => 4,'name' => 'category_description', 'id' => 'category_description', 'placeholder' =>
                    'Category Description']) !!}
                </div>
            </div>

        </div>
        <div class="card-footer bg-transparent border-info">
            <div class="form-group row">
                <div class="col-md-6"><a href="{{ route('products.index') }}" class="btn btn-success"> <i
                            class="fa fa-close"></i> Back</a></div>
                <div class="col-md-6 "><button type="submit" class="btn btn-primary pull-right"> <i
                            class="fa fa-send"></i> Submit</button></div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

</section>


@endsection