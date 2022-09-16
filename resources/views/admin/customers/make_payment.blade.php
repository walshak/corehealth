@extends('admin.layouts.admin')

@section('main-content')
<div id="content-wrapper">

    <div class="content-header">
        Client Budget Entering Form
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{$customers->fullname }}</div>

                    <div class="card-body">
                        {!! Form::open(array('route' => 'customer-payment.store', 'method'=>'POST', 'role'=>'form',
                        'enctype' => 'multipart/form-data' )) !!}
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $customers->id }}">

                        <div class="form-group row" id="trans">
                            <label for="trans"
                                class="col-md-2 col-form-label text-md-right">{{ __('Transaction No ') }}</label>

                            <div class="col-md-10">
                                <input id="trans" type="text"
                                    class="form-control{{ $errors->has('trans') ? ' is-invalid' : '' }}" name="trans"
                                    value="{{$trans}} " readonly="1">

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
                                    value="{{ (old('current_credit')) ? old('current_credit') : $customers->creadit }}"
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
                                    value="{{ (old('current_deposit')) ? old('current_deposit') : $customers->deposit }}"
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
                                class="col-md-2 col-form-label text-md-right">{{ __('Amount ₦ ') }}</label>

                            <div class="col-md-10">
                                <input id="total_amount" type="number"
                                    class="form-control{{ $errors->has('total_amount') ? ' is-invalid' : '' }}"
                                    name="total_amount" value="{{ old('total_amount') }}"
                                    placeholder="Enter Total Amount" autofocus>

                                @if ($errors->has('total_amount'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('total_amount') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        {{-- <div class="form-group row" id="payment_mode">
                            <label for="total_amount"
                                class="col-md-2 col-form-label text-md-right">{{ __('Mode of Payment: ') }}</label>
                        <div class="col-md-10">
                            {!! Form::select('payment_mode', $payment_mode , null, ['id' => 'payment_mode', 'class'
                            => 'select2 show-tick form-control', 'data-live-search' => 'true' ]) !!}
                        </div>
                    </div> --}}

                    <div class="form-group row" id="payment_mode" style="display: none;">
                        <label for="total_amount"
                            class="col-md-2 col-form-label text-md-right">{{ __('Mode of Payment: ') }}</label>
                        <div class="col-md-10">
                            {!! Form::select('payment_mode', $payment_mode , 1, ['id' => 'payment_mode', 'name'
                            => 'payment_mode', 'class'
                            => 'form-control', 'placeholder' => 'Pick a Value' ]) !!}
                        </div>
                    </div>

                    <div class="form-group row" id="cash" style="display: none;">
                        <label for="cash_payment_id"
                            class="col-md-2 col-form-label text-md-right">{{ __('Transaction Number') }}</label>

                        <div class="col-md-10">
                            <input id="cash_payment_id" type="text"
                                class="form-control{{ $errors->has('cash_payment_id') ? ' is-invalid' : '' }}"
                                name="cash_payment_id" value="{{ generateCashPaymentTransaction() }}" autofocus
                                readonly>

                            @if ($errors->has('cash_payment_id'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('cash_payment_id') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row" id="bankTeller" style="display: none;">
                        <label for="teller_payment_id"
                            class="col-md-2 col-form-label text-md-right">{{ __('Teller Number') }}</label>

                        <div class="col-md-10">
                            <input id="teller_payment_id" type="text"
                                class="form-control{{ $errors->has('teller_payment_id') ? ' is-invalid' : '' }}"
                                name="teller_payment_id" value="" autofocus>

                            @if ($errors->has('teller_payment_id'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('teller_payment_id') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row" id="internetBanking" style="display: none;">
                        <label for="internetBanking_payment_id"
                            class="col-md-2 col-form-label text-md-right">{{ __('Internet Banking Number') }}</label>

                        <div class="col-md-10">
                            <input id="internetBanking_payment_id" type="text"
                                class="form-control{{ $errors->has('internetBanking_payment_id') ? ' is-invalid' : '' }}"
                                name="internetBanking_payment_id" value=" " required autofocus>

                            @if ($errors->has('internetBanking_payment_id'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('internetBanking_payment_id') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row" id="pointOfSale" style="display: none;">
                        <label for="pointOfSale_payment_id"
                            class="col-md-2 col-form-label text-md-right">{{ __('POS Transaction Number') }}</label>

                        <div class="col-md-10">
                            <input id="pointOfSale_payment_id" type="text"
                                class="form-control{{ $errors->has('pointOfSale_payment_id') ? ' is-invalid' : '' }}"
                                name="pointOfSale_payment_id" value=" " required autofocus>

                            @if ($errors->has('pointOfSale_payment_id'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('pointOfSale_payment_id') }}</strong>
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


</script>