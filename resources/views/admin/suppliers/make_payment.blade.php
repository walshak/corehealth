@extends('admin.layouts.admin')

@section('main-content')
<div id="content-wrapper">

    <div class="content-header">
        Supplier Payment Form
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{$supplier->company_name }}</div>

                    <div class="card-body">
                        {!! Form::open(array('route' => 'pay_supplier.store', 'method'=>'POST', 'role'=>'form',
                        'enctype' => 'multipart/form-data' )) !!}
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $supplier->id }}">

                        <div class="form-group row" id="trans">
                            <label for="trans"
                                class="col-md-2 col-form-label text-md-right">{{ __('Transaction No ') }}</label>

                            <div class="col-md-10">
                                <input id="trans" type="text"
                                    class="form-control{{ $errors->has('trans') ? ' is-invalid' : '' }}" name="trans"
                                    value="{{ $trans }} " readonly="1">

                                @if ($errors->has('trans'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('trans') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name"
                                class="col-md-2 col-form-label text-md-right">{{ __('Current Credit ₦') }}</label>

                            <div class="col-md-10">
                                <input id="current_credit " type="text"
                                    class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                    name="current_credit"
                                    value="{{ (old('current_credit')) ? old('current_credit') : $supplier->credit }}"
                                    readonly="1">

                                @if ($errors->has('current_credit'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name"
                                class="col-md-2 col-form-label text-md-right">{{ __('Current Deposit ₦') }}</label>

                            <div class="col-md-10">
                                <input id="Current deposit " type="text"
                                    class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                    name="current_deposit"
                                    value="{{ (old('current_deposit')) ? old('current_deposit') : $supplier->deposit }}"
                                    readonly="1">

                                @if ($errors->has('current_deposit'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row" id="total_amount">
                            <label for="total_amount"
                                class="col-md-2 col-form-label text-md-right">{{ __('Amount  To Pay ₦ ') }}</label>

                            <div class="col-md-10">
                                <input id="total_amount" type="number"
                                    class="form-control{{ $errors->has('total_amount') ? ' is-invalid' : '' }}"
                                    name="total_amount" value="" autofocus>

                                @if ($errors->has('total_amount'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('total_amount') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row" id="payment_mode">
                            <label for="total_amount"
                                class="col-md-2 col-form-label text-md-right">{{ __('Mode of Payment: ') }}</label>
                            <div class="col-md-10">
                                {!! Form::select('payment_mode', $payment_mode , null, ['id' => 'payment_mode', 'name'
                                => 'payment_mode', 'class'
                                => 'form-control', 'placeholder' => 'Pick a Value' ]) !!}
                            </div>
                        </div>

                        <div class="form-group row" id="cash" style="display: none;">
                            <label for="total_amount"
                                class="col-md-2 col-form-label text-md-right">{{ __('Transaction Number') }}</label>

                            <div class="col-md-10">
                                <input id="payment_id" type="text"
                                    class="form-control{{ $errors->has('total_amount') ? ' is-invalid' : '' }}"
                                    name="payment_id" value="{{ generateCashPaymentTransaction() }}" required autofocus>

                                @if ($errors->has('payment_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('payment_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row" id="bankTeller" style="display: none;">
                            <label for="total_amount"
                                class="col-md-2 col-form-label text-md-right">{{ __('Teller Number') }}</label>

                            <div class="col-md-10">
                                <input id="payment_id" type="text"
                                    class="form-control{{ $errors->has('total_amount') ? ' is-invalid' : '' }}"
                                    name="payment_id" value=" " required autofocus>

                                @if ($errors->has('payment_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('payment_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row" id="internetBanking" style="display: none;">
                            <label for="total_amount"
                                class="col-md-2 col-form-label text-md-right">{{ __('Internet Banking Number') }}</label>

                            <div class="col-md-10">
                                <input id="payment_id" type="text"
                                    class="form-control{{ $errors->has('total_amount') ? ' is-invalid' : '' }}"
                                    name="payment_id" value=" " required autofocus>

                                @if ($errors->has('payment_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('payment_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row" id="pointOfSale" style="display: none;">
                            <label for="total_amount"
                                class="col-md-2 col-form-label text-md-right">{{ __('POS Transaction Number') }}</label>

                            <div class="col-md-10">
                                <input id="payment_id" type="text"
                                    class="form-control{{ $errors->has('total_amount') ? ' is-invalid' : '' }}"
                                    name="payment_id" value=" " required autofocus>

                                @if ($errors->has('payment_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('payment_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="box-footer" align="center">
                            <a href="{{ route('customers.index') }}" class="btn btn-success"> Back</a>
                            <button type="submit" class="btn btn-primary"> <i class="fa fa-send"></i> Save</button>
                        </div>
                        <br>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

<script src="{{ asset('../resources/assets/js/jquery-1.11.2.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){

        $('select[id="payment_mode"]').on('change', function() {
        
        // alert(this.value);
        if (this.value == 1) {
            // alert(this.value);
            $("#cash").slideDown(500);
            $("#bankTeller").slideUp(500);
            $("#internetBanking").slideUp(500);
            $("#pointOfSale").slideUp(500);
        }
        
        if (this.value == 2) {
            // alert(this.value);
            $("#bankTeller").slideDown(500);
            $("#internetBanking").slideUp(500);
            $("#pointOfSale").slideUp(500);
            $("#cash").slideUp(500);
        
        }
        
        if (this.value == 3) {
            // alert(this.value);
            $("#internetBanking").slideDown(500);
            $("#bankTeller").slideUp(500);
            $("#pointOfSale").slideUp(500);
            $("#cash").slideUp(500);
        }
        
        if (this.value == 4) {
            // alert(this.value);
            $("#pointOfSale").slideDown(500);
            $("#cash").slideUp(500);
            $("#internetBanking").slideUp(500);
            $("#bankTeller").slideUp(500);
        }

        });
    });
</script>