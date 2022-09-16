<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e($app->site_name); ?> | Dashboard </title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?php echo e(asset('/css/app.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('/css/font-awesome.css')); ?>">
    <!-- <link rel="stylesheet" href="<?php echo e(asset('/css/jquery.dataTables.css')); ?>"> -->
    <link rel="stylesheet"
        href="<?php echo e(asset('plugins/bootstrap-switch-master/dist/css/bootstrap4/bootstrap-switch.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('/plugins/datatables/dataTables.bootstrap4.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('/plugins/datatables/buttons.dataTables.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('/css/adminlte.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('/css/font-awesome.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('../node_modules/sweetalert2/dist/sweetalert2.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('/plugins/select2/select2.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('/plugins/datepicker/datepicker3.css')); ?>">
    <style>
        code {
            cursor:  !important pointer;
            color:  !important gray;
        }

        td {
            white-space: pre-wrap;
        }
    </style>
    <?php echo $__env->yieldContent('style'); ?>

</head>

<body class="hold-transition sidebar-mini">
    <div id="app" class="wrapper">
        <!-- Navbar -->
        <?php echo $__env->make('admin.layouts.partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php echo $__env->make('admin.layouts.partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Content Header (Page header) -->
            
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Info boxes -->
                    


                    <?php echo $__env->yieldContent('main-content'); ?>


                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <?php echo $__env->make('admin.layouts.partials.controlSidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <?php echo $__env->make('admin.layouts.partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    </div>
    <script src="<?php echo e(asset('/js/app.js')); ?>"></script>
    <script src="<?php echo e(asset('js/adminlte.min.js')); ?>"></script>
    <!-- <script src="<?php echo e(asset('../node_modules/sweetalert2/dist/sweetalert2.all.js')); ?>"></script> -->
    <?php echo $__env->make('sweetalert::alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script>
        window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token()]); ?>;
    </script>
    <script defer>
        function toggle_group(class_) {
            var x = document.getElementsByClassName(class_);
            for (i = 0; i < x.length; i++) {
                if (x[i].style.display === "none") {
                    x[i].style.display = "block";
                } else {
                    x[i].style.display = "none";
                }
            }

        }

        function clear_notifiactions(notice_id = null) {
            if(notice_id == null){
                var url = "<?php echo e(route('notifications.clear')); ?>";
            }else{
                var url = "<?php echo e(url('notifications/clear')); ?>/"+notice_id;
            }
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "<?php echo e(csrf_token()); ?>"
                },
                url: url,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    if(notice_id == null){
                        //clear the notification count badge
                        $('#unread_notification_count').text('');
                        alert('All Notifiactions have been marked as read');
                        //empty the notices list div
                        $('#notices_list').html(`
                            <a href="#" class="dropdown-item">
                                <i class="fa fa-envelope mr-2"></i> No new notifications
                            </a>
                        `);
                    }else{
                        //clear the notification count badge
                        console.log(data);
                        var notices = JSON.parse(data);


                        //empty the notices list div
                        $('#notices_list').html('');

                        for(var l = 0; l <= 10; l++ ){
                            var notice_item = `
                                <a href="#" class="dropdown-item">
                                    <small>
                                        <i class="fa fa-envelope "></i> The <b>${notices[l].data['lab_service_name']}</b> results <br> for <b>${notices[l].data['patient_name']}</b> are ready.
                                        <a class="ml-4" href="#" onclick="clear_notifiactions('${notices[l].id}')"><i class="fa fa-check "></i>Mark as read</a>
                                    </small>
                                    <span class="float-right text-muted text-sm">${notices[l].data['result_timestamp']}</span>
                                </a>
                                <div class="dropdown-divider"></div>
                            `;
                            $('#notices_list').html('');
                        }
                        $('#unread_notification_count').text(data.length);
                        //alert('All Notifiactions have been marked as read');
                    }
                }

            });
        }
    </script>
    <!-- <script src="<?php echo e(asset('js/adminlte.min.js')); ?>"></script> -->
    <?php echo $__env->yieldContent('scripts'); ?>
</body>

</html>
<?php /**PATH /home/mrapollos/Documents/database/resources/views/admin/layouts/admin.blade.php ENDPATH**/ ?>