@extends('admin.layouts.admin')

@section('main-content')

<div id="content-wrapper">

  <div class="content-header">
    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">
          <h2 class="m-0 text-dark"> List of Product in {{ $store->store_name }}</h2>
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
        <h3 class="card-title">List of Product in {{$store->store_name}} As on {!!$now !!}</h3>
      </div>

      <div class="card-body">
        <table id="products" class="table table-sm table-responsive table-bordered table-striped">
          <thead>
            <tr>
              <th>SN</th>
              <th>Product</th>
              <th>Current Quantity</th>
              <th>Quantity Sold</th>
              <th>Unsupply</th>
              <th>total</th>
              <th>Transfer Product</th>

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
        // "dom": 'Bfrtip',
        // "buttons": [ 'copy', 'excel', 'pdf', 'print', 'colvis' ],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{{ route('listStoresProducts',$id) }}",
            "type": "GET"
        },
        "columns": [
            { data: "DT_RowIndex", name: "DT_RowIndex" },
            { data: "product", name: "product" },
            { data: "current_quantity", name: "current_quantity" },
            { data: "quantity_sale", name: "quantity_sale" },
            { data: "unsupply", name: "unsupply" },
            { data: "totalQt", name: "totalQt" },
            { data: "movestock", name: "movestock" }
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