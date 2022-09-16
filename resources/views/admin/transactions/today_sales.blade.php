@extends('admin.layouts.admin')

@section('main-content')

	<div id="content-wrapper">
		<div class="content-header">
		  <div class="container-fluid">
		    <div class="row mb-2">
		      <div class="col-sm-6">
		        <h1 class="m-0 text-dark">Todays Transaction </h1>
		      </div>

		      <div class="col-sm-6">
		        <ol class="breadcrumb float-sm-right">
		          <li class="breadcrumb-item"><a href="#">Traansactions </a></li>
		          <li class="breadcrumb-item active">Todays Transaction </li>
		        </ol>
		      </div>

		    </div>

		  </div>
		</div>

		<div class="container">
		    <div class="card">
          <div class="card-header">
              <h3 class="card-title">Todays Transaction</h3>
          </div>

                    <div class="card-body">
                     <table id="products" class="table table-sm table-responsive table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>SN</th>
                            <th>SIV No</th>
                            <th>Client Name</th>
                            <th>Type</th>
                            <th>Payment Mode</th>
                            <th>Total Amount</th>
                            <th>Store</th>
                            <th>Voucher</th>
                          </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th colspan="2" style="text-align:left">Total Transactions:</th>
                                <th colspan="2" >{{ NAIRA_CODE }}  {!! number_format( $sum,2,'.',',') !!}</th>
                                <th colspan="2" style="text-align:left">Total Issued:  </th>
                                <th colspan="2" >{{ NAIRA_CODE }}  {!! number_format( $sales,2,'.',',') !!}</th>
                            </tr>

                            {{-- 
                            <tr>
                                <th colspan="2" style="text-align:left">Total Customers Payment to Account:</th>
                                <th colspan="2">{!! number_format( $sumpayment,2,'.',',') !!}</th>
                                <th colspan="2" style="text-align:left">Total Cash:</th>
                                <th colspan="2">{!!number_format( $sumCash,2,'.',',')!!}</th>

                            </tr> --}}

                            {{-- <tr>
                                <th colspan="2" style="text-align:left">Total Bank Payment:</th>
                                <th colspan="2">  {!! NAIRA_CODE . " ". number_format( $sumbank,2,'.',',') !!}</th>
                                <th colspan="2" style="text-align:left">Total Borrow:</th>
                                <th colspan="2">  {!! NAIRA_CODE . " ". number_format( $sumBorrow,2,'.',',') !!}</th>
                            </tr> --}}

                            <tr>
                                <th colspan="2" style="text-align:left">Total Expenses:</th>
                                <th colspan="2">  {!! NAIRA_CODE . " ". number_format( $sumexpense,2,'.',',')!!}</th>
                                <th colspan="2" style="text-align:left">Total Gain:</th>
                                <th colspan="2">  {!! NAIRA_CODE . " ". number_format( $sumgain,2,'.',',') !!}</th>
                            </tr>

                            {{-- <tr>
                                <th colspan="2" style="text-align:left">Total Cash at Hand:</th>
                                <th colspan="2">  {!! NAIRA_CODE . " ". number_format( $cash_at_hand,2,'.',',') !!}</th>
                                <th colspan="2" style="text-align:left"></th>
                                <th colspan="2">  </th>
                            </tr> --}}
                        </tfoot>


                    </table>
                    </div>
	          <!-- </div> -->
			</div>
	    </div>



@endsection
@section('scripts')
<!-- jQuery -->
{{--  <script src="{{ asset('/plugins/dataT/jQuery-3.3.1/jquery-3.3.1.min.js') }}"></script>  --}}
<!-- DataTables -->
{{--  <script src="{{ asset('/plugins/dataT/datatables.js') }}" defer></script>  --}}

<!-- jQuery -->
<script src="{{ asset('plugins/jQuery/jquery.min.js') }}"></script>
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
            "url": "{{ url('listTransactions') }}",
            "type": "GET"
        },
        "columns": [
            { data: "DT_RowIndex", name: "DT_RowIndex" },
            { data: "transaction_no", name: "transaction_no" },
            { data: "customer_name", name: "customer_name" },
            { data: "transaction_type", name: "transaction_type" },
            { data: "mode", name: "mode" },
            { data: "total_amount", name: "total_amount" },
            { data: "store_id", name: "store_id" },
            { data: "view", name: "view" }
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
