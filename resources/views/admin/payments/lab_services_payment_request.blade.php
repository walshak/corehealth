@extends('admin.layouts.admin')

@section('main-content')

	<div id="content-wrapper">

		<div class="content-header">
		  <div class="container-fluid">

		    <div class="row mb-2">

		      <div class="col-sm-6">
		        <h1 class="m-0 text-dark">New Patients </h1>
		      </div>

		      <div class="col-sm-6">
		        <ol class="breadcrumb float-sm-right">
		          <li class="breadcrumb-item"><a href="#">Home</a></li>
		          <li class="breadcrumb-item active">New Patients</li>
		        </ol>
		      </div>

		    </div>

		  </div>
		</div>

		<div class="container">

		    <div class="card">
                <div class="card-header">
                <h3 class="card-title">{{ __('New Patients') }}</h3>
                </div>

                <div class="card-body">
                    <table id="products" class="table table-sm table-responsive table-sm table-responsive table-bordered table-striped">
                        <thead>
                            <tr>
                              <th># </th>
		                      <th>Fullname</th>
		                      <th>Phone  </th>
		                      <th>Email</th>
		                      <th>Date</th>
		                      <th>Pay For Registration</th>
                            </tr>
                        </thead>
                    </table>
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
            "url": "{{ url('listNewPatients') }}",
            "type": "GET"
        },
        "columns": [
            { data: "DT_RowIndex", name: "DT_RowIndex" },
            { data: "fullname", name: "fullname" },
            { data: "phone_number", name: "phone_number" },
            { data: "email", name: "email" },
            { data: "created_at", name: "created_at" },
            { data: "payment", name: "payment" }
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
