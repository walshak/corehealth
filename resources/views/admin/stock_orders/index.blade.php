@extends('admin.layouts.admin')

@section('main-content')
 <script src="{{ asset('../resources/assets/plugins/datatables/jquery.dataTables.css') }}"></script> 
  <script src="{{ asset('../resources/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script> 

	<div id="content-wrapper">
		
		<div class="content-header">
		  <div class="container-fluid">

		    <div class="row mb-2">

		      <div class="col-sm-6">
		        <h1 class="m-0 text-dark">Incomplete Invoice List </h1>
		      </div>

		      <div class="col-sm-6">
		        <ol class="breadcrumb float-sm-right">
		          <li class="breadcrumb-item"><a href="#">Home</a></li>
		          <li class="breadcrumb-item active">Incomplete Invoice List</li>
		        </ol>
		      </div>

		    </div>
		    
		  </div>
		</div>

		<div class="container">

		    {{-- @include('admin.layouts.partials.infoBox') --}}
		    
		    <div class="card">
	            <div class="card-header">
	              <h3 class="card-title">Data Table With Full Features</h3>
	            </div>
	            <!-- /.card-header -->
	            <div class="card-body">
	              <table id="products" class="table table-sm table-responsive table-bordered table-striped">
	                <thead>
	                <tr>
	                  <th>id</th>
	                  <th>product_name</th>
	                  <th>order_quantity </th>
	                  <th>total_amount</th>
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
 {{-- <script src="{{ asset('../resources/assets/plugins/js/bootstrap.min.js') }}"></script> --}}
    {{-- <script type="text/javascript" src="{{ asset('../resources/assets/plugins/iCheck/icheck.min.js') }}"></script> --}}

    <!-- DataTables -->
   
    <script src="{{ asset('../resources/assets/plugins/datatables/dataTables.bootstrap.min.js') }}"></script> 
    {{-- <script type="text/javascript" src="{{ asset('../resources/assets/plugins/datatables2/datatables.min.js') }}"></script> --}}
    <script src="{{ asset('/plugins/jquery/jquery-3.3.1.min.js') }}"></script>
<!-- DataTables -->
    <script src="{{ asset('/plugins/dataT/datatables.js') }}" defer></script>
    <script>

<script type="text/javascript">
            var dtTable;
            ( function($) {
                $(function() {
                    $('#products').DataTable({
                        dom: 'Bfrtip',
                        buttons: [ 'copy', 'excel', 'pdf', 'print', 'colvis' ],
                        processing: true,
                        serverSide: true,
                        //ajax: ,
                           console.log(data);
                        columns: [
                            { data: 'id', name: 'id' },
                            { data: 'products_id', name: 'products_id' },
                            { data: 'order_quantity', name: 'order_quantity' },
                            { data: 'total_amount', name: 'total_amount' }
                        ]
                    });
                });
            }) ;
        
    </script>
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    
   {{--  <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
 --}}
    @endsection