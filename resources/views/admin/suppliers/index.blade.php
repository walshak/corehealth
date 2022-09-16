@extends('admin.layouts.admin')

@section('main-content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Suppliers</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Suppliers List</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="container">
    <div class="card border-info mb-3">
        <div class="card-header bg-transparent border-info">
            <h3 class="card-title">
                <div class="clearfix">
                    <div class="float-left">{{ __('Suppliers List') }}</div>
                    <div class="float-right">
                        {{-- <a class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="edit" href="{{ route('customers.create') }}">
                        <i class="fa fa-plus text-warning"></i> Add Customer
                        </a> --}}
                    </div>
                </div>
            </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive-sm">
                <table id="suppliers" class="table table-sm table-responsive table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Invoice</th>
                            <th>Payment</th>
                            <th>Make</th>
                            <th>Invoice </th>
                            <th class="text-center">Active</th>
                            <th>Manage</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>

@endsection
@section('scripts')


{{--  <script src="{{ asset('plugins/datatables/jquery-3.3.1.js') }}" ></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.select.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.buttons.min.js') }}"></script> --}}
{{--  <script src="{{ asset('plugins/datatables/dataTables.editor.min.js') }}"></script> --}}
<!-- jQuery -->
<script src="{{ asset('plugins/jQuery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
{{-- <script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script> --}}
{{-- <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script> --}}
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
    // jQuery.noConflict();

	jQuery(function($) {
        $('<div class="loading">Loading</div>').appendTo('body');
        
		var table = $('#suppliers').DataTable({
            "initComplete": function( settings, json ) {
                $('div.loading').remove();
            },
            dom: 'Bfrtip',
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
			],
            select: true,
			processing: true,
			serverSide: true,
			ajax: {
					"url": "{{ url('listSuppliers') }}",
					"type": "GET"
            },
            columnDefs: [ {
                orderable: false,
                //className: 'select-checkbox',
                data: null,
                defaultContent: '',
                targets:   0
            } ],
			columns: [
				{ data: 'DT_RowIndex', name: 'DT_RowIndex' },
				{ data: 'company_name', name: 'company_name' },
                { data: 'view_invoice', name: 'view_invoice' },
                { data: 'view_payment', name: 'view_payment' },
                { data: 'make_payment', name: 'make_payment' },
                { data: 'create_invoice', name: 'create_invoice' },
                { data: 'visible', name: 'visible' },
                { data: 'view', name: 'view' }

            ],
            {{--  select: {
                style:    'os',
                selector: 'td:first-child'
            },  --}}
            responsive: true,
			order: [[1, 'asc']],
			paging: true,
			lengthChange: false,
			searchable: false,
			"info": true,
            "autoWidth": false,
            buttons: [
                'pageLength',
                'copy',
                'excel',
                'pdf',
                'print',
                'colvis'
                //'selectColumns',
                //'selectCells'
                {{--  {
                    extend: 'selected', // Bind to Selected row
                    text: 'Edit',
                    name: 'edit'        // do not change name
                },  --}}
                {{--  { extend: "edit",   editor: editor },  --}}
            ]

		});

		table.on( 'order.dt search.dt', function () {
			table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
				cell.innerHTML = i+1;
			} );
        } ).draw();

        $('#ghaji tbody').on( 'click', 'tr', function () {
            $(this).toggleClass('selected');
        } );

        $('#button').click( function () {
            alert( table.rows('.selected').data().length +' row(s) selected' );
        } );

    });



      // Edit a User
  $(document).on('click', '.edit-modal', function() {
      $('.modal-title').text('Edit');
      $('#id_edit').val($(this).data('id'));
      $('#caligrapher_edit').val($(this).data('caligrapher'));
      id = $('#id_edit').val();

      // This onclick is to make sure that the checkbox is checked to Comfirm that you actually proccessed that information
      $('#caligrapher_edit').on('click', function(){
            $("#myButtonForCaligrapher").attr("disabled", !this.checked);
      });

      $('#editModal').modal('show');
  });

  $(document).on('click', '.edit', function(e) {
      {{-- console.log('me'); --}}
      $.ajax({
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          type: 'PUT',
          url: 'caligrapher/' + id,
          data: {
              'id': $("#id_edit").val(),
              'caligrapher': $('#caligrapher_edit').val(),
          },
          success: function(data) {
              $('.errorcaligrapher').addClass('hidden');
              // $('.errorGuard_name').addClass('hidden');
            console.log(data);
              if ((data.errors)) {
                    swal({
                      position: 'top-end',
                      type: 'error',
                      title: 'Oops...',
                      text: 'Validation Error!',
                      showConfirmButton: false,
                      timer: 3000
                    });

                    $('#editModal').modal('show');

                  if (data.errors.signature) {
                      $('.errorCaligrapher').removeClass('hidden');
                      $('.errorCaligrapher').text(data.errors.caligrapher);
                  }
                  // if (data.errors.permission) {
                  //     $('.errorPermission').removeClass('hidden');
                  //     $('.errorPermission').text(data.errors.permission);
                  // }

              } else {

                  swal({
                      position: 'top-end',
                      type: 'success',
                      title: 'Successfully updated your information',
                      showConfirmButton: false,
                      timer: 3000
                  });
                  window.location.reload();
              }
          }
      });
  });

	// Delete a User
	$(document).on('click', '.delete-modal', function() {
		$('.modal-title').text('Comfirmation');
		$('#id_delete').val($(this).data('id'));
		{{-- $('#caligrapher').val($(this).data('caligrapher')); --}}
		id = $('#id_delete').val();
		{{-- caligrapher = $('#caligrapher').val(); --}}
		$('#deleteModal').modal('show');
    });

	$(document).on('click', '.delete', function(e) {
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			type: 'PUT',
			url: 'caligrapher/' + id,
			data: {
				// '_token': $('input[name=_token]').val(),
				'id': $("#id_delete").val(),
				{{-- 'caligrapher': $("#caligrapher").val(), --}}
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