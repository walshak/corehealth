<?php $__env->startSection('main-content'); ?>
    <div id="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">

                <div class="row mb-2">

                    <div class="col-sm-6">

                    </div>




                </div>

            </div>
        </div>

        <div class="container">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"> Full Transaction History</h3>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="transactions" class="table table-sm table-responsive table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Client</th>
                                    <th>Tx No</th>
                                    <th>Date</th>
                                    <th>Tx Type</th>
                                    <th>Amt (<?php echo NAIRA_CODE; ?>)</th>
                                    <th>Amt Paid (<?php echo NAIRA_CODE; ?>)</th>
                                    <th>Payment Mode</th>
                                    <th>Payment Ref</th>
                                    <th>HMO</th>
                                    <th>View</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="7"></th>
                                    <th colspan="2">Total <?php echo e(NAIRA_CODE); ?>: <span id="subtotal"></span></th>
                                    
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $id = 1; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('/plugins/dataT/jQuery-3.3.1/jquery-3.3.1.min.js')); ?>"></script>
    <!-- Bootstrap 4 -->
    <!-- <script src="<?php echo e(asset('plugins/bootstrap/js/bootstrap.min.js')); ?>"></script> -->
    <script src="<?php echo e(asset('plugins/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
    <!-- DataTables -->
    <script src="<?php echo e(asset('plugins/datatables/jquery.dataTables.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/datatables/sum().js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/datatables/dataTables.select.min.js')); ?>"></script>
    
    <script src="<?php echo e(asset('plugins/datatables/dataTables.bootstrap4.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/datatables/dataTables.buttons.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/datatables/jszip.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/datatables/pdfmake.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/datatables/vfs_fonts.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/datatables/buttons.html5.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/datatables/buttons.print.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/datatables/buttons.colVis.min.js')); ?>"></script>

    <script>
        $(function() {
            //$.noConflict();
            $('#transactions').DataTable({
                "dom": 'Bfrtip',
                "buttons": ['pageLength', 'copy', 'excel', 'pdf', 'print', 'colvis'],
                "drawCallback": function() {

                    var sumTotal = $('#transactions').DataTable().column(7).data().sum();
                    $('#subtotal').html(sumTotal);

                },
                "lengthMenu": [
                    [10, 25, 50, 100, 200, 500, 1000, 2000, 5000, -1],
                    [10, 25, 50, 100, 200, 500, 1000, 2000, 5000, "All"]
                ],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "<?php echo e(url('listTransactions')); ?>",
                    "type": "GET"
                },
                "columns": [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex"
                    },
                    {
                        data: "customer_name",
                        name: "customer_name"
                    },
                    {
                        data: "transaction_no",
                        name: "transaction_no"
                    },
                    {
                        data: "tr_date",
                        name: "tr_date"
                    },
                    {
                        data: "transaction_type",
                        name: "transaction_type"
                    },
                    {
                        data: "total_amount",
                        name: "total_amount"
                    },
                    {
                        data: "amount_paid",
                        name: "amount_paid"
                    },
                    {
                        data: "mode_of_payment_id",
                        name: "mode_of_payment_id"
                    },
                    {
                        data: "bank_transaction_id",
                        name: "bank_transaction_id"
                    },
                    {
                        data: "hmo_id",
                        name: "hmo_id"
                    },
                    {
                        data: "view",
                        name: "view"
                    }
                ],
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mrapollos/Documents/database/resources/views/admin/transactions/index.blade.php ENDPATH**/ ?>