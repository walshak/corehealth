@extends('admin.layouts.admin')

@section('main-content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Change Product Manager</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Change Product Manager </li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<section class="container">



            <div class="card border-info mb-3">

                 <form class="form-horizontal" method="POST" action="{{ route('products-managers.update', $product->id) }}">
                                {{ csrf_field() }}

                        <input name="_method" type="hidden" value="PUT">
                        <input type="hidden" name="product_id" value="{{$product->id}}">
                    <div class="card-header bg-transparent border-info">
                        <div class="form-group row">
                            <div class="col-md-6">Change Manager for {!! $product->product_name !!}</div>
                            <div class="col-md-6"> <h5> Present Manager {!! $present_manager !!} </h5></div>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="form-group row">
                                    <label for="select" class="col-sm-2 col-form-label">Product Managers</label>
                                    <div class="col-sm-10">
                                        {{-- <select id="user" name="user" class="form-control">
                                             <option value=""> --Select--</option> @foreach($users as $user)
                                                   <option value="{{$user->id}}">{{$user->firstname.' '.$user->lastname.' '.$user->othername}} </option>
                                                   @endforeach
                                                </select>

                                        </select> --}}
                                        {!! Form::select('user_id', $users , null, ['id' => 'user_id', 'placeholder' => 'Please Select', 'class' => 'form-control', 'data-live-search' => 'true' ]) !!}

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
