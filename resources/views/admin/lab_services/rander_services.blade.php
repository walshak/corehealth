@extends('admin.layouts.admin')

@section('main-content')
    <div id="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">

                <div class="row mb-2">

                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Patient lab Sample Request</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">New Sample Request</li>
                        </ol>
                    </div>

                </div>

            </div>
        </div>
        <div class="row justify-content-center">


        </div>
        <div class="container">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Patient List </h3>
                    <a class="btn btn-success text-light" data-toggle="modal" id="mediumButton" data-target="#newTestModal"
                        data-attr="' . $pc->id . '" title="Enter Charges"> <i class="fas fa-plus-circle"></i> Create Lab Service Request
                    </a>
                </div>

                <div class="card-body">
                    <table id="products" class="table table-sm table-responsive table-sm table-responsive table-bordered table-striped">
                        <thead>
                            <tr>
                                <th># </th>
                                <th>patient</th>
                                <th>file No</th>
                                <th>Hmo</th>
                                <th>Lab</th>
                                <th>Service</th>
                                <th>Paid Amount </th>
                                <th>Payment Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>


                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- new test modal -->
    <div class="modal fade" id="newTestModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="card border-info mb-6">
                        {!! Form::open(['route' => 'createLabRequest', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
                        {{ csrf_field() }}

                        <div class="card-header bg-transparent border-info">{{ __('New Lab service Request ') }}
                        </div>
                        <div class="card-body">

                            <input type="hidden" name="payment_type_id" value="3">
                            {{-- <input type="hidden" id="medical_report_id" class="form-control" name="medical_report_id"
                                value="" readonly="1"> --}}

                            <div class="form-group ">

                                <div class="col-sm-12">
                                    <label for="Total Amount" class="control-label">Select patient</label>
                                    <select name="patient_id" id="patient_id" class="selectpicker form-control select2"
                                        data-live-search="true" required>
                                        <option value="not-apply">NON REGISTERED</option>
                                        @foreach ($patients as $p)
                                            <option value="{{ $p->user_id }}"
                                                data-tokens="{{ ucfirst($p->user->surname) }} {{ ucfirst($p->user->firstname) }} {{ ucfirst($p->user->lastname) }} {{ $p->file_no }}">
                                                {{ ucfirst($p->user->surname) }}, {{ ucfirst($p->user->firstname) }}
                                                {{ ucfirst($p->user->lastname) }}({{ $p->file_no }})
                                            </option>
                                        @endforeach
                                    </select>

                                    {{-- {!! Form::select('statuses', $patients, null, ['id' => 'is_admin', 'name' => 'is_admin', 'class' => 'form-control select2', 'placeholder' => 'Pick a value']) !!} --}}
                                </div>
                            </div>

                            <div class="form-group ">

                                <div class="col-sm-12">
                                    <label for="Total Amount" class="control-label">Select Lab Procedure</label>
                                    <select name="lab_id" id="lab_id" class="selectpicker form-control select2"
                                        data-live-search="true" required>
                                        <option value="">--select service--</option>
                                        @foreach ($labs as $l)
                                            <option value="{{ $l->id }}"
                                                data-tokens="{{ ucfirst($l->lab_service_name) }}">
                                                {{ ucfirst($l->lab_service_name) }}({{ $l->lab->lab_name }})
                                            </option>
                                        @endforeach
                                    </select>

                                    {{-- {!! Form::select('statuses', $patients, null, ['id' => 'is_admin', 'name' => 'is_admin', 'class' => 'form-control select2', 'placeholder' => 'Pick a value']) !!} --}}
                                </div>
                            </div>
                            {{-- <div class="form-group ">

                                <div class="col-sm-">
                                    <label for="Total Amount" class="control-label">Total Amount</label>
                                    <input type="number" id="tottal_amount" class="form-control" name="tottal_amount"
                                        value="" required>
                                </div>
                            </div> --}}

                            <div class="form-group">
                                <label for="service_description2" class="control-label">Service Description</label>
                                <textarea id="service_description2" name="service_description" cols="15" rows="10" class="form-control"
                                    placeholder="Enter Result">
                                {{ old('service_description') }}
                                </textarea>

                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-info">
                            <div class="form-group row">

                                <div class="col-md-6 "><button type="submit" class="btn btn-primary "> <i
                                class="fa fa-send"></i> Craete Lab Request</button></div>
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
@endsection

@section('scripts')
    <!-- jQuery -->
    <script src="{{ asset('plugins/jQuery/jquery.min.js') }}"></script>
    <!-- <script src="{{ asset('/plugins/dataT/jQuery-3.3.1/jquery-3.3.1.min.js') }}"></script> -->
    <!-- Bootstrap 4 -->
    <script src="{{ asset('/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/select2.min.js') }}"></script>
    <!-- DataTables -->
    <script src="{{ asset('/plugins/dataT/datatables.js') }}" defer></script>

    <script src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script>
    
    
    <!-- <script src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script> -->


    <script>
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
                    "url": "{{ url('randerServicesList') }}",
                    "type": "GET"
                },
                "columns": [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex"
                    },
                    {
                        data: "patient",
                        name: "patient"
                    },
                    {
                        data: "file_no",
                        name: "file_no"
                    },
                    {
                        data: "hmo",
                        name: "hmo"
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
                        data: "payment_date",
                        name: "payment_date"
                    },
                    {
                        data: "sample",
                        name: "sample"
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
        $(document).ready(function() {
            $.noConflict();
            CKEDITOR.replace('service_description2');
            $('.select2').select2({
                dropdownParent: $("#newTestModal")
            });
        });
    </script>
@endsection
