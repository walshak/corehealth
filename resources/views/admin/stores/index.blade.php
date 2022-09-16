@extends('admin.layouts.admin')

@section('main-content')

<div id="content-wrapper">

  <div class="content-header">
    <div class="container-fluid">

      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark"> Store Setting List </h1>
        </div>

        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Store Setting List</li>
          </ol>
        </div>

      </div>

    </div>
  </div>

  <div class="container">
    <div class="card">
      <div class="card-header">
        <div class="clearfix">
          <h3 class="float-left">{{ __('Store Setting List') }}</h3>
          @can('store-create')
          <a href="{{ route('stores.create') }}" class="btn btn-primary btn-sm float-right">New Store</a>
          @endcan
        </div>


      </div>

      <div class="card-body">
        <table id="products" class="table table-sm table-responsive table-bordered table-striped">
          <thead>
            <tr>
              <th>SN</th>
              <th>Store</th>
              <th>Location</th>
              <th>Visible</th>
              <th>Edit </th>
              <th>Products</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>



  @endsection
  @section('scripts')
  <!-- jQuery -->
  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <!-- Bootstrap 4 -->
  <!-- <script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script> -->
  <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- DataTables -->
  <script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
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
         [10, 25, 50, 100, 200, 300, 500, 1000, 2000, 3000, 5000, -1],
         [10, 25, 50, 100, 200, 300, 500, 1000, 2000, 3000, 5000, "All"]
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
            "url": "{{ url('listStores') }}",
            "type": "GET"
        },
        "columns": [
            { data: "DT_RowIndex", name: "DT_RowIndex" },
            { data: "store_name", name: "store_name" },
            { data: "location", name: "location" },
            { data: "visible", name: "visible" },
            { data: "edit", name: "edit" },
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