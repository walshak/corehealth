@extends('admin.layouts.admin')

@section('main-content')

<section class="content-header">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0 text-dark">List of Products by Category <span class="badge badge-dark">{!!
                            $reqCat[0]->category_name !!}</span></h4>
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
    <div class="card-header bg-transparent border-info">{{ __('List of Products') }}</div>
    <div class="card-body">
        <div class="form-group col-md-12">
            <label for="permission">List of Products Assigned to <span class="badge badge-dark">{!!
                    $reqCat[0]->category_name !!}</span> Category</label>
            <div class="col-md-12">
                <div class="row">
                    @foreach($reqCat[0]->products as $product)
                    @if(!empty($product))
                    <div class="col-md-4">
                        <div class="checkbox">
                            <label class="form-check-label" for="{{ $product->product_name }}"><i
                                    class="fa fa-compass"></i>
                                {{ $product->product_name }}</label>
                            <br />
                        </div>
                    </div>
                    @else
                    <div class="col-md-4">
                        <div class="checkbox">
                            <label class="form-check-label" for="{{ $product->product_name }}"><i
                                    class="fa fa-compass"></i>
                                {{ $product->product_name }}</label>
                            <p>No Product for this category <span class="badge badge-dark">{!!
                                    $reqCat[0]->category_name !!}</span></p>
                            <br />
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer bg-transparent border-info">
        <div class="form-group row">

            <div class="col-md-6"><a href="{{ route('categories.index') }}" class="btn btn-success"> <i
                        class="fa fa-close"></i> Back</a></div>
            <div class="col-md-6">
                {{-- <button type="submit" class="btn btn-primary float-right"> <i class="fa fa-send"></i>Update</button></div> --}}
            </div>
        </div>
    </div>

    @endsection