@extends('admin.layouts.admin')

@section('main-content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Product Price Setting</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Product Price Setting</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="container">
    <div class="card border-info mb-3">
        {!! Form::open(array('route' => 'prices.store', 'method'=>'POST', 'class' => 'form-horizontal' )) !!}
        @csrf
        <div class="card-header bg-transparent border-info">{{ __('Product Price Setting') }}</div>
        <div class="card-body">
            <table class="table table-sm table-responsive table-bordered table-striped ">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Supplier's Price (&#8358;)</th>
                        <th>Issue Price (&#8358;)</th>
                        <th>Max. Discount (&#8358;)</th>
                        @if($application->allow_piece_sale == 1)
                        <th>Pieces Price (&#8358;)</th>
                        <th>Pieces Max. Discount (&#8358;)</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>

                            {!! Form::select('products', $products , null, ['id' => 'product', 'placeholder' => 'Pick a
                            Product', 'class' => 'select2 show-tick form-control', 'data-live-search' => 'true'
                            ]) !!}


                        </td>
                        <td>
                            <input type="text" name="buy_price" id="buy_price" placeholder="Buying Price"
                                class=" form-control" value="{{ old('buy_price')  }}" />
                        </td>
                        <td>
                            <input type="text" name="price" id="price" placeholder="Price" class=" form-control"
                                value="{{ old('price')  }}" />
                        </td>
                        <td>
                            <input type="text" name="max_discount" id="max_discount" placeholder="Maximum Discount"
                                class=" form-control" value="{{ (old('max_discount')) ? old('max_discount') :0  }}" />
                        </td>
                        @if($application->allow_piece_sale == 1)
                        <td>
                            <input type="text" name="piece_sprice" id="pieces_price" placeholder="Pieces Price"
                                class=" form-control" value="{{ (old('piece_sprice')) ? old('piece_sprice') :0  }}" />
                        </td>
                        <td>
                            <input type="text" name="pieces_max_discount" id="pieces_max_discount"
                                placeholder="Maximum Discount" class=" form-control" readonly="1"
                                value="{{ (old('pieces_max_discount')) ? old('pieces_max_discount') :0  }}" />
                        </td>
                        @endif

                    </tr>
                </tbody>
            </table>

        </div>
        <div class="card-footer bg-transparent border-info">
            <div class="form-group row">
                <div class="col-md-6"><a href="{{ route('products.index') }}" class="btn btn-success"> <i
                            class="fa fa-close"></i> Back</a></div>
                <div class="col-md-6"><button type="submit" class="btn btn-primary float-right"> <i
                            class="fa fa-send"></i> Submit</button></div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</section>
@endsection