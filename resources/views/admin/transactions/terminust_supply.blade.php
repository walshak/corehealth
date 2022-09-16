@extends('admin.layouts.admin')

@section('main-content')

	<div id="content-wrapper">
		
		<div class="content-header">
		  <div class="container-fluid">

		    <div class="row mb-2">

		      <div class="col-sm-6">
		        <h1 class="m-0 text-dark">Terminus Supply </h1>
		      </div>

		      <div class="col-sm-6">
		        <ol class="breadcrumb float-sm-right">
		          <li class="breadcrumb-item"><a href="#">Terminus  </a></li>
		          <li class="breadcrumb-item active">Supply </li>
		        </ol>
		      </div>

		    </div>
		    
		  </div>
		</div>

		<div class="container">
		    <div class="card">
            <div class="card-header">
            <h3 class="card-title">Terminus Supply</h3>
            </div>
                    
            <div class="card-body">
              <table id="products" class="table table-sm table-responsive table-bordered table-striped">
                  <thead>
                      <tr>
                      <th>SN</th>
                      <th>Product</th>
                      <th>Tranx No:</th>
                      <th>Customer</th>
                      <th>Qty</th>
                      <th>Price</th>
                      <th>Amt</th>
                      <th>Date</th>
                      <th>Store</th>
                      <th>View</th>
                  
                      </tr>
                    
                  </thead>
                  
              </table>
            </div>
			  </div>
	  </div>

        

@endsection
@section('scripts')
<!-- jQuery -->
<script src="{{ asset('plugins/jQuery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
{{-- <!-- <script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script> --> --}}
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
<!-- {{-- <script src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script> --}} -->
<!-- <script src="{{ asset('/plugins/jquery/jquery-3.3.1.min.js') }}"></script> -->
<!-- DataTables -->
<!-- <script src="{{ asset('/plugins/dataT/datatables.js') }}" defer></script> -->

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
            "url": "{{ route('listTerminustSupply') }}",
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
