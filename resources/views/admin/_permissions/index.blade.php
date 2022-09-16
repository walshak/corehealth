@extends('admin.layouts.admin')

@section('main-content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Permission Management</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Permission Management</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

 <section class="content">

    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Permission Management</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="pull-right">
            <button type="button" class="add-modal btn btn-primary">New Permission</button>
          </div>
          
          <table id="ghaji" class="table table-sm table-responsive table-bordered table-striped display">
            <thead>
            <tr>
              <th>Name</th>
              <th>Guard Name</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
            </thead>
            
          </table>
        </div>
      </div>
      
    </div>

</section>

<!-- Modal form to add a user -->
<div id="addModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">   
          <form class="form-horizontal" role="form" id="myForm">
            {{ csrf_field() }}
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="Enter Name">
                  <div class="errorName text-center alert alert-danger hidden" role="alert"></div>
                </div>
              </div>
          </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success add" data-dismiss="modal">
                <span id="" class='glyphicon glyphicon-check'></span> Add
            </button>
            <button type="button" class="btn btn-warning" data-dismiss="modal">
                <span class='glyphicon glyphicon-remove'></span> Close
            </button>
        </div>
      </div>
    </div>
</div>

<!-- Modal form to edit a user -->
<div id="editModal" class="modal fade" role="dialog" >
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" role="form">
            <div class="form-group">
                <label class="control-label col-sm-2" for="title">Name:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name_edit" autofocus>
                    <input type="hidden" class="form-control" id="id_edit" disabled>
                    <p class="errorName text-center alert alert-danger hidden"></p>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-primary edit" data-dismiss="modal">
              <span class='glyphicon glyphicon-check'></span> Edit
          </button>
          <button type="button" class="btn btn-warning" data-dismiss="modal">
              <span class='glyphicon glyphicon-remove'></span> Close
          </button>
      </div>
    </div>
  </div>
</div>

<!-- Modal form to delete a user -->
<div id="deleteModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <h4 class="text-center">Are you sure you want to delete the following user?</h4>
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
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<!-- <script src="{{ asset('/plugins/bootstrap/js/bootstrap.min.js') }}"></script> -->
<script src="{{ asset('/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('/plugins/datatables/dataTables.bootstrap4.js') }}"></script>

<script>

// $( document ).ready(function( $ ) {

// });
  $(function () {
    $.noConflict();
    alert("Yes");
    $('#ghaji').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{{ url('listPermissions') }}",
            "type": "GET"
        },
        "columns": [
            { "data": "name" },
            { "data": "guard_name" },
            { "data": "edit" }, 
            { "data": "delete" }
        ],
      "paging": true
      // initComplete: function () {
      //       this.api().columns().every(function () {
      //           var column = this;
      //           var input = document.createElement('input');
      //           $(input).appendTo($(column.footer()).empty())
      //           .on('change', function () {
      //               var val = $.fn.dataTable.util.escapeRegex($(this).val());

      //               column.search(val ? val : '', true, false).draw();
      //           });
      //       });
      //   }
      // "lengthChange": false,
      // "searching": true,
      // "ordering": true,
      // "info": true,
      // "autoWidth": false
    });
  });

  // Add a User
  jQuery(document).on('click', '.add-modal', function() {
      // jQuery('.form-horizontal').show();
      // var stuff = jQuery(this).data('info').split(',');
      // fillmodalData(stuff)
      alert("meeeeeeeeeeeeeeeeeeeeeeeeeeeee");
      jQuery('.modal-title').text('Add');
      jQuery('#addModal').modal('show');
  });
  jQuery('.modal-footer').on('click', '.add', function() {
      // e.preventDefault();
      
      var formData = jQuery(this).serialize();
      // alert(formData);
      // var formData = JSON.stringify(jQuery("#myForm").serializeArray());
      console.log(formData);
      jQuery.ajax({
          headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
          type: 'POST', 
          url: "{{ route('permissions.store') }}",
          // dataType: 'json',
          // contentType : 'application/json',
          // processData: false,
          data: {
            'name': jQuery('#name').val()
          },
          // data: formData,
          success: function(data) {
              console.log(data);
              jQuery('.errorName').addClass('hidden');
             
              if ((data.errors)){
                    swal({
                      position: 'top-end',
                      type: 'error',
                      title: 'Oops...',
                      text: 'Validation Error!',
                      showConfirmButton: false,
                      timer: 3000
                    });

                   jQuery('#addModal').modal('show');

                  if (data.errors.name) {
                      jQuery('.errorName').removeClass('hidden');
                      jQuery('.errorName').text(data.errors.name);
                  }
                  
              }
              else {
                swal({
                      position: 'top-end',
                      type: 'success',
                      title: 'Successfully saved your information',
                      showConfirmButton: false,
                      timer: 3000
                    });
                window.location.reload();
              }
          },
          

      });
     
  });
</script>

@endsection

