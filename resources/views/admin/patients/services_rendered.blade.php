@extends('admin.layouts.admin')

@section('main-content')
    <div id="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">

                <div class="row mb-2">

                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Patient Services List </h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Patients Services</li>
                        </ol>
                    </div>

                </div>

            </div>
        </div>

        <div class="container">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{(null != $dependant) ? ($dependant->fullname .'('. userfullname($patient->user_id) .')') : userfullname($patient->user_id)}}</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <form action="{{route('patient.services_rendered',['patient_id'=>$patient->id,'dependant_id' => $dependant->id ?? ''])}}"
                                method="get" class="form-inline">
                                <div class="form-group">
                                    <input type="hidden" name="patient_id" value="{{$patient->id}}">
                                    @if(null != $dependant)
                                        <input type="hidden" name="dependant_id" value="{{$dependant->id}}">
                                    @endif
                                    <label for="">Date between</label>
                                    <input type="date" name="start_from" id="start_from" class="form-control m-1" value="{{( Request::get('start_from'))?  Request::get('start_from'): ''}}" required>
                                    <input type="date" name="stop_at" id="stop_at" class="form-control m-1" value="{{(Request::get('stop_at')) ? Request::get('stop_at'): ''}}" required>
                                    <button type="submit" class="btn btn-primary m-1">Fetch</button>
                                </div>
                            </form>
                        </div>
                        <hr>
                    </div>
                    @if(null != Request::get('start_from') && null != Request::get('stop_at'))
                    <button type="button" class="btn btn-warning" onclick="PrintElem('tableToPrint')"><i class="fa fa-print"></i> Print</button>
                    <hr>
                        <div id="tableToPrint">
                            <table  class="table table-sm table-responsivetext-sm table-sm table-bordered table-striped ">
                                <thead>
                                    <tr align="center">
                                        <th>{{$app->site_name }}</th>
                                    </tr>
                                    <tr>
                                        <th>Fullname</th>
                                    </tr>
                                    <tr>
                                        <td>{{ userfullname($patient->user_id)}} <br>Hosp. No:{{showFileNumber($patient->user_id)}}</td>
                                    </tr>
                                    <tr>
                                        <th>Dependnat Name</th>
                                    </tr>
                                    <tr>
                                        <td>{{$dependant->fullname ?? 'N/A'}}</td>
                                    </tr>
                                    <tr>
                                        <th>HMO / Insurance</th>
                                    </tr>
                                    <tr>
                                        <td>{{$patient->hmo->name}}</td>

                                    </tr>
                                    <tr>
                                        <th>HMO Number</th>
                                    </tr>
                                    <tr>
                                        <td>{{$dependant->hmo_no ?? $patient->hmo_no}}</td>
                                    </tr>
                                    <tr>
                                        <th>Repeort period</th>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{Request::get('start_from')}}
                                            <br>
                                            {{Request::get('stop_at')}}
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>Services Rendered</th>
                                    </tr>
                                    @foreach ($consultation as $con)
                                        <tr>
                                            <td>
                                                Consultation
                                                <br> {{$con->doctor->specialization->name}}
                                                <br> Dr. {{userfullname($con->doctor->user_id)}}
                                                <br>{{$con->created_at}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    @foreach ($prescription as $pres)
                                        <tr>
                                            <td>
                                                Precription
                                                <br> Dr. {{userfullname($pres->doctor->user_id)}}
                                                <br>{!!$pres->pharmacy!!}
                                                <br>{{$pres->created_at}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    @foreach ($lab as $la)
                                        <tr>
                                            <td>
                                                Investigation Request
                                                <br> Dr. {{userfullname($la->medical_report->doctor->user_id)}}
                                                <br>{{$la->lab_service->lab_service_name}}
                                                <br>{{$la->created_at}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    @foreach ($nursing as $nur)
                                        <tr>
                                            <td>
                                                Nursing service request
                                                <br> Dr. {{userfullname($nur->doctor->user_id)}}
                                                <br>{!!$nur->nurseContent!!}
                                                <br>{{$nur->created_at}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
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
        $(function() {
            $('#products').DataTable({
                "dom": 'Bfrtip',
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                "buttons": ['pageLength', 'copy', 'excel', 'pdf', 'print', 'colvis'],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ url('patientsList') }}",
                    "type": "GET"
                },
                "columns": [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex"
                    },
                    {
                        data: "fullname",
                        name: "fullname"
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
                        data: "hmo_no",
                        name: "hmo_no"
                    },
                    {
                        data: "acc_bal",
                        name: "acc_bal"
                    },
                    {
                        data: "created_at",
                        name: "created_at"
                    },
                    {
                        data: "edit",
                        name: "edit"
                    },
                    {
                        data: "add",
                        name: "add"
                    },
                    {
                        data: "note",
                        name: "note"
                    },
                    {
                        data: "services",
                        name: "services"
                    },
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
        function PrintElem(elem) {
            var mywindow = window.open('', 'PRINT', 'height=400,width=600');

            mywindow.document.write('<html><head><title>' + document.title + '</title>');
            mywindow.document.write(`<style>
                            table,th,td{
                                padding:2px;
                                border: 1px solid black;
                                border-collapse: collapse;
                            }
                            table{
                                width:50mm;
                                margin:0;
                            }
                            body{
                                margin:0;
                                max-height:100%;
                                font-size:9pt;
                                font-family:monospace;
                            }
                            html{
                                margin:0;
                                height:100%;
                            }
                        </style>`)
            mywindow.document.write('</head><body>');
            mywindow.document.write(document.getElementById(elem).innerHTML);
            mywindow.document.write('</body></html>');

            mywindow.document.close(); //IE >=10
            mywindow.focus(); // IE >= 10

            mywindow.print();
            //mywindow.close();

            return true;
        }
    </script>
@endsection
