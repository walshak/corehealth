@extends('admin.layouts.admin')

@section('main-content')
    <div id="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">

                <div class="row mb-2">

                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Patients Result</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">New Sample Result</li>
                        </ol>
                    </div>

                </div>

            </div>
        </div>
        <div class="row justify-content-center">


        </div>
        <div class="container">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Patients Result List </h3>
                </div>

                <div class="card-body">
                    <table id="products" class="table table-sm table-responsive table-sm table-responsive table-bordered table-striped">
                        <thead>
                            <tr>
                                <th># </th>
                                <th>Patient</th>
                                <th>File No</th>
                                <th>HMO</th>
                                <th>Lab</th>
                                <th>Service</th>
                                <th>Paid Amount </th>
                                <th>Sample Date</th>
                                <th>Sample by</th>
                                <th>Result by</th>
                                <th>Result Date</th>
                                <th>Result</th>
                            </tr>
                        </thead>


                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- medium modal -->
    <div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class="modal-body" id="mediumBody">
                    <div class="card border-info mb-6">


                        <div class="card-header bg-transparent border-info">{{ __('Lab Test Result ') }}</div>
                        <div class="card-body">
                            <input type="hidden" name="payment_type_id" value="3">
                            <div class="form-group row">

                                <div class="col-sm-">

                                    <input type="hidden" id="item_name" class="form-control" name="item_name" value=""
                                        readonly="1">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="result" class="control-label">Result</label>
                                <div id="result">

                                </div>

                            </div>



                        </div>


                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>
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
    <script src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('/plugins/dataT/datatables.js') }}" defer></script>

    <script>
        $(function() {
            $('#products').DataTable({
                "dom": 'Bfrtip',

                //  "drawCallback": function () {

                //     var sumTotal = $('#products').DataTable().column(4).data().sum();
                //     $('#subtotal').html(sumTotal);

                // },
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                "buttons": ['pageLength', 'copy', 'excel', 'pdf', 'print', 'colvis'],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ url('viewResultList') }}",
                    "type": "GET"
                },
                "columns": [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex"
                    },
                    {
                        data: "patient",
                        name: "patient"
                    },
                    {
                        data: "file_no",
                        name: "file_no"
                    },
                    {
                        data: "hmo",
                        name: "hmo"
                    },
                    {
                        data: "lab",
                        name: "lab"
                    },
                    {
                        data: "labService",
                        name: "labService"
                    },
                    {
                        data: "price",
                        name: "price"
                    },
                    {
                        data: "sampeDate",
                        name: "sampeDate"
                    },
                    {
                        data: "sample_by",
                        name: "sample_by"
                    },
                    {
                        data: "result_by",
                        name: "result_by"
                    },
                    {
                        data: "resultDate",
                        name: "resultDate"
                    },
                    {
                        data: "result",
                        name: "result"
                    }
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
            var result = $(this).attr('data-attr');
            document.getElementById("result").innerHTML = result;
            // $.ajax({
            //     beforeSend: function() {
            //         $('#loader').show();
            //     },
            //     // return the result
            //     success: function(result) {
            //         //$('#mediumModal').modal("show");
            //         $('#mediumBody').html(result).show();
            //     },
            //     complete: function() {
            //         $('#loader').hide();
            //     },
            //     error: function(jqXHR, testStatus, error) {
            //         console.log(error);
            //         alert("Page " + href + " cannot open. Error:" + error);
            //         $('#loader').hide();
            //     },
            //     timeout: 8000
            // })
        });
    </script>
    <script>
        // $(document).ready(function() {
        //     $.noConflict();

        //     CKEDITOR.replace('result');
        // });
    </script>
@endsection
