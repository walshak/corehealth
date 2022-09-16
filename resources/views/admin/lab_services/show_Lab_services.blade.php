@extends('admin.layouts.admin')

@section('main-content')

	<div id="content-wrapper">

		<div class="content-header">
		  <div class="container-fluid">

		    <div class="row mb-2">

		      <div class="col-sm-6">
		        <h1 class="m-0 text-dark">{{ $lab->lab_name }} List of Services</h1>
		      </div>

		      <div class="col-sm-6">
		        <ol class="breadcrumb float-sm-right">
		          <li class="breadcrumb-item"><a href="#">Home</a></li>
		          <li class="breadcrumb-item active">List of Services</li>
		        </ol>
		      </div>

		    </div>

		  </div>
		</div>

		<div class="content">
		    <div class="card">
                <div class="card-header">
                   <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="float-left">
                                <h3 class="card-title"> <span class="badge badge-dark">{{ $lab->lab_name }}</span></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                          <div class="float-right">
                            @if(auth()->user()->can('user-create'))
                                <a href="{{ route('lab-services.show',$lab->id) }}" id="loading-btn" data-loading-text="Loading..." class="btn btn-primary" >
                                    <i class="fa fa-home"></i>
                                    {{'Create New Service'}}
                                </a>
                            @endif
                          </div>
                      </div>
                  </div>
                </div>
                </div>

                <div class="card-body">
                    <table id="products" class="table table-sm table-responsive table-sm table-responsive table-bordered table-striped">
                        <thead>
                            <tr>
                            <th>SN</th>
                            <th>Service</th>
                            <th>Description</th>
                            <th>Visible</th>
                            <th>Edit</th>
                            <th>Assign Price</th>
                            </tr>
                        </thead>
                    </table>
                </div>
	       </div>
		</div>
	</div>

    <!-- medium modal -->
    <div id="mediumModal" class="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Add/Edit Price') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {!! Form::open(array('route' => 'payment-item.store', 'method'=>'POST', 'class' => 'form-horizontal' )) !!}
                <div class="modal-body">
                    {{ csrf_field() }}
                    <input type="hidden" name="payment_type_id" value="3">
                    <div class="card-header bg-transparent border-info">{{ __('New Payment item ') }}</div>
                        <div class="card-body">

                            <div class="form-group row">
                                <label class="control-label col-sm-3" for="item_name">Item Name</label>
                                <div class="col-sm-9">

                                    <input type="text" id="item_name" class="form-control" name="item_name" value="" readonly="1">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-sm-3" for="description">Description</label>
                                <div class="col-sm-9">

                                    <input id="description" type="text" class="form-control" name="description" value="{{ old('description') }}" placeholder="description">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-sm-3" for="description">Amount</label>
                                <div class="col-sm-9">
                                        <input id="amount" type="text" class="form-control" name="amount" value="{{ old('amount') }}" placeholder="Add Price {{ NAIRA_CODE }}">
                                    </div>
                                </div>
                            </div>
                        {{-- </div> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<!-- jQuery -->
<script src="{{ asset('/plugins/dataT/jQuery-3.3.1/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('/plugins/dataT/datatables.js') }}" ></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.maskMoney.js') }}"></script>
<script>
    $("#amount");
</script>

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
            "url": "{{ url('listShowLabServices', $lab->id) }}",
            "type": "GET"
        },
        "columns": [
            { data: "DT_RowIndex", name: "DT_RowIndex" },
            { data: "lab_service_name", name: "lab_service_name" },
            { data: "description", name: "description" },
            { data: "visible", name: "visible" },
            { data: "edit", name: "edit" },
            { data: "price", name: "price" }
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
    $(document).on('click', '#mediumButton', function(event) {
            event.preventDefault();
            let href = $(this).attr('data-attr');
            var item_name =  $(this).attr('data-attr');
            $('#item_name').val(item_name);
            $('#description').val(item_name);
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
<style>
    .footer {
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        background-color: #9C27B0;
        color: white;
        text-align: center;
    }
    body {
        background-color: #EDF7EF
    }

</style>
@endsection
