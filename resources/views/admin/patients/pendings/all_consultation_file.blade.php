@extends('admin.layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('/plugins/summernote/summernote-bs4.css') }}">
@endsection

@section('main-content')
    <section class="content-header">
        <div class="content">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Patient Management
                        <!-- <a class="btn btn-success text-light" data-toggle="modal" id="mediumButton"
                                data-target="#mediumModal" data-attr="
                                                                      <span class='badge badge-pill badge-success'><b>Doctor Report</b> </span><br>
                                                                       {{ $md->pateintDiagnosisReport }}
                                                                      <br><br><hr>
                                                                      <span class='badge badge-pill badge-dark'><b> Pharmacy Prescription </b> </span><br>
                                                                        {{ $md->pharmacy }}
                                                                      <br><br><hr>
                                                                      <span class='badge badge-pill badge-warning'><b>  Instruction to Nurse </b> </span> <br>
                                                                      {{ $md->nurseContent }}
                                                                      <br><br><hr>
                                                                      <span class='badge badge-pill badge-primary'><b> Lab Test </b> </span>
                                                                      <br>
                                                                       @if (!empty($labservices))
<ul>

                                @foreach ($labservices as $labservice)
<li>
                                        <span class='badge badge-pill badge-success'>
                                            <b>{{ $labservice->lab_service->lab_service_name }}</b>
                                        </span>
                                        @if ($labservice->lab_service->sampeTaken == 1)
Result Details:{{ $labservice->resultReport }}
@endif
                                    </li>
@endforeach
                            </ul>
@endif
                            " title="Report"> <i class="fas fa-plus-circle"></i> view record
                            </a> -->
                    </h1>
                </div>

                <div class="col-12">
                    <div class="card card-info collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">
                                {{ $dependant->fullname ?? $patient->user->surname . ' ' . $patient->user->firstname . ' ' . $patient->user->othername }}
                                Previous Diagonosis </h3>
                            @if ($patient->user->old_records)
                                <a href="{!! url('storage/image/user/old_records/' . $patient->user->old_records) !!}" target="_blank"><i class="fa fa-file"></i> Old
                                    Records</a>
                            @endif

                            <a href="{{ url('allConsultationlist') }}" class="btn btn-danger"><i
                                    class="fa fa-arrow-left"></i> Back </a>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                    data-toggle="tooltip" title="Collapse">
                                    <i class="fa fa-plus"></i></button>
                            </div>
                        </div>

                        <div class="card-body">
                                <table id="pending" class="table table-sm table-responsive table-sm table-responsive table-bordered table-striped ">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Date</th>
                                        <th>Doctor Name</th>
                                        <th>Doctors's Report</th>
                                        <th>Doctor Recomendation to Pharmacy</th>
                                        <th>Instruction to Nurse</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>


                    <div class="card card-info collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">
                                {{ $dependant->fullname ?? $patient->user->surname . ' ' . $patient->user->firstname . ' ' . $patient->user->othername }}
                                Ward / Procedure Notes </h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                    data-toggle="tooltip" title="Collapse">
                                    <i class="fa fa-plus"></i></button>
                            </div>
                        </div>

                        <div class="card-body">
                            <table id="ward_note" class="table table-sm table-responsive table-bordered table-striped display">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Patient</th>
                                        <th>Title</th>
                                        <th>Note</th>
                                        {{-- <th>Attched</th> --}}
                                        <th>Added by</th>
                                        <th>Date</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card card-info collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">
                                {{ $dependant->fullname ?? $patient->user->surname . ' ' . $patient->user->firstname . ' ' . $patient->user->othername }}
                                Previous Investigations </h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                    data-toggle="tooltip" title="Collapse">
                                    <i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            @if ($tests != ' ')
                                <h3 class="card-title">Investigations </h3>

                                <table class="table table-sm table-responsive table-sm table-responsive table-bordered table-striped DataTables">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Lab</th>
                                            <th>Test</th>
                                            <th>Result</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tests as $test)
                                            <tr>
                                                <td>#</td>
                                                <td>{{ $test->lab->lab_name }}</td>
                                                <td>{{ $test->lab_service->lab_service_name }}</td>
                                                <td>
                                                    @if ($test->resultReport != '0' && $test->status_id != 0)
                                                        {!! $test->resultReport !!}
                                                    @elseif($test->status_id == 2)
                                                        <span class="badge badge-danger">Request Declined</span>
                                                    @else
                                                        <span class="badge badge-warning">Awaiting Results</span>
                                                    @endif
                                                </td>
                                                <td>Requested On: <small>{{ $test->created_at }}</small> <br>
                                                    <hr> Last Updated On: <small>{{ $test->updated_at }}</small>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

        </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="row">
            <div class="col-6">
                <div class="card card-primary collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title">Patient Information</h3>
                        @if ($patient->user->old_records)
                            <a href="{!! url('storage/image/user/old_records/' . $patient->user->old_records) !!}" target="_blank"><i class="fa fa-file"></i> Old Records</a>
                        @endif

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                                <i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="card-body ">
                        <div class="form-group">
                            <input type="hidden" name="dependant_id" id="dependant_id"
                                value="{{ $dependant->id ?? '' }}">
                            <label for="fullname">Title/Fullname</label>
                            <div class="input-group input-group-sm">
                                @if (!empty($patient->title->name))
                                    <div class="input-group-append">
                                        <span class="input-group-text">{{ $patient->title->name }}</span>
                                    </div>
                                @endif
                                <input type="text" id="fullname" class="form-control form-control-sm"
                                    value="{{ $dependant->fullname ?? $patient->user->surname . ' ' . $patient->user->firstname . ' ' . $patient->user->othername }}"
                                    readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <input type="text" id="gender" class="form-control form-control-sm"
                                value="{{ $dependant->genderr->name ?? ($patient->genderr->name ?? 'N/A') }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="dob">Date of Birth</label>
                            <input type="text" id="dob" class="form-control form-control-sm"
                                value="{{ $dependant->dob ?? ($patient->dob ?? 'N/A') }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="email"> Email</label>
                            <input type="text" id="email" class="form-control form-control-sm"
                                value="{{ $patient->user->email ?? 'N/A' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="contact_address">Contact Address</label>
                            <textarea id="contact_address" class="form-control form-control-sm" rows="3" readonly>{{ $patient->address ?? 'N/A' }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="phone_number"> Phone Number</label>
                            <input type="text" id="phone_number" class="form-control form-control-sm"
                                value="{{ $patient->user->phone_number ?? 'N/A' }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="blood_groop">Blood Group</label>
                            <input type="text" id="blood_groop_id" class="form-control form-control-sm"
                                value="{{ $dependant->blood_group_id ?? ($patient->blood_group_id ?? 'N/A') }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="blood_groop">State/Province</label>
                            <input type="text" id="blood_groop_id" class="form-control form-control-sm"
                                value="{{ $patient->lgaa->name ?? 'N/A' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="blood_groop">LGA</label>
                            <input type="text" id="blood_groop_id" class="form-control form-control-sm"
                                value="{{ $patient->lgaa ? $patient->lgaa->getState() : 'N/A' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="phone_number"> Genotype</label>
                            <input type="text" id="phone_number" class="form-control form-control-sm"
                                value="{{ $dependant->genotype ?? ($patient->genotype ?? 'N/A') }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="hmo"> HMO/Insurance</label>
                            <input type="text" id="hmo" class="form-control form-control-sm"
                                value="{{ $patient->hmo->name ?? 'N/A' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="hmo"> HMO/Insurance Number</label>
                            <input type="text" id="hmo" class="form-control form-control-sm"
                                value="{{ $dependant->hmo_no ?? ($patient->hmo_no ?? 'N/A') }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card card-dark collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title">Vital Sign for </h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                data-toggle="tooltip" title="Collapse">
                                <i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <label for="temperature"> Temperature</label>
                            <input type="text" id="temperature" class="form-control form-control-sm"
                                value="{{ $vitalSign->temperature ?? 'N/A' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="weight"> Weight</label>
                            <input type="text" id="weight" class="form-control form-control-sm"
                                value="{{ $vitalSign->weight ?? 'N/A' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="bloodPressure"> Blood Pressure</label>
                            <input type="text" id="bloodPressure" class="form-control form-control-sm"
                                value="{{ $vitalSign->bloodPressure ?? 'N/A' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="VitalSignReport" class="control-label">Vital Sign Report</label>
                            <textarea id="VitalSignReport" name="VitalSignReport" cols="10" rows="2" class="form-control"
                                placeholder="Enter Instruction" readonly>{{ $vitalSign->VitalSignReport ?? 'N/A' }}
                </textarea>
                        </div>

                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <div class="float-left">
                        <a href="{{ url('allConsultationlist') }}" class="pull-right btn btn-danger"><i
                                class="fa fa-close"></i> Back </a>
                    </div>
                </div>
            </div>


        </div>
        {!! Form::close() !!}
    </section>
    <!-- medium modal -->
    <div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="card border-info mb-6">


                        <div class="card-tools"">
                        </div>


                        <button type=" button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>
                </div>
                <div class="modal-body" id="mediumBody">
                    <div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End medium modal -->
@endsection


@section('scripts')
    <script src="{{ asset('plugins/jQuery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('plugins/datatables/dataTables.bootstrap4.js') }}"></script>
    {{-- <script src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script> --}}

    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('plugins/input-mask/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('plugins/input-mask/jquery.maskMoney.js') }}"></script>

    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            // $('select[name="admission"]').on('change', function() {
            //     var admissionValue = $(this).val();
            //     // $("#showAdmission").slideDown(500);
            //     // alert(admissionValue);
            //     if (admissionValue == 1) {
            //         $("#showAdmission").slideDown(500);
            //     } else {
            //         $("#showAdmission").slideUp(500);
            //     }
            // });

            // $('select[name="ward_id"]').on('change', function() {
            //     var wardID = $(this).val();
            //     // alert(wardID);
            //     if (wardID) {
            //         $.ajax({
            //             headers: {
            //                 'X-CSRF-TOKEN': "{{ csrf_token() }}"
            //             },
            //             url: '{{ url('/mywardAjax/ajax') }}/' + wardID,
            //             type: "GET",
            //             dataType: "json",
            //             success: function(data) {
            //                 console.log(data);
            //                 $('select[name="bed_id"]').children('option:not(:first)').remove();

            //                 $.each(data, function(key, value) {
            //                     $('select[name="bed_id"]').append('<option value="' +
            //                         key + '">' + value + '</option>');
            //                 });
            //             }

            //         });

            //     } else {

            //         $('select[name="bed_id"]').children('option:not(:first)').remove();
            //     }

            // });

        });
        // $(document).on('click', '#mediumButton', function(event) {
        //       event.preventDefault();
        //       let href = $(this).attr('data-attr');
        //       var medical_report =  $(this).attr('data-attr');
        //       //alert(id)
        //       $.ajax({
        //           beforeSend: function() {
        //               $('#loader').show();
        //           },
        //           // return the result
        //           success: function(result) {
        //               $('#mediumModal').modal("show");
        //               $('#mediumBody').html(medical_report).show();
        //           },
        //           complete: function() {
        //               $('#loader').hide();
        //           },
        //           error: function(jqXHR, testStatus, error) {
        //               console.log(error);
        //               alert("Page " + href + " cannot open. Error:" + error);
        //               $('#loader').hide();
        //           },
        //           timeout: 8000
        //       })
        //   });
    </script>
    <script>
        //copy the conents of the editable div to the textarea form field so that the value can be sumitted
        function set_diagnosis() {
            var appended_values = "";
            $('.the-diagnosis').each(function() {
                appended_values = appended_values + this.innerHTML;
            });

            document.getElementById("pateintDiagnosisReport").innerText = appended_values;
        }
    </script>
    @if (isset($dependant))
        <script>
            $(function() {
                var ahmad = $('#pending').DataTable({
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
                        "url": "{{ url('listMedicalHistory', [$patient->user_id, $dependant->id]) }}",
                        "type": "GET"
                    },
                    "columns": [
                        {
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: "updated_at",
                            name: "updated_at"
                        },
                        {
                            data: "doctor_id",
                            name: "doctor_id"
                        },
                        {
                            data: "pateintDiagnosisReport",
                            name: "pateintDiagnosisReport"
                        },

                        // { data: "view", name: "view" },
                        // { data: "edit", name: "edit" },
                        // {
                        //     data: "delete",
                        //     name: "delete"
                        // }
                        {
                            data: "pharmacy",
                            name: "pharmacy"
                        },
                        {
                            data: "nurce",
                            name: "nurce"
                        },
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

                var ward_note = $('#ward_note').DataTable({
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
                        "url": "{{ route('listWardNotes', ['patient_id' => $patient->id, 'dependant_id' => $dependant->id]) }}",
                        "type": "GET"
                    },
                    "columns": [{
                            "data": "DT_RowIndex"
                        },
                        {
                            "data": "patient_id"
                        },
                        {
                            "data": "title"
                        },
                        {
                            "data": "note"
                        },
                        // {
                        //     "data": "filename"
                        // },
                        {
                            "data": "user_id"
                        },
                        {
                            "data": "created_at"
                        },
                        {
                            "data": "edit"
                        },
                        {
                            "data": "delete"
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
            });
        </script>
    @else
        <script>
            $(function() {
                var ahmad = $('#pending').DataTable({
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
                        "url": "{{ url('listMedicalHistory', $patient->user_id) }}",
                        "type": "GET"
                    },
                    "columns": [
                        {
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: "updated_at",
                            name: "updated_at"
                        },
                        {
                            data: "doctor_id",
                            name: "doctor_id"
                        },
                        {
                            data: "pateintDiagnosisReport",
                            name: "pateintDiagnosisReport"
                        },

                        // { data: "view", name: "view" },
                        // { data: "edit", name: "edit" },
                        // {
                        //     data: "delete",
                        //     name: "delete"
                        // }
                        {
                            data: "pharmacy",
                            name: "pharmacy"
                        },
                        {
                            data: "nurce",
                            name: "nurce"
                        },
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

                var ward_note = $('#ward_note').DataTable({
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
                        "url": "{{ route('listWardNotes', ['patient_id' => $patient->id]) }}",
                        "type": "GET"
                    },
                    "columns": [{
                            "data": "DT_RowIndex"
                        },
                        {
                            "data": "patient_id"
                        },
                        {
                            "data": "title"
                        },
                        {
                            "data": "note"
                        },
                        // {
                        //     "data": "filename"
                        // },
                        {
                            "data": "user_id"
                        },
                        {
                            "data": "created_at"
                        },
                        {
                            "data": "edit"
                        },
                        {
                            "data": "delete"
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
            });
        </script>
    @endif
    <script>
        $(document).ready(function() {
            $('#clinic_id').on('change', function() {
                var id = $(this).val();
                //alert(id);
                if (id) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        url: '{{ url('getNoteTemplate') }}/' + id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            document.getElementById("the-diagnosis").innerHTML = data.template;
                        }

                    });
                } else {

                    // $('#total_amount').val("");
                }
            });
        });

        $('.DataTables').DataTable();
    </script>
@endsection
