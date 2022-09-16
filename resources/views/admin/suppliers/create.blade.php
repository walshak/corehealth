@extends('admin.layouts.admin')

@section('main-content')

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
                <div class="card-header">
                    <h3 class="card-title">Add New Supplier</h3>
                </div>


                {!! Form::open(array('route' => 'suppliers.store', 'method'=>'POST', 'class' => 'form-horizontal' )) !!}
                {{ csrf_field() }}
                <div class="card-body">
                    <div>
                        {{-- @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                    </div>
                    @endif --}}
                    {{-- @include('partials.notification') --}}
                </div>
                <div class="form-group row">
                    <label for="company_name" class="col-sm-2 col-form-label"> {{ __('Company Name:') }} </label>
                    <div class="col-sm-10">
                        <input type="text" name="company_name" id="company_name" placeholder="{{ __('Company Name') }}"
                            class="form-control" value="{{ old('company_name') }}" />

                    </div>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-md-2 col-form-label">{{ __('Company address') }}</label>

                    <div class="col-md-10">
                        <textarea id="address" class="form-control" name="address"
                            placeholder="{{ __('Company address') }}">{{ old('address') }}</textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="phone" class="col-md-2 col-form-label">{{ __('Phone Number') }}</label>
                    <div class="col-md-10">
                        <input id="phone" type="phone" placeholder="{{ __('Phone Number') }}" class="form-control"
                            name="phone" value="{{ old('phone') }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="last_payment" class="col-md-2 col-form-label">{{ __('Last Payment Amt') }}</label>
                    <div class="col-md-10">
                        <input id="last_payment" type="number" placeholder="{{ __('Last Payment Amount') }}"
                            class="form-control" name="last_payment" value="{{ old('last_payment') }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="last_payment_date"
                        class="col-md-2 col-form-label">{{ __('Last Payment Date ') }}</label>
                    <div class="col-md-10">
                        <input id="last_payment_date" type="date" placeholder="{{ __('Last Payment Date ') }}"
                            class="form-control" name=" last_payment_date" value="{{ old('last_payment_date') }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="last_buy_date" class="col-md-2 col-form-label">{{ __('Last Buy Date ') }}</label>
                    <div class="col-md-10">
                        <input id="last_buy_date" type="date" placeholder="{{ __('Last Buy Date ') }}"
                            class="form-control" name="last_buy_date" value="{{ old('last_buy_date') }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="last_buy_amount" class="col-md-2 col-form-label">{{ __('Last Buy Amount ') }}</label>
                    <div class="col-md-10">
                        <input id="last_buy_amount" type="number" placeholder="{{ __('Last Buy Amount ') }}"
                            class="form-control" name="last_buy_amount" value="{{ old('last_buy_amount') }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="credit" class="col-md-2 col-form-label">{{ __('Credit Amount') }}</label>
                    <div class="col-md-10">
                        <input id="credit" type="number" placeholder="{{ __('Credit Amount') }}" class="form-control"
                            name="credit" value="{{ old('credit') }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="deposit" class="col-md-2 col-form-label">{{ __('Deposit') }}</label>
                    <div class="col-md-10">
                        <input id="deposit" type="number" placeholder="{{ __('Deposit') }}" class="form-control"
                            name="deposit" value="{{ old('deposit') }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="date_line" class="col-md-2 col-form-label">{{ __('Date Line ') }}</label>
                    <div class="col-md-10">
                        <input id="date_line" type="date" placeholder="{{ __('Date Line ') }}" class="form-control"
                            name=" date_line" value="{{ old('date_line') }}">
                    </div>
                </div>

            </div>
            <div class="card-footer bg-transparent border-info">
                <div class="form-group row">
                    <div class="col-md-6"><a href="{{ route('suppliers.index') }}" class="btn btn-success"> <i
                                class="fa fa-close"></i> Back</a></div>
                    <div class="col-md-6 "><button type="submit" class="btn btn-primary pull-right"> <i
                                class="fa fa-send"></i> Submit</button></div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    </div>
</section>


@endsection