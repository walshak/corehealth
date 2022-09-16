@extends('admin.layouts.admin')

@section('main-content')

	<div id="content-wrapper">

		<div class="content-header">
		  <div class="container-fluid">

		    <div class="row mb-2">

		      <div class="col-sm-6">
		        <h1 class="m-0 text-dark">{{$lab->lab_name}}  - Staffs List</h1>
		      </div>

		      <div class="col-sm-6">
		        <ol class="breadcrumb float-sm-right">
		          <li class="breadcrumb-item"><a href="#">Home</a></li>
		          <li class="breadcrumb-item active">Labs Staffs</li>
		        </ol>
		      </div>

		    </div>

		  </div>
		</div>

		<div class="container">
          <div class="card-header">
            @if(auth()->user()->can('user-create'))
                <a href="{{ route('lab-managers.show',$lab->id) }}" id="loading-btn" data-loading-text="Loading..." class="btn btn-primary" >
                    <i class="fa fa-home"></i>
                    {{'Add Staff'}}
                </a>
            @endif
        </div>
		    <div class="card">
                <div class="card-header">
                <h3 class="card-title"> {{$lab->lab_name}}</h3>
                </div>

                <div class="card-body">
                    <table id="products" class="table table-sm table-responsive table-sm table-responsive table-bordered table-striped">
                        <thead>
                            <tr>
                            <th>SN</th>
                            <th>Staff Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Status</th>
                            <th>Action</th>
                            <th>Remove</th>
                            </tr>
                        </thead>
                    </table>
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
                <h4 class="text-center">Please comfirm that you whant to Remove this this Staff from this Lab ?</h4>
                <br />
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <div class="col-sm-10">
                            <input type="hidden" class="form-control" id="id_delete">
                            {{-- <input type="hidden" class="form-control" id="caligrapher" name="caligrapher"> --}}
                        </div>
                    </div>
                </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success delete" data-dismiss="modal">
                        <span id="" class='glyphicon glyphicon-plus'></span> Continue
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
            "url": "{{ url('listLabStaffs', $lab->id) }}",
            "type": "GET"
        },
        "columns": [
            { data: "DT_RowIndex", name: "DT_RowIndex" },
            { data: "fullname", name: "fullname" },
            { data: "email", name: "email" },
            { data: "phone_number", name: "phone_number" },
            { data: "visible", name: "visible" },
            { data: "action", name: "action" },
            { data: "remove", name: "remove" }
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
        $('.modal-title').text('Comfirmation');
        $('#id_delete').val($(this).data('id'));
        id = $('#id_delete').val();
        $('#deleteModal').modal('show');
    });

    $(document).on('click', '.delete', function(e) {
          Swal.fire({
                    title: 'Are you sure?',
                    text: 'You want to Remove this staff from this lab!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, leave!'
            }).then((result) => {
                if (result.value) {

                    {{-- var id = $(this).data("id_delete"); --}}
                    //alert(id);
                    console.log(id);
                    $.ajax(
                    {
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        type: 'DELETE',
                        url: '{!! url("lab-managers.") !!}/' + id,
                        data: {
                            "id": id,
                        },
                        success: function (){
                            console.log("delete");
                            Swal.fire(
                            'Success',
                            'Staff Remove.',
                            'success'
                            )
                            window.location.href='{{ route("lab-managers.show", $lab->id) }}';
                            
                        }
                    });
                }
            });
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
