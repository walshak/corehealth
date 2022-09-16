@extends('admin.layouts.admin')

@section('main-content')

<div id="content-wrapper">

  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Product Category </h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Product Category</li>
          </ol>
        </div>

      </div>
    </div>
  </div>

  <div class="content">

    <div class="card">
      <div class="card-header">
        {{-- <h3 class="card-title">{{ __('Product Category') }}</h3> --}}
        <div class="card-header">
          <div class="row">
            <div class="col-sm-6">
              {{ __('Product Category') }}
            </div>
            <div class="col-sm-6">
              {{-- @if(auth()->user()->can('user-create')) --}}
              <a href="{{ route('categories.create') }}" id="loading-btn" data-loading-text="Loading..."
                class="btn btn-primary btn-sm float-right">
                <i class="fa fa-gear"></i>
                New Category
              </a>
              {{-- @endif --}}
            </div>
          </div>
        </div>
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <table id="products" class="table table-sm table-responsive table-sm table-responsive table-bordered table-striped">
            <thead>
              <tr>
                <th>SN</th>
                <th>Category</th>
                <th>Category Code</th>
                <th>Status</th>
                <th>Product</th>
                <th>Edit</th>
                {{-- <th>Delete</th> --}}
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal form to delete a user -->
<div id="deleteModal" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="deleteProductCategory"
  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="deleteProductCategory">Delete Product Category</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <h4 class="text-center">Are you sure you want to delete the following category?</h4>
        <br />
        <form class="form-horizontal" role="form">
          <div class="form-group">
            <div class="col-sm-10">
              <input type="hidden" class="form-control" id="id_delete">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger delete" data-dismiss="modal">
          <span id="" class='glyphicon glyphicon-trash'></span> Delete
        </button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">
          <span class='glyphicon glyphicon-remove'></span> Close
        </button>
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
    // $.noConflict();
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
            "url": "{{ url('listCategories') }}",
            "type": "GET"
        },
        "columns": [
            { data: "DT_RowIndex", name: "DT_RowIndex" },
            { data: "category_name", name: "category_name" },
            { data: "category_code", name: "category_code" },
            { data: "status_id", name: "status_id" },
            { data: "view", name: "view" },
            { data: "edit", name: "edit" },
            // { data: "delete", name: "delete" }
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

  // Delete a User
  $(document).on('click', '.delete-modal', function() {
    // $('.modal-title').text('Delete');
    $('#id_delete').val($(this).data('id'));
    id = $('#id_delete').val();
    $('#deleteModal').modal('show');
  });
  $(document).on('click', '.delete', function(e) {
      $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'DELETE',
        url: 'categories/' + id,
      data: {
        // '_token': $('input[name=_token]').val(),
      ' id': $("#id_delete").val(),
      },
      success: function(data) {
        Swal.fire({
          position: 'top-end',
          icon: 'success',
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