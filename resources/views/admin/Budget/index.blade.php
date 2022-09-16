@extends('admin.layouts.admin')

@section('main-content')

    <div id="content-wrapper">

        <div class="content-header">
          <div class="container-fluid">

            <div class="row mb-2">

              <div class="col-sm-6">
                <h1 class="m-0 text-dark">Clients Budget List</h1>
              </div>

              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Clients Budget List</li>
                </ol>
              </div>

            </div>

          </div>
        </div>

        <div class="container">

            {{-- @include('admin.layouts.partials.infoBox') --}}
            <div class="card">
                    <div class="card-header">
                    <!-- <h3 class="card-title">Data Table With Full Features</h3> -->
                    </div>

                    <div class="card-body">
                     <table id="products" class="table table-sm table-responsive table-bordered table-striped">
                        <thead>
                            <tr>
                            <th>SN</th>
                            <th>Client</th>
                            <th>Year</th>
                            <th>Amount</th>
                            <th>Spending</th>
                            <th>Balance</th>

                            </tr>
                        </thead>
                        <tfoot>
                    <tr>
                        <th colspan="3"></th>
                        <th colspan="0">Total {{ NAIRA_CODE }}: <span id="subtotal"></span></th>

                        <th colspan="0">Total {{ NAIRA_CODE }}: <span id="subtotalSpending"></span></th>
                        <th colspan="0">Total {{ NAIRA_CODE }}: <span id="subtotalBalance"></span></th>
                 
                    </tr>
                </tfoot>
                    </table>
                    
                    </div>
              <!-- </div> -->
            </div>
        </div>


@endsection

@section('scripts')
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
{{-- <script src="{{ asset('plugins/jquery/jquery-3.5.1.js') }}"></script> --}}
<!-- Bootstrap 4 -->
<!-- <script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script> -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('plugins/datatables/sum().js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.select.min.js') }}"></script>
{{-- <script src="{{ asset('plugins/datatables/dataTables.editor.min.js') }}"></script> --}}
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
        "buttons": [ 'pageLength', 'copy', 'excel', 'pdf', 'print', 'colvis' ],
        "drawCallback": function () {

            var sumTotal = $('#products').DataTable().column(3).data().sum();
            $('#subtotal').html(sumTotal);
             var sumSpending = $('#products').DataTable().column(4).data().sum();
            $('#subtotalSpending').html(sumSpending);
            var sumBalance = $('#products').DataTable().column(5).data().sum();
            $('#subtotalBalance').html(sumBalance);

        },
        "lengthMenu": [
            [10, 25, 50, 100, 200, 500, 1000, 2000, 5000, -1],
            [10, 25, 50, 100, 200, 500, 1000, 2000, 5000, "All"]],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{{ url('listBudget') }}",
            "type": "GET"
        },
        "columns": [
            { data: "DT_RowIndex", name: "DT_RowIndex" },
            { data: "customer", name: "customer" },
            { data: "budget", name: "budget" },
            { data: "amount", name: "amount" },
            { data: "balance", name: "balance" },
            { data: "spending", name: "spending" }
        ],
       "paging": true,
       "lengthChange": false,
       "searching": true,
       "ordering": true,
       "info": true,
       "autoWidth": false
    });
  });

</script>

@endsection