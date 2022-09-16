@extends('admin.layouts.admin')

@section('main-content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Client</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Create Client</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="container">
    <div class="card border-info mb-3">
        <div class="card-header bg-transparent border-info">
            <h3 class="card-title">

                <div class="clearfix">
                    <div class="float-left">{{ __('New Client') }}</div>
                    <div class="float-right">
                        {{-- <a class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="edit" href="{{ route('customers.create') }}">
                        <i class="fa fa-plus text-warning"></i> Add Customer
                        </a> --}}
                    </div>
                </div>
            </h3>
        </div>
        {!! Form::open(array('route' => 'customers.store', 'method'=>'POST', 'role'=>'form', 'class' =>
        'form-horizontal' )) !!}
        <div class="card-body">
            {{ csrf_field() }}

            <div class="form-group row">
                <label for="Fullname" class="col-sm-2 col-form-label">FullName: </label>
                <div class="col-sm-10">
                    <input type="text" name="name" id="name" placeholder="Fullname" class="form-control"
                        value="{{old('name')}}" />
                </div>
            </div>
            <div class="form-group row">
                <label for="Code" class="col-sm-2 col-form-label">Code: </label>
                <div class="col-sm-10">
                    <input type="text" name="code" id="code" placeholder="Code" class="form-control"
                        value="{{old('code')}}" />
                </div>
            </div>

            {{-- <div class="form-group row">
                <label for="type_name" class="col-sm-2 col-form-label">Client Type:</label>
                <div class="col-sm-10">
                    {!! Form::select('customers ', $customers , null, ['id' => 'type_name', 'placeholder' => '--Pick--',
                    'class' => 'select2 show-tick form-control', 'data-live-search' => 'true' ]) !!}
                </div>
            </div> --}}
            <div class="form-group row">
                {{-- <label for="type_name" class="col-sm-2 col-form-label">Client Type:</label> --}}
                <div class="col-sm-10">
                    <input type="hidden" name="customers_" id="customers_" placeholder="credit type name"
                        class="form-control" value="2" />
                </div>
            </div>

            <div class="form-group row">
                <label for="phone" class="col-sm-2 col-form-label"> Contact Number: </label>
                <div class="col-sm-10">
                    <input type="text" name="phone" id="phone" placeholder="Contact Number" class="form-control"
                        value="{{old('phone')}}" />
                </div>
            </div>

            <div class="form-group row">
                <label for="address" class="col-sm-2 col-form-label"> Address: </label>
                <div class="col-sm-10">
                    <textarea name="address" placeholder="Enter Address" id="address" class="form-control" cols="88"
                        rows="10">{{ old('address') }}</textarea>
                </div>
            </div>

            <div class="form-group row" style="display: none;">
                <label for="credit_limit" class="col-sm-2 col-form-label"> Budget Limit:</label>
                <div class="col-sm-10">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="creditLimit">{{ __(NAIRA_CODE) }}</span>
                        </div>
                        <input type="number" name="credit_limit" id="credit_limit"
                            placeholder="Budget Limit for Client's Department" class="form-control"
                            value="00000000" aria-describedby="creditLimit" />
                    </div>
                </div>
            </div>

        </div>
        <div class="card-footer bg-transparent border-info">
            <div class="form-group row">
                <div class="col-md-6"><a href="{{ route('customers.index') }}" class="btn btn-success"> <i
                            class="fa fa-close"></i> Back</a></div>
                <div class="col-md-6 "><button type="submit" class="btn btn-primary pull-right"> <i
                            class="fa fa-send"></i> Submit</button></div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</section>

@endsection