@extends('admin.layouts.admin')

@section('main-content')


	<div id="content-wrapper">
		
		<div class="content-header">
		  <div class="container-fluid">

		    <div class="row mb-2">

		      <div class="col-sm-6">
		        <h1 class="m-0 text-dark">All Invoice List </h1>
		      </div>

		      <div class="col-sm-6">
		        <ol class="breadcrumb float-sm-right">
		          <li class="breadcrumb-item"><a href="#">Home</a></li>
		          <li class="breadcrumb-item active">{!! $company_name->company_name !!} Invoice List</li>
		        </ol>
		      </div>

		    </div>
		    
		  </div>
		</div>

		<div class="container">

		    {{-- @include('admin.layouts.partials.infoBox') --}}
		    
		    <div class="card">
	            <div class="card-header">
	              <h3 class="card-title">{!! $company_name->company_name !!} Invoice List</li></h3>
	            </div>
	            <!-- /.card-header -->
	            <div class="card-body">
	              <table id="products" class="table table-sm table-responsive table-bordered table-striped">
	                <thead>
	                <tr>
	                  <th>#</th>
	                  <th> Invoice Number </th>
	                  <th>view Invoice</th>
	                  <th> Total Products </th>
	                  <th>Total Amont</th>
	                  <th>Edit</th>
	                  <th>Date</th>
	                  
	                  
	                </tr>
	                </thead>
	                <tbody>
	                <tr>
	                @foreach($data as $datas)
	                 <th>#</th>
	                  
	                   <th>{!! $datas->invoice_no !!}</th>
	                   <th><a class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="edit" href="{{ route('print_invoice',$datas->id) }}"><i class="fa fa-eye text-warning"> </i> view Invoice</a>
	                  </th>
	                   <th>{!! $datas->number_of_products !!}</th>
	                  <th>{!! '₦'. $datas->total_amount !!}</th>
	                  <th><a class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="edit" href="{{ route('invoices.edit',$datas->id) }}"><i class="fa fa-pencil text-warning"> </i> Edit</a>
	                  <th>{!! $datas->invoice_date !!}</th>
	                 </th>
                   
	                  
	                </tr>
	                   @endforeach
	                </tbody>
	                <tfoot>
	                <tr>
	                  <th>#</th>
	                  <th> Invoice Number </th>
	                  <th>view Invoice</th>
	                  <th> Total Products</th>
	                  <th>Total Amont</th>
	                  <th>Date</th>
	                  
	                
	                  
	                </tr>
	                </tfoot>
	              </table>
	            </div>
	            <!-- /.card-body -->
	          </div>
	          <!-- /.card -->

			</div>

	</div>

@endsection
{{-- <script>
            ( function($) {
                $(function() {
                    $('#product').DataTable({
                        dom: 'Bfrtip',
                        buttons: [ 'copy', 'excel', 'pdf', 'print', 'colvis' ],
                        processing: true,
                        serverSide: true,
                        ajax: '{!! route('products.data') !!}',
                        columns: [
                            { data: 'id', name: 'id' },
                            { data: 'tin', name: 'tin' },
                            { data: 'surname', name: 'surname' },
                            { data: 'firstname', name: 'firstname' },
                            { data: 'phone_no', name: 'phone_no' },
                            { data: 'email', name: 'email' },
                            { data: 'visible', name: 'visible' },
                            { data: 'status', name: 'status' },
                            { data: 'created_at', name: 'created_at' },
                            { data: 'action', name: 'action' }
                        ]
                    });
                });
            }) ( jQuery );
        
    </script> --}}