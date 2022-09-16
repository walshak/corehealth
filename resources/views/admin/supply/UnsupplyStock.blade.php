@extends('admin.layouts.admin')

@section('main-content')

	<div id="content-wrapper">

		<div class="content-header">
		  <div class="container-fluid">

		    <div class="row mb-2">

		      <div class="col-sm-6">
		        <h1 class="m-0 text-dark"> List of Unsupply stock</h1>
		      </div>

		      <div class="col-sm-6">
		        <ol class="breadcrumb float-sm-right">
		          <li class="breadcrumb-item"><a href="#">List Unsupply Stock </a></li>
		          <li class="breadcrumb-item active"> Product </li>
		        </ol>
		      </div>

		    </div>

		  </div>
		</div>

		<div class="container">

		    {{-- @include('admin.layouts.partials.infoBox') --}}
		    <div class="table-responsive">
                <div class="card">
                    <div class="card-header">
                    <h3 class="card-title">List of unsupply stock as at {!! $now !!}</h3>
                    </div>

                    <div class="card-body">
                     <table id="products" class="table table-sm table-responsive table-bordered table-striped">
                        <thead>
                            <tr>
                            <th>SN</th>
                            <th>Product</th>
                            <th>Trans</th>
                            <th>Customer</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Amt {!! NAIRA_CODE !!}</th>
                            <th>Date</th>
                            <th>Store</th>
                            <th>Cashier</th>

                            </tr>

                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                            <th colspan="4"></th>
                            <th>Total: <span id="qtytotal"></span></th>
                            <th></th>
                            <th>Total {{ NAIRA_CODE }}: <span id="subtotal"></span></th>
                            <th colspan="3"></th>
                            </tr>
                        </tfoot>
                        {{--  <tfoot align="right">
                        <tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tr>
                       </tfoot>  --}}

                    </table>
                    </div>
	          <!-- </div> -->
			</div>
            </div>
	    </div>



@endsection
@section('scripts')
{{--  <!-- jQuery -->
<script src="{{ asset('plugins/jQuery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<!-- <script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script> -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('plugins/datatables/sum().js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap4.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/buttons.colVis.min.js') }}"></script>  --}}


<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('plugins/datatables/sum().js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.select.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap4.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/buttons.colVis.min.js') }}"></script>

<script>
  $(document).ready( function () {
    $.noConflict();
    $('#products').DataTable({
        "dom": 'Bfrtip',
        "lengthMenu": [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "All"]
        ],
        "buttons": [ 'pageLength','copy', 'excel', 'pdf', 'print', 'colvis' ],
        drawCallback: function () {

            var sumTotalQty = $('#products').DataTable().column(4).data().sum();
            $('#qtytotal').html(sumTotalQty);

            var sumTotal = $('#products').DataTable().column(6).data().sum();
            $('#subtotal').html(sumTotal);

        },
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{{ url('ListTotalUnsupplyStock') }}",
            "type": "GET"
        },
        "columns": [
            { data: "DT_RowIndex", name: "DT_RowIndex" },
            { data: "product", name: "product" },
            { data: "trans", name: "trans" },
            { data: "customer", name: "customer" },
            { data: "quantity_buy", name: "quantity_buy" },
            { data: "sale_price", name: "sale_price" },
            { data: "total_amount", name: "total_amount" },
            { data: "date", name: "date" },
            { data: "store", name: "store" },
            { data: "user", name: "user" }
        ],
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
