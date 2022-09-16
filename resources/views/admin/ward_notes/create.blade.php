@extends('admin.layouts.admin')

@section('main-content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Ward/Procedure Note</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Create Ward/Procedure</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create Ward/Procedure Note - {{($dependant->fullname) ?? ''}}-{{($patient->user->surname . ' ' . $patient->user->firstname . ' ' . $patient->user->othername)}}</h3>
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

                    {!! Form::open(['method' => 'POST', 'route' => 'ward_note.store', 'class' => 'form-horizontal', 'role' => 'form','enctype' => 'multipart/form-data']) !!}
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="hidden" name="patient_id" value="{{$patient->id}}">
                        <input type="hidden" name="dependant_id" value="{{($dependant->id) ?? ''}}">
                        <label for="name" class="col-sm-12 control-label">Title/Heading(Required)</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}"
                                required autofocus placeholder="Enter Title/Heading">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="discount" class="col-12 control-label">Attach file(Optional)-pdf, jpeg, jpg, docx, png</label>
                        <div class="col-sm-12">
                            <input type="file" class="form-control" id="filename" name="filename" placeholder="Attach a file">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="desc" class="col-sm-12 control-label">Note</label>
                        <div class="col-sm-12">
                            <textarea name="note" id="note" class="form-control" cols="30" rows="10" placeholder="Enter Description">{{ old('note') }}</textarea>
                        </div>
                    </div>

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
                                    <a href="{{ route('ward_note.index') }}" class="pull-right btn btn-danger"><i
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
    </script>
@endsection
