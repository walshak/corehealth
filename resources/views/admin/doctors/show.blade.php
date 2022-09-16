@extends('admin.layouts.admin')

@section('style')
    {{-- <link href="{{  asset('plugins/bootstrap-datetimepicker/css/bootstrap.min.css" rel="stylesheet') }}" media="screen"> --}}
    {{-- <link href="{{  asset('plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet">
@endsection

@section('main-content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Doctors Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Doctors Management</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Doctor's Information</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                                <i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        {!! Form::model($doctor, ['method' => 'PATCH', 'route' => ['doctors.update', $doctor->id], 'enctype' => 'multipart/form-data']) !!}
                        <div class="form-group">
                            <label for="fullname">Title/Fullname</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-append">
                                    <span class="input-group-text">{{ $doctor->title->name }}</span>
                                </div>
                                <input type="text" id="fullname" class="form-control form-control-sm"
                                    value="{{ $doctor->user->surname . ' ' . $doctor->user->firstname . ' ' . $doctor->user->othername }}"
                                    readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="specialization">Specialization</label>
                            <input type="text" id="specialization" class="form-control form-control-sm"
                                value="{{ $doctor->specialization->name }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="email">Primary Email</label>
                            <input type="text" id="email" class="form-control form-control-sm"
                                value="{{ $doctor->user->email }}" readonly>
                        </div>
                        {{-- <div class="form-group">
              <label for="contact_address">Contact Address</label>
              <textarea id="contact_address" class="form-control form-control-sm" rows="2" readonly>{{ $doctor->contact_address }}</textarea>
            </div> --}}
                        <div class="form-group">
                            <label for="phone_number">Primary Phone Number</label>
                            <input type="text" id="phone_number" class="form-control form-control-sm"
                                value="{{ $doctor->user->phone_number }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="email">Consultancy Fee</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-append">
                                    <span class="input-group-text">{{ NAIRA_CODE }}</span>
                                </div>
                                <input type="text" id="email" class="form-control form-control-sm"
                                    value="{{ $doctor->consultation_fee }}" readonly>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="status_id">Account Status</label>
                            <input type="text" id="status_id" class="form-control form-control-sm"
                                value="{{ $doctor->status->name }}" readonly>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Create Calender Entry</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                                <i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        {!! Form::open(['id' => 'appointmentForm', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
                        <input type="hidden" id="user_id" name="user_id" value="{{ $doctor->user_id }}">
                        <input type="hidden" id="doctor_id" name="doctor_id" value="{{ $doctor->id }}">
                        <div class="form-group ">
                            <label class="control-label" for="appDate">Start Date:</label>
                            <div class="col-sm-12 date mb-3">
                                <input type="text" class="form-control" id="apStartDate" name="apStartDate"
                                    value="{!! old('apStartDate') !!}" placeholder="Start Date" autofocus>

                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label" for="appDate">End Date:</label>
                            <div class="col-sm-12 date mb-3">
                                <input type="text" class="form-control" id="apEndDate" name="apEndDate"
                                    value="{!! old('apEndDate') !!}" placeholder="End Date" autofocus>

                            </div>
                        </div>
                        {{-- <div class="form-group">
                  <label class="control-label" for="appDate">Waiting Time:</label>
                  <div  class="date mb-3 col-md-6">
                    <div class="input-group-prepend ">
                      <span class="input-group-text"><i class="">Hrs</i></span>
                    </div>
                    <input type="text" class="form-control" id="waitTime" name="waitTime" value="{!! old('waitTime') !!}" placeholder="Waiting Time" autofocus>

                  </div>
              </div> --}}

                        <div class="form-group">
                            <label class="control-label" for="waitTime">Waiting Time:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="waitTime" name="waitTime"
                                    value="{!! old('waitTime') !!}" placeholder="Waiting Time" autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-check checkbox-success checkbox-circle">
                                <input id="apStatus_id" type="checkbox" name="apStatus_id">
                                <label for="apStatus_id">Is Active</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="float-left">
                                        <a href="{{ route('doctors.index') }}" class="pull-right btn btn-danger"><i
                                                class="fa fa-close"></i> Back </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="float-right">
                                        <button type="submit" id="saveAppointment" class="btn btn-success"><i
                                                class="fa fa-save"></i> Create</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Calender Entries Created by {{ $doctor->title->name }}
                            {{ $doctor->user->surname . ' ' . $doctor->user->firstname . ' ' . $doctor->user->othername }}
                        </h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                                <i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="ghaji" class="table table-sm table-responsive table-bordered table-striped display">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Wait Time</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>

                                {{-- <tr>
                                    <td>Functional-requirements.docx</td>
                                    <td>49.8005 kb</td>
                                    <td class="text-right py-0 align-middle">
                                        <div class="btn-group btn-group-sm">
                                            <a href="#" class="btn btn-info"><i class="fa fa-eye"></i></a>
                                            <a href="#" class="btn btn-success"><i class="fa fa-pencil"></i></a>
                                            <a href="#" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr> --}}
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <a href="#" class="btn btn-secondary">Cancel</a>
                <input type="submit" value="Save Changes" class="btn btn-success float-right">
            </div>
        </div>

    </section>
    <div id="deleteModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h4 class="text-center">Are you sure you want to delete this calender entry?</h4>
                    <br />
                    {!! Form::open(['method' => 'DELETE', 'class' => 'form-horizontal del-form']) !!}

                    <div class="form-group">
                        <div class="col-sm-10">
                            <input type="hidden" class="form-control" id="id_delete">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-danger delete">
                        <span id="" class='glyphicon glyphicon-trash'></span> Delete
                    </button>
                    {!! Form::close() !!}
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                        <span class='glyphicon glyphicon-remove'></span> Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- <div id="editModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    {!! Form::open(['id' => 'appointmentForm', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
                    <input type="hidden" id="user_id" name="user_id" value="{{ $doctor->user_id }}">
                    <input type="hidden" id="doctor_id" name="doctor_id" value="{{ $doctor->id }}">
                    <div class="form-group ">
                        <label class="control-label" for="appDate">Start Date:</label>
                        <div class="col-sm-12 date mb-3">
                            <input type="text" class="form-control" id="apStartDate" name="apStartDate"
                                value="{!! old('apStartDate') !!}" placeholder="Start Date" autofocus>

                        </div>

                    </div>
                    <div class="form-group">
                        <label class="control-label" for="appDate">End Date:</label>
                        <div class="col-sm-12 date mb-3">
                            <input type="text" class="form-control" id="apEndDate" name="apEndDate"
                                value="{!! old('apEndDate') !!}" placeholder="End Date" autofocus>

                        </div>
                    </div>


                    <div class="form-group">
                        <label class="control-label" for="waitTime">Waiting Time:</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="waitTime" name="waitTime"
                                value="{!! old('waitTime') !!}" placeholder="Waiting Time" autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-check checkbox-success checkbox-circle">
                            <input id="apStatus_id" type="checkbox" name="apStatus_id">
                            <label for="apStatus_id">Is Active</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="float-left">
                                    <a href="{{ route('doctors.index') }}" class="pull-right btn btn-danger"><i
                                            class="fa fa-close"></i> Back </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="float-right">
                                    <button type="submit" id="saveAppointment" class="btn btn-success"><i
                                            class="fa fa-save"></i> Create</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger delete" data-dismiss="modal">
                        <span id="" class='glyphicon glyphicon-trash'></span> Delete
                    </button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                        <span class='glyphicon glyphicon-remove'></span> Close
                    </button>
                </div>
            </div>
        </div> --}}
    </div>
@endsection

@section('scripts')
<script src="{{ asset('js/adminlte.min.js') }}"></script>
    <script src="{{ asset('plugins/jQuery/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
    {{-- <script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script> --}}
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('plugins/datatables/extensions/AutoFill/js/dataTables.autoFill.js') }}"></script>
    <script src="{{ asset('plugins/datatables/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('plugins/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/buttons.colVis.min.js') }}"></script>

    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/datepicker/bootstrap-datepicker.js') }}"></script>

    {{-- <script  src="{{ asset('plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script> --}}
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>


    <script>
        // CKEDITOR.replace('content_edit');
        // CKEDITOR.replace('contact_address');
        // CKEDITOR.replace('home_address');
        $('#apStartDate').datepicker({
            format: 'dd/mm/yyyy',
            language: 'en'
        });

        $('#apEndDate').datepicker({
            format: 'dd/mm/yyyy',
            language: 'en'
        });
        // $("#consultation_fee");
        // $("#secondary_phone_number").inputmask('9999-999-9999');
    </script>

    <script type="text/javascript">
        $.validator.setDefaults({
            submitHandler: function() {

                $('#saveAppointment').html('Sending..');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: "{{ route('appointments.store') }}",
                    dataType: 'json',
                    data: $('#appointmentForm').serialize(),
                    success: function(data) {
                        console.log(data);
                        Swal.fire({
                            title: 'Appointment Created',
                            text: 'You have successfully created an appointment',
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            showConfirmButton: true,
                            confirmButtonText: 'Proceed'
                        }).then(function(result) {

                            if (result.isConfirmed) {
                                Swal.fire(
                                    'Thanks!',
                                    'Appointment saved.',
                                    'success'
                                )
                            }
                        });

                        $('#saveAppointment').html('Save Changes');
                        $('#appointmentForm').trigger("reset");
                        // window.location.reload();



                    },
                    error: function(data) {
                        // console.log('Error:', data);
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Validation Error!',
                            showConfirmButton: false,
                            // timer: 3000
                        });
                        // $('#saveBtn').html('Save Changes');
                    }
                });

            }
        });

        $(function() {

            $("#appointmentForm").validate({
                rules: {
                    apStartDate: "required",
                    apEndDate: {
                        required: true
                    },
                    waitTime: {
                        required: true
                    },
                    agree: "required"
                },
                messages: {
                    apStartDate: "Please enter your Appointment Start Date",
                    apEndDate: "Please enter your Appointment End Date",
                    waitTime: "Please enter Waiting",
                    agree: "Please accept our policy"
                },
                errorElement: "em",
                errorPlacement: function(error, element) {
                    // Add the `help-block` class to the error element
                    error.addClass("help-block");

                    // Add `has-feedback` class to the parent div.form-group
                    // in order to add icons to inputs
                    element.parents(".col-sm-12").addClass("has-feedback");

                    if (element.prop("type") === "checkbox") {
                        error.insertAfter(element.parent("label"));
                    } else {
                        error.insertAfter(element);
                    }

                    // Add the span element, if doesn't exists, and apply the icon classes to it.
                    if (!element.next("span")[0]) {
                        $("<span class='glyphicon glyphicon-remove form-control-feedback'></span>")
                            .insertAfter(element);
                    }
                },
                success: function(label, element) {
                    // Add the span element, if doesn't exists, and apply the icon classes to it.
                    if (!$(element).next("span")[0]) {
                        $("<span class='glyphicon glyphicon-ok form-control-feedback'></span>")
                            .insertAfter($(element));
                    }
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).parents(".col-sm-12").addClass("has-error").removeClass("has-success");
                    $(element).next("span").addClass("glyphicon-remove").removeClass("glyphicon-ok");
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).parents(".col-sm-12").addClass("has-success").removeClass("has-error");
                    $(element).next("span").addClass("glyphicon-ok").removeClass("glyphicon-remove");
                }
            });

        });

        $(function() {
            //  $.noConflict()
            var ahmad = $('#ghaji').DataTable({
                "dom": 'Bfrtip',
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                "buttons": [
                    'pageLength',
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5',
                    'print',
                    // 'colvis',
                    {
                        extend: 'collection',
                        text: 'Table control',
                        buttons: [{
                                text: 'Toggle start date',
                                action: function(e, dt, node, config) {
                                    dt.column(-2).visible(!dt.column(-2).visible());
                                }
                            },
                            {
                                text: 'Toggle salary',
                                action: function(e, dt, node, config) {
                                    dt.column(-1).visible(!dt.column(-1).visible());
                                }
                            },
                            {
                                collectionTitle: 'Visibility control',
                                extend: 'colvis'
                            }
                        ]
                    }
                ],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('listMyAppointments', $doctor->user->id) }}",
                    "type": "GET"
                },
                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: "apStartDate",
                        name: "apStartDate"
                    },
                    {
                        data: "apEndDate",
                        name: "apEndDate"
                    },
                    {
                        data: "waitTime",
                        name: "waitTime"
                    },
                    {
                        data: "edit",
                        name: "edit"
                    },
                    {
                        data: "delete",
                        name: "delete"
                    },
                    {
                        data: "status_id",
                        name: "status_id"
                    }
                ],
                "autoFill": {
                    "editor": "editor"
                },
                "responsive": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });
            new $.fn.dataTable.AutoFill(ahmad);
            // Handle click on "Expand All" button
            $('#btn-show-all-children').on('click', function() {
                // Expand row details
                ahmad.rows(':not(.parent)').nodes().to$().find('td:first-child').trigger('click');
            });

            // Handle click on "Collapse All" button
            $('#btn-hide-all-children').on('click', function() {
                // Collapse row details
                ahmad.rows('.parent').nodes().to$().find('td:first-child').trigger('click');
            });

            $(document).on('click', '.delete-modal', function() {
                $('.modal-title').text('Delete Appointment');
                $('#id_delete').val($(this).data('id'));
                var id_ = $(this).data('id');
                $('.del-form').attr('action', "{{ url('appointments') }}/" + $(this).data('id'));
                $('#deleteModal').modal("show");
            });

            $(document).on('click', '.edit-modal', function() {
                $('.modal-title').text('Edit Appointment');
                $('#id_edit').val($(this).data('id'));

                $('#editModal').modal("show");
            });
        });
    </script>
@endsection
