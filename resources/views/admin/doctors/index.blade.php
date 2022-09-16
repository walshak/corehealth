@extends('admin.layouts.admin')

@section('style')
    <link rel="stylesheet" href="{{ asset('plugins/datatables/extensions/AutoFill/css/dataTables.autoFill.css') }}">
@endsection

@section('main-content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Staff Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Staff Management</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Staff Management</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="pull-right">
                        @hasrole('Admin|Super-Admin')
                            <a href="{{ route('doctors.create') }}" class="btn btn-primary">Add</a>
                        @endhasrole
                    </div>
                    <button id="btn-show-all-children" class="btn btn-dark btn-sm" type="button">Expand All</button>
                    <button id="btn-hide-all-children" class="btn btn-dark btn-sm" type="button">Collapse All</button>
                    <hr>

                    <div class="table-responsive">
                        <table id="ghaji" class="table table-sm table-responsive table-bordered table-striped display">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Title</th>
                                    <th>Name</th>
                                    <th>Specialization</th>
                                    <th>Clinic</th>
                                    {{-- <th>Phone</th> --}}
                                    <th>Status</th>
                                    <th>Account</th>
                                    <th class="none">View</th>
                                    <th class="none">Book</th>
                                    <th class="none">Edit</th>
                                    <th class="none">Delete</th>
                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>

        </div>

    </section>

    <!-- Modal form to delete a user -->
    <div id="deleteModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h4 class="text-center">Are you sure you want to delete the following Details?</h4>
                    <br />
                    <form class="form-horizontal" role="form" id="deleteMyForm">
                        {{ csrf_field() }}
                        <input name="_method" type="hidden" value="DELETE">
                        <div class="form-group">
                            <div class="col-sm-10">
                                <input type="hidden" class="form-control" id="id">
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
    <script src="{{ asset('plugins/jQuery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('plugins/datatables/extensions/AutoFill/js/dataTables.autoFill.js') }}"></script>
    <script src="{{ asset('plugins/datatables/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('plugins/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/buttons.colVis.min.js') }}"></script>
    <script>
        // CKEDITOR.replace('content_edit');
        // CKEDITOR.replace('content');
    </script>
    <script>
        $(function() {
            //  $.noConflict()
            var ahmad = $('#ghaji').DataTable({
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
                        buttons: [{
                                text: 'Toggle start date',
                                action: function(e, dt, node, config) {
                                    dt.column(-2).visible(!dt.column(-2).visible());
                                }
                            },
                            {
                                text: 'Toggle salary',
                                action: function(e, dt, node, config) {
                                    dt.column(-1).visible(!dt.column(-1).visible());
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
                "serverSide": true,
                "ajax": {
                    "url": "{{ url('listDoctors') }}",
                    "type": "GET"
                },
                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: "title_id",
                        name: "title_id"
                    },
                    {
                        data: "user_id",
                        name: "user_id"
                    },
                    {
                        data: "specialization_id",
                        name: "specialization_id"
                    },
                    {
                        data: "clinic_id",
                        name: "clinic_id"
                    },
                    // { data: "secondary_email", name: "secondary_email" },
                    // { data: "secondary_phone_number", name: "secondary_phone_number" },
                    {
                        data: "status_id",
                        name: "status_id"
                    },
                    {
                        data: "deleted",
                        name: "deleted"
                    },
                    {
                        data: "view",
                        name: "view"
                    },
                    {
                        data: "book",
                        name: "book"
                    },
                    {
                        data: "edit",
                        name: "edit"
                    },
                    {
                        data: "delete",
                        name: "delete"
                    }
                ],
                "autoFill": {
                    "editor": "editor"
                },
                "responsive": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });
            new $.fn.dataTable.AutoFill(ahmad);
            // Handle click on "Expand All" button
            $('#btn-show-all-children').on('click', function() {
                // Expand row details
                ahmad.rows(':not(.parent)').nodes().to$().find('td:first-child').trigger('click');
            });

            // Handle click on "Collapse All" button
            $('#btn-hide-all-children').on('click', function() {
                // Collapse row details
                ahmad.rows('.parent').nodes().to$().find('td:first-child').trigger('click');
            });
        });

        // Delete a User
        $(document).on('click', '.delete-modal', function() {
            $('.modal-title').text('Delete');
            $('#id').val($(this).data('id'));
            $('#deleteModal').modal('show');
        });
        $('.modal-footer').on('click', '.delete', function() {
            let id = $('#id').val();
            deleteMyForm = $('#deleteMyForm');
            let od = deleteMyForm.serialize();
            console.log(id);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'DELETE',
                url: 'doctors/' + id,
                data: od,
                dataType: 'json',
                processData: false,
                contentType: 'application/x-www-form-urlencoded',
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
