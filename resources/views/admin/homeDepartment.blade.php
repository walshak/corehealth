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
                        <li class="breadcrumb-item active">Dashboard v2</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="content">
        @include('admin.layouts.partials.infoBox')
        <div class="card">
            {{-- <div class="card-header">
        <h3 class="card-title">Credit Customer (Date Line)</h3>
      </div> --}}
            <div class="card-body">
                @hasrole('Head|Secretary')
                <div class="">
                    @include('admin.layouts.partials.dashboard.departments.requisitionRequest')
                </div>
                @endhasrole
                <hr>
                {{-- @hasrole('Head|Secretary')
                <div>
                    @include('admin.layouts.partials.dashboard.admin.productReorderAlert')
                </div>
                @endhasrole --}}
            </div>
        </div>


    </div>

    @endsection

    @section('scripts')

    <script src="{{ asset('/plugins/dataT/jQuery-3.3.1/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('/plugins/dataT/datatables.js') }}" defer></script>

    <script>
        $(document).ready( function () {
            $('#customers').DataTable({
                "dom": 'Bfrtip',
                "lengthMenu": [
                [10, 25, 50, 100, 200, 500, 1000, -1],
                [10, 25, 50, 100, 200, 500, 1000, "All"]
                ],
                "buttons": [ 'pageLength', 'copy', 'excel', 'pdf', 'print', 'colvis' ],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ url('listRequestRequisition') }}",
                    "type": "GET"
                },
                "columns": [
                    { data: "DT_RowIndex", name: "DT_RowIndex" },
                    { data: "customer_id", name: "customer_id" },
                    { data: "transaction_no", name: "transaction_no" },
                    { data: "total_amount", name: "total_amount" },
                    { data: "request_date", name: "request_date" },
                    { data: "aprove_date", name: "aprove_date" },
                
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
    </script>
    @endsection