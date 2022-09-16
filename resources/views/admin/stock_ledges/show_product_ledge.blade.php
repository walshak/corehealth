@extends('admin.layouts.admin')

@section('main-content')

  <div id="content-wrapper">
    
    <div class="content-header">
      <div class="container-fluid">

           <div class="row mb-2">

          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Stock Ledger </h1>
          </div>

          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Stock Ledger</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="container">

        <div class="card">
                <div class="card-header">
                <h3 class="card-title">{{ __('Stock Ledger') }}</h3>
                </div>
                <div class="card-body">
                    <table id="products" class="table table-sm table-responsive table-sm table-responsive table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Product</th>
                                <th>Date</th>
                                <th>Open</th>
                                <th>IN</th>
                                <th>OUT</th>
                                <th>Balance</th>
                                <th>Manager</th>
                                <th>View</th>
                                <th>View</th>
                            </tr>
                        </thead>
                    </table>
                       <div class="box-footer" align="center">
                                <a href="{{ route('stock-ledge.index') }}" class="btn btn-success"> Back</a>
                       {{-- <button onclick="goBack()">Go Back </button> --}}
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

<script>
  $(function () {
    $('#products').DataTable({
        "dom": 'Bfrtip',
        "lengthMenu": [
          [10, 25, 50, 100, -1],
          [10, 25, 50, 100, "All"]
        ],
        "buttons": [ 'pageLength', 'copy', 'excel', 'pdf', 'print', 'colvis' ],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{{ url('list-find-ledge', $param) }}",
            "type": "GET"
        },
        "columns": [
                    { data: "DT_RowIndex", name: "DT_RowIndex" },
                    { data: 'product', name: 'product' },
                    { data: 'ledge_date', name: 'ledge_date' },
                    { data: 'initial_balance', name: 'initial_balance' },
                    { data: 'in_coming', name: 'in_coming' },
                    { data: 'out_goin', name: 'out_goin' },
                    { data: 'Balance', name: 'Balance' },
                    { data: 'user', name: 'user' },
                    { data: 'view_incoming', name: 'view_incoming' },
                    { data: 'view_outgoing', name: 'view_outgoing' },
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
<script>
  function goBack() {
    window.history.go(-1);
  }
</script> 
@endsection
