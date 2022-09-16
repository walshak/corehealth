@extends('admin.layouts.admin')

@section('main-content')
<div id="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Supplier</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Supplier</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">{{ __('Company') }}</div>

                    <div class="card-body">
                        <form class="form-horizontal" method="POST"
                            action="{{ route('suppliers.update', $supplier->id) }}">
                            {{ csrf_field() }}
                            <input name="_method" type="hidden" value="PUT">

                            <div class="form-group row">
                                <label for="name" class="col-md-2 col-form-label">{{ __('Company Name') }}</label>

                                <div class="col-md-10">
                                    <input id="name" type="text"
                                        class="form-control{{ $errors->has('company_name') ? ' is-invalid' : '' }}"
                                        name="company_name"
                                        value="{{ (old('company_name')) ? old('company_name') : $supplier->company_name }}"
                                        required autofocus>

                                    @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-2 col-form-label">{{ __('Company address') }}</label>

                                <div class="col-md-10">
                                    <input id="address" type="text"
                                        class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"
                                        name="address"
                                        value="{{ (old('address')) ? old('address') : $supplier->address }}" required
                                        autofocus>

                                    @if ($errors->has('address'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="phone" class="col-md-2 col-form-label">{{ __('Phone Number') }}</label>

                                <div class="col-md-10">
                                    <input id="phone" type="phone"
                                        class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                        name="phone" value="{{ (old('phone')) ? old('phone') : $supplier->phone }}"
                                        required autofocus>

                                    @if ($errors->has('phone'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="last_payment"
                                    class="col-md-2 col-form-label">{{ __('Last Payment Amount') }}</label>

                                <div class="col-md-10">
                                    <input id=" last_payment" type="number"
                                        class="form-control{{ $errors->has('  last_payment') ? ' is-invalid' : '' }}"
                                        name=" last_payment"
                                        value="{{ (old('last_payment')) ? old('last_payment') : $supplier->last_payment }}">

                                    @if ($errors->has(' last_payment'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('last_payment') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="  last_payment_date"
                                    class="col-md-2 col-form-label">{{ __('Last Payment Date ') }}</label>

                                <div class="col-md-10">
                                    <input id="last_payment_date" type="date"
                                        class="form-control{{ $errors->has('last_payment_date') ? ' is-invalid' : '' }}"
                                        name=" last_payment_date"
                                        value="{{ (old('last_payment_date')) ? old('last_payment_date') : $supplier->last_payment_date }}">

                                    @if ($errors->has('last_payment_date'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('last_payment_date') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="last_buy_date"
                                    class="col-md-2 col-form-label">{{ __('Last Buy Date ') }}</label>

                                <div class="col-md-10">
                                    <input id="last_buy_date" type="date"
                                        class="form-control{{ $errors->has('last_buy_date') ? ' is-invalid' : '' }}"
                                        name="last_buy_date"
                                        value="{{ (old('last_buy_date')) ? old('last_buy_date') : $supplier->last_buy_date }}">

                                    @if ($errors->has('last_buy_date'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('last_buy_date') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="last_buy_amount"
                                    class="col-md-2 col-form-label">{{ __('Last Buy Amount ') }}</label>

                                <div class="col-md-10">
                                    <input id="last_buy_amount" type="number"
                                        class="form-control{{ $errors->has('last_buy_amount') ? ' is-invalid' : '' }}"
                                        name="last_buy_amount"
                                        value="{{ (old('last_buy_amount')) ? old('last_buy_amount') : $supplier->last_buy_amount }}">

                                    @if ($errors->has('last_buy_amount'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('last_buy_amount') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="credit" class="col-md-2 col-form-label">{{ __('Credit Amount') }}</label>

                                <div class="col-md-10">
                                    <input id="credit" type="number"
                                        class="form-control{{ $errors->has('credit') ? ' is-invalid' : '' }}"
                                        name="credit" value="{{ (old('credit')) ? old('credit') : $supplier->credit }}">

                                    @if ($errors->has('credit'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('credit') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="deposit" class="col-md-2 col-form-label">{{ __('Deposit') }}</label>

                                <div class="col-md-10">
                                    <input id="deposit" type="number"
                                        class="form-control{{ $errors->has('deposit') ? ' is-invalid' : '' }}"
                                        name="deposit"
                                        value="{{ (old('deposit')) ? old('deposit') : $supplier->deposit }}">

                                    @if ($errors->has('deposit'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('deposit') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="date_line" class="col-md-2 col-form-label">{{ __('Date Line ') }}</label>

                                <div class="col-md-10">
                                    <input id="date_line" type="date"
                                        class="form-control{{ $errors->has('date_line') ? ' is-invalid' : '' }}"
                                        name=" date_line"
                                        value="{{ (old('date_line')) ? old('date_line') : $supplier->date_line }}">

                                    @if ($errors->has('date_line'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('date_line') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="visible" class="col-md-2 col-form-label">Visible</label>
                                <div class="col-md-10">
                                    <select id="visible" name="visible" class="form-control selectpicker"
                                        data-style="btn-white" data-live-search="true">
                                        <option value="">--Select--</option>
                                        <option value="0" {{ ($supplier->visible == 0) ? "selected='selected'" : '' }}>
                                            No</option>
                                        <option value="1" {{ ($supplier->visible == 1) ? "selected='selected'" : '' }}>
                                            Yes</option>

                                    </select>
                                </div>
                            </div>

                            <div class="card-footer bg-transparent border-info">
                                <div class="form-group row">
                                    <div class="col-md-6"><a href="{{ route('suppliers.index') }}"
                                            class="btn btn-success"> <i class="fa fa-close"></i> Back</a></div>
                                    <div class="col-md-6 "><button type="submit" class="btn btn-primary pull-right"> <i
                                                class="fa fa-send"></i>
                                            Update</button></div>
                                </div>
                            </div>

                            {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

@endsection