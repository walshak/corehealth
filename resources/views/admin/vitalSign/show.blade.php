@extends('admin.layouts.admin')

@section('style')
    <link rel="stylesheet" href="{{ asset('plugins/datatables/extensions/AutoFill/css/dataTables.autoFill.css') }}">
    <link rel="stylesheet"
        href="{{ asset('plugins/bootstrap-editable/bootstrap3-editable/css/bootstrap-editable.css') }}">
    <link rel="stylesheet"
        href="{{ asset('plugins/bootstrap-editable/inputs-ext/wysihtml5/bootstrap-wysihtml5-0.0.2/bootstrap-wysihtml5-0.0.2.css') }}">
@endsection

@section('main-content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Vital Sign Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Vital Sign Management</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Vital Sign Management</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    {{-- <div class="pull-right">
            <a href="{{ route('doctors.create') }}" class="btn btn-primary">Add</a>
          </div> --}}
                    {{-- <button id="btn-show-all-children" class="btn btn-dark btn-sm" type="button">Expand All</button>
          <button id="btn-hide-all-children" class="btn btn-dark btn-sm" type="button">Collapse All</button> --}}
                    <hr>

                    <div class="table-responsive">

                        <table class="table table-sm table-responsive table-bordered">
                            <?php $now = Carbon\Carbon::now(); ?>
                            <tr>
                                <td>{{ trans('Fullname') }}:</td>
                                <td colspan="2">
                                    {!! $dependant->fullname ?? ($getPatientVitalSign->user->surname . ' ' . $getPatientVitalSign->user->firstname . ' ' . $getPatientVitalSign->user->othername) !!}
                                </td>
                            </tr>
                            <tr>
                                <td>{{ trans('File Number') }}:</td>
                                <td colspan="2">{!! $getPatientVitalSign->file_no !!}</td>
                            </tr>
                            <tr>
                                <td>{{ trans('Receptionist') }}:</td>
                                <td colspan="2">{!! userfullname($getPatientVitalSign->receptionist_id) !!}</td>
                            </tr>
                            <tr>
                                <td>{{ trans('Temperature') }}:</td>
                                <td colspan="2"><a href="#" id="temperature" class="update"
                                        data-emptytext='Click to enter temperature reading' data-type="text"
                                        data-pk="{{ $getPatientVitalSign->id }}" data-name="temperature"
                                        data-title="Enter Temperature">{!! $getPatientVitalSign->temperature !!}</a></td>
                            </tr>
                            <tr>
                                <td>{{ trans('Weight') }}:</td>
                                <td colspan="2"><a href="#" id="weight" class="update"
                                        data-emptytext='Click to enter weight reading' data-type="text"
                                        data-pk="{{ $getPatientVitalSign->id }}" data-name="weight"
                                        data-title="Enter Weight">{!! $getPatientVitalSign->weight !!}</a></td>
                            </tr>
                            <tr>
                                <td>{{ trans('Blood Pressure') }}:</td>
                                <td colspan="2"><a href="#" id="bloodPressure" class="update"
                                        data-emptytext='Click to enter blood pressure reading' data-type="text"
                                        data-pk="{{ $getPatientVitalSign->id }}" data-name="bloodPressure"
                                        data-title="Enter Blood Pressure">{!! $getPatientVitalSign->bloodPressure !!}</a></td>
                            </tr>
                            <tr>
                                <td>{{ trans('Vital Sign Report by Nurse') }}:</td>
                                <td colspan="2"><a href="#" id="VitalSignReport" class="update"
                                        data-emptytext='Click to enter vital sign report' data-type="textarea"
                                        data-pk="{{ $getPatientVitalSign->id }}" data-name="VitalSignReport"
                                        data-title="Enter Vital Sign Report">{!! $getPatientVitalSign->VitalSignReport !!}</a></td>
                            </tr>
                            <tr>
                                <td>{{ trans('Processed') }}:</td>
                                <td colspan="2"><a href="#" id="status" data-type="select"
                                        data-pk="{{ $getPatientVitalSign->id }}" data-url="{!! route('update-user') !!}"
                                        data-title="Select options" data-emptytext='Click to enter'></a></td>
                            </tr>
                            <tr>
                                <td colspan="2">Pick Other Important Information</td>
                            </tr>
                            {{-- <tr>
                    <td colspan="2">
                        <div class="form-group row">
                            <label for="trans" class="col-md-4 col-form-label text-md-right">{{ __('Transaction No ') }}</label>
                            <div class="col-md-6">
                                <input id="trans" type="text" class="form-control{{ $errors->has('trans') ? ' is-invalid' : '' }}" name="trans" value="{{$trans}} " readonly="1" >

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="clinic" class="col-md-4 col-form-label text-md-right">{{ __('Clinic: ') }}</label>
                            <div class="col-md-6">
                                {!! Form::select('clinic', $clinic , null, ['id' => 'clinic_name', 'class' => 'form-control', 'data-live-search' => 'true', 'placeholder' => 'Pick a Value']) !!}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="clinic" class="col-md-4 col-form-label text-md-right">{{ __('Payment Item: ') }}</label>
                            <div class="col-md-6">
                            {!! Form::select('payment_items', $payment_items , null, ['id' => 'payment_items', 'name' => 'payment_items', 'placeholder' => 'Pick a Value', 'class' => 'form-control', 'data-live-search' => 'true' ]) !!}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="total_amount" class="col-md-4 col-form-label text-md-right">{{ __('Amount ₦ ') }}</label>
                            <div class="col-md-6">
                                <input type="text" id="total_amount" name="total_amount" class="form-control" readonly />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="mode" class="col-md-4 col-form-label text-md-right">{{ __('Mode of Payment: ') }}</label>
                            <div class="col-md-6">
                                {!! Form::select('payment_mode', $payment_mode , null, ['id' => 'payment_mode', 'class' => 'form-control', 'data-live-search' => 'true', 'placeholder' => 'Pick a Value' ]) !!}
                            </div>
                        </div>
                    </td>

                </tr> --}}
                            <tr class="default">
                                <td></td>
                                {{-- <td> <p id="correctName"></p> </td> --}}
                                <td>
                                    {{-- <form> --}}
                                    <input type="hidden" name="id_edit" id="id_edit"
                                        value="{{ $getPatientVitalSign->id }}">
                                    <button id="getNameEdit" name="getNameEdit" class="btn btn-success">Send to
                                        Doctor</button>
                                    {{-- </form> --}}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="pull-center">

                                </td>
                            </tr>
                        </table>

                    </div>
                </div>
            </div>

        </div>

    </section>

    <!-- Modal form to delete a user -->
    <div id="deleteModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h4 class="text-center">Are you sure you want to delete the following Details?</h4>
                    <br />
                    <form class="form-horizontal" role="form" id="deleteMyForm">
                        {{ csrf_field() }}
                        <input name="_method" type="hidden" value="DELETE">
                        <div class="form-group">
                            <div class="col-sm-10">
                                <input type="hidden" class="form-control" id="id">
                            </div>
                        </div>
                    </form>
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
@endsection

@section('scripts')
    <script src="{{ asset('plugins/jQuery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap-editable/bootstrap3-editable/js/bootstrap-editable.js') }}"></script>
    <script
        src="{{ asset('plugins/bootstrap-editable/inputs-ext/wysihtml5/bootstrap-wysihtml5-0.0.2/wysihtml5-0.3.0.min.js') }}">
    </script>
    <script
        src="{{ asset('plugins/bootstrap-editable/inputs-ext/wysihtml5/bootstrap-wysihtml5-0.0.2/bootstrap-wysihtml5-0.0.2.min.js') }}">
    </script>
    <script>
        // CKEDITOR.replace('content_edit');
        // CKEDITOR.replace('content');
    </script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        {{-- $.fn.editable.defaults.mode = 'inline'; --}}


        jQuery(function($) {

            $('.update').editable({
                url: '{!! route('update-user') !!}',
                type: 'text',
                pk: {{ $getPatientVitalSign->id }},
                name: 'name',
                title: 'Enter name',
                validate: function(value) {
                    if ($.trim(value) === '') {
                        return 'This field is required';
                    }
                }
            });

            $('#status').editable({
                value: {{ $getPatientVitalSign->status ? $getPatientVitalSign->status : 0 }},
                source: [{
                        value: 2,
                        text: 'New Treated'
                    },
                    {
                        value: 1,
                        text: 'Returning Treated'
                    },
                    {
                        value: 0,
                        text: 'None'
                    }
                ]


            });

            $('#getNameEdit').click(function() {

                $.ajax({
                    type: 'GET',
                    url: '{!! route('saveWhoProcessed', $getPatientVitalSign->id) !!}',
                    data: {
                        'id': $("#id_edit").val(),
                        // 'id': $("#id_edit").val(),
                    },
                    success: function(data) {
                        // var fullname = data.othername == null ?  data.lastname + ', ' + data.firstname : data.lastname + ', ' + data.firstname + ' ' + data.othername;
                        console.log(data);
                        // console.log(data.fullname);
                        {{-- swal({
                            type: 'success',
                            title: 'Vital Sign Taken',
                            text: 'The Vital Sign have being taken and sent to the doctors on call',
                            showConfirmButton: true,
                            timer: 30000
                        }); --}}
                        // $('#correctName').html(fullname);
                        Swal.fire({
                            title: 'Vital Sign Taken',
                            text: 'You are about to send the vital sign to the doctors on call',
                            icon: "warning",
                            buttons: [
                                'No, Adjust Vital Sign!',
                                'Yes, I am sure!'
                            ],
                            dangerMode: true,
                        }).then(function(isConfirm) {
                            if (isConfirm) {
                                Swal.fire({
                                    title: 'Vital Sign Taken Successfully',
                                    text: 'Successfully completed',
                                    icon: 'success'
                                }).then(function() {

                                    $.ajax({
                                        type: "POST",
                                        url: '{!! route('saveVitalSignStatus', $getPatientVitalSign->id) !!}',
                                        // data: {
                                        //     'trans': $("#trans").val(),
                                        //     'clinic_name': $("#clinic_name").val(),
                                        //     'payment_items': $("#payment_items").val(),
                                        //     'total_amount': $("#total_amount").val(),
                                        //     'payment_mode': $("#payment_mode").val(),
                                        //     'payment_id': $("#payment_id").val(),
                                        // },
                                        success: function(data) {
                                            console.log(data);
                                            window.location.href =
                                                "{!! route('vitalSign.index') !!}";
                                        },
                                        error: function(data) {
                                            console.log('Error:',
                                                data);
                                        }
                                    });

                                });
                            } else {
                                Swal.fire("Re-edit", "Edit the vital signs again :)",
                                    "info");
                            }
                        })
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        {{-- $('#btn-save').html('Save Changes'); --}}
                    }
                });
            });

            $('select[name="payment_items"]').on('change', function() {
                var id = $(this).val();

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

        });
    </script>
@endsection
