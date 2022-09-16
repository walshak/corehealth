@extends('admin.layouts.admin')

@section('main-content')

	<div id="content-wrapper">
		
		<div class="content-header">
		  <div class="container-fluid">

		    <div class="row mb-2">

		      <div class="col-sm-6">
		        <h1 class="m-0 text-dark">Today Outgoing Product </h1>
		      </div>

		      <div class="col-sm-6">
		        <ol class="breadcrumb float-sm-right">
		          <li class="breadcrumb-item"><a href="#">Today </a></li>
		          <li class="breadcrumb-item active"> Outgoing Product </li>
		        </ol>
		      </div>

		    </div>
		    
		  </div>
		</div>

		<div class="container">

		    {{-- @include('admin.layouts.partials.infoBox') --}}
		    <div class="card">
                    <div class="card-header">
                    <!-- <h3 class="card-title">Data Table With Full Features</h3> -->
                    </div>
                    
                    <div class="card-body">
                     <table id="products" class="table table-sm table-responsive table-bordered table-striped">
                        <thead>
                            <tr>
                            <th>SN</th>
                            <th>Product</th>
                            <th>Tranx No</th>
                            <th>Customer Name</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Store</th>
                            <th>View</th>
                         
                            </tr>
                           
                        </thead>
                        <tfoot align="right">
               <tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tr>
              </tfoot>
                        
                    </table>
                    <button onclick="goBack()">Go Back </button> 
                    </div>
	          <!-- </div> -->
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
                 "url": "{{ route('ListOutgoing',$id) }}",
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
            { data: "sale_date", name: "sale_date" },
             { data: "store", name: "store" },
            { data: "view", name: "view" }
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
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // converting to interger to find total
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
             var quantity_buy = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

             var total_amount = api
                .column( 6 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
      
        
                    // Update footer by showing the total with the reference of the column index 
                 $( api.column( 0 ).footer() ).html('Total');
                    $( api.column( 1 ).footer() ).html('');
                    $( api.column( 2 ).footer() ).html('');
                    $( api.column( 3 ).footer() ).html('');
                    $( api.column( 4 ).footer() ).html(quantity_buy); 
                    $( api.column( 5 ).footer() ).html('');
                    $( api.column( 6 ).footer() ).html(total_amount);
                    $( api.column( 7 ).footer() ).html(''); 
                    $( api.column( 8 ).footer() ).html('');
                    $( api.column( 9 ).footer() ).html('');
              },
      "paging": true
      // "lengthChange": false,
      // "searching": true,
      // "ordering": true,
      // "info": true,
      // "autoWidth": false
    });
  });

</script>
<script>
  function goBack() {
    window.history.go(-1);
  }
</script>
@endsection


