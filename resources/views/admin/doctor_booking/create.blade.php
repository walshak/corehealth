@extends('admin.layouts.admin')

@section('main-content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Book Appointment With Doctor </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"> Book Appointment With Dr. {{ $doctor->user->firstname }}
                            {{ $doctor->user->surname }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Book Appointment With Dr. {{ $doctor->user->firstname }}
                        {{ $doctor->user->surname }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div>
                        @if (count($errors) > 0)
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert"
                                    aria-hidden="true">×</button>
                                <!-- <h5><i class="icon fa fa-info"></i> Alert!</h5> -->
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>

                            </div>
                        @endif
                        @include('partials.notification')
                    </div>

                    {!! Form::open(['method' => 'POST', 'route' => 'DoctorBooking.store', 'class' => 'form-horizontal', 'role' => 'form','id'=>'booking-form']) !!}
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="patient_id" class="col-sm-2 control-label">Patient</label>
                        <select name="patient" id="patient_id" class="selectpicker form-control select2"
                        data-live-search="true" required>
                        <option value="">--Select Patient--</option>
                        @foreach ($patients as $p)
                            <option value="{{ $p->user_id }}"
                                data-tokens="{{ ucfirst($p->user->surname) }} {{ ucfirst($p->user->firstname) }} {{ ucfirst($p->user->lastname) }} {{ $p->file_no }}">
                                {{ ucfirst($p->user->surname) }}, {{ ucfirst($p->user->firstname) }}
                                {{ ucfirst($p->user->lastname) }}({{ $p->file_no }})
                            </option>
                        @endforeach
                    </select>
                    </div>

                    <div class="form-group">
                        <label for="calender_id" class="col-sm-2 control-label">Availaible Spaces</label>
                        <select name="calender" id="calender_id" class="form-control" required>
                            <option value="">--Select Space--</option>
                            @foreach ($calender as $c)
                                <option value="{{ $c->id }}">{{ $c->apStartDate }} - {{ $c->apEndDate }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="time">Date (date and time):</label>
                        <input type="datetime-local" id="time" name="time" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="fee" class="col-sm-2 control-label">Fee</label>
                        <input type="text" name="fee" id="fee" class="form-control" readonly
                            value="{{ $doctor->consultation_fee }}">
                    </div>
                    <input type="hidden" name="doc_id" value="{{ Request::input('doc') }}">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="col-sm-offset-1 col-sm-6">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>
                                        Save</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <a href="{{ route('doctors.index') }}" class="pull-right btn btn-danger"><i
                                            class="fa fa-close"></i> Back </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>

        </div>

    </section>

@endsection

@section('scripts')
    <!-- jQuery -->
    <script src="{{ asset('plugins/jQuery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/select2.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <!-- <script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script> -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- DataTables -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('plugins/datatables/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script>

    <script>
        // CKEDITOR.replace('content_edit');
        CKEDITOR.replace('content');
    </script>
    <script>
        $(document).ready(function() {
            $(".select2").select2();
        });

        $(document).ready(function() {
        $('select[name="calender"]').on('change', function() {
            var id = $(this).val();
            //alert(id);
            if (id) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    url: '{{ url('calenderDoctor') }}/' + id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        var max_date = data.apEndDate.replace('/','-').replace('/','-');
                        var min_date = data.apStartDate.replace('/','-').replace('/','-');
                        max_date = max_date.split('-');
                        min_date = min_date.split('-');
                        max_year = max_date[2];
                        max_month = max_date[1];
                        max_day  = max_date[0];

                        min_year = min_date[2];
                        min_month = min_date[1];
                        min_day  = min_date[0];
                        document.getElementById("time").max = max_year+'-'+max_month+'-'+max_day+"T23:59";
                        document.getElementById("time").min = min_year+'-'+min_month+'-'+min_day+"T00:00";
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
@endsection
