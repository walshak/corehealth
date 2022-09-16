@extends('admin.layouts.admin')

@section('main-content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Patient Form</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Patient</li>
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
                                <p class="text-danger">Click <a href="{{ route('users.edit',[$patient->user_id]) }}">Here</a> to edit the
                                    above details </p>
                            </div>

                        </div>
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('patient.update', $patient->id) }}" method="post"
                        enctype="multipart/form-data">
                        <p class="text-danger">Fields marked * are required</p>
                        <div class="row">

                            <div class="col-sm-6">
                                @method('PUT')
                                {{ csrf_field() }}

                                <input type="hidden" name="id" value="{{ $patient->id }}">
                                <div class="form-group">
                                    <label for="file_no" class="control-label">File No.</label>
                                    <input type="text" class="form-control" id="file_no" name="file_no"
                                        value="{{ old('file_no') ?? $patient->file_no }}" placeholder="file_no">
                                </div>
                                <div class="form-group">
                                    <label for="gender" class="control-label">Gender <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" name="gender">
                                        <option value=''>Pick a Value</option>
                                        <option value='1' {{ $patient->gender == '1' ? 'selected' : '' }}>Male</option>
                                        <option value='2' {{ $patient->gender == '2' ? 'selected' : '' }}>Female</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="dob" class="control-label">Date of Birth <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="dob" name="dob"
                                        value="{{$patient->dob }}" placeholder="Date of Birth">
                                </div>
                                <div class="form-group">
                                    <label for="blood_group_id" class="control-label">Blood Group</label>
                                    <select class="form-control" name="blood_group_id" placeholder="Pick a Value">
                                        <option value=''>Pick a Value</option>
                                        <option value='O+' {{ $patient->blood_group_id == 'O+' ? 'selected' : '' }}>O+
                                        </option>
                                        <option value='O-' {{ $patient->blood_group_id == 'O-' ? 'selected' : '' }}>O-
                                        </option>
                                        <option value='A+' {{ $patient->blood_group_id == 'A+' ? 'selected' : '' }}>A+
                                        </option>
                                        <option value='A-' {{ $patient->blood_group_id == 'A-' ? 'selected' : '' }}>A-
                                        </option>
                                        <option value='B+' {{ $patient->blood_group_id == 'B+' ? 'selected' : '' }}>B+
                                        </option>
                                        <option value='B-' {{ $patient->blood_group_id == 'B-' ? 'selected' : '' }}>B-
                                        </option>
                                        <option value='AB+' {{ $patient->blood_group_id == 'AB+' ? 'selected' : '' }}>AB+
                                        </option>
                                        <option value='AB-' {{ $patient->blood_group_id == 'AB-' ? 'selected' : '' }}>AB-
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="genotype" class="control-label">Genotype</label>
                                    <select class="form-control" name="genotype">
                                        <option value=''>Pick a Value</option>
                                        <option value='AA' {{ $patient->genotype == 'AA' ? 'selected' : '' }}>AA</option>
                                        <option value='AS' {{ $patient->genotype == 'AS' ? 'selected' : '' }}>AS</option>
                                        <option value='SS' {{ $patient->genotype == 'SS' ? 'selected' : '' }}>SS</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="hieght" class="control-label">Height(cm)</label>
                                    <input type="number" class="form-control" id="hieght" name="hieght"
                                        value="{{ old('hieght') ?? $patient->hieght }}" placeholder="Enter Height">
                                </div>

                                <div class="form-group">
                                    <label for="address" class="control-label">Address</label>
                                    <textarea class="form-control" id="address" name="address" cols="20" row="10" placeholder="Address">
                            {{ old('address') ?? $patient->address }}
                          </textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="weight" class="control-label">Weight(Kg)</label>
                                    <input type="text" class="form-control" id="weight" name="weight"
                                        value="{{ old('weight') ?? $patient->weight }}" placeholder="Weight">
                                </div>

                                {{-- <div class="form-group">
                                <label for="account_type" class="control-label">Account Type</label>
                                <select class="form-control" name="account_type">
                                    <option value=''>Pick a Value</option>
                                    <option value='1'>OUT Patient Department Account</option>
                                    <option value='2'>Ward Patient Account</option>
                                    <option value='1'>Register Account</option>
                                    <option value='2'>NHIS Account</option>
                                </select>
                            </div> --}}

                                <div class="form-group">
                                    <label for="disability" class="control-label">Disability</label>
                                    <select class="form-control" name="disability">
                                        <option value='1' {{ $patient->disability == '1' ? 'selected' : '' }}>No
                                        </option>
                                        <option value='2' {{ $patient->disability == '2' ? 'selected' : '' }}>Yes
                                        </option>
                                    </select>
                                </div>
                                @if (null != $patient->lgaa)
                                    <div class="form-group">
                                        <label for="state_id" class="control-label">State Of Origin</label>
                                        {!! Form::select('states', $states, $patient->lgaa->getStateId(), ['id' => 'state_id', 'name' => 'state_id', 'class' => 'form-control', 'placeholder' => 'Pick a Value']) !!}
                                    </div>
                                @else
                                    <div class="form-group">
                                        <label for="state_id" class="control-label">State Of Origin</label>
                                        {!! Form::select('states', $states, null ,['id' => 'state_id', 'name' => 'state_id', 'class' => 'form-control', 'placeholder' => 'Pick a Value']) !!}
                                    </div>
                                @endif


                                <div class="form-group">
                                    <label for="lga_id" class="control-label">LGA</label>
                                    <select id="lga_id" name="lga_id" class="form-control">
                                        <option value="">Pick a Value</option>
                                    </select>
                                </div>


                            </div>

                        </div>
                        @if(isset($next_of_kin))
                            <div class="col-sm-12">
                                <hr>
                                <h3 class="badge badge-sm badge-info"> Next of Kin Details</h3>
                                <hr>
                                <div class="form-group">
                                    <input type="hidden" name="next_of_kin_ID" value="{{ $next_of_kin->id }}">
                                    <label for="next_of_king_id" class="control-label">Fullname <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="next_of_king_id" name="next_of_king_id"
                                        value="{{ old('next_of_king_id') ?? $next_of_kin->full_name }}"
                                        placeholder="Fullname">
                                </div>

                                <div class="form-group">
                                    <label for="next_of_king_phone" class="control-label">Phone Number <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="next_of_king_phone" name="next_of_king_phone"
                                        value="{{ old('next_of_king_phone') ?? $next_of_kin->phone }}"
                                        placeholder="Phone Number">
                                </div>

                                <div class="form-group">
                                    <label for="next_of_king_address" class="control-label">Home Address</label>
                                    <input type="text" class="form-control" id="next_of_king_address"
                                        name="next_of_king_address"
                                        value="{{ old('next_of_king_address') ?? $next_of_kin->address }}"
                                        placeholder="Home Address">

                                </div>
                            </div>
                        @else
                            <div class="col-sm-12">
                                <hr>
                                <h3 class="badge badge-sm badge-info"> Next of Kin Details</h3>
                                <hr>
                                <div class="form-group">
                                    <input type="hidden" name="next_of_kin_ID">
                                    <label for="next_of_king_id" class="control-label">Fullname <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="next_of_king_id" name="next_of_king_id"
                                        value="{{ old('next_of_king_id') }}"
                                        placeholder="Fullname">
                                </div>

                                <div class="form-group">
                                    <label for="next_of_king_phone" class="control-label">Phone Number <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="next_of_king_phone" name="next_of_king_phone"
                                        value="{{ old('next_of_king_phone')  }}"
                                        placeholder="Phone Number">
                                </div>

                                <div class="form-group">
                                    <label for="next_of_king_address" class="control-label">Home Address</label>
                                    <input type="text" class="form-control" id="next_of_king_address"
                                        name="next_of_king_address"
                                        value="{{ old('next_of_king_address')}}"
                                        placeholder="Home Address">
                                </div>
                            </div>
                        @endif
                        <div class="col-sm-12">
                            <hr>
                            <h3 class="badge badge-sm badge-info">Health Insurance Detail</h3>
                            <hr>
                            <div class="form-group">
                                <label for="hmo" class="control-label">Hmo <span class="text-danger">*</span></label>
                                <select name="hmo" id="" class="form-control">
                                    <option value="">--Select Hmo--</option>
                                    @foreach ($hmos as $hmo)
                                        <option value="{{ $hmo->id }}"
                                            {{ $patient->hmo_id == $hmo->id ? 'selected' : '' }}>{{ $hmo->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="hmo_no" class="control-label">Hmo Number</label>
                                <input type="text" name="hmo_no" class="form-control" id="hmo_no"
                                    value="{{ old('hmo_no') ?? $patient->hmo_no }}" placeholder="E.g 120228992/1">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="float-left">
                                        <a href="{{ route('patient.index') }}" class="pull-right btn btn-danger"><i
                                                class="fa fa-close"></i> Back </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="float-right">
                                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>
                                            Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>
@endsection

@section('scripts')
    <script src="{{ asset('plugins/jQuery/jquery.min.js') }}"></script>
    <script type="text/javascript">
        function get_state_lgas(stateID) {
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
        }
        $(document).ready(function() {
            if ($('select[name="state_id"]').val() != '') {
                get_state_lgas($('select[name="state_id"]').val());

            }
            $('select[name="state_id"]').on('change', function() {
                get_state_lgas($('select[name="state_id"]').val());
            });


        });
    </script>
@endsection
