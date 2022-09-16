<?php $__env->startSection('main-content'); ?>
    <div id="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">

                <div class="row mb-2">

                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Dashboard </h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard v2</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>

        <div class="content">
            <?php echo $__env->make(
                'admin.layouts.partials.dashboard.receptionist.infoBox'
            , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php if(Auth::user()->is_admin == 19): ?>
                
            <?php elseif(Auth::user()->is_admin == 20): ?>
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Control</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <ul>
                            <li><a href="<?php echo e(route('CurrentConsultationRequestlist')); ?>"><i class="fa fa-user mr-1"></i>
                                    New
                                    Consultations</a></li>
                            <li><a href="<?php echo e(url('PendingConsultationlist')); ?>"><i class="fa fa-users mr-1"></i>
                                    Pending Consultations</a></li>
                            <li><a href="<?php echo e(url('AdmittedPatients')); ?>"><i class="fa fa-plus mr-1"></i> Ward Round
                                </a></li>
                            <li><a href="<?php echo e(url('doctors', Auth::id())); ?>"><i class="fa fa-minus mr-1"></i> My
                                    Schedule/Calender
                                </a></li>
                            <li><a href="<?php echo e(url('BookedPatients')); ?>"><i class="fa fa-users mr-1"></i>
                                    Appointments
                                </a></li>
                        </ul>

                    </div>
                    <!-- /.card-body -->
                </div>
            <?php elseif(Auth::user()->is_admin == 21): ?>
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Control</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <ul>
                            <li><a href="<?php echo e(url('vitalSign')); ?>"><i class="fa fa-user mr-1"></i> Take
                                    Vital Sign</a></li>
                            <li><a href="<?php echo e(route('nurseServiceRequest')); ?>"><i class="fa fa-users mr-1"></i>
                                    Doctor Request</a></li>
                            
                        </ul>

                    </div>
                    <!-- /.card-body -->
                </div>
            <?php elseif(Auth::user()->is_admin == 22): ?>
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Control</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <ul>
                            <li><a href="<?php echo e(route('sales.index')); ?>"><i class="fa fa-user mr-1"></i> New
                                    Requests</a></li>
                            <li><a href="<?php echo e(route('receptionists.create')); ?>"><i class="fa fa-users mr-1"></i>
                                    Returning Pateint</a></li>
                            <li><a href="<?php echo e(route('transactions.edit', 1)); ?>"><i class="fa fa-users mr-1"></i> Today</a>
                            </li>
                        </ul>

                    </div>
                    <!-- /.card-body -->
                </div>
            <?php elseif(Auth::user()->is_admin == 23): ?>
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Control</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <ul>
                            <li><a href="<?php echo e(route('labs.create')); ?>"><i class="fa fa-user mr-1"></i> Add
                                    Lab</a></li>
                            <li><a href="<?php echo e(route('labs.index')); ?>"><i class="fa fa-users mr-1"></i>
                                    View Labs</a></li>
                            <li><a href="<?php echo e(route('lab-services.index')); ?>"><i class="fa fa-users mr-1"></i>
                                    View Lab Services</a></li>
                            <li><a href="<?php echo e(route('randerServices')); ?>"><i class="fa fa-users mr-1"></i>
                                    Take Sample</a></li>
                            <li><a href="<?php echo e(route('randerResult')); ?>"><i class="fa fa-users mr-1"></i>
                                    Enter Result</a></li>
                            <li><a href="<?php echo e(route('viewResult')); ?>"><i class="fa fa-users mr-1"></i> View
                                    Result</a></li>
                        </ul>

                    </div>

                    <li class="nav-item">
                        <a href="<?php echo e(route('randerServices')); ?>" class="nav-link">
                            <i class="nav-icon fa fa-search"></i>
                            <p>Take Sample</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo e(route('randerResult')); ?>" class="nav-link">
                            <i class="nav-icon fa fa-search"></i>
                            <p>Enter Result</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo e(route('viewResult')); ?>" class="nav-link">
                            <i class="nav-icon fa fa-search"></i>
                            <p>View Result</p>
                        </a>
                    </li>
                    <!-- /.card-body -->
                </div>
            <?php elseif(Auth::user()->is_admin == 24): ?>
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Control</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <ul>
                            <li><a href="<?php echo e(route('users.create')); ?>"><i class="fa fa-user mr-1"></i> New
                                    Pateint</a></li>
                            <li><a href="<?php echo e(route('receptionists.create')); ?>"><i class="fa fa-users mr-1"></i>
                                    Returning Pateint</a></li>
                            <li><a href="<?php echo e(url('doctors')); ?>"><i class="fa fa-plus mr-1"></i> Doctor Booking</a></li>
                            <li><a href="<?php echo e(url('BedRequests')); ?>"><i class="fa fa-minus mr-1"></i> Bed Requests</a></li>
                            <li><a href="<?php echo e(route('newRegistrationFormRequestList')); ?>"><i class="fa fa-users mr-1"></i> Registration Form</a></li>
                        </ul>

                    </div>
                    <!-- /.card-body -->
                </div>
            <?php endif; ?>
            <div class="card">
                
                
            </div>
        </div>
    <?php $__env->stopSection(); ?>

    <?php $__env->startSection('scripts'); ?>
        <script src="<?php echo e(asset('/plugins/dataT/jQuery-3.3.1/jquery-3.3.1.min.js')); ?>"></script>
        <script src="<?php echo e(asset('/plugins/dataT/datatables.js')); ?>" defer></script>

        <script>
            $(document).ready(function() {
                $('#customers').DataTable({
                    "dom": 'Bfrtip',
                    "lengthMenu": [
                        [10, 25, 50, 100, 200, 500, 1000, -1],
                        [10, 25, 50, 100, 200, 500, 1000, "All"]
                    ],
                    "buttons": ['pageLength', 'copy', 'excel', 'pdf', 'print', 'colvis'],
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "<?php echo e(url('listCustomers')); ?>",
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
                            data: "phone",
                            name: "phone"
                        },
                        {
                            data: "creadit",
                            name: "creadit"
                        },
                        {
                            data: "date_line",
                            name: "date_line"
                        },

                    ],
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false
                });
                $('#productsAlert').DataTable();
                $('#productsCreate').DataTable();
            });
        </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mrapollos/Documents/database/resources/views/admin/home.blade.php ENDPATH**/ ?>