@extends('admin.layouts.admin')

@section('main-content')


	<div id="content-wrapper">
		
		<div class="content-header">
		  <div class="container-fluid">

		    <div class="row mb-2">

		      <div class="col-sm-6">
		        <h1 class="m-0 text-dark">All Prices List </h1>
		      </div>

		      <div class="col-sm-6">
		        <ol class="breadcrumb float-sm-right">
		          <li class="breadcrumb-item"><a href="#">Home</a></li>
		          <li class="breadcrumb-item active">Prices List</li>
		        </ol>
		      </div>

		    </div>
		    
		  </div>
		</div>

		<div class="container">

		    {{-- @include('admin.layouts.partials.infoBox') --}}
		    
		    <div class="card">
	           
	            <!-- /.card-header -->
	            <div class="card-body">
                     <table id="products" class="table table-sm table-responsive table-bordered table-striped">
                        <thead>
	                <tr>
	                  <th># </th>
	                  <th>Product </th>
	                  <th>Buy price </th>
	                   <th>Sale Price</th>
	                  <th>Max Discount</th>
	                  <th>Pieces Price</th>
	                  <th>Pieces max Discount</th>
	                  <th>Initial Sale Price</th>
	                  <th>Initial Sale Date</th>
	                 
	                </tr>
	                </thead>
	               
	              </table>
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

<script>
  $(function () {
    $('#products').DataTable({
        // "dom": 'Bfrtip',
        // "buttons": [ 'copy', 'excel', 'pdf', 'print', 'colvis' ],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{{ url('listPrices') }}",
            "type": "GET"
        },
        "columns": [
            { data: "DT_RowIndex", name: "DT_RowIndex" },
            { data: "product", name: "product" },
            { data: "pr_buy_price", name: "pr_buy_price" },
            { data: "current_sale_price", name: "current_sale_price" },
            { data: "max_discount", name: "max_discount" },
            { data: "pieces_price", name: "pieces_price" }, 
            { data: "pieces_max_discount", name: "pieces_max_discount" },
            { data: "initial_sale_price", name: "initial_sale_price" }, 
            { data: "initial_sale_date", name: "initial_sale_date" }
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
      "paging": true,
      //  "lengthChange": true,
      // "searching": true,
      // "ordering": true,
      //  "info": true,
       "autoWidth": false
    });
  });

</script>
@endsection

 