@extends('admin.layouts.admin')

@section('main-content')
    <div id="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">

                <div class="row mb-2">

                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark"> Nurse Services Request</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active"> Nurse Services Request</li>
                        </ol>
                    </div>

                </div>

            </div>
        </div>

        <div class="container">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __(' Nurse Services Request') }}</h3>
                    <a class="btn btn-success text-light" data-toggle="modal" id="mediumButton"
                        data-target="#newChargeModal" data-attr="' . $pc->id . '" title="Enter Charges"> <i
                            class="fas fa-plus-circle"></i> Create Charge
                    </a>
                </div>

                <div class="card-body">
                    <table id="products" class="table table-sm table-responsive table-sm table-responsive table-bordered table-striped">
                        <thead>
                            <tr>
                                <th># </th>
                                <th>Fullname</th>
                                <th>File No</th>
                                <th>Clinic or Desc</th>
                                <th>Doctor</th>
                                <th>Instruction</th>
                                <th>Date</th>
                                <th>No Charges</th>
                                <th>Pay For Services</th>
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
                        {!! Form::open(['route' => 'nurse-services.store', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
                        {{ csrf_field() }}

                        <div class="card-header bg-transparent border-info">{{ __('Nurse/Doctor Services Charges ') }}
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="payment_type_id" value="3">
                            <input type="hidden" id="medical_report_id" class="form-control" name="medical_report_id"
                                value="" readonly="1">

                            <div class="form-group ">

                                <div class="col-sm-">
                                    <label for="Total Amount" class="control-label">Total Amount</label>
                                    <input type="number" id="tottal_amount" class="form-control" name="tottal_amount"
                                        value="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="service_description" class="control-label">Service Description</label>
                                <textarea id="service_description" name="service_description" cols="10" rows="20" class="form-control"
                                    placeholder="Enter Result">
                                {{ old('result') }}
                                </textarea>

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

    <!-- new charge modal -->
    <div class="modal fade" id="newChargeModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="card border-info mb-6">
                        {!! Form::open(['route' => 'nurse-services.store', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
                        {{ csrf_field() }}

                        <div class="card-header bg-transparent border-info">{{ __('Nurse/Doctor Services Charges ') }}
                        </div>
                        <div class="card-body">

                            <input type="hidden" name="payment_type_id" value="3">
                            {{-- <input type="hidden" id="medical_report_id" class="form-control" name="medical_report_id"
                                value="" readonly="1"> --}}

                            <div class="form-group ">

                                <div class="col-sm-">
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

                                <div class="col-sm-">
                                    <label for="Total Amount" class="control-label">Total Amount</label>
                                    <input type="number" id="tottal_amount" class="form-control" name="tottal_amount"
                                        value="" required>
                                </div>
                            </div>

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
                                            class="fa fa-send"></i> Craete new charge</button></div>
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


@section('scripts')
    <!-- jQuery -->
<script src="{{ asset('/plugins/dataT/jQuery-3.3.1/jquery-3.3.1.min.js') }}"></script>
<!-- Bootstrap 4 -->
<!-- DataTables -->
<script src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('/plugins/dataT/datatables.js') }}" defer></script>
<script src="{{ asset('plugins/select2/select2.min.js') }}"></script>
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
                    "url": "{{ url('nurseServiceRequestList') }}",
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
                        name: "clinic or desc"
                    },
                    {
                        data: "doctor",
                        name: "doctor"
                    },
                    {
                        data: "nurseContent",
                        name: "nurseContent"
                    },
                    {
                        data: "created_at",
                        name: "created_at"
                    },
                    {
                        data: "no_service_charge",
                        name: "no_service_charge"
                    },
                    {
                        data: "sevices_charge",
                        name: "sevices_charge"
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
            var medical_report_id = $(this).attr('data-attr');
            $('#medical_report_id').val(medical_report_id);
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
        $(document).ready(function() {
            $.noConflict();

            CKEDITOR.replace('service_description');
            CKEDITOR.replace('service_description2');
        });
        $('.select2').select2({
            dropdownParent: $("#newChargeModal")
        });
    </script>
@endsection
@endsection
