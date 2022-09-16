@extends('admin.layouts.admin')

@section('main-content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Patient Dependant Registration Form</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dependant</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <div class="row">
                            <div class="col-lg-12 col-6">
                                <!-- small box -->
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <p>
                                            File Number: {{ $patient->file_no }}<br>
                                            Fullname: {{ $fullname }}<br>
                                            Email: {{ $user_detail->email }}<br>
                                            Phone: {{ $user_detail->phone_number }}
                                        </p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-bag"></i>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </h3>
                </div>
                <div class="card-body">
                    {!! Form::open(['route' => 'dependants.store', 'method' => 'POST', 'role' => 'form', 'enctype' => 'multipart/form-data']) !!}
                    <div class="row">
                        <div class="col-sm-6">

                            {{ csrf_field() }}
                            <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                            <div class="form-group">
                                <label for="fullname" class="control-label">Fullname</label>
                                <input type="text" name="fullname" class="form-control" id="fullname"
                                    placeholder="Fullname" required>
                            </div>
                            <div class="form-group">
                                <label for="gender" class="control-label">Gender <span
                                        class="text-danger">*</span></label>
                                <select class="form-control" name="gender" required>
                                    <option value=''>Pick a Value</option>
                                    <option value='1'>Male</option>
                                    <option value='2'>Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="dob" class="control-label">Date of Birth <span
                                        class="text-danger">*</span></label>
                                <input type="Date" class="form-control" id="dob" name="dob" value="{{ old('dob') }}"
                                    placeholder="Date of Birth" required>
                            </div>
                            <div class="form-group">
                                <label for="blood_group_id" class="control-label">Blood Group</label>
                                <select class="form-control" name="blood_group_id" placeholder="Pick a Value">
                                    <option value=''>Pick a Value</option>
                                    <option value='O+'>O+</option>
                                    <option value='O-'>O-</option>
                                    <option value='A+'>A+</option>
                                    <option value='A-'>A-</option>
                                    <option value='B+'>B+</option>
                                    <option value='B-'>B-</option>
                                    <option value='AB+'>AB+</option>
                                    <option value='AB-'>AB-</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="disability" class="control-label">Disability</label>
                                <select class="form-control" name="disability">
                                    <option value='1'>No</option>
                                    <option value='2'>Yes</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="genotype" class="control-label">Genotype</label>
                                <select class="form-control" name="genotype">
                                    <option value=''>Pick a Value</option>
                                    <option value='AA'>AA</option>
                                    <option value='AS'>AS</option>
                                    <option value='SS'>SS</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-12">
                        <hr>
                        <h3 class="badge badge-sm badge-info">Health Insurance Detail</h3>
                        <hr>
                        <div class="form-group">
                            <label for="hmo" class="control-label">Hmo</label>
                            <select name="hmo" id="" class="form-control" disabled>
                                <option value="{{ $hmos->id }}">{{ $hmos->name }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="hmo_no" class="control-label">Hmo number</label>
                            <input type="text" name="hmo_no" class="form-control" id="hmo_no" placeholder="Hmo number">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="float-left">
                                    <a href="{{ route('dependants.index') }}" class="pull-right btn btn-danger"><i
                                            class="fa fa-close"></i> Back </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="float-right">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>
                                        Save</button>
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
    <script src="{{ asset('plugins/jQuery/jquery.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            $('select[name="state_id"]').on('change', function() {
                var stateID = $(this).val();
                // alert(stateID);
                if (stateID) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        url: '{{ url('/mystateAjax/ajax') }}/' + stateID,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            console.log(data);
                            $('select[name="lga_id"]').children('option:not(:first)').remove();

                            $.each(data, function(key, value) {
                                $('select[name="lga_id"]').append('<option value="' +
                                    key + '">' + value + '</option>');
                            });
                        }

                    });

                } else {

                    $('select[name="lga_id"]').children('option:not(:first)').remove();
                }

            });


        });
    </script>
@endsection
