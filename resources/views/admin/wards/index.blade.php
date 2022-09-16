@extends('admin.layouts.admin')

@section('main-content')

	<div id="content-wrapper">

		<div class="content-header">
		  <div class="container-fluid">

		    <div class="row mb-2">

		      <div class="col-sm-6">
		        <h1 class="m-0 text-dark">wards </h1>
		      </div>

		      <div class="col-sm-6">
		        <ol class="breadcrumb float-sm-right">
		          <li class="breadcrumb-item"><a href="#">Home</a></li>
		          <li class="breadcrumb-item active">wards</li>
		        </ol>
		      </div>

		    </div>

		  </div>
		</div>

		<div class="container">
          <div class="card-header">
            @if(auth()->user()->can('user-create'))
                <a href="{{ route('wards.create') }}" id="loading-btn" data-loading-text="Loading..." class="btn btn-primary" >
                    <i class="fa fa-home"></i>
                    Create New ward
                </a>
            @endif
        </div>
		    <div class="card">
                <div class="card-header">
                <h3 class="card-title">{{ __('wards') }}</h3>
                </div>

                <div class="card-body">
                    <table id="products" class="table table-sm table-responsive table-sm table-responsive table-bordered table-striped">
                        <thead>
                            <tr>
                            <th>SN</th>
                            <th>ward</th>
                            <th>Description</th>
                            <th>Visible</th>
                            <th>View Beds</th>
                            <th>Add Bed</th>
                            <th>Bed Price</th>
                            <th>Edit</th>
                            </tr>
                        </thead>
                    </table>
                </div>
	       </div>
		</div>
	</div>
    <!-- medium modal -->
     <!-- small modal -->
    <div class="modal fade" id="smallModal" tabindex="-1" role="dialog" aria-labelledby="smallModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="smallBody">
                  {!! Form::open(array('route' => 'bedPrice', 'method'=>'POST', 'class' => 'form-horizontal' )) !!}
                {{ csrf_field() }}
                       
            <div class="card-header bg-transparent border-info">{{ __('New Payment item ') }}</div>
            <div class="card-body">
                        <input type="hidden" name="payment_type_id" value="2">
                    <div class="form-group row">
                      
                        <div class="col-sm-">
                            Payment Item
                            <input type="text" id="item_name" class="form-control" name="item_name" value="" readonly="1">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-">
                            Description
                            <input id="description" type="text" class="form-control" name="description" value="{{ old('description') }}" placeholder="description">
                        </div>
                    </div> 
                    <div class="form-group row">
                       
                       <div class="col-sm-">
                        Public Bed Amount
                            <input id="public_amount" type="text" class="form-control" name="public_amount" value="0" placeholder="public_amount">
                        </div>
                    </div>
                    <div class="form-group row">
                       
                       <div class="col-sm-">
                        Private Bed Amount
                            <input id="private_amount" type="text" class="form-control" name="private_amount" value="0" placeholder="private_amount">
                        </div>
                    </div>

                  

            </div>
            <div class="card-footer bg-transparent border-info">
                <div class="form-group row">
                    <div class="col-md-6"><a href="{{ route('payment-item.index') }}" class="btn btn-success"> <i class="fa fa-close"></i> Back</a></div>
                    <div class="col-md-6 "><button type="submit" class="btn btn-primary pull-right"> <i class="fa fa-send"></i> Submit</button></div>
                </div>
            </div>
                </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header"> 
                     <div class="card border-info mb-6">
        {!! Form::open(array('route' => 'beds.store', 'method'=>'POST', 'class' => 'form-horizontal' )) !!}
                {{ csrf_field() }}
               
            <div class="card-header bg-transparent border-info">{{ __('Create New Bed for ') }}</div>
            <div class="card-body">
                        <input type="hidden" name="payment_type_id" value="3">
                    <div class="form-group row">
                      
                        <div class="col-sm-">
                       
                            <input type="text" id="ward_id" class="form-control" name="ward_id" value="" readonly="1">
                        </div>
                    </div>

                    
                    <div class="form-group row">
                       
                       <div class="col-sm-">
                        Enter  Number of Public Beds 
                            <input id="p_bed_no" type="text" class="form-control" name="p_bed_no" value="0" placeholder="Public Number">
                        </div>
                    </div> 
                    <div class="form-group row">
                       
                       <div class="col-sm-">
                        Enter  Number of Private Beds 
                            <input id="pr_bed_no" type="text" class="form-control" name="pr_bed_no" value="0" placeholder="Private Number">
                        </div>
                    </div>

                  

            </div>
            <div class="card-footer bg-transparent border-info">
                <div class="form-group row">
                    <div class="col-md-6"><a href="{{ route('payment-item.index') }}" class="btn btn-success"> <i class="fa fa-close"></i> Back</a></div>
                    <div class="col-md-6 "><button type="submit" class="btn btn-primary pull-right"> <i class="fa fa-send"></i> Submit</button></div>
                </div>
            </div>
        {!! Form::close() !!}

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
               
    </div>
                </div>
                <div class="modal-body" id="mediumBody">
                    <div>
   <!-- the result to be displayed apply here -->
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
            "url": "{{ url('listWards') }}",
            "type": "GET"
        },
        "columns": [
            { data: "DT_RowIndex", name: "DT_RowIndex" },
            { data: "ward_name", name: "ward_name" },
            { data: "description", name: "description" },
            { data: "visible", name: "visible" },
            { data: "viewBeds", name: "viewBeds" },
            { data: "addBed", name: "addBed" },
            { data: "price", name: "price" },
            { data: "edit", name: "edit" }
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
    $(document).on('click', '#smallButton', function(event) {
            event.preventDefault();
            let href = $(this).attr('data-attr');
            var item_name =  $(this).attr('data-attr');
             $('#item_name').val(item_name);
            $('#description').val(item_name);
            $.ajax({
                url: href,
                beforeSend: function() {
                    $('#loader').show();
                },
                // return the result
                success: function(result) {
                    $('#smallModal').modal("show");
                    $('#smallBody').html(result).show();
                },
                complete: function() {
                    $('#loader').hide();
                },
                // error: function(jqXHR, testStatus, error) {
                //     console.log(error);
                //     alert("Page " + href + " cannot open. Error:" + error);
                //     $('#loader').hide();
                // },
                timeout: 8000
            })
        });
   $(document).on('click', '#mediumButton', function(event) {
            event.preventDefault();
            let href = $(this).attr('data-attr');
            var ward_id =  $(this).attr('data-attr');
            $('#ward_id').val(ward_id);
            //alert(id)
            $.ajax({
                beforeSend: function() {
                    $('#loader').show();
                },
                // return the result
                success: function(result) {
                    $('#mediumModal').modal("show");
                    $('#mediumBody').html(result).show();
                },
                complete: function() {
                    $('#loader').hide();
                },
                error: function(jqXHR, testStatus, error) {
                    console.log(error);
                    alert("Page " + href + " cannot open. Error:" + error);
                    $('#loader').hide();
                },
                timeout: 8000
            })
        });
</script>
@endsection
