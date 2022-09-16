@extends('admin.layouts.admin')

@section('main-content')
<div id="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Client Borrow Form</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Client Borrow Form</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{$customers->fullname }}</div>

                    <div class="card-body">
                        {!! Form::open(array('route' => 'borrows.store', 'method'=>'POST', 'role'=>'form', 'enctype' =>
                        'multipart/form-data' )) !!}
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
                                    <strong>{{ $errors->first('current_credit') }}</strong>
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
                                    <strong>{{ $errors->first('current_deposit') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row" id="total_amount">
                            <label for="total_amount"
                                class="col-md-2 col-form-label text-md-right">{{ __('Borrow Amount ₦ ') }}</label>

                            <div class="col-md-10">
                                <input id="total_amount" type="number"
                                    class="form-control{{ $errors->has('total_amount') ? ' is-invalid' : '' }}"
                                    name="total_amount" value="{{ old('total_amount') }}" autofocus>

                                @if ($errors->has('total_amount'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('total_amount') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row" id="payment_mode">
                            <label for="total_amount"
                                class="col-md-2 col-form-label text-md-right">{{ __('Mode of Collection: ') }}</label>
                            <div class="col-md-10">
                                {!! Form::select('payment_mode', $payment_mode , null, ['id' => 'payment_mode', 'class'
                                => 'select2 show-tick form-control', 'data-live-search' => 'true' ]) !!}
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
    if (document.getElementById('publish').checked)
    $('select[name="payment_mode"]').on('change', function() {
        $("#dropMe").slideDown(500);
         // document.getElementById('password').disabled = false;
        console.log("dropDown");
    } 
    if (document.getElementById('publish_').checked) {
        $("#dropMe").slideUp(500);
        // document.getElementById('password').disabled = true;
        console.log("dropUp");
    } 



     $("#publish").click(function(){
        $("#dropMe").slideDown(500);
         // document.getElementById('password').disabled = false;
        console.log("drop2");
     });

     $("#publish_").click(function(){
        $("#dropMe").slideUp(500);
        // document.getElementById('password').disabled = true;
        console.log("dont drop");
     });

    
});
 
 
</script>