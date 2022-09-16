@extends('admin.layouts.admin')

@section('main-content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Assign Bed To Patient </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"> Assign Bed</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Assign Bed To Patient. {{ $rep->user->firstname }}
                        {{ $rep->user->surname }} As Requested By Dr. {{ $rep->doctor->user->firstname }}
                        {{ $rep->doctor->user->surname }}</h3>
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

                    {!! Form::open(['method' => 'POST', 'route' => 'assignBedPost', 'class' => 'form-horizontal', 'role' => 'form']) !!}
                    {{ csrf_field() }}
                    <div id="showAdmission">
                        <input type="hidden" value="{{$medicalReport_id}}" name="medicalReport_id" readonly>
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
                    </div>
                    <div class="card-footer bg-transparent border-info">
                        <div class="form-group row">
                            <div class="col-md-6"><a href="{{ route('listBedRequests') }}" class="btn btn-success"> <i class="fa fa-close"></i> Back</a></div>
                            <div class="col-md-6 "><button type="submit" class="btn btn-primary pull-right"> <i class="fa fa-send"></i> Submit</button></div>
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
            $('select[name="ward_id"]').on('change', function() {
                var wardID = $(this).val();
                // alert(wardID);
                if (wardID) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        url: '{{ url('/mywardAjax/ajax') }}/' + wardID,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            console.log(data);
                            $('select[name="bed_id"]').children('option:not(:first)').remove();

                            $.each(data, function(key, value) {
                                $('select[name="bed_id"]').append('<option value="' +
                                    key + '">' + value + '</option>');
                            });
                        }

                    });

                } else {

                    $('select[name="bed_id"]').children('option:not(:first)').remove();
                }

            });
        });
    </script>
@endsection
