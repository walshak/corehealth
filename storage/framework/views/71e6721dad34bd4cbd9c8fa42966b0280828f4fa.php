<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fa fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="home" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Contact</a>
        </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fa fa-bell"></i>
                <span class="badge badge-warning navbar-badge badge-sm" class="unread_notification_count">
                    <?php if(count(Auth::user()->unreadNotifications) > 0): ?>
                        <?php echo e(count(Auth::user()->unreadNotifications)); ?>

                    <?php endif; ?>
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right">
                <span class="dropdown-item dropdown-header" ><span class="unread_notification_count"><?php echo e(count(Auth::user()->unreadNotifications)); ?></span> Notifications</span>
                <div class="dropdown-divider"></div>
                <?php
                    $yy = 0;
                ?>
                <p id="notices_list">
                    <?php $__empty_1 = true; $__currentLoopData = Auth::user()->unreadNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php if($yy < 10): ?>
                            <a href="#" class="dropdown-item">
                                <small>
                                    <i class="fa fa-envelope "></i> The <b><?php echo e($notice->data['lab_service_name']); ?></b> results <br> for <b><?php echo e($notice->data['patient_name']); ?></b> are ready.
                                    
                                </small>
                                <span class="float-right text-muted text-sm"><?php echo e((date_diff(date_create(),date_create($notice->data['result_timestamp']))->format('%d days, %h hrs and %i mins ago'))); ?></span>
                            </a>
                            <div class="dropdown-divider"></div>
                        <?php endif; ?>
                        <?php
                            $yy ++;
                        ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <a href="#" class="dropdown-item">
                            <i class="fa fa-envelope mr-2"></i> No new notifications
                            
                        </a>
                    <?php endif; ?>
                </p>
                <div class="dropdown-divider"></div>

                <a href="#" class="dropdown-item dropdown-footer" onclick="clear_notifiactions()">Mark all as read</a>
            </div>
        </li>
        
        <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false" v-pre>
                <?php echo e(Auth::user()->lastname . ' ' . Auth::user()->firstname); ?> <span class="caret"></span>
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                    onclick="event.preventDefault();
                                       document.getElementById('logout-form').submit();">
                    <?php echo e(__('Logout')); ?>

                </a>

                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                    <?php echo csrf_field(); ?>
                </form>
            </div>
        </li>
    </ul>
</nav>
<?php /**PATH /home/mrapollos/Documents/database/resources/views/admin/layouts/partials/header.blade.php ENDPATH**/ ?>