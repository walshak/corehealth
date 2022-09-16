@extends('admin.layouts.admin')

@section('main-content')



<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Role Management</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Role Management</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

 <section class="content">

    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Role Management</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="pull-right">
            <button type="button" class="add-modal btn btn-primary" data-toggle="modal">New Role</button>
          </div>
          <table id="ghaji" class="table table-sm table-responsive table-bordered table-striped display">
            <thead>
            <tr>
              <th>S/N</th>
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
          <form class="form-horizontal" role="form">
            {{ csrf_field() }}
              
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="Enter Name">
                  <div class="errorName text-center alert alert-danger hidden" role="alert"></div>
                </div>
              </div>
            
              <div class="form-group col-md-12">
                  <label for="permission">Assign permission to the role above:</label>
                  <div class="col-md-12">
                      <div class="row">
                          @foreach($permission as $value)
                              <div class="col-md-4">
                                  <div class="checkbox">
                                  <input type="checkbox" class="form-check-input" id="permission" name="permission[]" value="{{ $value->id }}">
                                  <label class="form-check-label" for="{{ $value->id }}">{{ $value->name }}</label>

                                  <br/>
                                  </div>
                              </div>
                          @endforeach
                          <!-- <div class="errorPermission text-center alert alert-danger hidden" role="alert"></div> -->
                      </div>
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
            <div class="form-group ">
                <div class="col-md-12">
                @if (!empty($rolePermissions))
                    <label for="permission">Permission assigned to role: <span >{{ $role->name }}</span></label>
                @else
                    <label for="permission">No permission assigned to role <span >{{ $role->name }}</span></label>
                @endif
                    <div class="row">
                        @foreach($permission as $value)
                        <div class="col-md-4">
                            {{-- <div class="checkbox"> --}}
                        
                                {{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'form-check-input')) }}
                                <label for="{{ $value->id }}">{{ $value->name }}</label>
                          
                                <br/>
                            {{-- </div> --}}
                        </div>                                                        
                        @endforeach
                    </div>
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
<!-- <script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script> -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap4.js') }}"></script>
<script>
  $(function () {
    $('#ghaji').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{{ url('listRoles') }}",
            "type": "GET"
        },
        "columns": [
            { "data": "DT_RowIndex" },
            { "data": "name" },
            { "data": "guard_name" },
            { "data": "edit" }, 
            { "data": "delete" }
        ],
      "paging": true
      // "lengthChange": false,
      // "searching": true,
      // "ordering": true,
      // "info": true,
      // "autoWidth": false
    });
  });

  // Add a User
  $(document).on('click', '.add-modal', function() {
      // $('.form-horizontal').show();
      // var stuff = $(this).data('info').split(',');
      // fillmodalData(stuff)
      $('.modal-title').text('Add');
      $('#addModal').modal('show');
  });
  $('.modal-footer').on('click', '.add', function() {
      // e.preventDefault();
      var form_data = $(this).serialize();
      $.ajax({
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          type: 'POST',
          url: "{{ route('roles.store') }}",
          data: {
            'name': $('#name').val(),
            'permission': $('#permission').val()
          },
          success: function(data) {
              console.log(data);
              $('.errorName').addClass('hidden');
              // $('.errorPermission').addClass('hidden');
             
              if ((data.errors)){
               
                    swal({
                      position: 'top-end',
                      type: 'error',
                      title: 'Oops...',
                      text: 'Validation Error!',
                      showConfirmButton: false,
                      timer: 3000
                    });

                   $('#addModal').modal('show');

                  if (data.errors.name) {
                      $('.errorName').removeClass('hidden');
                      $('.errorName').text(data.errors.name);
                  }
                  // if (data.errors.permission) {
                  //     $('.errorPermission').removeClass('hidden');
                  //     $('.errorPermission').text(data.errors.permission);
                  // }
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

  // Edit a User
  $(document).on('click', '.edit-modal', function() {
      $('.modal-title').text('Edit');
      $('#id_edit').val($(this).data('id'));
      $('#name_edit').val($(this).data('name'));
      $('#permission_edit').val($(this).data('permission'));
      id = $('#id_edit').val();
      $('#editModal').modal('show');
  });
  $('.modal-footer').on('click', '.edit', function() {
      $.ajax({
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          type: 'PUT',
          url: 'roles/' + id,
          data: {
              // '_token': $('input[name=_token]').val(),
              'id': $("#id_edit").val(),
              'name': $('#name_edit').val(),
              'permission': $('#permission_edit').val(),
          },
          success: function(data) {
              $('.errorName').addClass('hidden');
              // $('.errorGuard_name').addClass('hidden');

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

                  if (data.errors.name) {
                      $('.errorName').removeClass('hidden');
                      $('.errorName').text(data.errors.name);
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
      $('.modal-title').text('Delete');
      $('#id_delete').val($(this).data('id'));
      id = $('#id_delete').val();
      $('#deleteModal').modal('show');
  });
  $('.modal-footer').on('click', '.delete', function() {
      $.ajax({
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          type: 'DELETE',
          url: 'roles/' + id,
          data: {
              // '_token': $('input[name=_token]').val(),
              'id': $("#id_delete").val(),
          },
          success: function(data) {
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

