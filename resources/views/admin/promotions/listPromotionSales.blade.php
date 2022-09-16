@extends('admin.layouts.admin')

@section('main-content')

	<div id="content-wrapper">
		
		<div class="content-header">
		  <div class="container-fluid">

		    <div class="row mb-2">

		      <div class="col-sm-6">
		        <h1 class="m-0 text-dark">{{$promotion->promotion_name}} </h1>
		      </div>

		      <div class="col-sm-6">
		        <ol class="breadcrumb float-sm-right">
		          <li class="breadcrumb-item"><a href="#">Home</a></li>
		          <li class="breadcrumb-item active">Promotion List</li>
		        </ol>
		      </div>
               <div class="box-footer" align="float-sm-right">
                                <a href="{{ route('promotion.index') }}" class="btn btn-success"><i class="fa fa-hand-left"></i> Back</a>
                   </div>

		    </div>
		    
		  </div>
		</div>

		<div class="container">

		    <div class="card">
                <div class="card-header">
                <!-- <h3 class="card-title">Data Table With Full Features</h3> -->
                </div>
                
                <div class="card-body">
                    <table id="products" class="table table-sm table-responsive table-sm table-responsive table-bordered table-striped">
                        <thead>
                            <tr>
                            <th>SN</th>
                            <th>Product</th>
                            <th>Transaction</th>
                            <th>Quantity </th>
                            <th>Gives Quantity </th>
                            <th>Total Amount </th>
                            <th>Date</th>
                            <th>View</th>
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
            "url": "{{ route('listPromotionSales',$id) }}",
            "type": "GET"
        },
        "columns": [
            { data: "DT_RowIndex", name: "DT_RowIndex" },
            { data: "product", name: "product" },
            { data: "transaction", name: "transaction" },
            { data: "quantity_buy", name: "quantity_buy" },
            { data: "quantity_give", name: "quantity_give" },
            { data: "total_amount", name: "total_amount" },
            { data: "created_at", name: "created_at" },
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