@extends('admin.layouts.admin')

@section('main-content')

    <div id="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">

                <div class="row mb-2">

                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark"> Patients Account</h1>
                        <a class="btn btn-success text-light" data-toggle="modal" id="mediumButton"
                            data-target="#newAccountModal" data-attr="' . $pc->id . '" title="Enter Charges"> <i
                                class="fas fa-plus-circle"></i> New Account
                        </a>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Patients Account</li>
                        </ol>
                    </div>

                </div>

            </div>
        </div>

        <div class="content">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __(' Patients Account') }}</h3>
                </div>

                <div class="card-body">
                    <table id="products" class="table table-sm table-responsive table-sm table-responsive table-bordered table-striped">
                        <thead>
                            <tr>
                                <th># </th>
                                <th>Fullname</th>
                                <th>File No</th>
                                <th>Clinic</th>
                                <th>Deposit B4</th>
                                <th>Current Deposit</th>
                                <th>Current Credit </th>
                                <th>Credit B4 </th>
                                <th>Make Payment </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- medium modal -->
    <div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="card border-info mb-6">
                        {!! Form::open(['route' => 'patient-account.deposit', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
                        {{ csrf_field() }}

                        <div class="card-header bg-transparent border-info">
                            {{ __('Patient Into Deposit Account Payment ') }}
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="payment_type_id" value="5">
                            <input type="hidden" id="user_id" class="form-control" name="user_id" value="" readonly="1">


                            <div class="form-group row" id="total_amount">
                                <label for="total_amount"
                                    class="col-md-10 col-form-label text-md-right">{{ __('Amount ₦ ') }}</label>

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



                            <div class="form-group row" id="payment_mode">
                                <label for="Mode of Payment"
                                    class="col-md-10 col-form-label text-md-right">{{ __('Mode of Payment: ') }}</label>
                                <div class="col-md-10">
                                    {!! Form::select('payment_mode', $payment_mode, null, ['id' => 'payment_mode', 'name' => 'payment_mode', 'class' => 'form-control', 'placeholder' => 'Pick a Value']) !!}
                                </div>
                            </div>

                            <div class="form-group row" id="cash" style="display: none;">
                                <label for="cash_payment_id"
                                    class="col-md-10 col-form-label text-md-right">{{ __('Transaction Number') }}</label>

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
                                    class="col-md-10 col-form-label text-md-right">{{ __('Teller Number') }}</label>

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
                                    class="col-md-10 col-form-label text-md-right">{{ __('Internet Banking Number') }}</label>

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
                                    class="col-md-10 col-form-label text-md-right">{{ __('POS Transaction Number') }}</label>

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
                            <div class="card-footer bg-transparent border-info">
                                <div class="form-group row">

                                    <div class="col-md-6 "><button type="submit" class="btn btn-primary pull-right"> <i
                                                class="fa fa-send"></i> Submit</button></div>
                                </div>
                            </div>
                            {!! Form::close() !!}

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>

                        </div>
                    </div>
                    <div class="modal-body" id="mediumBody">
                        <div>
                            <!-- the result to be displayed apply here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="newAccountModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="card border-info mb-6">
                        {!! Form::open(['route' => 'patient-account.store', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
                        {{ csrf_field() }}

                        <div class="card-header bg-transparent border-info">{{ __('Patient Deposit Account Setup ') }}
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="payment_type_id" value="5">
                            <div class="col-sm-12">
                                <label for="Total Amount" class="control-label">Select patient</label>
                                <select name="patient_id" id="patient_id" class="form-control select2"
                                    data-live-search="true" required>
                                    <option value="">--Select Patient-- </option>
                                    @foreach ($patients as $p)
                                        <option value="{{ $p->user_id }}_{{$p->file_no}}"
                                            data-tokens="{{ ucfirst($p->user->surname) }} {{ ucfirst($p->user->firstname) }} {{ ucfirst($p->user->lastname) }} {{ $p->file_no }}">
                                            {{ ucfirst($p->user->surname) }}, {{ ucfirst($p->user->firstname) }}
                                            {{ ucfirst($p->user->lastname) }}({{ $p->file_no }})
                                        </option>
                                    @endforeach
                                </select>

                                {{-- {!! Form::select('statuses', $patients, null, ['id' => 'is_admin', 'name' => 'is_admin', 'class' => 'form-control select2', 'placeholder' => 'Pick a value']) !!} --}}
                            </div>


                            <div class="form-group row" id="total_amount">
                                <label for="total_amount"
                                    class="col-md-12 col-form-label">{{ __('Initial Deposit Amount ₦ ') }}</label>

                                <div class="col-md-12">
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



                            <div class="form-group row" id="payment_mode_">
                                <label for="Mode of Payment"
                                    class="col-md-12 col-form-label text-md-right">{{ __('Mode of Payment: ') }}</label>
                                <div class="col-md-12">
                                    {!! Form::select('payment_mode', $payment_mode, null, ['id' => 'payment_mode1', 'name' => 'payment_mode', 'class' => 'form-control', 'placeholder' => 'Pick a Value']) !!}
                                </div>
                            </div>

                            <div class="card-footer bg-transparent border-info">
                                <div class="form-group row">

                                    <div class="col-md-6 "><button type="submit" class="btn btn-primary pull-right">
                                            <i class="fa fa-send"></i> Submit</button></div>
                                </div>
                            </div>


                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>

                            <div class="form-group row" id="cash1" style="display: none;">
                                <label for="cash_payment_id"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Transaction Number') }}</label>

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

                            <div class="form-group row" id="bankTeller1" style="display: none;">
                                <label for="teller_payment_id"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Teller Number') }}</label>

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

                            <div class="form-group row" id="internetBanking1" style="display: none;">
                                <label for="internetBanking_payment_id"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Internet Banking Number') }}</label>

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

                            <div class="form-group row" id="pointOfSale1" style="display: none;">
                                <label for="pointOfSale_payment_id"
                                    class="col-md-4 col-form-label text-md-right">{{ __('POS Transaction Number') }}</label>

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
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="modal-body" id="mediumBody">
                        <div>
                            <!-- the result to be displayed apply here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@section('scripts')
    <!-- jQuery -->
    <script src="{{ asset('/plugins/dataT/jQuery-3.3.1/jquery-3.3.1.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <!-- DataTables -->
    <script src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('/plugins/dataT/datatables.js') }}" defer></script>
    <script src="{{ asset('plugins/select2/select2.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {

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

    <script>
        $(function() {
            $('#products').DataTable({
                "dom": 'Bfrtip',
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                "buttons": ['pageLength', 'copy', 'excel', 'pdf', 'print', 'colvis'],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ url('patientsAccountList') }}",
                    "type": "GET"
                },
                "columns": [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex"
                    },
                    {
                        data: "fullname",
                        name: "fullname"
                    },
                    {
                        data: "file_no",
                        name: "file_no"
                    },
                    {
                        data: "clinic",
                        name: "clinic"
                    },
                    {
                        data: "deposite_b4",
                        name: "deposite_b4"
                    },
                    {
                        data: "deposit",
                        name: "deposit"
                    },
                    {
                        data: "creadit",
                        name: "creadit"
                    },
                    {
                        data: "credit_b4",
                        name: "credit_b4"
                    },
                    {
                        data: "make_payment",
                        name: "make_payment"
                    }
                ],
                // initComplete: function () {
                //     this.api().columns().every(function () {
                //         var column = this;
                //         var input = document.createElement("input");
                //         $(input).appendTo($(column.footer()).empty())
                //         .on('change', function () {
                //             column.search($(this).val(), false, false, true).draw();
                //         });
                //     });
                // },
                "paging": true
                // "lengthChange": false,
                // "searching": true,
                // "ordering": true,
                // "info": true,
                // "autoWidth": false
            });
        });

        $(document).on('click', '#mediumButton', function(event) {
            event.preventDefault();
            let href = $(this).attr('data-attr');
            var user_id = $(this).attr('data-attr');
            $('#user_id').val(user_id);
            //alert(id)
            $.ajax({
                beforeSend: function() {
                    $('#loader').show();
                },
                // return the result
                success: function(result) {
                    $('#mediumModal').modal("show");
                    $('#mediumBody').html(result).show();
                },
                complete: function() {
                    $('#loader').hide();
                },
                error: function(jqXHR, testStatus, error) {
                    console.log(error);
                    alert("Page " + href + " cannot open. Error:" + error);
                    $('#loader').hide();
                },
                timeout: 8000
            })
        });
    </script>

    <script>
        // $(document).ready(function() {
        //     $.noConflict();

        //     CKEDITOR.replace('service_description');
        // });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {

            $('select[id="payment_mode1"]').on('change', function() {

                // alert(this.value);
                if (this.value == 1) {
                    //alert(this.value);
                    $("#cash1").show(500);
                    $("#bankTeller1").slideUp(500);
                    $("#internetBanking1").slideUp(500);
                    $("#pointOfSale1").slideUp(500);
                }

                if (this.value == 2) {
                    //alert(this.value);
                    $("#bankTeller1").slideDown(500);
                    $("#internetBanking1").slideUp(500);
                    $("#pointOfSale1").slideUp(500);
                    $("#cash1").slideUp(500);

                }

                if (this.value == 3) {
                    // alert(this.value);
                    $("#internetBanking1").slideDown(500);
                    $("#bankTeller1").slideUp(500);
                    $("#pointOfSale1").slideUp(500);
                    $("#cash1").slideUp(500);
                }

                if (this.value == 4) {
                    // alert(this.value);
                    $("#pointOfSale1").slideDown(500);
                    $("#cash1").slideUp(500);
                    $("#internetBanking1").slideUp(500);
                    $("#bankTeller1").slideUp(500);
                }

            });
        });
        $('.select2').select2({
            dropdownParent: $("#newAccountModal")
        });
    </script>
@endsection

@endsection
