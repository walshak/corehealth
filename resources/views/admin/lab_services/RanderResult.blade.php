@extends('admin.layouts.admin')

@section('main-content')
    <div id="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">

                <div class="row mb-2">

                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Patient lab Sample Result</h1>
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
                    <h3 class="card-title">Patient Result List </h3>
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
                        {!! Form::open(['route' => 'testResult', 'method' => 'POST', 'class' => 'form-horizontal', 'onsubmit' => 'setTemplateText()']) !!}
                        {{ csrf_field() }}

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
                                <label for="result_" class="control-label">Result</label>
                                <textarea id="result_" name="result" style="display: none;">
                                    {{ old('result') }}
                                </textarea>
                                <div style="border:1px solid black;" id="the-template" class= 'the-template'>
                                    <?php //echo $patient->clinic->clinic_note_format; ?>
                                </div>
                            </div>


                        </div>
                        <div class="card-footer bg-transparent border-info">
                            <div class="form-group row">
                                <div class="col-md-6"><a href="{{ route('randerResult') }}"
                                        class="btn btn-success"> <i class="fa fa-close"></i> Back</a></div>
                                <div class="col-md-6 "><button type="submit" class="btn btn-primary pull-right" onclick="return confirm('Are you sure you wish to submit this result? it cannot be edited afterwards.')"> <i
                                            class="fa fa-send"></i> Submit</button></div>
                            </div>
                        </div>
                        {!! Form::close() !!}

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
                    "url": "{{ url('randerResultList') }}",
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
            var item_name = $(this).attr('data-attr');
            $('#item_name').val(item_name);
            $('#description').val(item_name);
            //alert(id)
            $.ajax({
                'url':"{{route('randerResult')}}/"+href,
                beforeSend: function() {
                    $('#loader').show();
                },
                // return the result
                success: function(result) {
                    result = JSON.parse(result);
                    //$('#mediumModal').modal("show");
                    $('#the-template')[0].innerHTML = result.template;
                },
                complete: function() {
                    $('#loader').hide();
                },
                error: function(jqXHR, testStatus, error) {
                    console.log(error);
                    alert("Page " + href + " cannot open. Error:" + error);
                    $('#loader').hide();
                },
                timeout: 8000
            })
        });
    </script>
    <script>
        // $(document).ready(function() {
        //     $.noConflict();

        //     CKEDITOR.replace('result');
        // });

        function setTemplateText(){
            //sleep(7000);
            document.getElementById("result_").innerText = $('#the-template')[0].innerHTML;
            //$('#result_').innerText = "hhhhh";
            console.log($('#the-template')[0].innerHTML);
        }
        $('#DataTables').DataTable();
    </script>
@endsection
