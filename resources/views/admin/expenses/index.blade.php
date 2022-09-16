@extends('admin.layouts.admin')

@section('main-content')

	<div id="content-wrapper">
		<div class="content-header">
		  <div class="container-fluid">
		    <div class="row mb-2">
		      <div class="col-sm-6">
		        <h1 class="m-0 text-dark"> Expenses  </h1>
		      </div>

		      <div class="col-sm-6">
		        <ol class="breadcrumb float-sm-right">
		          <li class="breadcrumb-item"><a href="#">Home</a></li>
		          <li class="breadcrumb-item active">Today Expenses</li>
		        </ol>
		      </div>
		    </div>
		  </div>
		</div>

		<div class="container">
		    <div class="card">
	            <div class="card-header">
	              <h3 class="card-title">Expenses</h3>
	            </div>
	            <!-- /.card-header -->
	            <div class="card-body">
	              <table id="dailyExpenses" class="table table-sm table-responsive table-bordered table-striped">
	                <thead>
	                <tr>
                      <th>#</th>
                      <th>Beneficiary </th>
	                  <th>Expenses Type</th>
                      <th>Amount</th>
                      <th>Date</th>
                      <th>View </th>
	                </tr>
	                </thead>
                    <tbody>

                    </tbody>
	                <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>Total (&#8358;): <span id="total"></span></th>
                                <th></th>
                                <th></th>
                            </tr>
	                </tfoot>
	              </table>
	            </div>
	        </div>
		</div>
	</div>

@endsection

@section('scripts')
    <script src="{{ asset('../resources/assets/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('../resources/assets/js/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.6 -->
    <script src="{{ asset('../resources/assets/plugins/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>


    <!-- DataTables -->
    {{--  <script src="{{ asset('plugins/datatables2/datatables.min.js') }}"></script>  --}}
    <script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('plugins/datatables/sum().js') }}"></script>
    <script src="{{ asset('plugins/datatables/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('plugins/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('plugins/jQuery/sweetalert.min.js') }}" ></script>
    <script>


        $(document).ready(function() {
            $.noConflict();
            var dtTable = $('#dailyExpenses').DataTable({
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
                "serverSide": false,
                "ajax": {
                    "url": "{{ url('listExpenses') }}",
                    "type": "GET"
                },
                drawCallback: function () {

                    var sumTotal = $('#dailyExpenses').DataTable().column(3).data().sum();
                    $('#total').html(sumTotal);

                },
                "columns": [
                    { "data": "DT_RowIndex" },
                    { "data": "beneficiary" },
                    { "data": "expense_id" },
                    { "data": "amount" },
                    { "data": "created_at" },
                    { "data": "view" },

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
