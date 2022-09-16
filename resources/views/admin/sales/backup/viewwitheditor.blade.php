@extends('admin.layouts.admin')

@section('styles')
    <link href="{{ asset('plugins/datatables/jquery.dataTables.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/datatables/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/datatables/select.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/datatables/editor.dataTables.min.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('main-content')


<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>List of Customers</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">List of Customers</li>
        </ol>
      </div>
    </div>
  </div>
</section>


<section class="container">
    <div class="card border-info mb-3">
        <div class="card-header bg-transparent border-info">
            <h3 class="card-title">

                <div class="clearfix">
                    <div class="float-left">{{ __('List of Customers') }}</div>
                    <div class="float-right">
                        <a class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="edit" href="{{ route('customers.create') }}">
                            <i class="fa fa-plus text-warning"></i> Add Customer
                        </a>
                    </div>
                </div>
            </h3>
        </div>
        <div class="card-body">
                <div class="table-responsive">
                    <table id="products" class="table table-sm table-responsive table-bordered table-striped">
                        <thead>
                            <tr>
                            <th>S/N</th>
                            <th>Name</th>
                            <th>Phone </th>
                            <th>Credit</th>
                            <th>Deposit</th>
                            <th>Tranx</th>
                            <th>Payment</th>
                            <th>Borrow</th>
                            <th>Dateline</th>
                            <th>View</th>
                            </tr>
                        </thead>
                    </table>
                </div>
        </div>
    </div>
</section>



@endsection

@section('scripts')
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
{{-- <script src="{{ asset('plugins/datatables/jquery-3.5.1.js') }}"></script> --}}
{{-- <!-- Bootstrap 4 --> --}}
{{-- <!-- <script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script> --> --}}
{{-- <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script> --}}
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
{{-- <script src="{{ asset('plugins/datatables/dataTables2.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables2.select.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.editor.min.js') }}" ></script> --}}

<script src="{{ asset('plugins/datatables/dataTables.bootstrap4.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/buttons.colVis.min.js') }}"></script>




<script>
    {{-- var editor; // use a global for the submit and return data rendering in the examples --}}
    {{-- $(function () { --}}
    jQuery(document).ready(function() {
        var editor;
        jQuery.noConflict();
        editor = new $.fn.dataTable.Editor( {
            ajax: "{{ url('customers.save') }}",
            table: "#products",
            fields: [ {
                    label: "Full name:",
                    name: "fullname"
                }, {
                    label: "Phone Number:",
                    name: "phone"
                }, {
                    label: "Credit:",
                    name: "creadit"
                }, {
                    label: "Deposit:",
                    name: "deposit"
                }, {
                    label: "Transaction:",
                    name: "trans"
                }, {
                    label: "Payment:",
                    name: "payment"
                }, {
                    label: "Borrow:",
                    name: "borrow"
                }, {
                    label: "Date Line:",
                    name: "dateline",
                    type: "datetime"
                }, {
                    label: "View:",
                    name: "view"
                }
            ]
        });

        // Activate an inline edit on click of a table cell
    $('#products').on( 'click', 'tbody td:not(:first-child)', function (e) {
        editor.inline( this, {
            buttons: { label: '&gt;', fn: function () { this.submit(); } }
        } );
    } );

    $('#products').DataTable( {
        dom: "Bfrtip",
        ajax: "{{ url('listCustomers') }}",
        columns: [
            {
                data: null,
                defaultContent: '',
                className: 'select-checkbox',
                orderable: false
            },
            { data: "fullname" },
            { data: "phone" },
            { data: "creadit" },
            { data: "deposit" },
            { data: "trans" },
            { data: "payment" },
            { data: "borrow" },
            { data: "dateline" },
            { data: "view" }
            {{-- { data: "salary", render: $.fn.dataTable.render.number( ',', '.', 0, '$' ) } --}}
        ],
        order: [ 1, 'asc' ],
        select: {
            style:    'os',
            selector: 'td:first-child'
        },
        buttons: [
            { extend: "create", editor: editor },
            { extend: "edit",   editor: editor },
            { extend: "remove", editor: editor }
        ]
    } );

    });

</script>
@endsection

