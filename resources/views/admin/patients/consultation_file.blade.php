@extends('admin.layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('/plugins/summernote/summernote-bs4.css') }}">
@endsection

@section('main-content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Patient Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Patient Management</li>
                    </ol>
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
                        @if (null != $dependant)
                            <a href="{{ route('dependants.edit', $dependant->id) }}" target="_blank" style="float: right">
                                <i class="fa fa-edit"></i> Edit Patient Information
                            </a>
                        @else
                            <a href="{{ route('patient.edit', $patient->id) }}" target="_blank" style="float: right">
                                <i class="fa fa-edit"></i> Edit Patient Information
                            </a>
                        @endif
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                                <i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="card-body ">
                        <div class="form-group">
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
                        <h3 class="card-title">Vital Sign for
                            {{ $dependant->fullname ?? $patient->user->surname . ' ' . $patient->user->firstname . ' ' . $patient->user->othername }}
                        </h3>

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
            <div class="col-12">
                <div class="card card-dark collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title">Medical History</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                data-toggle="tooltip" title="Collapse">
                                <i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="ghaji" class="table table-sm table-responsive table-bordered table-striped display">
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
                    <!-- /.card-body -->
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
        </div>
        <div class="row">
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
                        @if ($tests != '')
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

        @if(isset($pending))
        {!! Form::open(['route' => 'addMedicalReport', 'method' => 'POST', 'role' => 'form', 'enctype' => 'multipart/form-data', 'onsubmit' => 'set_diagnosis()']) !!}
        @else
        {!! Form::open(['route' => 'medical-report.store', 'method' => 'POST', 'role' => 'form', 'enctype' => 'multipart/form-data', 'onsubmit' => 'set_diagnosis()']) !!}
        @endif
        {{ csrf_field() }}
        <input type="hidden" name="patient_user_id" value="{{ $patient->user_id }}">
        <input type="hidden" name="dependant_id" id="dependant_id" value="{{ $dependant->id ?? '' }}">
        <div class="row">
            <div class="col-12">

                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Doctor's Diagnosis and Management Notes</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                data-toggle="tooltip" title="Collapse">
                                <i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="diagnosticNoteSection">
                            <div class="form-group">
                                <label for="Section">Patient Section/Note Template</label>
                                <select name="clinic" id="clinic_id" class="form-control">
                                    <option value="">--Select Note Template--</option>
                                    @for ($i = 0; $i < count($clinics); $i++)
                                        <option value="{{ $clinics[$i]->id }}"
                                            {{ $clinics[$i]->id == $patient->clinic_id ? 'selected' : '' }}>
                                            {{ $clinics[$i]->clinic_name }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="pateintDiagnosisReport" class="control-label">Diagnosis and
                                    Prescription</label>
                                <div style="border:1px solid black;" id="the-diagnosis" class='the-diagnosis'>
                                    <?php echo $patient->clinic->clinic_note_format; ?>
                                </div>
                                <textarea style="display: none" id="pateintDiagnosisReport" name="pateintDiagnosisReport"
                                    class="form-control pateintDiagnosisReport">
                                </textarea>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="button" id="addNoteBtn" onclick="appendNote()"><i
                                class="fa fa-plus"></i> Append Note</button>
                        <hr>
                        <div class="form-group">
                            <label for="admission">Admission</label>
                            <select class="form-control" id="admission" name="admission">
                                <option value=''>--Pick a Value --</option>
                                <option value='0'>No</option>
                                <option value='1'>Yes</option>
                            </select>
                        </div>

                        {{-- <div id="showAdmission" style="display: none">
                            <div class="form-group">
                                <label for="Ward">Ward</label>
                                {!! Form::select('wards', $wards, null, ['id' => 'ward_id', 'name' => 'ward_id', 'class' => 'form-control', 'placeholder' => 'Pick a Value']) !!}
                            </div>
                            <div class="form-group">
                                <label for="bed">Bed</label>
                                <select id="bed_id" name="bed_id" class="form-control">
                                    <option value="">--Pick a Value--</option>
                                </select>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-dark collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title">Pharmacist</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                data-toggle="tooltip" title="Collapse">
                                <i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="pharmacy" class="control-label">Prescription</label>
                            <select id="parm_sel" class="select2 form-control" style="min-width: 100%">
                                <option value="">select drug to add</option>
                                @foreach ($products as $pro)
                                    <option value="{{$pro->id}}"> {{$pro->product_name}} - NGN {{$pro->price->current_sale_price}} - {{$pro->current_quantity}} units avail.</option>
                                @endforeach
                            </select>
                            <hr>
                            <div id="pharm_tbl">
                                <table class="table table-sm" >
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Dose</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="parm_tbl_body">

                                    </tbody>
                                </table>
                            </div>

                            <textarea style="display: none;" id="pharmacy" name="pharmacy" cols="10" rows="5" class="form-control"
                                placeholder="Enter Instruction">
                                {{ old('pharmacy') }}
                            </textarea>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-success collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title">Nurse Instruction</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                data-toggle="tooltip" title="Collapse">
                                <i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <label for="nurseContent" class="control-label">Todo</label>
                            <textarea id="nurseContent" name="nurseContent" cols="10" rows="2" class="form-control"
                                placeholder="Enter Instruction"
                                style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ old('nurseContent') }}
                            </textarea>
                        </div>

                        <div class="card card-danger" style="display:none;">
                            <div class="card-header">
                                <h3 class="card-title">Pick to discharge</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="admission">Discharge</label><br>
                                        {{-- <input type="checkbox" id="discharge" name="discharge" data-bootstrap-switch> --}}
                                        <input type="checkbox" data-toggle="toggle" id="discharge" name="discharge">
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="admission">Discharge Channel</label>
                                            <select class="form-control" id="dischargeChannel" name="dischargeChannel"
                                                placeholder="Pick a Value">
                                                <option value=''>Final Stage</option>
                                                <option value='1'>Pharmacist</option>
                                                <option value='2'>Nurse Station</option>
                                                <option value='3'>Doctor</option>

                                            </select>
                                        </div>
                                    </div>

                                    {{-- <input type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success"> --}}

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-info collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title">Lab Services</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                data-toggle="tooltip" title="Collapse">
                                <i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group ">
                            <div class="col-sm-offset-3 col-sm-9">
                                <label for="permission">Lab Services Availiable</label>
                                <div class="row">
                                    @foreach ($lab_services as $value)
                                        <div class="col-md-3">
                                            <label class="control-label" for="{{ $value->id }}">
                                                {{ Form::checkbox('service[]', $value->id) }}
                                                {{ $value->lab_service_name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
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
                        <a href="{{ route('roles.index') }}" class="pull-right btn btn-danger"><i
                                class="fa fa-close"></i> Back </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <div class="float-right">
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Update</button>
                    </div>
                </div>
            </div>
        </div>

        {!! Form::close() !!}

        <div id="deleteModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <h4 class="text-center">Are you sure you want to delete the following Details?</h4>
                        <br />

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
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('plugins/jQuery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap-switch-master/dist/js/bootstrap-switch.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('plugins/datatables/extensions/AutoFill/js/dataTables.autoFill.js') }}"></script>
    <script src="{{ asset('plugins/datatables/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('plugins/input-mask/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('plugins/input-mask/jquery.maskMoney.js') }}"></script>
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>

    <script src="{{ asset('plugins/select2/select2.min.js') }}"></script>
    <script>
        $('#parm_sel').select2({ width: '100%' }).on('change', function() {
            var id = $(this).val();
            if (id && id != '') {
                $.ajax({
                    url: '{{ url('/myform/ajaxprice') }}/' + id,
                    type: "GET",
                    dataType: "text",
                    success: function(response) {


                        var data = jQuery.parseJSON(response);
                        data = data[0];
                        data1 = data['product'];
                        //do not tamper with the markup
                        var pharm_tr_markup = `
                            <tr>
                                <td>${data1.product_name}</td>
                                <td>${data.current_sale_price}</td>
                                <td style="border:1px solid black; width:100%;  min-width: 80px; height:100%; min-height: 100px; display:inline-block;"
                                    contenteditable="true">
                                </td>
                                <td>
                                    <button type='button' class = 'btn btn-secondary btn-sm' onclick = 'remove_pharm_tr_row(this)'>
                                        <i class = 'fa fa-times text-danger'></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                        $('#parm_tbl_body').append(pharm_tr_markup);
                    }

                });



            } else {
                $('#price').val("");
            }
        });
    </script>

    <script>
        function remove_pharm_tr_row(obj){
            $(obj).closest('tr').remove();
        }
    </script>

    <script>
        $(document).ready(function() {
            // $('#pateintDiagnosisReport').summernote();
            // $('#nurseContent').summernote();
            // $('#pharmacy').summernote();
            // $('select[name="discharge"]').on('change', function() {

            // $("input[data-bootstrap-switch]").each(function(){
            // // alert("Meee");
            //     $(this).bootstrapSwitch('state', $(this).prop('checked'));
            // });

            // });

            // $("[name='my-checkbox']").bootstrapSwitch();
            // $('#toggle-demo').bootstrapToggle('toggle');
            $("#dischargeChannel").attr('disabled', 'disabled');
            $("[name='discharge']").bootstrapSwitch({
                size: "mini",
                onSwitchChange: function(event, state) {

                    if (this.checked) {


                        $("#dischargeChannel").removeAttr('disabled');
                        $("#admission").attr('disabled', 'disabled');
                    } else {

                        $("#dischargeChannel").attr('disabled', 'disabled');
                        $("#admission").removeAttr('disabled');
                    }
                }
            });

        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="admission"]').on('change', function() {
                var admissionValue = $(this).val();
                // $("#showAdmission").slideDown(500);
                // alert(admissionValue);
                if (admissionValue == 1) {
                    $("#showAdmission").slideDown(500);
                    // $("#discharge").attr('disabled','disabled');
                    $("[name='discharge']").bootstrapSwitch('disabled', true);
                    $("#dischargeChannel").attr('disabled', 'disabled');
                } else {
                    $("#showAdmission").slideUp(500);
                    $("[name='discharge']").bootstrapSwitch('disabled', false);
                    $("#dischargeChannel").removeAttr('disabled');
                }
            });

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
    </script>
    @if (isset($dependant))
        <script>
            $(function() {
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
        //copy the conents of the editable div to the textarea form field so that the value can be sumitted
        function set_diagnosis() {
            var appended_values = "";
            $('.the-diagnosis').each(function() {
                appended_values = appended_values + this.innerHTML;
            });

            document.getElementById("pateintDiagnosisReport").innerText = appended_values;

            var prescription_table = document.getElementById("pharm_tbl").innerHTML;

            document.getElementById("pharmacy").innerText = prescription_table;

        }
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

        function appendNote() {
            var new_random_id = Math.floor(Math.random() * 10000);
            var newNoteDiv =
                `<div id = '${new_random_id}'>
                    <hr>
                    <button onclick = "removeNoteTemplate('${new_random_id}')" class = 'btn btn-danger m-1' style = "float:right">
                        <i class='fa fa-times'></i> Remove
                    </button>
                    <div class="form-group">
                        <label for="Section">Patient Section/Note Template</label>
                        <select id="clinic_id_${new_random_id}" class="form-control" onchange = "setAppendedNoteTemplate('${new_random_id}')">
                            <option value="">--Select Note Template--</option>
                            @for($i = 0; $i< count($clinics); $i++)
                                <option value="{{ $clinics[$i]->id }}"
                                    {{ $clinics[$i]->id == $patient->clinic_id ? 'selected' : '' }}>
                                    {{ $clinics[$i]->clinic_name }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="pateintDiagnosisReport" class="control-label">Diagnosis and Prescription</label>
                        <div style="border:1px solid black;" id="the-diagnosis_${new_random_id}" class= 'the-diagnosis'>
                            <?php echo $patient->clinic->clinic_note_format; ?>
                        </div>
                    </div>
                </div>`;
            $('#diagnosticNoteSection').append(newNoteDiv);
        }

        function removeNoteTemplate(id) {
            if (confirm('Remove Note Entry?')) {
                $('#' + id).remove();
            }
        }

        function setAppendedNoteTemplate(id) {
            clinic_id = $('#clinic_id_' + id).val();
            if (id) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    url: '{{ url('getNoteTemplate') }}/' + clinic_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        document.getElementById("the-diagnosis_" + id).innerHTML = data.template;
                    }

                });
            } else {

                // $('#total_amount').val("");
            }
        }
    </script>
    <script>
        function toggle_group(class_) {
            var x = document.getElementsByClassName(class_);
            for (i = 0; i < x.length; i++) {
                if (x[i].style.display === "none") {
                    x[i].style.display = "block";
                } else {
                    x[i].style.display = "none";
                }
            }

        }
        $('.DataTables').DataTable();
    </script>
@endsection
