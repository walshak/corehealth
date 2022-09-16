<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="" class="brand-link">
        <img src="<?php echo e(asset('/img/AdminLTELogo.png')); ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light"><?php echo e($app->site_abbreviation); ?></span>
    </a>
    <?php if(Auth::user()): ?>
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="<?php echo url('storage/image/user/' . Auth::user()->filename); ?>" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block"><?php echo e(Auth::user()->surname . ' ' . Auth::user()->firstname); ?></a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">

                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li class="nav-item has-treeview">
                        <a href="<?php echo e(route('home')); ?>" class="nav-link active">
                            <i class="nav-icon fa fa-dashboard"></i>
                            <p>Personal Dashboard <i class="right fa fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?php echo e(url('/home')); ?>" class="nav-link">
                                    <i class="fa fa-user nav-icon"></i>
                                    <p>Home</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(url('receptionists')); ?>" class="nav-link">
                                    <i class="fa fa-user nav-icon"></i>
                                    <p><?php echo e(Auth::user()->surname . '\'s Profile'); ?></p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>

                
                

                
                <?php if(Auth::user()->is_admin == 2 || Auth::user()->is_admin == 3 || Auth::user()->is_admin == 14 || Auth::user()->is_admin == 15 || Auth::user()->is_admin == 16 || Auth::user()->is_admin == 17 || Auth::user()->is_admin == 18 || Auth::user()->is_admin == 19 || Auth::user()->is_admin == 20 || Auth::user()->is_admin == 21 || Auth::user()->is_admin == 22 || Auth::user()->is_admin == 23 || Auth::user()->is_admin == 24): ?>
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <?php if(auth()->check() && auth()->user()->hasRole('Super-Admin|Admin|Receptionist')): ?>
                            <?php if(auth()->check() && auth()->user()->hasRole('Users|Receptionist')): ?>
                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fa fa-users"></i>
                                        <p> User Management
                                            <i class="right fa fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user-list')): ?>
                                                <a href="<?php echo e(url('users')); ?>" class="nav-link">
                                                    <i class="fa fa-circle-o nav-icon"></i>
                                                    <p>Users</p>
                                                </a>
                                            <?php endif; ?>

                                        </li>
                                    </ul>
                                </li>
                            <?php endif; ?>

                            <?php if(auth()->check() && auth()->user()->hasRole('Roles')): ?>
                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fa fa-lock"></i>
                                        <p> Role Management
                                            <i class="right fa fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="<?php echo e(url('roles')); ?>" class="nav-link">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                <p>Roles</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            <?php endif; ?>

                            <?php if(auth()->check() && auth()->user()->hasRole('Hmo')): ?>
                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fa fa-users"></i>
                                        <p> Hmo Management
                                            <i class="right fa fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('hmo-list')): ?>
                                                <a href="<?php echo e(route('hmos.index')); ?>" class="nav-link">
                                                    <i class="fa fa-circle-o nav-icon"></i>
                                                    <p>HMO List</p>
                                                </a>
                                            <?php endif; ?>

                                        </li>
                                        <li class="nav-item">
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('hmo-create')): ?>
                                                <a href="<?php echo e(route('hmos.create')); ?>" class="nav-link">
                                                    <i class="fa fa-circle-o nav-icon"></i>
                                                    <p>Create HMO</p>
                                                </a>
                                            <?php endif; ?>

                                        </li>
                                    </ul>
                                </li>
                            <?php endif; ?>

                            <?php if(auth()->check() && auth()->user()->hasRole('Permissions')): ?>
                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fa fa-gear"></i>
                                        <p> Permission Mgt
                                            <i class="right fa fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="<?php echo e(url('permissions')); ?>" class="nav-link">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                <p>Permissions</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            <?php endif; ?>
                        <?php endif; ?>

                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-users"></i>
                                <p> Staff Management
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    
                                    <a href="<?php echo e(url('doctors')); ?>" class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>Staff</p>
                                    </a>
                                    

                                </li>
                            </ul>
                        </li>
                        <?php if(auth()->check() && auth()->user()->hasRole('Doctor')): ?>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-linkedin-square"></i>
                                    <p>
                                        Doctors
                                        <i class="fa fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    <li class="nav-item has-treeview">
                                        <a href="<?php echo e(url('receptionists')); ?>" class="nav-link">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>My Dashboard</p>
                                        </a>

                                        <a href="<?php echo e(url('doctors', Auth::id())); ?>" class="nav-link">
                                            <i class="nav-icon fa fa-dashboard"></i>
                                            <p>Schedule/Calender</p>
                                        </a>

                                        <a href="#" class="nav-link">
                                            <i class="nav-icon fa fa-linkedin-square"></i>
                                            <p>
                                                Consultation
                                                <i class="fa fa-angle-left right"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">

                                            <li class="nav-item">
                                                <a href="<?php echo e(route('CurrentConsultationRequestlist')); ?>"
                                                    class="nav-link">
                                                    <i class="nav-icon fa fa-plus"></i>
                                                    <p>New</p>
                                                </a>
                                            </li>

                                            <li class="nav-item">
                                                <a href="<?php echo e(url('PendingConsultationlist')); ?>" class="nav-link">
                                                    <i class="nav-icon fa fa-search"></i>
                                                    <p>Pending</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?php echo e(url('PreviousConsultationlist')); ?>" class="nav-link">
                                                    <i class="nav-icon fa fa-search"></i>
                                                    <p>Previous</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?php echo e(url('BookedPatients')); ?>" class="nav-link">
                                                    <i class="nav-icon fa fa-search"></i>
                                                    <p>Appointments</p>
                                                </a>
                                            </li>

                                            <li class="nav-item">
                                                <a href="<?php echo e(url('AdmittedPatients')); ?>" class="nav-link">
                                                    <i class="nav-icon fa fa-plus"></i>
                                                    <p>Ward Round</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?php echo e(url('allConsultationlist')); ?>" class="nav-link">
                                                    <i class="nav-icon fa fa-search"></i>
                                                    <p>All Consultations</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>

                        <?php if(auth()->check() && auth()->user()->hasRole('Nurse')): ?>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-users"></i>
                                    <p> Nurse
                                        <i class="right fa fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <a href="<?php echo e(url('receptionists')); ?>" class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>My Dashboard</p>
                                    </a>
                                    <li class="nav-item">
                                        
                                        <a href="<?php echo e(url('vitalSign')); ?>" class="nav-link">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>Vital Sign</p>
                                        </a>
                                        

                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('nurseServiceRequest')); ?>" class="nav-link">
                                            <i class="nav-icon fa fa-plus"></i>
                                            <p>Doctor Request </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo e(url('allConsultationlist')); ?>" class="nav-link">
                                            <i class="nav-icon fa fa-search"></i>
                                            <p>All Consultations</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        <?php endif; ?>

                        <?php if(auth()->check() && auth()->user()->hasRole('Receptionist')): ?>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-users"></i>
                                    <p> Receptionist
                                        <i class="right fa fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        
                                        <a href="<?php echo e(route('users.create')); ?>" class="nav-link">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>New
                                                Pateint</p>
                                        </a>
                                        

                                    </li>
                                    <li class="nav-item">
                                        
                                        <a href="<?php echo e(route('receptionists.create')); ?>" class="nav-link">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>Returning Pateint</p>
                                        </a>
                                        

                                    </li>
                                    <li class="nav-item">
                                        
                                        <a href="<?php echo e(url('doctors')); ?>" class="nav-link">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>Doctor Booking</p>
                                        </a>
                                        

                                    </li>
                                    <li class="nav-item">
                                        
                                        <a href="<?php echo e(url('BedRequests')); ?>" class="nav-link">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>Bed Requests</p>
                                        </a>
                                        
                                    </li>
                                    <li class="nav-item">
                                        
                                        <a href="<?php echo e(route('newRegistrationFormRequestList')); ?>" class="nav-link">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>Registration Form</p>
                                        </a>
                                        

                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo e(url('allConsultationlist')); ?>" class="nav-link">
                                            <i class="nav-icon fa fa-search"></i>
                                            <p>All Consultations</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        
                                        <a href="<?php echo e(url('receptionists')); ?>" class="nav-link">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>My Dashboard</p>
                                        </a>
                                        

                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>

                        <?php if(auth()->check() && auth()->user()->hasRole('Receptionist|Super-Admin|Admin|Nurse|Doctor')): ?>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-linkedin-square"></i>
                                    <p>
                                        Patients
                                        <i class="fa fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href="<?php echo e(route('patient.index')); ?>" class="nav-link">
                                            <i class="nav-icon fa fa-search"></i>
                                            <p>All Patients </p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>

                        <?php if(auth()->check() && auth()->user()->hasRole('Doctor|Super-Admin|Admin|Nurse')): ?>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-linkedin-square"></i>
                                    <p>
                                        Ward Notes
                                        <i class="fa fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href="<?php echo e(route('patient.index')); ?>" class="nav-link">
                                            <i class="nav-icon fa fa-search"></i>
                                            <p>Add</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('ward_note.index')); ?>" class="nav-link">
                                            <i class="nav-icon fa fa-search"></i>
                                            <p>Manage</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>


                        <?php if(auth()->check() && auth()->user()->hasRole('Receptionist|Super-Admin|Admin|Doctor|Nurse')): ?>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-linkedin-square"></i>
                                    <p>
                                        Dependants
                                        <i class="fa fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href="<?php echo e(route('listPatients')); ?>" class="nav-link">
                                            <i class="nav-icon fa fa-plus"></i>
                                            <p>Add Dependants </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?php echo e(route('dependants.index')); ?>" class="nav-link">
                                            <i class="nav-icon fa fa-search"></i>
                                            <p>View Dependants</p>
                                        </a>
                                    </li>


                                </ul>
                            </li>
                        <?php endif; ?>

                        <?php if(auth()->check() && auth()->user()->hasRole('Technologist')): ?>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-users"></i>
                                    <p> Technologist
                                        <i class="right fa fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <a href="<?php echo e(url('receptionists')); ?>" class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>My Dashboard</p>
                                    </a>
                                    <li class="nav-item">
                                        
                                        <a href="<?php echo e(url('doctors')); ?>" class="nav-link">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>Technologist</p>
                                        </a>
                                        

                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>

                        <?php if(auth()->check() && auth()->user()->hasRole('Clinics')): ?>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-linkedin-square"></i>
                                    <p>
                                        Clinics
                                        <i class="fa fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href="<?php echo e(route('clinics.create')); ?>" class="nav-link">
                                            <i class="nav-icon fa fa-plus"></i>
                                            <p>Add Clinic </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?php echo e(route('clinics.index')); ?>" class="nav-link">
                                            <i class="nav-icon fa fa-search"></i>
                                            <p>View Clinic</p>
                                        </a>
                                    </li>


                                </ul>
                            </li>
                        <?php endif; ?>
                        <?php if(auth()->check() && auth()->user()->hasRole('Labs')): ?>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-linkedin-square"></i>
                                    <p>
                                        Labs
                                        <i class="fa fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href="<?php echo e(route('labs.create')); ?>" class="nav-link">
                                            <i class="nav-icon fa fa-plus"></i>
                                            <p>Add Lab </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?php echo e(route('labs.index')); ?>" class="nav-link">
                                            <i class="nav-icon fa fa-search"></i>
                                            <p>View Labs</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('labs.index')); ?>" class="nav-link">
                                            <i class="nav-icon fa fa-plus"></i>
                                            <p>Add Lab Service </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?php echo e(route('lab-services.index')); ?>" class="nav-link">
                                            <i class="nav-icon fa fa-search"></i>
                                            <p>View Lab Services</p>
                                        </a>
                                    </li>
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


                                </ul>
                            </li>
                        <?php endif; ?>

                        <?php if(auth()->check() && auth()->user()->hasRole('Accounts|Receptionist')): ?>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-linkedin-square"></i>
                                    <p>
                                        Accounts
                                        <i class="fa fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <?php if(auth()->check() && auth()->user()->hasRole('Accounts')): ?>
                                        <li class="nav-item has-treeview">
                                            <a href="#" class="nav-link">
                                                <i class="nav-icon fa fa-linkedin-square"></i>
                                                <p>
                                                    Payment Setings
                                                    <i class="fa fa-angle-left right"></i>
                                                </p>
                                            </a>
                                            <ul class="nav nav-treeview">

                                                <li class="nav-item">
                                                    <a href="<?php echo e(route('payment-type.create')); ?>" class="nav-link">
                                                        <i class="nav-icon fa fa-plus"></i>
                                                        <p>Add Payment Type </p>
                                                    </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a href="<?php echo e(route('payment-type.index')); ?>" class="nav-link">
                                                        <i class="nav-icon fa fa-search"></i>
                                                        <p>View Payment Types</p>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="<?php echo e(route('payment-type.index')); ?>" class="nav-link">
                                                        <i class="nav-icon fa fa-plus"></i>
                                                        <p>Add Payment Item </p>
                                                    </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a href="<?php echo e(route('payment-item.index')); ?>" class="nav-link">
                                                        <i class="nav-icon fa fa-search"></i>
                                                        <p>View Payment Items</p>
                                                    </a>
                                                </li>


                                            </ul>
                                        </li>
                                    <?php endif; ?>

                                    <li class="nav-item has-treeview">
                                        <a href="#" class="nav-link">
                                            <i class="nav-icon fa fa-linkedin-square"></i>
                                            <p>
                                                Cashier <i class="fa fa-angle-left right"></i>
                                            </p>
                                        </a>

                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('newPatients')); ?>" class="nav-link">
                                                    <i class="nav-icon fa fa-plus"></i>
                                                    <p>Pay Card (New)</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('returningPatients')); ?>" class="nav-link">
                                                    <i class="nav-icon fa fa-plus"></i>
                                                    <p>Pay Card (Returning)</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('returningPatientsBooking')); ?>"
                                                    class="nav-link">
                                                    <i class="nav-icon fa fa-plus"></i>
                                                    <p>Pay Booking (Returning)</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('labServicesPaymentRequest')); ?>"
                                                    class="nav-link">
                                                    <i class="nav-icon fa fa-search"></i>
                                                    <p>Pay Lab Test</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('nurseServicePaymentRequest')); ?>"
                                                    class="nav-link">
                                                    <i class="nav-icon fa fa-search"></i>
                                                    <p>Pay Charges</p>
                                                </a>
                                            </li>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('store-process-request')): ?>
                                                <li class="nav-item">
                                                    <a href="<?php echo e(route('sales.index')); ?>" class="nav-link">
                                                        <i class="fa fa-dot-circle nav-icon"></i>
                                                        <p>Pay Pharmacy Request </p>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('patient-account.index')); ?>" class="nav-link">
                                                    <i class="nav-icon fa fa-search"></i>
                                                    <p>View Patient Accounts</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                </ul>
                            </li>
                        <?php endif; ?>

                        <?php if(auth()->check() && auth()->user()->hasRole('Patients')): ?>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-linkedin-square"></i>
                                    <p>
                                        Patients
                                        <i class="fa fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href="<?php echo e(route('newPatients')); ?>" class="nav-link">
                                            <i class="nav-icon fa fa-plus"></i>
                                            <p>Pay Card </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?php echo e(route('newRegistrationFormRequestList')); ?>" class="nav-link">
                                            <i class="nav-icon fa fa-search"></i>
                                            <p>Registration Form</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('CurrentConsultationRequestlist')); ?>" class="nav-link">
                                            <i class="nav-icon fa fa-search"></i>
                                            <p>Consultation</p>
                                        </a>
                                    </li>


                                </ul>
                            </li>
                        <?php endif; ?>

                        <?php if(auth()->check() && auth()->user()->hasRole('Wards-Beds')): ?>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-linkedin-square"></i>
                                    <p>
                                        Ward/Beds
                                        <i class="fa fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href="<?php echo e(route('wards.create')); ?>" class="nav-link">
                                            <i class="nav-icon fa fa-plus"></i>
                                            <p>Add Ward </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?php echo e(route('wards.index')); ?>" class="nav-link">
                                            <i class="nav-icon fa fa-search"></i>
                                            <p>View Ward</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('wards.index')); ?>" class="nav-link">
                                            <i class="nav-icon fa fa-search"></i>
                                            <p>Add Bed</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('wards.index')); ?>" class="nav-link">
                                            <i class="nav-icon fa fa-search"></i>
                                            <p>View Beds</p>
                                        </a>
                                    </li>


                                </ul>
                            </li>
                        <?php endif; ?>

                        <?php if(auth()->check() && auth()->user()->hasRole('Requisition')): ?>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-circle"></i>
                                    <p>
                                        Pharmacy
                                        <i class="right fa fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview" style="display: none;">
                                    <a href="<?php echo e(url('receptionists')); ?>" class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>My Dashboard</p>
                                    </a>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('process')): ?>
                                        <li class="nav-item has-treeview">
                                            <a href="#" class="nav-link">
                                                <i class="fa fa-circle nav-icon"></i>
                                                <p>
                                                    Process
                                                    <i class="right fa fa-angle-left"></i>
                                                </p>
                                            </a>
                                            <ul class="nav nav-treeview" style="display: none;">
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('store-process-request')): ?>
                                                    <li class="nav-item">
                                                        <a href="<?php echo e(route('sales.index')); ?>" class="nav-link">
                                                            <i class="fa fa-dot-circle nav-icon"></i>
                                                            <p>New Request </p>
                                                        </a>
                                                    </li>
                                                <?php endif; ?>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('store-view-issue')): ?>
                                                    <li class="nav-item">
                                                        <a href="<?php echo e(route('transactions.edit', 1)); ?>" class="nav-link">
                                                            <i class="fa fa-dot-circle nav-icon"></i>
                                                            <p>Today </p>
                                                        </a>
                                                    </li>
                                                <?php endif; ?>
                                                <li class="nav-item">
                                                    <a href="<?php echo e(url('allConsultationlist')); ?>" class="nav-link">
                                                        <i class="nav-icon fa fa-search"></i>
                                                        <p>All Consultations</p>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        <?php endif; ?>

                        <?php if(auth()->check() && auth()->user()->hasRole('Budget')): ?>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-linkedin-square"></i>
                                    <p>
                                        Budgets
                                        <i class="fa fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <a href="<?php echo e(url('receptionists')); ?>" class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>My Dashboard</p>
                                    </a>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('budget-year.create')); ?>" class="nav-link">
                                            <i class="nav-icon fa fa-plus"></i>
                                            <p>Add New year Budget </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?php echo e(route('budget-year.index')); ?>" class="nav-link">
                                            <i class="nav-icon fa fa-search"></i>
                                            <p>View year Budget</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?php echo e(route('budget-year.index')); ?>" class="nav-link">
                                            <i class="nav-icon fa fa-search"></i>
                                            <p>Closed Year Bodged</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?php echo e(route('customers.index')); ?>" class="nav-link">
                                            <i class="nav-icon fa fa-plus"></i>
                                            <p>Add Budget To Single Client </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?php echo e(route('products.index')); ?>" class="nav-link">
                                            <i class="nav-icon fa fa-search"></i>
                                            <p>Upload Budget to Clients </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?php echo e(route('budget.index')); ?>" class="nav-link">
                                            <i class="nav-icon fa fa-search"></i>
                                            <p>View Client Budget </p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>

                        <?php if(auth()->check() && auth()->user()->hasRole('Store')): ?>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-th"></i>
                                    <p>
                                        Store
                                        <i class="right fa fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <a href="<?php echo e(url('receptionists')); ?>" class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>My Dashboard</p>
                                    </a>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('stores.index')); ?>" class="nav-link">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>Stores</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        <?php endif; ?>

                        <?php if(auth()->check() && auth()->user()->hasRole('Transaction')): ?>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-linkedin-square"></i>
                                    <p>
                                        Transactions
                                        <i class="fa fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href="<?php echo e(route('transactions.index')); ?>" class="nav-link">
                                            <i class="nav-icon fa fa-plus"></i>
                                            <p>Today</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?php echo e(route('transactions.create')); ?>" class="nav-link">
                                            <i class="nav-icon fa fa-search"></i>
                                            <p>Search</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        <?php endif; ?>

                        <?php if(auth()->check() && auth()->user()->hasRole('Treasure')): ?>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-th"></i>
                                    <p>Treasures
                                        <i class="right fa fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('treasures')): ?>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('treasure.index')); ?>" class="nav-link">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                <p>View</p>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        <?php endif; ?>

                        <?php if(auth()->check() && auth()->user()->hasRole('Ledger')): ?>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-tree"></i>
                                    <p>Ledger <i class="fa fa-angle-left right"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('stock-ledge.index')); ?>" class="nav-link">
                                            <i class="fa fa-plus nav-icon"></i>
                                            <p>Search</p>
                                        </a>
                                    </li>
                                </ul>

                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('stock-ledge.create')); ?>" class="nav-link">
                                            <i class="fa fa-plus nav-icon"></i>
                                            <p>Add</p>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('products-managers.index')); ?>" class="nav-link">
                                            <i class="fa fa-plus nav-icon"></i>
                                            <p>Managers</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>

                        <?php if(auth()->check() && auth()->user()->hasRole('Supply')): ?>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-tree"></i>
                                    <p>
                                        Supply
                                        <i class="fa fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('approve-supply')): ?>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('supply.index')); ?>" class="nav-link">
                                                <i class="fa fa-plus nav-icon"></i>
                                                <p>Approve Supply</p>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                </ul>
                                <ul class="nav nav-treeview">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('total-supply-product')): ?>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('TotalUnsupplyStock')); ?>" class="nav-link">
                                                <i class="fa fa-plus nav-icon"></i>
                                                <p>Total Unsupply Stock</p>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                </ul>
                                <ul class="nav nav-treeview">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product-managers')): ?>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('products-managers.index')); ?>" class="nav-link">
                                                <i class="fa fa-plus nav-icon"></i>
                                                <p>Products Managers</p>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                </ul>
                            </li>
                        <?php endif; ?>

                        <?php if(auth()->check() && auth()->user()->hasRole('Product-Category')): ?>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-lemon-o"></i>
                                    <p>
                                        Product Category
                                        <i class="fa fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview" style="display: none;">

                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="fa fa-plus nav-icon"></i>
                                            <p>Categories</p>
                                        </a>
                                        <ul class="nav nav-treeview" style="display: none;">
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category')): ?>
                                                <li class="nav-item">
                                                    <a href="<?php echo e(route('categories.index')); ?>" class="nav-link">
                                                        <i class="fa fa-dot-circle nav-icon"></i>
                                                        <p>View</p>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    </li>


                                </ul>
                            </li>
                        <?php endif; ?>

                        <?php if(auth()->check() && auth()->user()->hasRole('Products')): ?>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-lemon-o"></i>
                                    <p>
                                        Products
                                        <i class="fa fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('products.create')); ?>" class="nav-link">
                                            <i class="fa fa-plus nav-icon"></i>
                                            <p>Add Product</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('products.index')); ?>" class="nav-link">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>View Products</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('prices.index')); ?>" class="nav-link">
                                            <i class="fa fa-plus nav-icon"></i>
                                            <p>Price </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('prices.create')); ?>" class="nav-link">
                                            <i class="fa fa-plus nav-icon"></i>
                                            <p>View Price List </p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>

                        <?php if(auth()->check() && auth()->user()->hasRole('Invoice')): ?>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-tumblr-square"></i>
                                    <p>
                                        Invoice
                                        <i class="fa fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('invoices.index')); ?>" class="nav-link">
                                            <i class="fa fa-plus nav-icon"></i>
                                            <p>View order invoice</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        <?php endif; ?>

                        <?php if(auth()->check() && auth()->user()->hasRole('Customer')): ?>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-apple"></i>
                                    <p>
                                        Client
                                        <i class="fa fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('customers.create')); ?>" class="nav-link">
                                            <i class="fa fa-plus nav-icon"></i>
                                            <p>Add Client</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?php echo e(route('customers.index')); ?>" class="nav-link">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>View Client</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        <?php endif; ?>

                        <?php if(auth()->check() && auth()->user()->hasRole('Borrow')): ?>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-windows"></i>
                                    <p>Borrow <i class="fa fa-angle-left right"></i> </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('customers.create')); ?>" class="nav-link">
                                            <i class="fa fa-plus nav-icon"></i>
                                            <p>New Borrow </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?php echo e(route('borrows.index')); ?>" class="nav-link">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>View Today Borrow</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('customers.index')); ?>" class="nav-link">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>View Borrow</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        <?php endif; ?>

                        <?php if(auth()->check() && auth()->user()->hasRole('Expenses')): ?>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-android"></i>
                                    <p>
                                        Expenses
                                        <i class="fa fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('expenses.create')); ?>" class="nav-link">
                                            <i class="fa fa-plus nav-icon"></i>
                                            <p>Add Daily Expenses</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('expenses.index')); ?>" class="nav-link">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>View Today Expenses</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?php echo e(route('expenses.index')); ?>" class="nav-link">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>View Expenses</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        <?php endif; ?>

                        <?php if(auth()->check() && auth()->user()->hasRole('Suppliers')): ?>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-linux"></i>
                                    <p>
                                        Suppliers
                                        <i class="fa fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('suppliers.create')); ?>" class="nav-link">
                                            <i class="fa fa-plus nav-icon"></i>
                                            <p>Add Suppliers</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="pages/UI/icons.html" class="nav-link">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>Enter Stocks for Invoice</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('suppliers.index')); ?>" class="nav-link">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>View Suppliers</p>
                                        </a>
                                    </li>
                                    
                                </ul>
                            </li>
                        <?php endif; ?>

                        <?php if(auth()->check() && auth()->user()->hasRole('Report')): ?>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-bar-chart-o"></i>
                                    <p>
                                        Report
                                        <i class="fa fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="" class="nav-link">
                                            <i class="fa fa-plus nav-icon"></i>
                                            <p>Reports</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>

                        <?php if(auth()->check() && auth()->user()->hasRole('Credit-Date-Line')): ?>
                            <li class="nav-item has-treeview menu-open">
                                <a href="<?php echo e(route('listcustomerDateline')); ?>" class="nav-link active">
                                    <i class="nav-icon fa fa-calendar"></i>
                                    <p>Credit Date-Line</p>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if(auth()->check() && auth()->user()->hasRole('Promotion')): ?>
                            <li class="nav-item has-treeview menu-open">
                                <a href="<?php echo e(route('promotion.index')); ?>" class="nav-link active">
                                    <i class="nav-icon fa fa-credit-card"></i>
                                    <p>Promotions</p>
                                </a>

                            </li>
                        <?php endif; ?>

                        <?php if(auth()->check() && auth()->user()->hasRole('System-Setting')): ?>
                            <li class="nav-item has-treeview">
                                <a href="<?php echo e(route('home')); ?>" class="nav-link active">
                                    <i class="nav-icon fa fa-cog"></i>
                                    <p>System Settings <i class="right fa fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('backup.index')); ?>" class="nav-link">
                                            <i class="fa fa-user nav-icon"></i>
                                            <p>Database Backup</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>


                        <li class="nav-item has-treeview menu-open">
                            <a href="<?php echo e(url('/logout')); ?>"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="nav-link active">
                                <i class="nav-icon fa fa-minus-square"></i>
                                <p>Logout</p>
                            </a>
                        </li>


                    </ul>
                    
                <?php endif; ?>
            </nav>
        </div>
    <?php endif; ?>
</aside>
<?php /**PATH /home/mrapollos/Documents/database/resources/views/admin/layouts/partials/sidebar.blade.php ENDPATH**/ ?>