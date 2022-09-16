@extends('admin.layouts.admin')

@section('main-content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Payment Type</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Payment Type</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="container">

    <div class="card border-info mb-3">
        <form class="form-horizontal" method="POST" action="{{ route('payment-item.update', $payment_item->id) }}">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            <div class="card-header bg-transparent border-info">{{ __('item_name') }}</div>
            <div class="card-body">
                 <input type="hidden" class="form-control" name="payment_type_id" value="{{$payment_item->payment_type_id }}">
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">{{ __('Name') }}</label>
                        <div class="col-sm-10">
                            <input type="text" id="item_name" class="form-control" name="item_name" value="{{ (old('item_name')) ? old('item_name') : $payment_item->item_name }}" placeholder="payment items">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="reorder_alert" class="col-sm-2 col-form-label">{{ __('Description') }}</label>

                        <div class="col-sm-10">
                            <input id="description" type="text" class="form-control" name="description" value="{{ (old('description')) ? old('description') : $payment_item->description }}" placeholder="description">
                        </div>
                    </div>
                     <div class="form-group row">
                        <label for="amount" class="col-sm-2 col-form-label">{{ __('amount') }}</label>

                        <div class="col-sm-10">
                            <input id="amount" type="text" class="form-control" name="amount" value="{{ (old('amount')) ? old('amount') : $payment_item->amount }}" placeholder="amount">
                        </div>
                    </div>
                     <div class="form-group row">
                        <label for="select" class="col-sm-2 col-form-label">Visible</label>
                        <div class="col-sm-10">
                            <select id="visible" name="visible" class="form-control">
                                <option value="">--Select--</option>
                                <option value="0" {{ ($payment_item->visible == 0) ? "selected='selected'" : '' }}>No</option>
                                <option value="1" {{ ($payment_item->visible == 1) ? "selected='selected'" : '' }}>Yes</option>

                            </select>
                        </div>
                    </div>

                  

            </div>
            <div class="card-footer bg-transparent border-info">
                <div class="form-group row">
                    <div class="col-md-6"><a href="{{ route('payment-type.index') }}" class="btn btn-success"> <i class="fa fa-close"></i> Back</a></div>
                    <div class="col-md-6 "><button type="submit" class="btn btn-primary pull-right"> <i class="fa fa-send"></i> Submit</button></div>
                </div>
            </div>
        {!! Form::close() !!}
    </div>

</section>


@endsection
