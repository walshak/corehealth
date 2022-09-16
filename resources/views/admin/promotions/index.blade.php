@extends('admin.layouts.admin')

@section('main-content')

	<div id="content-wrapper">
		
		<div class="content-header">
		  <div class="container-fluid">

		    <div class="row mb-2">

		      <div class="col-sm-6">
		        <h1 class="m-0 text-dark">Promotion List </h1>
		      </div>

		      <div class="col-sm-6">
		        <ol class="breadcrumb float-sm-right">
		          <li class="breadcrumb-item"><a href="#">Home</a></li>
		          <li class="breadcrumb-item active">Promotion List</li>
		        </ol>
		      </div>
		    </div>
		    
		  </div>
		</div>

		<div class="container">

		    <div class="card">
                <div class="card-header">
                <a href="{{ route('promotion.create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Promotion</a>
                </div>
                
                <div class="card-body">
                    <table id="products" class="table table-sm table-responsive table-sm table-responsive table-bordered table-striped">
                        <thead>
                            <tr>
                            <th>SN</th>
                            <th>Product</th>
                            <th>Promo</th>
                            <th>Visible</th>
                            <th>Quantity </th>
                            <th>Gives Quantity </th>
                            <th>Current Quantity </th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Edit</th>
                            <th>Transaction</th>
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
        // "dom": 'Bfrtip',
        // "buttons": [ 'copy', 'excel', 'pdf', 'print', 'colvis' ],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{{ url('listPromotion') }}",
            "type": "GET"
        },
        "columns": [
            { data: "DT_RowIndex", name: "DT_RowIndex" },
            { data: "product", name: "product" },
            { data: "promotion_name", name: "promotion_name" },
            { data: "visible", name: "visible" },
            { data: "promotion_total_quantity", name: "promotion_total_quantity" },
            { data: "give_qt", name: "give_qt" },
            { data: "current_qt", name: "current_qt" },
            { data: "start_date", name: "start_date" }, 
            { data: "end_date", name: "end_date" },
            { data: "edit", name: "edit" },
            { data: "trans", name: "trans"}
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