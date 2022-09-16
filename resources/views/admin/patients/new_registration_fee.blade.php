@extends('admin.layouts.admin')

@section('main-content')
    <div id="content-wrapper">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create User Management</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Create User Management</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <div class="content">
            {{-- <div class="row justify-content-center"> --}}
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ $patient }}</div>

                    <div class="card-body">
                        {!! Form::open(['route' => 'payment.store', 'method' => 'POST', 'role' => 'form', 'enctype' => 'multipart/form-data']) !!}
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $userid }}">

                        <div class="form-group row">
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

                        <div class="form-group row" id="clinic">
                            <label for="clinic" class="col-md-4 col-form-label text-md-right">{{ __('clinic: ') }}</label>
                            <div class="col-md-6">
                                {!! Form::select('clinic', $clinic, null, ['id' => 'clinic_name', 'class' => 'select2 show-tick form-control', 'data-live-search' => 'true', 'placeholder' => 'Pick a Value']) !!}
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="total_amount"
                                class="col-md-4 col-form-label text-md-right">{{ __('Amount ₦ ') }}</label>

                            <div class="col-md-6">
                                <input id="amount" type="number"
                                    class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" name="amount"
                                    value=" " required autofocus>

                                @if ($errors->has('amount'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row" hidden="1">
                            <label for="payment_mode"
                                class="col-md-4 col-form-label text-md-right">{{ __('Mode of Payment: ') }}</label>
                            <div class="col-md-6">
                                {!! Form::select('payment_mode', $payment_mode, null, ['id' => 'payment_mode', 'class' => 'select2 show-tick form-control', 'data-live-search' => 'true']) !!}
                            </div>
                        </div>
                        <div class="form-group row" id="dropMe" style="display: none">
                            <label for="total_amount"
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

                        <div class="card-footer" align="center">
                            <a href="{{ route('newPatients') }}" class="btn btn-success"> Back</a>
                            <button type="submit" class="btn btn-primary"> <i class="fa fa-send"></i> Save</button>
                        </div>
                        <br>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            {{-- </div> --}}
        </div>

    </div>
@endsection

<script src="{{ asset('../resources/assets/js/jquery-1.11.2.min.js') }}"></script>
<script type="text/javascript">
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
                        $('#total_amount').val(data.amount);

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
