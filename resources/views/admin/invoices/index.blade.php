@extends('admin.layouts.admin')

@section('main-content')
<section class="content-header">
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
</section>

<section class="content">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Details for Invoices</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <div class="table-responsive">
          <table id="products" class="table table-sm table-responsive table-bordered table-striped">
            <thead>
              <tr>
                <th>S/N</th>
                <th>Company</th>
                <th>Invoice No </th>
                <th>Invoice</th>
                <th>Product(s)</th>
                <th>Total Amount</th>
                <th>Date</th>
                <th>Visible</th>
                <th>Items</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
      <!-- /.card-body -->
    </div>
  </div>
</section>


@endsection


@section('scripts')
<!-- jQuery -->
<script src="{{ asset('plugins/jQuery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<!-- <script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script> -->
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
        "serverSide": false,
        "ajax": {
            "url": "{{ url('listInvoices') }}",
            "type": "GET"
        },
        "columns": [
            { "data": "DT_RowIndex", "name": "DT_RowIndex" },
			{ "data": "supplier_id", "name": "supplier_id" },
			{ "data": "invoice_no", "name": "invoice_no" },
			{ "data": "edit", "name": "edit" },
			{ "data": "number_of_products", "name": "number_of_products" },
			{ "data": "total_amount", "name": "total_amount" },
			{ "data": "invoice_date", "name": "invoice_date" },
			{ "data": "visible", "name": "visible" },
			{ "data": "show", "name": "show" },
			// { "data": "status", "name": "status" },
			// { "data": "created_at", "name": "created_at" },
			// { "data": "action", "name": "action" }
			
        ],
		"paging": true,
		// "lengthChange": false,
		"searching": true,
		// "ordering": true,
		// "info": true,
		// "autoWidth": false
    });
  });


  // Delete a User
  $(document).on('click', '.delete-modal', function() {
      $('.modal-title').text('Delete');
      $('#id_delete').val($(this).data('id'));
      id = $('#id_delete').val();
      // alert(id);
      console.log(id);
      $('#deleteModal').modal('show');
  });

  $(document).on('click', '.delete', function(e) {
    console.log("Delete this record");
    id = $('#id_delete').val();
    console.log(id);
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'DELETE',
        url: 'permissions/' + id,
        data: {
            // '_token': $('input[name=_token]').val(),
            'id': $("#id_delete").val()
        },
        success: function(data) {
          console.log(data);
                swal({
                    position: 'top-end',
                    type: 'success',
                    title: 'Successfully deleted your information',
                    showConfirmButton: false,
                    timer: 3000
                });
                window.location.reload();
        }
    });
  });

</script>

@endsection