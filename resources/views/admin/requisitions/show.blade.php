@extends('admin.layouts.admin')


@section('main-content')


<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h5>{{ $transi->customer->fullname }} Requisitions Request Edit Form </h5>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Requisitions Request Edit Form </li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-7">
                            <table class="table table-sm table-responsive table-sm table-responsive table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th colspan="4">{{ $transi->customer->fullname }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Request Amount:</td>
                                        <td>{{ formatMoney($transi->total_amount)  }}</td>
                                    </tr>
                                    <tr>
                                        <td>Request Date:</td>
                                        <td>{!! ($transi->request_date) ? "<span class='badge badge-primary'>
                                                ".\Carbon\Carbon::parse($transi->request_date)->format('D
                                                M Y')."</span> " : "" !!}</td>
                                    </tr>
                                    <tr>
                                        <td>Approved Date:</td>
                                        <td>{!! ($transi->aprove_date) ? "<span class='badge badge-success'>
                                                ".\Carbon\Carbon::parse($transi->aprove_date)->format('D
                                                M Y')."</span> " :
                                            "<span class='badge badge-dark'>Waiting for
                                                Approval</span>" !!}</td>
                                    </tr>
                                    <tr>
                                        <td>SIV No:</td>
                                        <td>{!! '<span class="badge badge-pill badge-dark">'.$transi->transaction_no."</span>"
                                            !!}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="col-md-5">
                            <table class="table table-sm table-responsive table-sm table-responsive table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th colspan="4">
                                            Manage Request
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            @can('approve-request')
                                            <form class="form-horizontal" method="POST" action="{{ route('requisitions.update', $transi->id) }}">
                                                {{ csrf_field() }}
                            
                                                <input name="_method" type="hidden" value="PUT">
                                                <div class="col-md-4 pull-left"><button type="submit" class="btn btn-success btn-sm">
                                                        <i class="fa fa-send"></i> Approve</button></div>
                                            </form>
                                            @endcan
                                        </td>
                                        <td>
                                            @if($transi->visible == 2)
                                            <a href="{{ route('showRequisitionReceipt',$transi->id) }}" class="btn btn-info btn-sm"> <i
                                                    class="fa fa-print"></i>
                                                Print</a>
                                            @endif
                                        </td>
                                        <td>
                                            @if (!empty($transi))
                                            <a href="{{ route('addItems') }}" class="btn btn-dark btn-sm ">
                                                <i class="fa fa-plus"></i> Add Items</a>
                                            @endif
                                        </td>
                                        <td>
                                            @can('edit-request')
                                            <a href="{{ route('requisitions.show',$transi->id) }}" class="btn btn-primary btn-sm float-right"> <i
                                                    class="fa fa-pencil"></i>
                                                Edit</a>
                                            @endcan
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            @hasrole('Head')
                            <table class="table table-sm table-responsive table-sm table-responsive table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th colspan="4">
                                            Departmental Budget for Year (2020)
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                            
                                        </td>
                                        <td>
                            
                                        </td>
                                        <td>
                            
                                        </td>
                                        <td>
                            
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            @endhasrole
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="product" class="table table-sm table-responsive table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th> SN</th>
                                    <th> Product Name</th>
                                    <th> Quantity</th>
                                    <th> Price (&#8358;)</th>
                                    <th> Total Amount (&#8358;)</th>
                                    <th> Reduce Quantity</th>
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
                        <h4 class="text-center">
                            Please comfirm that you want to reduce an item from these request.
                        </h4>
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
                                    <input type="checkbox" id="caligrapher_edit" class="checkbox" value="1"> Check me
                                    to activate the continue button
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
                <h4 class="text-center">Please comfirm that you want to delete this item from this list.
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
        "initComplete": function( settings, json ) {
            $('div.loading').remove();
        },
        "dom": 'Bfrtip',
        "lengthMenu": [
          [10, 25, 50, 100, -1],
          [10, 25, 50, 100, "All"]
        ],
        "buttons": [ 'pageLength', 'copy', 'excel', 'pdf', 'print', 'colvis' ],
        "processing": true,
        "serverSide": true,
            ajax: {
                    "url": "{{ url('listDepartmentRequest', $transi->id) }}",
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
                { data: 'productName', name: 'productName' },
                { data: 'quantity', name: 'quantity' },
                { data: 'price', name: 'price' },
                { data: 'total_amount', name: 'total_amount' },
                { data: 'edit', name: 'edit' },
                { data: 'delete', name: 'delete' }

            ],
            responsive: true,
            order: [[1, 'asc']],
            paging: true,
            lengthChange: false,
            searchable: false,
            "info": true,
            "autoWidth": false,
        });

        table.on( 'order.dt search.dt', function () {
            table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();

        $('#product tbody').on( 'click', 'tr', function () {
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
        id = $('#id_edit').val();
      
        $('#caligrapher_edit').on('click', function(){
            $("#myButtonForCaligrapher").attr("disabled", !this.checked);
            qt = $('#quantity').val();
        });

        $('#editModal').modal('show');
    });

    $(document).on('click', '.edit', function(e) {
       
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'GET',
            url: '{!! url("/editRequest") !!}/' + id + '/' + qt,
            data: {
                'id': $("#id_edit").val(),
                'quantity': $('#quantity').val(),
            },
            success: function(data) {
                $('.errorcaligrapher').addClass('hidden');
                $('.errorQuantity').addClass('hidden');
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
                    // window.location.href='{{ route("requisitions.show", $transi->id) }}';
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
                    text: 'You want to Remove this item from the request!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, leave!'
            }).then((result) => {
                if (result.value) {

                    $.ajax(
                    {
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        type: 'DELETE',
                        url: '{!! url("removed-request") !!}/' + id,
                        data: {
                            "id": id,
                        },
                        success: function (data){
                            // console.log("delete");
                            Swal.fire(
                            'Success',
                            'Print Receipt.',
                            'success'
                            )
                            window.location.href='{{ route("requisitions.show", $transi->id) }}';
                            
                        }
                    });
                }
            });
    });

    $(document).on("click", ".deleteRecord", function() {
            Swal.fire({
                    title: 'Are you sure?',
                    text: 'You want to Remove this Item!!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, leave!'
            }).then((result) => {
                if (result.value) {

                    var id = $(this).data("id");
                    {{--  var token = $("meta[name='csrf-token']").attr("content");  --}}

                    $.ajax(
                    {
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        
                        type: 'GET',
                        url: '{!! url("/destroyRequest") !!}/' + id ,
                        data: {
                            "id": id,
                        },
                        success: function (){
                            Swal.fire(
                            'Congratulation!',
                            'You will be redirected immediately.',
                            'success'
                            )
                            window.location.href='{{ route("requisitions.create") }}';
                        }
                    });
                }
            });
    });

</script>


@endsection