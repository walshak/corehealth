<?php $__env->startSection('main-content'); ?>
    <div id="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">

                <div class="row mb-2">

                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Patient List </h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Patients </li>
                        </ol>
                    </div>

                </div>

            </div>
        </div>

        <div class="container">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><?php echo e(__('Patients ')); ?></h3>
                </div>

                <div class="card-body">
                    <table id="products" class="table table-sm table-responsive table-sm table-responsive table-bordered table-striped ">
                        <thead>
                            <tr>
                                <th># </th>
                                <th>Fullname</th>
                                <th>File No</th>
                                <th>HMO / Insurance</th>
                                <th>HMO Number</th>
                                <th>A/C Bal.</th>
                                <th>Date</th>
                                <th>Edit</th>
                                <th>Dependants</th>
                                <th>Note</th>
                                <th>Services Rendered</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <!-- jQuery -->
    <script src="<?php echo e(asset('/plugins/dataT/jQuery-3.3.1/jquery-3.3.1.min.js')); ?>"></script>
    <!-- Bootstrap 4 -->
    <!-- DataTables -->
    <script src="<?php echo e(asset('/plugins/dataT/datatables.js')); ?>" defer></script>

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
                    "url": "<?php echo e(url('patientsList')); ?>",
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
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mrapollos/Documents/database/resources/views/admin/patients/patient_list.blade.php ENDPATH**/ ?>