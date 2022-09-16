@extends('admin.layouts.admin')

@section('main-content')

  <div id="content-wrapper">

    <div class="content-header">
      <div class="container-fluid">

        <div class="row mb-2">

          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Pending Consultation Patient List </h1>
          </div>

          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Pending Consultation  </li>
            </ol>
          </div>

        </div>

      </div>
    </div>

    <div class="container">

        <div class="card">
                <div class="card-header">
                <h3 class="card-title">{{ __('Pending Consultation (Principals)') }}</h3>
                </div>

                <div class="card-body">
                    <table id="products" class="table table-sm table-responsive table-sm table-responsive table-bordered table-striped "  >
                        <thead>
                          <tr>
                          <th># </th>
                          <th>Fullname</th>
                          <th>Gender</th>
                          <th>File No</th>
                          <th>HMO/Insurance</th>
                          <th>Clinic</th>
                          <th>Phone  </th>
                          <th>Type</th>
                          <th>Date</th>
                          <th>Doctor</th>
                          <th>End</th>
                          </tr>
                        </thead>
                    </table>
                </div>
         </div>

         <div class="card">
            <div class="card-header">
            <h3 class="card-title">{{ __('Pending Consultation (Dependants)') }}</h3>
            </div>

            <div class="card-body">
                <table id="products2" class="table table-sm table-responsive table-sm table-responsive table-bordered table-striped "  >
                    <thead>
                      <tr>
                      <th># </th>
                      <th>Fullname</th>
                      <th>Gender</th>
                      <th>File No</th>
                      <th>HMO/Insurance</th>
                      <th>Clinic</th>
                      {{-- <th>Phone  </th> --}}
                      <th>Type</th>
                      <th>Date</th>
                      <th>Doctor</th>
                      <th>End</th>
                      </tr>
                    </thead>
                </table>
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
            "url": "{{ url('listPendingPatients') }}",
            "type": "GET"
        },
        "columns": [
            { data: "DT_RowIndex", name: "DT_RowIndex" },
            { data: "fullname", name: "fullname" },
            { data: "gender", name: "gender" },
            { data: "file_no", name: "file_no" },
            { data: "hmo", name: "hmo" },
            { data: "clinic", name: "clinic" },
            { data: "phone_number", name: "phone_number" },
            { data: "type", name: "type" },
            { data: "updated_at", name: "updated_at" },
            { data: "attend", name: "attend" },
            { data: "end", name: "end" }
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

    $('#products2').DataTable({
        "dom": 'Bfrtip',
        "lengthMenu": [
          [10, 25, 50, 100, -1],
          [10, 25, 50, 100, "All"]
        ],
        "buttons": [ 'pageLength', 'copy', 'excel', 'pdf', 'print', 'colvis' ],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{{ url('listPendingDependants') }}",
            "type": "GET"
        },
        "columns": [
            { data: "DT_RowIndex", name: "DT_RowIndex" },
            { data: "fullname", name: "fullname" },
            { data: "gender", name: "gender" },
            { data: "file_no", name: "file_no" },
            { data: "hmo", name: "hmo" },
            { data: "clinic", name: "clinic" },
            // { data: "phone_number", name: "phone_number" },
            { data: "type", name: "type" },
            { data: "updated_at", name: "updated_at" },
            { data: "attend", name: "attend" },
            { data: "end", name: "end" }
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

</script>
@endsection
