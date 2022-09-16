@extends('admin.layouts.admin')

@section('main-content')

<section class="content-header">
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
</section>

<div class="card border-info mb-3">
    {!! Form::model($productCat, ['method' => 'PATCH', 'route'=> ['categories.update', $productCat->id], 'class' =>
    'form-horizontal'])
    !!}
    {{ csrf_field() }}
    <input name="_method" type="hidden" value="PUT">

    <div class="card-header bg-transparent border-info">{{ __('Edit Product') }}</div>
    <div class="card-body">
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">{{ __('Name') }}</label>
            <div class="col-sm-10">
                <input type="text" id="category_name" class="form-control" name="category_name"
                    value="{{ (old('category_name')) ? old('category_name') : $productCat->category_name }}"
                    placeholder="Category Name">
            </div>
        </div>

        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">{{ __('Code') }}</label>
            <div class="col-sm-10">
                <input type="text" id="category_code" class="form-control" name="category_code"
                    value="{{ (old('category_code')) ? old('category_code') : $productCat->category_code }}"
                    placeholder="Category Name">
            </div>
        </div>

        <div class="form-group row">
            <label for="category_description " class="col-sm-2 col-form-label">{{ __('Description') }}</label>
            <div class="col-sm-10">
                {!! Form::textarea("category_description", $productCat->category_description, ['class' =>
                'form-control',
                'rows' => 4,'name' => 'category_description', 'id' => 'category_description', 'placeholder' =>
                'Category Description']) !!}
            </div>
        </div>

        <div class="form-group row">
            <label for="visible" class="col-sm-2 col-form-label">Status</label>

            <div class="col-sm-10">
                {!! Form::select('options', $options , $productCat->status_id, ['id' => 'status_id', 'name' =>
                'status_id','placeholder' => 'Pick a Value', 'class' => 'form-control', 'data-live-search' => 'true' ])
                !!}
            </div>
        </div>

    </div>
    <div class="card-footer bg-transparent border-success">
        <div class="form-group row">

            <div class="col-md-6"><a href="{{ route('products.index') }}" class="btn btn-success"> <i
                        class="fa fa-close"></i> Back</a></div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary float-right"> <i class="fa fa-send"></i>
                    Update</button></div>
        </div>
    </div>
    </form>
</div>

@endsection