@extends('admin.layouts.admin')

@section('styles')
    <link href="{{ asset('plugins/datatables/jquery.dataTables.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/datatables/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/datatables/select.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/datatables/editor.dataTables.min.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('main-content')


<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>List of Customers</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">List of Customers</li>
        </ol>
      </div>
    </div>
  </div>
</section>


<section class="container">
    <div class="card border-info mb-3">
        <div class="card-header bg-transparent border-info">
            <h3 class="card-title">

                <div class="clearfix">
                    <div class="float-left">{{ __('List of Customers') }}</div>
                    <div class="float-right">
                        <a class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="edit" href="{{ route('customers.create') }}">
                            <i class="fa fa-plus text-warning"></i> Add Customer
                        </a>
                    </div>
                </div>
            </h3>
        </div>
        <div class="card-body">
                <div class="table-responsive">
                    <table id="products" class="table table-sm table-responsive table-bordered table-striped">
                        <thead>
                            <tr>
                            <th>S/N</th>
                            <th>Name</th>
                            <th>Phone </th>
                            <th>Credit</th>
                            <th>Deposit</th>
                            <th>Tranx</th>
                            <th>Payment</th>
                            <th>Borrow</th>
                            <th>Dateline</th>
                            <th>View</th>
                            </tr>
                        </thead>
                    </table>
                </div>
        </div>
    </div>
</section>



@endsection

@section('scripts')
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
{{-- <script src="{{ asset('plugins/jquery/jquery-3.5.1.js') }}"></script> --}}
<!-- Bootstrap 4 -->
<!-- <script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script> -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.select.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.editor.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap4.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/buttons.colVis.min.js') }}"></script>

<script>
  $(function () {
    $.noConflict();
    $('#products').DataTable({
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
                buttons: [
                    {
                        text: 'Toggle start date',
                        action: function ( e, dt, node, config ) {
                            dt.column( -2 ).visible( ! dt.column( -2 ).visible() );
                        }
                    },
                    {
                        text: 'Toggle salary',
                        action: function ( e, dt, node, config ) {
                            dt.column( -1 ).visible( ! dt.column( -1 ).visible() );
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
            "url": "{{ url('listCustomers') }}",
            "type": "GET"
        },
        "columns": [
            { data: "DT_RowIndex", name: "DT_RowIndex" },
            { data: "fullname", name: "fullname" },
            { data: "phone", name: "phone" },
            { data: "creadit", name: "creadit" },
            { data: "deposit", name: "deposit" },
            { data: "trans", name: "trans" },
            { data: "payment", name: "payment" },
            { data: "borrow", name: "borrow" },
            { data: "dateline", name: "dateline" },
            { data: "view", name: "view" }
        ],
        // initComplete: function () {
        //     this.api().columns().every(function () {
        //         var column = this;
        //         var input = document.createElement("input");
        //         $(input).appendTo($(column.footer()).empty())
        //         .on('change', function () {
        //             column.search($(this).val(), false, false, true).draw();
        //         });
        //     });
        // },
      "paging": true
      // "lengthChange": false,
      // "searching": true,
      // "ordering": true,
      // "info": true,
      // "autoWidth": false
    });
  });

</script>
@endsection

