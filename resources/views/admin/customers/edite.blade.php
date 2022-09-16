@extends('admin.layouts.admin')

@section('main-content')

@section('main-content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Client Information</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Edit Client Information</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <!-- Default box -->
    <div class="card card-primary">
        <div class="card-header with-border">
            <h3 class="card-title">Edit Client Information</h3>
            <div class="card-tools pull-right">
                {{-- <a href="{{ route('company.create') }}" class="btn btn-success"><i class="fa fa-list"></i> View
                Citizens</a> --}}
            </div>
        </div>
        <form class="form-horizontal" method="POST" action="{{ route('customers.update', $data->id) }}">
            <div class="card-body">
                {{ csrf_field() }}
                <input name="_method" type="hidden" value="PUT">
                <div class="form-group">
                    <label for="name" class="control-label"> FullName </label>
                    <div class="form-control-material">
                        <input type="text" name="name" id="name" placeholder=" Client FullName " class="form-control"
                            value="{{ (old('name')) ? old('name') : $data->fullname }}" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="code" class="control-label"> Code </label>
                    <div class="form-control-material">
                        <input type="text" name="code" id="code" placeholder=" Client Code " class="form-control"
                            value="{{ (old('code')) ? old('code') : $data->code }}" />
                    </div>
                </div>
                {{-- <div class="form-group">
                    <label>Customer Type:</label>
                    {!! Form::select('customers ', $customers , null, ['id' => 'type_name', 'placeholder' =>
                    $data->customer_type->type_name, 'class' => 'select2 show-tick form-control', 'data-live-search' =>
                    'true' ]) !!}
                </div> --}}
                <div class="form-group">
                    {{-- <label for="type_name" class="col-sm-2 col-form-label">Client Type:</label> --}}
                    <div class="col-sm-10">
                        <input type="hidden" name="customers_" id="customers_" placeholder="credit type name"
                            class="form-control" value="2" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="phone" class="control-label"> Phone Number</label>
                    <div class="form-control-material">
                        <input type="text" name="phone" id="phone" placeholder=" Phone Number" class="form-control"
                            value="{{ (old('phone')) ? old('phone') : $data->phone }}" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="address" class="control-label"> Address </label>
                    <div class="form-control-material">
                        <input type="text" name="address" id="address" placeholder="Address" class="form-control"
                            value="{{ (old('address')) ? old('address') : $data->address }}" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="credit_limit" class="control-label"> Budget Limit :</label>
                    <div class="form-control-material">
                        <input type="text" name="credit_limit" id="credit_limit" placeholder=" Budget Limit"
                            class="form-control"
                            value="{{ (old('credit_limit')) ? old('credit_limit') : $data->credit_limit }}" />
                    </div>

                </div>
                <div class="form-group">
                    <label for="select" class="control-label">Visible</label>
                    <div class="">
                        <select id="visible" name="visible" class="form-control selectpicker" data-style="btn-white"
                            data-live-search="true">
                            <option value="">--Select--</option>
                            <option value="0" {{ ($data->visible == 0) ? "selected='selected'" : '' }}>No
                            </option>
                            <option value="1" {{ ($data->visible == 1) ? "selected='selected'" : '' }}>Yes
                            </option>

                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="form-group row">
                    <div class="col-md-6"><a href="{{ route('customers.index') }}" class="btn btn-success"> <i
                                class="fa fa-close"></i>
                            Back</a></div>
                    <div class="col-md-6 "><button type="submit" class="btn btn-primary pull-right"> <i
                                class="fa fa-send"></i>
                            Submit</button></div>
                </div>
            </div>
            {!! Form::close() !!}
    </div>
    {{-- </div> --}}
    </div>
    </div>
</section>
@endsection