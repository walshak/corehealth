@extends('admin.layouts.admin')

@section('main-content')

	<div id="content-wrapper">

		<div class="content-header">
		  <div class="container-fluid">

		    <div class="row mb-2">

		      <div class="col-sm-6">

		      </div>

		      <div class="col-sm-6">
		        <ol class="breadcrumb float-sm-right">
		          <li class="breadcrumb-item"><a href="#">Traansactions </a></li>
		          <li class="breadcrumb-item active">Today Traansactions </li>
		        </ol>
		      </div>

		    </div>

		  </div>
		</div>

		<div class="container">
		    <div class="card">
          <div class="card-header">
            <h3 class="card-title">Data Table With Full Features</h3>
          </div>

          <div class="card-body">
            <table id="transactions" class="table table-sm table-responsive table-bordered table-striped">
              <thead>
                  <tr>
                    <th>SN</th>
                    <th>SIV No</th>
                    <th>Type</th>
                    <th>Client</th>
                    <th>Total Amount</th>
                    <th>View</th>
                  </tr>
              </thead>
            </table>
          </div>
	      </div>
    </div>
	</div>

        <?php $id = 1;?>

@endsection

@section('scripts')
<!-- jQuery -->
<script src="{{ asset('/plugins/dataT/jQuery-3.3.1/jquery-3.3.1.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('/plugins/dataT/datatables.js') }}" defer></script>

<script>
  $(document).ready( function () {
    // $.noConflict();
    $('#transactions').DataTable({
        // "dom": 'Bfrtip',
        // "buttons": [ 'copy', 'excel', 'pdf', 'print', 'colvis' ],
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{{ url('daylistTransactions') }}",
            "type": "GET"
        },
        "columns": [
            { data: "DT_RowIndex", name: "DT_RowIndex" },
            { data: "transaction_no", name: "transaction_no" },
            { data: "transaction_type", name: "transaction_type" },
            { data: "customer_name", name: "customer_name" },
            { data: "total_amount", name: "total_amount" },
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
