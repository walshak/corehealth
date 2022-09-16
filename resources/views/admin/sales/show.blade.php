@extends('admin.layouts.admin')


@section('main-content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Transactions</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Transactions</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <div class="clearfix">

                                <div class="float-left">
                                    <a href="{{ route('transactions.show', $transi->id) }}" class="btn btn-success"><i
                                            class="fa fa-print"></i> Print Receipt</a>

                                    {{ __(ucwords($transi->customer_name) . ' with Trans No ' . $transi->transaction_no . ' and  Total Amount ' . NAIRA_CODE . $transi->total_amount) }}
                                </div>
                                <div class="float-right">
                                    {{-- <input type="hidden" id="deleteRecord" class="form-control"> --}}
                                    <button id="deleteRecord" class="btn btn-danger btn-sm deleteRecord"
                                        data-id="{{ $transi->id }}"> <i class="fa fa-trash"></i> Remove Transaction
                                    </button>
                                </div>
                            </div>
                        </h3>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="product" class="table table-sm table-responsive table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th> SN</th>
                                        <th> Product Name</th>
                                        <th> Quantity</th>
                                        <th> Sale Price (&#8358;)</th>
                                        <th> Total Amount (&#8358;)</th>
                                        <th> Update</th>
                                        <th> Delete</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal form to edit a user -->
    <div id="editModal" class="modal fade" role="dialog">
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
                            <h4 class="text-center">Please comfirm that you want to remove an item from the transaction?
                                click the checkbox below to continue</h4>
                            <hr>
                        </div>
                        <div class="form-group">
                            <label for="Quantity" class="col-sm-2 col-form-label"> Quantity: </label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="quantity" placeholder="Enter Quantity"
                                    required="true">
                                <p class="errorQuantity text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <div class="col-sm-10">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" id="caligrapher_edit" class="checkbox" value="1"> Check
                                        me out
                                    </label>
                                    <p class="errorCaligrapher text-center alert alert-danger hidden"></p>
                                </div>
                                <input type="hidden" class="form-control" id="id_edit" readonly="1">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="myButtonForCaligrapher" type="button" disabled class="btn btn-primary edit"
                        data-dismiss="modal">
                        <span class='glyphicon glyphicon-check'></span> Continue
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
                    <h4 class="text-center">Please comfirm that you whant to delete this product from this transanction ?
                    </h4>
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
    <script src="{{ asset('plugins/jQuery/jquery.min.js') }}"></script>

    <!-- Bootstrap 3.3.6 -->
    {{-- <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('../resources/assets/plugins/datatables2/datatables.min.js') }}"></script> --}}
    <script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('plugins/datatables/sum().js') }}"></script>
    <script src="{{ asset('plugins/datatables/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('plugins/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/buttons.colVis.min.js') }}"></script>
    {{-- <script src="{{ asset('plugins/jQuery/sweetalert.min.js') }}" ></script> --}}
    <script src="{{ asset('../node_modules/sweetalert2/dist/sweetalert2.all.js') }}"></script>

    <script>
        // jQuery.noConflict();
        jQuery(function($) {
            var table = $('#product').DataTable({
                "initComplete": function(settings, json) {
                    $('div.loading').remove();
                },
                "dom": 'Bfrtip',
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                "buttons": ['pageLength', 'copy', 'excel', 'pdf', 'print', 'colvis'],
                "processing": true,
                "serverSide": true,
                ajax: {
                    "url": "{{ url('listShowTransactions', $transi->id) }}",
                    "type": "GET"
                },
                columnDefs: [{
                    orderable: false,
                    //className: 'select-checkbox',
                    data: null,
                    defaultContent: '',
                    targets: 0
                }],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'productName',
                        name: 'productName'
                    },
                    {
                        data: 'quantity_buy',
                        name: 'quantity_buy'
                    },
                    {
                        data: 'sale_price',
                        name: 'sale_price'
                    },
                    {
                        data: 'total_amount',
                        name: 'total_amount'
                    },
                    {
                        data: 'edit',
                        name: 'edit'
                    },
                    {
                        data: 'delete',
                        name: 'delete'
                    }

                ],
                responsive: true,
                order: [
                    [1, 'asc']
                ],
                paging: true,
                lengthChange: false,
                searchable: false,
                "info": true,
                "autoWidth": false,
                {{-- buttons: [
                'selected',
                'selectedSingle',
                'selectAll',
                'selectNone',
                'selectRows',
                //'selectColumns',
                //'selectCells'
            ] --}}

            });

            table.on('order.dt search.dt', function() {
                table.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();

            $('#product tbody').on('click', 'tr', function() {
                $(this).toggleClass('selected');
            });

            $('#button').click(function() {
                alert(table.rows('.selected').data().length + ' row(s) selected');
            });

        });



        // Edit a User
        $(document).on('click', '.edit-modal', function() {
            $('.modal-title').text('Edit');
            $('#id_edit').val($(this).data('id'));
            id = $('#id_edit').val();


            // This onclick is to make sure that the checkbox is checked to Comfirm that you actually proccessed that information
            $('#caligrapher_edit').on('click', function() {

                $("#myButtonForCaligrapher").attr("disabled", !this.checked);
                qt = $('#quantity').val();

            });

            $('#editModal').modal('show');
        });

        $(document).on('click', '.edit', function(e) {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                url: '{!! url('/edit-quantity') !!}/' + id + '/' + qt,
                data: {
                    'id': $("#id_edit").val(),
                    'quantity': $('#quantity').val(),
                },
                success: function(data) {
                    $('.errorcaligrapher').addClass('hidden');
                    $('.errorQuantity').addClass('hidden');
                    console.log(data);
                    if ((data.errors)) {
                        Swal.fire(
                            'Error',
                            'Error in validation please try again later',
                            'Error'
                        )

                        $('#editModal').modal('show');

                        if (data.errors.quantity) {
                            $('.errorQuantity').removeClass('hidden');
                            $('.errorQuantity').text(data.errors.quantity);
                        }

                        if (data.errors.signature) {
                            $('.errorCaligrapher').removeClass('hidden');
                            $('.errorCaligrapher').text(data.errors.caligrapher);
                        }

                    } else {

                        Swal.fire(
                            'Success',
                            'Successfully updated your information.',
                            'success'
                        )

                        window.location.href = '{{ route('transactions.show', $transi->id) }}';
                        //window.location.reload();
                    }
                }
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
                text: 'You want to Delete this transaction!',
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
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'DELETE',
                        url: '{!! url('removed-edit-sales') !!}/' + id,
                        data: {
                            "id": id,
                        },
                        success: function() {
                            console.log("delete");
                            Swal.fire(
                                'Success',
                                'Print Receipt.',
                                'success'
                            )
                            window.location.href =
                                '{{ route('transactions.show', $transi->id) }}';

                        }
                    });
                }
            });
        });

        $(document).on("click", ".deleteRecord", function() {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You want to Delete this transaction!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, leave!'
            }).then((result) => {
                if (result.value) {

                    var id = $(this).data("id");
                    {{-- var token = $("meta[name='csrf-token']").attr("content"); --}}

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'DELETE',
                        url: '{!! url('sales') !!}/' + id,
                        data: {
                            "id": id,
                            {{-- "_token": token, --}}
                        },
                        success: function() {
                            console.log("it Works");
                            Swal.fire(
                                'Congratulation!',
                                'You will be redirected immediately.',
                                'success'
                            )
                            window.location.href = '{{ route('transactions.create') }}';
                        }
                    });
                }
            });
        });
    </script>
@endsection
