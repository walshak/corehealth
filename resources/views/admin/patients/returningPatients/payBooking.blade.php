@extends('admin.layouts.admin')

@section('main-content')
    <div id="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1> Booking Fee</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Booking Fee</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <div class="content">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><span class="badge badge-sm badge-dark">{{ $patient }} </span>
                                Booking Fee (Returning) For Dr. {{ $doc }}</h3>
                        </div>

                        <div class="card-body">
                            {!! Form::open(['route' => 'returningPatientBookingPayment', 'method' => 'POST', 'role' => 'form', 'enctype' => 'multipart/form-data']) !!}
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{ $userid }}" readonly="1">
                            <input type="text" name="booking_id" value="{{ $booking->id }}" readonly="1">
                            <input type="hidden" name="patient" value="{{ $patient }}" readonly="1">

                            <div class="form-group row" id="trans">
                                <label for="trans"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Transaction No ') }}</label>
                                <div class="col-md-6">
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
                                <label for="clinic"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Clinic: ') }}</label>
                                <div class="col-md-6">
                                    {!! Form::select('clinic', $clinic, null, ['id' => 'clinic_name', 'name' => 'clinic_name', 'class' => 'form-control', 'data-live-search' => 'true', 'placeholder' => 'Pick a Value', 'required' => 'true']) !!}
                                </div>
                            </div>

                            {{-- <div class="form-group row">
                                <label for="clinic"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Payment Item: ') }}</label>
                                <div class="col-md-6">
                                    {!! Form::select('payment_items', $payment_items, null, ['id' => 'payment_items', 'name' => 'payment_items', 'placeholder' => 'Select Payment Item', 'class' => 'form-control', 'data-live-search' => 'true', 'required' => 'true']) !!}
                                </div>
                            </div> --}}

                            <div class="form-group row">
                                <label for="total_amount"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Amount ₦ ') }}</label>
                                <div class="col-md-6">
                                    <input type="text" id="total_amount" name="total_amount" class="form-control" required
                                        readonly value="{{ $booking->fee }}" />
                                    <span class="text-danger" id="discount_text"></span>
                                </div>

                            </div>
                            <div class="form-group row">
                                <label for="use_hmo"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Use Hmo') }}</label>
                                <div class="col-md-6">
                                    <input type="checkbox" id="use_hmo" name="use_hmo" class=""
                                        onclick="cal_tot(this)" value="{{ $hmo->discount }}" checked required />
                                    {{ $hmo->discount }}% Discount - {{ $hmo->name }}
                                    <input type="hidden" name="hmo" value="{{ $hmo->id }}">
                                </div>
                            </div>

                            <div class="form-group row" id="payment_mode">
                                <label for="mode"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Mode of Payment: ') }}</label>
                                <div class="col-md-6">
                                    {{-- {!! Form::select('payment_mode', $payment_mode, null, ['id' => 'payment_mode', 'class' => 'form-control', 'data-live-search' => 'true', 'placeholder' => 'Pick a Value', 'required' => 'true']) !!} --}}
                                    <select name="payment_mode" id="payment_mode" placeholder="Pick a Value"
                                        class="form-control">
                                        <option value="">--Select payment mode--</option>
                                        @foreach ($payment_mode as $key => $mode)
                                            <option value="{{ $key }}">{{ $mode }}</option>
                                        @endforeach

                                        @isset($patient_account)
                                            <option value="from_account">Patient Account
                                                (₦{{ $patient_account->deposit - $patient_account->creadit }})</option>
                                        @endisset
                                    </select>
                                    @isset($patient_account)
                                        <input type="hidden" name="from_account_id" value="{{ $patient_account->id }}">
                                    @endisset
                                </div>
                            </div>


                            <div class="form-group row" id="dropMe" style="display: none;">
                                <label for="amount"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Payment Rreference Id(teller/POS etc) ') }}</label>

                                <div class="col-md-6">
                                    <input id="payment_id" type="text"
                                        class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}"
                                        name="payment_id" value="" autofocus>

                                    @if ($errors->has('payment_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('payment_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="box-footer" align="center">
                                <a href="{{ route('returningPatientsBooking') }}" class="btn btn-success"> Back</a>
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

{{-- <script src="{{ asset('../resources/assets/js/jquery-1.11.2.min.js') }}"></script> --}}
<script src="{{ asset('/plugins/dataT/jQuery-3.3.1/jquery-3.3.1.min.js') }}"></script>
<script type="text/javascript">
    function cal_tot(obj) {
        if ($('#use_hmo').is(':checked')) {
            discount = $(obj).val();
            discount = (parseFloat(discount) / 100) * parseFloat($('#total_amount').val());
            discount_text = parseFloat($('#total_amount').val()) - discount;
            $('#discount_text').text('You pay ₦' + discount_text);
        } else {
            discount = $(obj).val();
            discount_text = "You pay ₦" + $('#total_amount').val();
            $('#discount_text').text(discount_text);
        }
    }
    $(document).ready(function() {
        $('select[name="payment_items"]').on('change', function() {
            var id = $(this).val();
            //alert(id);
            if (id) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    url: '{{ url('/myItem/ajaxprice') }}/' + id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        // console.log(data);
                        // alert(data.amount);

                    }

                });
            } else {

                // $('#total_amount').val("");
            }
        });

        if ($('#use_hmo').is(':checked')) {
            discount = $('#use_hmo').val();
            discount = (parseFloat(discount) / 100) * parseFloat($(
                '#total_amount').val());
            discount_text = parseFloat($('#total_amount').val()) - discount;
            $('#discount_text').text('You pay ₦' + discount_text);
        } else {
            discount = $('#use_hmo').val();
            discount_text = "You pay ₦" + $('#total_amount').val();
            $('#discount_text').text(discount_text);
        }

        $('select[name="payment_mode"]').on('change', function() {
            $('#dropMe').slideDown(300);
        });

    });
</script>
