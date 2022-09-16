@extends('admin.layouts.admin')

@section('main-content')
<!-- <div class="content-wrapper"> -->
    <!-- Content Header (Page header) -->

    <section class="content">
        <!-- Default box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Create Daily Expenses</h3>
                <div class="box-tools pull-right">
                    {{-- <a href="{{ route('company.create') }}" class="btn btn-success"><i class="fa fa-list"></i> View Citizens</a> --}}
                </div>
            </div>
            <div class="box-body">
                {{-- <div class="col-sm-offset-2 col-sm-10"> --}}
                {!! Form::open(array('route' => 'expenses.store', 'method'=>'POST', 'role'=>'form', 'enctype' => 'multipart/form-data' )) !!}
                    {{ csrf_field() }}
                    <div class="callout callout-info">
                        <strong> Expenses </strong>
                    </div>

                     <input type="hidden" name="now" id="now" readonly="true" class="form-control" value="{{ $now }}" />

                    <table id="exp" class="table table-sm table-responsive table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Expenses Type</th>
                                <th>Beneficiary </th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    {!! Form::select('expenses', $expenses , null, ['id' => 'expenses', 'placeholder' => 'Please Select Expenses', 'class' => 'select2 show-tick form-control', 'data-live-search' => 'true' ]) !!}
                                </td>
                                <td>
                                    {!! Form::select('beneficiary', $beneficiary , null, ['id' => 'beneficiary', 'placeholder' => 'Please Select Beneficiary', 'class' => 'select2 show-tick form-control', 'data-live-search' => 'true' ]) !!}
                                </td>
                                <td>
                                    <input type="number" name="total_amount"  id="total_amount" placeholder=" Amount" class="form-control" value="{{ old('total_amount') }}" />
                                </td>
                            </tr>
                        </tbody>

                    </table>

                    <div class=" form-group text-right">
                        <button type="button" onclick='

                            if( $("#now").text() == "Please Select now" )
                            {

                                swal({
                                    type: "error",
                                    text: "Please select a day and time",
                                    showConfirmButton: true,
                                    timer: 30000
                                });
                                $("#now option:selected").focus();
                                return false;
                            }

                            if( $("#expenses option:selected").text() == "Please Select Expenses" )
                            {
                                //alert("Please Select Expenses.");
                                swal({
                                    type: "error",
                                    text: "Please Select Expenses",
                                    showConfirmButton: true,
                                    timer: 30000
                                });
                                $("#expenses option:selected").focus();
                                return false;
                            }


                            if( $("#beneficiary option:selected").text() == "Please Select Beneficiary" )
                            {
                                //alert("Please Select Beneficiary.");
                                swal({
                                    type: "error",
                                    text: "Please select Benefiiary",
                                    showConfirmButton: true,
                                    timer: 30000
                                });
                                $("#beneficiary option:selected").focus();
                                return false;
                            }



                            if( !($.isNumeric($("#total_amount").val()))  )
                            {
                                //alert("Please enter a valid total amount of ." + $("#expenses option:selected").text() + " order for this now.");
                                swal({
                                    type: "error",
                                    text: "Please enter a valid amount of " + $("#expenses option:selected").text() + " expenses to continue.",
                                    showConfirmButton: true,
                                    timer: 30000
                                });
                                $("#total_amount").focus();
                                return false;
                            }

                            sn = dtTable.rows().count();
                            dtTable.row.add([
                                sn+1,
                                $("#expenses option:selected").text(),
                                $("#beneficiary option:selected").text(),
                                $("#total_amount").val(),
                                $("#now").val(),
                                total += parseInt($("#total_amount").val())
                            ]).draw();

                            $("#expenses").val("");
                            $("#expenses").focus();
                            $("#beneficiary").val("");
                            $("#total_amount").val("");
                            $("#total").html(total);
                            console.log(total);

                            ' class="btn btn-primary">
                            <i class="fa fa-plus">
                            </i> Add Expenses
                        </button>
                        <a href="{{ route('expenses.index') }}" class="btn btn-warning"><i class="fa fa-hand-o-left"></i> Back</a>
                    </div>

                {!! Form::close() !!}
                <table id="property" class="table table-sm table-responsive table-bordered table-striped ">
                    <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Expenses</th>
                        <th>Beneficiary </th>
                        <th>Amount (&#8358;)</th>
                        <th>Date</th>

                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>Total (&#8358;): <span id="total"></span></th>
                        <th></th>

                    </tr>
                    </tfoot>
                </table>

                <div class="flash alert alert-danger fadeOut" ></div>

                <a onclick="dtTable.row('.selected').remove().draw();

                    // dtTable.cells().each( function (index) {
                    //   var cell = dtTable.cell(index);
                    //   alert(cell.data());

                    // });
                    for (i = 0; i < dtTable.rows().count(); i++){
                        dtTable.cell(i,0).data(i+1);
                    }


                " class="btn btn-danger"><i class="fa fa-remove"></i> Delete Selected item(s)
                </a>


               <a onclick="
                    if( dtTable.rows().count() < 1){
                        // alert('Enter items to upload');
                        $('.flash').html('<h4>Add items to upload to server.</h4>').fadeIn(300).delay(2000).fadeOut(500);
                        return false;
                    }else{
                        postData();
                    }"
                    class="btn btn-success pull-right"><i class="fa fa-arrow-up"></i> Upload Items to Server
                </a>

            </div>
        </div>
            {{-- </div> --}}
            </div>
        </div>
    </section>
@endsection

@section('scripts')

    <script src="{{ asset('../resources/assets/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('../resources/assets/js/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.6 -->
    {{-- <script src="{{ asset('../resources/assets/plugins/js/bootstrap.min.js') }}"></script> --}}
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>


    <!-- DataTables -->
    {{-- <script src="{{ asset('../resources/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('../resources/assets/plugins/datatables/dataTables.bootstrap.min.js') }}"></script> --}}
    {{-- <script type="text/javascript" src="{{ asset('../resources/assets/plugins/datatables2/datatables.min.js') }}"></script> --}}

    <script src="{{ asset('../resources/assets/plugins/datatables2/datatables.min.js') }}"></script>
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
    <script src="{{ asset('plugins/datatables/sum().js') }}"></script>
    <script src="{{ asset('plugins/jQuery/sweetalert.min.js') }}" ></script>

    <script>
        var dtTable;
        var total = 0;
        $('.flash').hide();

        (function($) {

            $(document).ready(function() {
                dtTable =  $('#property').DataTable( {
                    dom: 'Bfrtip',
                    buttons: [ 'copy', 'excel', 'pdf', 'print', 'colvis' ],
                    "paging": true,
                    "lengthChange": false,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "select":true
                });
                dtTable.column( 4 ).data().sum();
            });

        }) ( jQuery );

        function postData(){

            var DataPayLoad = '';

            DataPayLoad =  '[';
                        for (i = 0; i < dtTable.rows().count() -1; i++){
                            DataPayLoad += '{' + '"expenses":' + '"' + dtTable.cell(i,1).data() + '", "beneficiary":"' + dtTable.cell(i,2).data() + '", "total_amount":"' + dtTable.cell(i,3).data() + '", "now":"' +  dtTable.cell(i,4).data() + '"}, ';
                        }
                            DataPayLoad += '{' + '"expenses":' + '"' + dtTable.cell(i,1).data() + '", "beneficiary":"' + dtTable.cell(i,2).data() + '", "total_amount":"' + dtTable.cell(i,3).data() + '", "now":"' +  dtTable.cell(i,4).data() + '"}] ';

                dataPL = {'now_id': "{{ $now }}", 'payload' : DataPayLoad };
            // var jsonString = JSON.stringify(dataPL);
            $.ajax({
                type: "post",
                url: "{{ route ('expenses.store') }}",
                data:dataPL,

                headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}" },
                success: function(data){
                    $('.flash').html(data).fadeIn(300).delay(200000).fadeOut(300);
                },

                error: function(xhr, textStatus, errorThrown){
                    $('.flash').html(errorThrown).fadeIn(300).delay(2000).fadeOut(300);
                }

            });
        }
    </script>




{{-- <script>
    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>
<script src="{{ asset('js/app.js') }}" type="text/javascript"></script> --}}
@endsection
