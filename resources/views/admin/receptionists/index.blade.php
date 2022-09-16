@extends('admin.layouts.admin')

@section('main-content')
    <div id="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">

                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Dashboard </h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>

        <div class="content">
            @include(
                'admin.layouts.partials.dashboard.receptionist.infoBox'
            )
            <div class="card">
                {{-- <div class="card-header">
        <h3 class="card-title">Credit Customer (Date Line)</h3>
      </div> --}}
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-3">
                            <!-- Profile Image -->
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                        <img class="profile-user-img img-fluid img-circle" src="{!! url('storage/image/user/' . $user->filename) !!}"
                                            alt="User profile picture">
                                    </div>

                                    <h3 class="profile-username text-center">{!! $user->slug !!}</h3>

                                    <p class="text-muted text-center">{!! $user->statuscategory->name !!}</p>
                                    {{-- <p class="text-muted text-center">{!! $user->phone_number !!}</p>
                  <p class="text-muted text-center">{!! $user->email !!}</p> --}}



                                    <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->

                            <!-- About Me Box -->
                            @if (Auth::user()->is_admin == 19)
                                {{-- <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Control</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <ul>
                                            <li><a href="{{ route('users.create') }}"><i class="fa fa-user mr-1"></i> New
                                                    Pateint</a></li>
                                            <li><a href="{{ route('receptionists.create') }}"><i
                                                        class="fa fa-users mr-1"></i>
                                                    Returning Pateint</a></li>
                                            <li><a href="{{ url('user.index') }}"><i class="fa fa-users mr-1"></i> Old
                                                    Pateint</a></li>
                                        </ul>
                                        <li>
                                            <a href="{{ route('newPatients') }}" class="nav-link">
                                                <i class="nav-icon fa fa-plus"></i>
                                                <p>Pay Card </p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ route('newRegistrationFormRequestList') }}" class="nav-link">
                                                <i class="nav-icon fa fa-search"></i>
                                                <p>Registration Form</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('CurrentConsultationRequestlist') }}" class="nav-link">
                                                <i class="nav-icon fa fa-search"></i>
                                                <p>Consultation</p>
                                            </a>
                                        </li>
                                    </div>
                                    <!-- /.card-body -->
                                </div> --}}
                            @elseif(Auth::user()->is_admin == 20)
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Control</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <ul>
                                            <li><a href="{{ route('CurrentConsultationRequestlist') }}"><i
                                                        class="fa fa-user mr-1"></i> New
                                                    Consultations</a></li>
                                            <li><a href="{{ url('PendingConsultationlist') }}"><i
                                                        class="fa fa-users mr-1"></i>
                                                    Pending Consultations</a></li>
                                            <li><a href="{{ url('AdmittedPatients') }}"><i class="fa fa-plus mr-1"></i>
                                                    Ward Round
                                                </a></li>
                                            <li><a href="{{ url('doctors', Auth::id()) }}"><i
                                                        class="fa fa-minus mr-1"></i> My Schedule/Calender
                                                </a></li>
                                            <li><a href="{{ url('BookedPatients') }}"><i class="fa fa-users mr-1"></i>
                                                    Appointments
                                                </a></li>


                                        </ul>

                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            @elseif (Auth::user()->is_admin == 21)
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Control</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <ul>
                                            <li><a href="{{ url('vitalSign') }}"><i class="fa fa-user mr-1"></i> Take
                                                    Vital Sign</a></li>
                                            <li><a href="{{ route('nurseServiceRequest') }}"><i
                                                        class="fa fa-users mr-1"></i>
                                                    Doctor Request</a></li>
                                            {{-- <li><a href="{{ url('user.index') }}"><i class="fa fa-users mr-1"></i> Old
                                                    Pateint</a></li> --}}
                                        </ul>

                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            @elseif (Auth::user()->is_admin == 22)
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Control</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <ul>
                                            <li><a href="{{ route('sales.index') }}"><i class="fa fa-user mr-1"></i> New
                                                    Requests</a></li>
                                            <li><a href="{{ route('receptionists.create') }}"><i
                                                        class="fa fa-users mr-1"></i>
                                                    Returning Pateint</a></li>
                                            <li><a href="{{ route('transactions.edit', 1) }}"><i
                                                        class="fa fa-users mr-1"></i> Today</a></li>
                                        </ul>

                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            @elseif (Auth::user()->is_admin == 23)
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Control</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <ul>
                                            <li><a href="{{ route('labs.create') }}"><i class="fa fa-user mr-1"></i> Add
                                                    Lab</a></li>
                                            <li><a href="{{ route('labs.index') }}"><i class="fa fa-users mr-1"></i>
                                                    View Labs</a></li>
                                            <li><a href="{{ route('lab-services.index') }}"><i
                                                        class="fa fa-users mr-1"></i>
                                                    View Lab Services</a></li>
                                            <li><a href="{{ route('randerServices') }}"><i class="fa fa-users mr-1"></i>
                                                    Take Sample</a></li>
                                            <li><a href="{{ route('randerResult') }}"><i class="fa fa-users mr-1"></i>
                                                    Enter Result</a></li>
                                            <li><a href="{{ route('viewResult') }}"><i class="fa fa-users mr-1"></i> View
                                                    Result</a></li>
                                        </ul>

                                    </div>

                                    <li class="nav-item">
                                        <a href="{{ route('randerServices') }}" class="nav-link">
                                            <i class="nav-icon fa fa-search"></i>
                                            <p>Take Sample</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('randerResult') }}" class="nav-link">
                                            <i class="nav-icon fa fa-search"></i>
                                            <p>Enter Result</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('viewResult') }}" class="nav-link">
                                            <i class="nav-icon fa fa-search"></i>
                                            <p>View Result</p>
                                        </a>
                                    </li>
                                    <!-- /.card-body -->
                                </div>
                            @elseif (Auth::user()->is_admin == 24)
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Control</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <ul>
                                            <li><a href="{{ route('users.create') }}"><i class="fa fa-user mr-1"></i> New
                                                    Pateint</a></li>
                                            <li><a href="{{ route('receptionists.create') }}"><i
                                                        class="fa fa-users mr-1"></i>
                                                    Returning Pateint</a></li>
                                            <li><a href="{{ url('user.index') }}"><i class="fa fa-users mr-1"></i> Old
                                                    Pateint</a></li>
                                        </ul>

                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            @endif
                            <!-- /.card -->
                        </div>
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-header p-2">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item"><a class="nav-link active" href="#activity"
                                                data-toggle="tab">Information</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#timeline"
                                                data-toggle="tab">Avatar Upload</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#settings"
                                                data-toggle="tab">Settings</a></li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="active tab-pane" id="activity">
                                            <div class="post">
                                                <div class="user-block">

                                                    <img class="img-circle img-bordered-sm" src="{!! url('storage/image/user/' . $user->filename) !!}"
                                                        alt="{{ $user->getNameAttribute() }}">
                                                    <span class="username">
                                                        <a href="#">{{ $user->getNameAttribute() }}</a>
                                                        <a href="#" class="float-right btn-tool"><i
                                                                class="fa fa-times"></i></a>
                                                    </span>
                                                    <span class="description">Shared publicly -
                                                        {{ Carbon\Carbon::now() }}</span>
                                                </div>
                                                <!-- /.user-block -->
                                                <p>
                                                <h5>About Me</h5>
                                                {!! $user->content !!}</p>

                                                <p>
                                                <div class="card-body p-0">
                                                    <table class="table">
                                                        <thead>
                                                            {{-- <tr>
                                              <th style="width: 10px">#</th>
                                              <th>Task</th>
                                              <th>Progress</th>
                                              <th style="width: 40px">Label</th>

                                          </tr> --}}
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Fullname</td>
                                                                <td>{!! $user->getNameAttribute() !!}</td>
                                                                <td>Status Category</td>
                                                                <td><span
                                                                        class="badge bg-dark">{!! $user->statuscategory->name !!}</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Email</td>
                                                                <td>{!! $user->email !!}</td>
                                                                <td>Phone Number</td>
                                                                <td><span
                                                                        class="badge bg-dark">{!! $user->phone_number !!}</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Designation</td>
                                                                <td>{!! $user->designation !!}</td>
                                                                <td>Account Status</td>
                                                                <td><span
                                                                        class="badge bg-dark">{!! $user->status->name !!}</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Role(s) Assigned</td>
                                                                <td colspan="3">
                                                                    @if (!empty($user->getRoleNames()))
                                                                        @foreach ($user->getRoleNames() as $v)
                                                                            <label
                                                                                class="badge badge-success">{{ $v }}</label>
                                                                        @endforeach
                                                                    @endif
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>Permission(s) Assigned</td>
                                                                <td colspan="3">
                                                                    @if (!empty($user->getPermissionNames()))
                                                                        @foreach ($user->getPermissionNames() as $v)
                                                                            <label
                                                                                class="badge badge-success">{{ $v }}</label>
                                                                        @endforeach
                                                                    @endif
                                                                </td>

                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                                {{-- <a href="#" class="link-black text-sm mr-2"><i class="fa fa-share mr-1"></i>
                                                    Share</a>
                                                <a href="#" class="link-black text-sm"><i class="fa fa-thumbs-up mr-1"></i>
                                                    Like</a>
                                                <span class="float-right">
                                                    <a href="#" class="link-black text-sm">
                                                        <i class="fa fa-comments mr-1"></i> Comments (5)
                                                    </a>
                                                </span>
                                                </p>

                                                <input class="form-control form-control-sm" type="text"
                                                    placeholder="Type a comment"> --}}
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="timeline">
                                            {!! Form::model($user, ['method' => 'PATCH', 'route' => ['users.updateAvatar', $user->id], 'enctype' => 'multipart/form-data']) !!}
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" value="PUT">
                                            <div class="form-group">
                                                <span class="badge badge-sm badge-dark">Current Login User Active
                                                    Image...</span>
                                                <br><br>
                                                <img src="{!! url('storage/image/user/' . $user->filename) !!}" valign="middle" width="150px"
                                                    height="120px" />
                                                <br>
                                                <hr>
                                                <span class="badge badge-sm badge-dark">Use the browse... button to pick a
                                                    new image and click on upload.</span>
                                                <hr>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            {{ Form::label('filename', 'Passport:') }}
                                                            {{ Form::file('filename') }}
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="float-right" style="border: dotted 1px 000000">
                                                                <img src="" class="float-right" id="myimg" width=80>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div class="float-right">
                                                                <button type="submit" class="btn btn-success"><i
                                                                        class="fa fa-save"></i> Upload
                                                                    Passport</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            {!! Form::close() !!}
                                        </div>


                                        <div class="tab-pane" id="settings">
                                            {!! Form::model($user, ['method' => 'PATCH', 'route' => ['users.update', $user->id], 'enctype' => 'multipart/form-data']) !!}
                                            {{ csrf_field() }}
                                            <input type="hidden" name="is_admin" value="{{ $user->is_admin }}">
                                            <div class="form-group row">
                                                <label class="control-label col-sm-2 col-form-label"
                                                    for="title">Surname:</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="surname" name="surname"
                                                        value="{!! !empty($user->surname) ? $user->surname : old('surname') !!}" autofocus>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-sm-2 col-form-label"
                                                    for="title">Firstname:</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="firstname"
                                                        name="firstname" value="{!! !empty($user->firstname) ? $user->firstname : old('firstname') !!}" autofocus>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-sm-2 col-form-label"
                                                    for="title">Othername:</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="othername"
                                                        name="othername" value="{!! !empty($user->othername) ? $user->othername : old('othername') !!}" autofocus>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="control-label col-sm-2" for="email">Email</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="email" name="email"
                                                        value="{!! !empty($user->email) ? $user->email : old('email') !!}" readonly autofocus>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-sm-2" for="phone_number">Phone</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="phone_number"
                                                        name="phone_number" value="{!! !empty($user->phone_number) ? $user->phone_number : old('phone_number') !!}" autofocus>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="url" class="col-sm-2 control-label">About Me</label>
                                                <div class="col-sm-10">
                                                    <textarea id="content" name="content" cols="30" rows="10" class="form-control" placeholder="Enter Content">
                                                    {!! !empty($user->content) ? $user->content : old('content') !!}
                                                    </textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="password" class="col-sm-2 control-label">Password</label>

                                                <div class="col-sm-10">
                                                    <input type="password" class="form-control" id="password"
                                                        name="password" placeholder="Password">
                                                </div>
                                            </div>
                                            <input type="hidden" name="visible" value="2">
                                            <div class="form-group row">
                                                <div class="offset-sm-2 col-sm-10">
                                                    <button type="submit" class="btn btn-danger"
                                                        onclick="return confirm('are you sure you wish to update your details?')">Submit</button>
                                                </div>
                                            </div>
                                            {!! Form::close() !!}
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


        </div>

    @endsection

    @section('scripts')
        <script src="{{ asset('/plugins/dataT/jQuery-3.3.1/jquery-3.3.1.min.js') }}"></script>
        <script src="{{ asset('/plugins/dataT/datatables.js') }}" defer></script>
        <script src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script>
        <script src="{{ asset('plugins/select2/select2.min.js') }}"></script>

        <script>
            $(document).ready(function() {
                $('#customers').DataTable({
                    "dom": 'Bfrtip',
                    "lengthMenu": [
                        [10, 25, 50, 100, 200, 500, 1000, -1],
                        [10, 25, 50, 100, 200, 500, 1000, "All"]
                    ],
                    "buttons": ['pageLength', 'copy', 'excel', 'pdf', 'print', 'colvis'],
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "{{ url('listCustomers') }}",
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
                            data: "phone",
                            name: "phone"
                        },
                        {
                            data: "creadit",
                            name: "creadit"
                        },
                        {
                            data: "date_line",
                            name: "date_line"
                        },

                    ],
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false
                });
                $('#productsAlert').DataTable();
                $('#productsCreate').DataTable();
            });
            $(document).ready(function() {
                // $.noConflict();
                CKEDITOR.replace('content');
                $(".select2").select2();
            });
        </script>
    @endsection
