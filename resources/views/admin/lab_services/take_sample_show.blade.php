@extends('admin.layouts.admin')

@section('main-content')
    <div id="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">

                <div class="row mb-2">

                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Patient lab Sample Request</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">New Sample Request</li>
                        </ol>
                    </div>

                </div>

            </div>
        </div>
        <div class="row justify-content-center">


        </div>
        <div class="container">

            <div class="card">
                <div class="card-header">
                    <a href="{{route('randerServices')}}" class="btn btn-danger" style="float: right;"> <i class="fa fa-arrow-left"></i> Back
                    </a>
                    <h3 class="card-title">Requested Service List (
                        {{($lab_requests[0]->dependant_id) ? dependantfullname($lab_requests[0]->dependant_id): userfullname($lab_requests[0]->patient_user_id)}} - {{showFileNumber($lab_requests[0]->patient_user_id)}} )</h3>
                </div>

                <div class="card-body">
                    <form action="{{route('takeSample')}}" method="post" id="takeSampleForm">
                        @csrf
                        <div class="form-group">
                            @foreach ($lab_requests  as $lab_request)
                                <label for="{{$lab_request->lab_service->lab_service_name}}">{{$lab_request->lab_service->lab_service_name}}</label>
                                <input type="checkbox" name="lab_services[]" value="{{$lab_request->id}}" id="{{$lab_request->lab_service->lab_service_name}}"> &nbsp; &nbsp;
                            @endforeach
                        </div>
                        <input type="hidden" name="reject_selected" id="reject_selected" value="">
                        <hr>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-disk"></i>Sample taken</button>
                        <button type="button" class="btn btn-danger" id="decline_selected" style="float: right;"><i class="fa fa-disk"></i>Decline Selected</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- jQuery -->
    <script src="{{ asset('/plugins/dataT/jQuery-3.3.1/jquery-3.3.1.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <!-- DataTables -->
    <script src="{{ asset('/plugins/dataT/datatables.js') }}" defer></script>

    <script src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script>

    <script>
        $('#decline_selected').on('click', function(){
            if(confirm('Are you sure you wish to decline the selected lab requests? You cannot undo this...!')){
                $('#reject_selected').val('1');
                $('#takeSampleForm').submit();
            }
        });
    </script>
@endsection
