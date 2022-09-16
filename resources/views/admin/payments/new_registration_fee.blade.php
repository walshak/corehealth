@extends('admin.layouts.admin')

@section('main-content')
    <div id="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1> Registration Fee</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Registration Fee</li>
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
                                Registration Fee (New)</h3>
                        </div>

                        <div class="card-body">
                            {!! Form::open(['route' => 'payment.store', 'method' => 'POST', 'role' => 'form', 'enctype' => 'multipart/form-data']) !!}
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{ $userid }}" readonly="1">
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
                                <label for="file_no"
                                    class="col-md-4 col-form-label text-md-right">{{ __('File Number') }}</label>
                                <div class="col-md-6">
                                    <input type="text" id="file_no" name="file_no" class="form-control" placeholder="Eg. 0001" required />
                                </div>
                            </div>

                            <div class="form-group row" id="clinic">
                                <label for="clinic"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Clinic: ') }}</label>
                                <div class="col-md-6">
                                    {!! Form::select('clinic', $clinic, null, ['id' => 'clinic_name', 'class' => 'form-control', 'data-live-search' => 'true', 'placeholder' => 'Pick a Value', 'required' => 'true']) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="clinic"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Payment Item: ') }}</label>
                                <div class="col-md-6">
                                    {!! Form::select('payment_items', $payment_items, null, ['id' => 'payment_items', 'name' => 'payment_items', 'placeholder' => 'Select Payment Item', 'class' => 'form-control', 'data-live-search' => 'true','required'=>'true']) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="total_amount"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Amount ₦ ') }}</label>
                                <div class="col-md-6">
                                    <input type="text" id="total_amount" name="total_amount" class="form-control"  required/>
                                </div>
                            </div>

                            <div class="form-group row" id="payment_mode">
                                <label for="mode"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Mode of Payment: ') }}</label>
                                <div class="col-md-6">
                                    {!! Form::select('payment_mode', $payment_mode, null, ['id' => 'payment_mode', 'class' => 'form-control', 'data-live-search' => 'true', 'placeholder' => 'Pick a Value','required' => 'true']) !!}
                                </div>
                            </div>


                            <div class="form-group row" id="dropMe" style="display: none;">
                                <label for="payment_id"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Payment Rreference Id ') }}</label>

                                <div class="col-md-6">
                                    <input id="payment_id" type="text"
                                        class="form-control{{ $errors->has('payment_id') ? ' is-invalid' : '' }}"
                                        name="payment_id" value=" " required autofocus>

                                    @if ($errors->has('payment_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('payment_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="box-footer" align="center">
                                <a href="{{ route('newPatients') }}" class="btn btn-success"> Back</a>
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

<script src="{{ asset('/plugins/dataT/jQuery-3.3.1/jquery-3.3.1.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        // alert("you");
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
                        $('#total_amount').val(data.amount);

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
                    }

                });

            } else {

                // $('#total_amount').val("");
            }
        });

        $('select[name="payment_mode"]').on('change', function() {
            $('#dropMe').slideDown(300);
        });

    });
</script>
