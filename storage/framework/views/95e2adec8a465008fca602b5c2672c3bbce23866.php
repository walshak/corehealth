<?php $__env->startSection('main-content'); ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Pending Requests</li>
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
                                    <h5>List of Phamarcy Pending Request
                                    </h5>
                                    <?php if(auth()->check() && auth()->user()->hasRole('Requisition|Admin|Super-Admin')): ?>
                                        <a class="btn btn-success text-light" data-toggle="modal" id="mediumButton"
                                            data-target="#newPharmReqModal" data-attr="' . $pc->id . '" title="Enter Charges">
                                            <i class="fas fa-plus-circle"></i> Create Pharmacy Service Request
                                        </a>
                                    <?php endif; ?>
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
                                        <th> Patient</th>
                                        <th> Report No</th>
                                        <th> Date</th>
                                        
                                        <th> Process </th>
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
    
    <div class="modal fade" id="newPharmReqModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="card border-info mb-6">
                        <?php echo Form::open(['route' => 'createSaleRequest', 'method' => 'POST', 'class' => 'form-horizontal']); ?>

                        <?php echo e(csrf_field()); ?>


                        <div class="card-header bg-transparent border-info"><?php echo e(__('New Pahrmacy Service Request ')); ?>

                        </div>
                        <div class="card-body">

                            <input type="hidden" name="payment_type_id" value="3">
                            

                            <div class="form-group ">

                                <div class="col-sm-12">
                                    <label for="Total Amount" class="control-label">Select patient</label>
                                    <select name="patient_id" id="patient_id" class="selectpicker form-control select2"
                                        data-live-search="true" required>
                                        <option value="not-apply">NON REGISTERED</option>
                                        <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($p->user_id); ?>"
                                                data-tokens="<?php echo e(ucfirst($p->user->surname)); ?> <?php echo e(ucfirst($p->user->firstname)); ?> <?php echo e(ucfirst($p->user->lastname)); ?> <?php echo e($p->file_no); ?>">
                                                <?php echo e(ucfirst($p->user->surname)); ?>, <?php echo e(ucfirst($p->user->firstname)); ?>

                                                <?php echo e(ucfirst($p->user->lastname)); ?>(<?php echo e($p->file_no); ?>)
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    
                                </div>
                            </div>
                            

                            <div class="form-group">
                                <label for="service_description2" class="control-label">Service Description</label>
                                <textarea id="service_description2" name="service_description" cols="15" rows="10" class="form-control"
                                    placeholder="Enter Result">
                                <?php echo e(old('service_description')); ?>

                                </textarea>

                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-info">
                            <div class="form-group row">

                                <div class="col-md-6 "><button type="submit" class="btn btn-primary "> <i
                                            class="fa fa-send"></i> Craete Pharmacy Service Request </button></div>
                            </div>
                        </div>
                        <?php echo Form::close(); ?>


                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>
                </div>
                <div class="modal-body" id="mediumBody">
                    <div>
                        <!-- the result to be displayed apply here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('plugins/jQuery/jquery.min.js')); ?>"></script>

    <!-- Bootstrap 3.3.6 -->
    
    
    <script src="<?php echo e(asset('plugins/datatables/jquery.dataTables.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/datatables/sum().js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/datatables/dataTables.bootstrap4.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/datatables/dataTables.buttons.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/datatables/jszip.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/datatables/pdfmake.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/datatables/vfs_fonts.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/datatables/buttons.html5.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/datatables/buttons.print.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/datatables/buttons.colVis.min.js')); ?>"></script>
    
    <script src="<?php echo e(asset('../node_modules/sweetalert2/dist/sweetalert2.all.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/ckeditor/ckeditor.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/select2/select2.min.js')); ?>"></script>

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
                    "url": "<?php echo e(url('listRequest')); ?>",
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
                        data: 'patient',
                        name: 'patient'
                    },
                    {
                        data: 'transaction_no',
                        name: 'transaction_no'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    // {
                    //     data: 'account',
                    //     name: 'account'
                    // },
                    {
                        data: 'process',
                        name: 'process'
                    },

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

        $(document).ready(function() {
            $.noConflict();
            CKEDITOR.replace('service_description2');
        });
        $('.select2').select2({
            dropdownParent: $("#newPharmReqModal")
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mrapollos/Documents/database/resources/views/admin/sales/index.blade.php ENDPATH**/ ?>