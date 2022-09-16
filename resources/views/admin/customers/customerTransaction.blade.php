@extends('admin.layouts.admin')

@section('main-content')


<div id="content-wrapper">

	<div class="content-header">
		<div class="container-fluid">

			<div class="row mb-2">
				<div class="col-sm-6">
					<h3 class="m-0 text-dark">Client Transactions History</h3>
				</div>

				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Client history</li>
					</ol>
				</div>

			</div>

		</div>
	</div>

	<div class="content">

		{{-- @include('admin.layouts.partials.infoBox') --}}

		<div class="card">
			<div class="card-header">
				<h3 class="card-title">{!! $customers!!} Transactions History</h3>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="products" class="table table-sm table-responsive table-bordered table-striped">
						<thead>
							<tr>
								<th>#</th>
								{{-- <th>Type </th> --}}
								<th>SIV No. </th>
								<th>Amount </th>
								<th>BudgetYear </th>
								<th>Date </th>
								<th>Credit Before </th>
								<th>Credit </th>
								<th>Deposit Before</th>
								<th>Deposit </th>
								<th>Voucher</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
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
            "url": "{{ route('listcustomerTransaction',$id) }}",
            "type": "GET"
        },
        "columns": [

			{ data: "DT_RowIndex", name: "DT_RowIndex" },
			// { data: "transaction_type", name: "transaction_type" },
            { data: "transaction_no", name: "transaction_no" },
            
            { data: "total_amount", name: "total_amount" },
			{ data: "budgetYear", name: "budgetYear" },
			{ data: "tr_date", name: "tr_date" },
            { data: "credit_b4", name: "credit_b4" },
            { data: "current_credit", name: "current_credit" },
            { data: "deposit_b4", name: "deposit_b4" },
            { data: "current_deposit", name: "current_deposit" },
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