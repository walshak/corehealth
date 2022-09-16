@extends('admin.layouts.admin')

@section('main-content')


<div id="content-wrapper">

	<div class="content-header">
		<div class="container-fluid">

			<div class="row mb-2">

				<div class="col-sm-6">
					<h6 class="m-0 text-dark">{!! $supplier->company_name!!} </h6>
				</div>

				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">supplier history</li>
					</ol>
				</div>

			</div>

		</div>
	</div>

	<div class="content">

		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Payment History List</h3>
			</div>
			<!-- /.card-header -->
			<div class="card-body">
				<div class="table-responsive">
					<table id="products" class="table table-sm table-responsive table-bordered table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>Supplier</th>
								<th>Transaction No: </th>
								<th>Pay Amount </th>
								<th>Mode of Payment </th>
								<th>Credit Before </th>
								<th>Deposit Before</th>
								<th>Payment Date </th>
								<th>View</th>
							</tr>
						</thead>

						<tfoot>
							<tr>
								<td colspan="2">Total Payment:

								</td>
								<td colspan="2">{!! NAIRA_CODE . "" .number_format($sum_payment,2,'.',',')!!}</td>
								<td></td>
								<td colspan="2">
									Total Supply:
								</td>
								<td colspan="2">{!! NAIRA_CODE . "" .number_format(
									$sum_supply,2,'.',',')!!}</td>
							</tr>
						</tfoot>

					</table>
				</div>
			</div>
			<!-- /.card-body -->
		</div>
		<!-- /.card -->

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
<script src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('/plugins/jquery/jquery-3.3.1.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('/plugins/dataT/datatables.js') }}" defer></script>
{{-- <script>
  $(document).ready(function() {
    $('#products').DataTable();
} );
 </script> --}}
<script>
	$(function () {
    $('#products').DataTable({
        // "dom": 'Bfrtip',
        // "buttons": [ 'copy', 'excel', 'pdf', 'print', 'colvis' ],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{{ route('listsupplierPayment',$supplier->id) }}",
            "type": "GET"
        },
        "columns": [
            
            { data: "DT_RowIndex", name: "DT_RowIndex" },
            { data: "company", name: "company" },
            { data: "transaction_id", name: "transaction_id" },
            { data: "pay_amount", name: "pay_amount" },
            { data: "mode", name: "mode" },
            { data: "credit_b4", name: "credit_b4" }, 
            { data: "deposit_b4", name: "deposit_b4" },
            { data: "transaction_date", name: "transaction_date" },
            { data: "view", name: "view" }
        ],
        
      "paging": true,
      //  "lengthChange": true,
      // "searching": true,
      // "ordering": true,
      //  "info": true,
      //  "autoWidth": false
    });
  });

</script>
@endsection