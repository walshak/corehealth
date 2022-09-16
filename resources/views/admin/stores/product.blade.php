@extends('admin.layouts.admin')

@section('main-content')

<div id="content-wrapper">

  <div class="content-header">
    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">
          <h1 class="m-0 text-dark">{{ $product->product_name }}</h1>
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

    {{-- @include('admin.layouts.partials.infoBox') --}}
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Stocks Location ({{ $product->product_name }}) as of {!! $now !!}</h4>
      </div>

      <div class="card-body">
        <table id="products" class="table table-sm table-responsive table-bordered table-striped">
          <thead>
            <tr>
              <th>SN</th>
              <th>Product</th>
              <th>Store</th>
              <th>Quantity</th>
              <th>Quantity Sold</th>
              <th>Issued</th>
              <th>Total</th>

            </tr>
          </thead>

        </table>
      </div>
      <!-- </div> -->
    </div>
  </div>



  @endsection
  @section('scripts')
  <!-- jQuery -->
  <script src="{{ asset('/plugins/dataT/jQuery-3.3.1/jquery-3.3.1.min.js') }}"></script>
  <!-- Bootstrap 4 -->
  <!-- DataTables -->
  <script src="{{ asset('/plugins/dataT/datatables.js') }}" defer></script>



  <script>
    $(function () {
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
            "url": "{{ route('listProductslocations',$id) }}",
            "type": "GET"
        },
        "columns": [
            { data: "DT_RowIndex", name: "DT_RowIndex" },
            { data: "product", name: "product" },
            { data: "store", name: "store" },
            { data: "current_quantity", name: "current_quantity" },
            { data: "quantity_sale", name: "quantity_sale" },
            { data: "unsupply", name: "unsupply" },
            { data: "totalQt", name: "totalQt" },

        ],

        // Update footer
        // var numFormat = $.fn.DataTable.render.number( '\,', '.', 2, '£' ).display;
        // $( api.column( 4 ).footer() ).html(
        //     'Due '+ numFormat(current_quantity)
        // );
        // $( api.column( 5 ).footer() ).html(
        //     'Paid '+ numFormat(quantity_sale)
        // );
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