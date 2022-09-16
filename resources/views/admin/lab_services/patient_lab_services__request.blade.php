@extends('admin.layouts.admin')

@section('main-content')
    <div id="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">

                <div class="row mb-2">

                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Patient lab Service Request Payment</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">New Payment Request</li>
                        </ol>
                    </div>

                </div>

            </div>
        </div>
        <div class="row justify-content-center">

            <div class="col-md-11">
                <div class="card">
                    @if ($userid != 44)
                        <div class="card-header">{{ $patient }} File No:{{ showFileNumber($pc->user_id) }}</div>
                    @else
                        <div class="card-header">{{ $patient }} File No: N/A</div>
                    @endif

                    <div class="card-body">
                        {!! Form::open(['route' => 'storePatientLabServices', 'method' => 'POST', 'role' => 'form', 'enctype' => 'multipart/form-data']) !!}
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $userid }}" readonly="1">
                        <input type="hidden" name="medical_report_id" value="{{ $pc->id }}" readonly="1">
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

                        <div class="form-group row" id="total_amount_">
                            <label for="total_amount"
                                class="col-md-4 col-form-label text-md-right">{{ __('Amount ₦ ') }}</label>

                            <div class="col-md-6">

                                <input type="text" name="total_amount" id="total_amount" placeholder="Enter Amount"
                                    class="form-control" value="{{$sum}}" readonly="1" required="true" />
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
                                    <option value="">--Select payment mode</option>
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


                        <div class="form-group row" id="dropMe" style="display: none">
                            <label for="amount"
                                class="col-md-4 col-form-label text-md-right">{{ __('Payment Rreference Id(POS/Teller no) ') }}</label>

                            <div class="col-md-6">
                                <input id="payment_id" type="text"
                                    class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}"
                                    name="payment_id" value=" " required autofocus>

                                @if ($errors->has('payment_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('payment_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="box-footer" align="center">
                            <a href="{{ url('labServicesPaymentRequest') }}" class="btn btn-success"> Back</a>
                            <button type="submit" class="btn btn-primary"> <i class="fa fa-send"></i> Save</button>
                        </div>
                        <br>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="container">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Service List </h3>
                </div>

                <div class="card-body">
                    <table id="products" class="table table-sm table-responsive table-sm table-responsive table-bordered table-striped">
                        <thead>
                            <tr>
                                <th># </th>
                                <th>Lab</th>
                                <th>Service</th>
                                <th> Price </th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3"></th>
                                <th colspan="2">Total {{ NAIRA_CODE . $sum }}: <span id="subtotal"></span></th>
                                {{-- <th></th> --}}
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- jQuery -->
    <script src="{{ asset('/plugins/dataT/jQuery-3.3.1/jquery-3.3.1.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <!-- DataTables -->
    <script src="{{ asset('/plugins/dataT/datatables.js') }}" defer></script>

    <script>
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
        $(function() {
            $('#products').DataTable({
                "dom": 'Bfrtip',

                //  "drawCallback": function () {

                //     var sumTotal = $('#products').DataTable().column(4).data().sum();
                //     $('#subtotal').html(sumTotal);

                // },
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                "buttons": ['pageLength', 'copy', 'excel', 'pdf', 'print', 'colvis'],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ url('PatientlabServicesRequestList', $pc->id) }}",
                    "type": "GET"
                },
                "columns": [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex"
                    },
                    {
                        data: "lab",
                        name: "lab"
                    },
                    {
                        data: "labService",
                        name: "labService"
                    },
                    {
                        data: "price",
                        name: "price"
                    },
                    {
                        data: "created_at",
                        name: "created_at"
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
@endsection
