<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="" class="brand-link">
        <img src="{{ asset('/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">{{ $app->site_abbreviation }}</span>
    </a>
    @if (Auth::user())
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{!! url('storage/image/user/' . Auth::user()->filename) !!}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ Auth::user()->surname . ' ' . Auth::user()->firstname }}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">

                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li class="nav-item has-treeview">
                        <a href="{{ route('home') }}" class="nav-link active">
                            <i class="nav-icon fa fa-dashboard"></i>
                            <p>Personal Dashboard <i class="right fa fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ url('/home') }}" class="nav-link">
                                    <i class="fa fa-user nav-icon"></i>
                                    <p>Home</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('receptionists') }}" class="nav-link">
                                    <i class="fa fa-user nav-icon"></i>
                                    <p>{{ Auth::user()->surname . '\'s Profile' }}</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>

                {{-- Guess --}}
                {{-- @if (Auth::user()->is_admin == 1) --}}

                {{-- Admin --}}
                @if (Auth::user()->is_admin == 2 || Auth::user()->is_admin == 3 || Auth::user()->is_admin == 14 || Auth::user()->is_admin == 15 || Auth::user()->is_admin == 16 || Auth::user()->is_admin == 17 || Auth::user()->is_admin == 18 || Auth::user()->is_admin == 19 || Auth::user()->is_admin == 20 || Auth::user()->is_admin == 21 || Auth::user()->is_admin == 22 || Auth::user()->is_admin == 23 || Auth::user()->is_admin == 24)
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        @hasrole('Super-Admin|Admin|Receptionist')
                            @hasrole('Users|Receptionist')
                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fa fa-users"></i>
                                        <p> User Management
                                            <i class="right fa fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            @can('user-list')
                                                <a href="{{ url('users') }}" class="nav-link">
                                                    <i class="fa fa-circle-o nav-icon"></i>
                                                    <p>Users</p>
                                                </a>
                                            @endcan

                                        </li>
                                    </ul>
                                </li>
                            @endhasrole

                            @hasrole('Roles')
                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fa fa-lock"></i>
                                        <p> Role Management
                                            <i class="right fa fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ url('roles') }}" class="nav-link">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                <p>Roles</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endhasrole

                            @hasrole('Hmo')
                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fa fa-users"></i>
                                        <p> Hmo Management
                                            <i class="right fa fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            @can('hmo-list')
                                                <a href="{{ route('hmos.index') }}" class="nav-link">
                                                    <i class="fa fa-circle-o nav-icon"></i>
                                                    <p>HMO List</p>
                                                </a>
                                            @endcan

                                        </li>
                                        <li class="nav-item">
                                            @can('hmo-create')
                                                <a href="{{ route('hmos.create') }}" class="nav-link">
                                                    <i class="fa fa-circle-o nav-icon"></i>
                                                    <p>Create HMO</p>
                                                </a>
                                            @endcan

                                        </li>
                                    </ul>
                                </li>
                            @endhasrole

                            @hasrole('Permissions')
                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fa fa-gear"></i>
                                        <p> Permission Mgt
                                            <i class="right fa fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ url('permissions') }}" class="nav-link">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                <p>Permissions</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endhasrole
                        @endhasrole

                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-users"></i>
                                <p> Staff Management
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    {{-- @can('user-list') --}}
                                    <a href="{{ url('doctors') }}" class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>Staff</p>
                                    </a>
                                    {{-- @endcan --}}

                                </li>
                            </ul>
                        </li>
                        @hasrole('Doctor')
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
                                        <a href="{{ url('receptionists') }}" class="nav-link">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>My Dashboard</p>
                                        </a>

                                        <a href="{{ url('doctors', Auth::id()) }}" class="nav-link">
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
                                                <a href="{{ route('CurrentConsultationRequestlist') }}"
                                                    class="nav-link">
                                                    <i class="nav-icon fa fa-plus"></i>
                                                    <p>New</p>
                                                </a>
                                            </li>

                                            <li class="nav-item">
                                                <a href="{{ url('PendingConsultationlist') }}" class="nav-link">
                                                    <i class="nav-icon fa fa-search"></i>
                                                    <p>Pending</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ url('PreviousConsultationlist') }}" class="nav-link">
                                                    <i class="nav-icon fa fa-search"></i>
                                                    <p>Previous</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ url('BookedPatients') }}" class="nav-link">
                                                    <i class="nav-icon fa fa-search"></i>
                                                    <p>Appointments</p>
                                                </a>
                                            </li>

                                            <li class="nav-item">
                                                <a href="{{ url('AdmittedPatients') }}" class="nav-link">
                                                    <i class="nav-icon fa fa-plus"></i>
                                                    <p>Ward Round</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ url('allConsultationlist') }}" class="nav-link">
                                                    <i class="nav-icon fa fa-search"></i>
                                                    <p>All Consultations</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        @endhasrole

                        @hasrole('Nurse')
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-users"></i>
                                    <p> Nurse
                                        <i class="right fa fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <a href="{{ url('receptionists') }}" class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>My Dashboard</p>
                                    </a>
                                    <li class="nav-item">
                                        {{-- @can('user-list') --}}
                                        <a href="{{ url('vitalSign') }}" class="nav-link">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>Vital Sign</p>
                                        </a>
                                        {{-- @endcan --}}

                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('nurseServiceRequest') }}" class="nav-link">
                                            <i class="nav-icon fa fa-plus"></i>
                                            <p>Doctor Request </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('allConsultationlist') }}" class="nav-link">
                                            <i class="nav-icon fa fa-search"></i>
                                            <p>All Consultations</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        @endhasrole

                        @hasrole('Receptionist')
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-users"></i>
                                    <p> Receptionist
                                        <i class="right fa fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        {{-- @can('user-list') --}}
                                        <a href="{{ route('users.create') }}" class="nav-link">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>New
                                                Pateint</p>
                                        </a>
                                        {{-- @endcan --}}

                                    </li>
                                    <li class="nav-item">
                                        {{-- @can('user-list') --}}
                                        <a href="{{ route('receptionists.create') }}" class="nav-link">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>Returning Pateint</p>
                                        </a>
                                        {{-- @endcan --}}

                                    </li>
                                    <li class="nav-item">
                                        {{-- @can('user-list') --}}
                                        <a href="{{ url('doctors') }}" class="nav-link">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>Doctor Booking</p>
                                        </a>
                                        {{-- @endcan --}}

                                    </li>
                                    <li class="nav-item">
                                        {{-- @can('user-list') --}}
                                        <a href="{{ url('BedRequests') }}" class="nav-link">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>Bed Requests</p>
                                        </a>
                                        {{-- @endcan --}}
                                    </li>
                                    <li class="nav-item">
                                        {{-- @can('user-list') --}}
                                        <a href="{{ route('newRegistrationFormRequestList') }}" class="nav-link">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>Registration Form</p>
                                        </a>
                                        {{-- @endcan --}}

                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('allConsultationlist') }}" class="nav-link">
                                            <i class="nav-icon fa fa-search"></i>
                                            <p>All Consultations</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        {{-- @can('user-list') --}}
                                        <a href="{{ url('receptionists') }}" class="nav-link">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>My Dashboard</p>
                                        </a>
                                        {{-- @endcan --}}

                                    </li>
                                </ul>
                            </li>
                        @endhasrole

                        @hasrole('Receptionist|Super-Admin|Admin|Nurse|Doctor')
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
                                        <a href="{{ route('patient.index') }}" class="nav-link">
                                            <i class="nav-icon fa fa-search"></i>
                                            <p>All Patients </p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endhasrole

                        @hasrole('Doctor|Super-Admin|Admin|Nurse')
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
                                        <a href="{{ route('patient.index') }}" class="nav-link">
                                            <i class="nav-icon fa fa-search"></i>
                                            <p>Add</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('ward_note.index') }}" class="nav-link">
                                            <i class="nav-icon fa fa-search"></i>
                                            <p>Manage</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endhasrole


                        @hasrole('Receptionist|Super-Admin|Admin|Doctor|Nurse')
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
                                        <a href="{{ route('listPatients') }}" class="nav-link">
                                            <i class="nav-icon fa fa-plus"></i>
                                            <p>Add Dependants </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('dependants.index') }}" class="nav-link">
                                            <i class="nav-icon fa fa-search"></i>
                                            <p>View Dependants</p>
                                        </a>
                                    </li>


                                </ul>
                            </li>
                        @endhasrole

                        @hasrole('Technologist')
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-users"></i>
                                    <p> Technologist
                                        <i class="right fa fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <a href="{{ url('receptionists') }}" class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>My Dashboard</p>
                                    </a>
                                    <li class="nav-item">
                                        {{-- @can('user-list') --}}
                                        <a href="{{ url('doctors') }}" class="nav-link">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>Technologist</p>
                                        </a>
                                        {{-- @endcan --}}

                                    </li>
                                </ul>
                            </li>
                        @endhasrole

                        @hasrole('Clinics')
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
                                        <a href="{{ route('clinics.create') }}" class="nav-link">
                                            <i class="nav-icon fa fa-plus"></i>
                                            <p>Add Clinic </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('clinics.index') }}" class="nav-link">
                                            <i class="nav-icon fa fa-search"></i>
                                            <p>View Clinic</p>
                                        </a>
                                    </li>


                                </ul>
                            </li>
                        @endhasrole
                        @hasrole('Labs')
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
                                        <a href="{{ route('labs.create') }}" class="nav-link">
                                            <i class="nav-icon fa fa-plus"></i>
                                            <p>Add Lab </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('labs.index') }}" class="nav-link">
                                            <i class="nav-icon fa fa-search"></i>
                                            <p>View Labs</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('labs.index') }}" class="nav-link">
                                            <i class="nav-icon fa fa-plus"></i>
                                            <p>Add Lab Service </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('lab-services.index') }}" class="nav-link">
                                            <i class="nav-icon fa fa-search"></i>
                                            <p>View Lab Services</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('randerServices') }}" class="nav-link">
                                            <i class="nav-icon fa fa-search"></i>
                                            <p>Take Sample</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('randerResult') }}" class="nav-link">
                                            <i class="nav-icon fa fa-search"></i>
                                            <p>Enter Result</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('viewResult') }}" class="nav-link">
                                            <i class="nav-icon fa fa-search"></i>
                                            <p>View Result</p>
                                        </a>
                                    </li>


                                </ul>
                            </li>
                        @endhasrole

                        @hasrole('Accounts|Receptionist')
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-linkedin-square"></i>
                                    <p>
                                        Accounts
                                        <i class="fa fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @hasrole('Accounts')
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
                                                    <a href="{{ route('payment-type.create') }}" class="nav-link">
                                                        <i class="nav-icon fa fa-plus"></i>
                                                        <p>Add Payment Type </p>
                                                    </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a href="{{ route('payment-type.index') }}" class="nav-link">
                                                        <i class="nav-icon fa fa-search"></i>
                                                        <p>View Payment Types</p>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="{{ route('payment-type.index') }}" class="nav-link">
                                                        <i class="nav-icon fa fa-plus"></i>
                                                        <p>Add Payment Item </p>
                                                    </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a href="{{ route('payment-item.index') }}" class="nav-link">
                                                        <i class="nav-icon fa fa-search"></i>
                                                        <p>View Payment Items</p>
                                                    </a>
                                                </li>


                                            </ul>
                                        </li>
                                    @endhasrole

                                    <li class="nav-item has-treeview">
                                        <a href="#" class="nav-link">
                                            <i class="nav-icon fa fa-linkedin-square"></i>
                                            <p>
                                                Cashier <i class="fa fa-angle-left right"></i>
                                            </p>
                                        </a>

                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="{{ route('newPatients') }}" class="nav-link">
                                                    <i class="nav-icon fa fa-plus"></i>
                                                    <p>Pay Card (New)</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('returningPatients') }}" class="nav-link">
                                                    <i class="nav-icon fa fa-plus"></i>
                                                    <p>Pay Card (Returning)</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('returningPatientsBooking') }}"
                                                    class="nav-link">
                                                    <i class="nav-icon fa fa-plus"></i>
                                                    <p>Pay Booking (Returning)</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('labServicesPaymentRequest') }}"
                                                    class="nav-link">
                                                    <i class="nav-icon fa fa-search"></i>
                                                    <p>Pay Lab Test</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('nurseServicePaymentRequest') }}"
                                                    class="nav-link">
                                                    <i class="nav-icon fa fa-search"></i>
                                                    <p>Pay Charges</p>
                                                </a>
                                            </li>
                                            @can('store-process-request')
                                                <li class="nav-item">
                                                    <a href="{{ route('sales.index') }}" class="nav-link">
                                                        <i class="fa fa-dot-circle nav-icon"></i>
                                                        <p>Pay Pharmacy Request </p>
                                                    </a>
                                                </li>
                                            @endcan
                                            <li class="nav-item">
                                                <a href="{{ route('patient-account.index') }}" class="nav-link">
                                                    <i class="nav-icon fa fa-search"></i>
                                                    <p>View Patient Accounts</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                </ul>
                            </li>
                        @endhasrole

                        @hasrole('Patients')
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
                                        <a href="{{ route('newPatients') }}" class="nav-link">
                                            <i class="nav-icon fa fa-plus"></i>
                                            <p>Pay Card </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('newRegistrationFormRequestList') }}" class="nav-link">
                                            <i class="nav-icon fa fa-search"></i>
                                            <p>Registration Form</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('CurrentConsultationRequestlist') }}" class="nav-link">
                                            <i class="nav-icon fa fa-search"></i>
                                            <p>Consultation</p>
                                        </a>
                                    </li>


                                </ul>
                            </li>
                        @endhasrole

                        @hasrole('Wards-Beds')
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
                                        <a href="{{ route('wards.create') }}" class="nav-link">
                                            <i class="nav-icon fa fa-plus"></i>
                                            <p>Add Ward </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('wards.index') }}" class="nav-link">
                                            <i class="nav-icon fa fa-search"></i>
                                            <p>View Ward</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('wards.index') }}" class="nav-link">
                                            <i class="nav-icon fa fa-search"></i>
                                            <p>Add Bed</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('wards.index') }}" class="nav-link">
                                            <i class="nav-icon fa fa-search"></i>
                                            <p>View Beds</p>
                                        </a>
                                    </li>


                                </ul>
                            </li>
                        @endhasrole

                        @hasrole('Requisition')
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-circle"></i>
                                    <p>
                                        Pharmacy
                                        <i class="right fa fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview" style="display: none;">
                                    <a href="{{ url('receptionists') }}" class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>My Dashboard</p>
                                    </a>
                                    @can('process')
                                        <li class="nav-item has-treeview">
                                            <a href="#" class="nav-link">
                                                <i class="fa fa-circle nav-icon"></i>
                                                <p>
                                                    Process
                                                    <i class="right fa fa-angle-left"></i>
                                                </p>
                                            </a>
                                            <ul class="nav nav-treeview" style="display: none;">
                                                @can('store-process-request')
                                                    <li class="nav-item">
                                                        <a href="{{ route('sales.index') }}" class="nav-link">
                                                            <i class="fa fa-dot-circle nav-icon"></i>
                                                            <p>New Request </p>
                                                        </a>
                                                    </li>
                                                @endcan
                                                @can('store-view-issue')
                                                    <li class="nav-item">
                                                        <a href="{{ route('transactions.edit', 1) }}" class="nav-link">
                                                            <i class="fa fa-dot-circle nav-icon"></i>
                                                            <p>Today </p>
                                                        </a>
                                                    </li>
                                                @endcan
                                                <li class="nav-item">
                                                    <a href="{{ url('allConsultationlist') }}" class="nav-link">
                                                        <i class="nav-icon fa fa-search"></i>
                                                        <p>All Consultations</p>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endhasrole

                        @hasrole('Budget')
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-linkedin-square"></i>
                                    <p>
                                        Budgets
                                        <i class="fa fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <a href="{{ url('receptionists') }}" class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>My Dashboard</p>
                                    </a>
                                    <li class="nav-item">
                                        <a href="{{ route('budget-year.create') }}" class="nav-link">
                                            <i class="nav-icon fa fa-plus"></i>
                                            <p>Add New year Budget </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('budget-year.index') }}" class="nav-link">
                                            <i class="nav-icon fa fa-search"></i>
                                            <p>View year Budget</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('budget-year.index') }}" class="nav-link">
                                            <i class="nav-icon fa fa-search"></i>
                                            <p>Closed Year Bodged</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('customers.index') }}" class="nav-link">
                                            <i class="nav-icon fa fa-plus"></i>
                                            <p>Add Budget To Single Client </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('products.index') }}" class="nav-link">
                                            <i class="nav-icon fa fa-search"></i>
                                            <p>Upload Budget to Clients </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('budget.index') }}" class="nav-link">
                                            <i class="nav-icon fa fa-search"></i>
                                            <p>View Client Budget </p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endhasrole

                        @hasrole('Store')
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-th"></i>
                                    <p>
                                        Store
                                        <i class="right fa fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <a href="{{ url('receptionists') }}" class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>My Dashboard</p>
                                    </a>
                                    <li class="nav-item">
                                        <a href="{{ route('stores.index') }}" class="nav-link">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>Stores</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        @endhasrole

                        @hasrole('Transaction')
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
                                        <a href="{{ route('transactions.index') }}" class="nav-link">
                                            <i class="nav-icon fa fa-plus"></i>
                                            <p>Today</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('transactions.create') }}" class="nav-link">
                                            <i class="nav-icon fa fa-search"></i>
                                            <p>Search</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        @endhasrole

                        @hasrole('Treasure')
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-th"></i>
                                    <p>Treasures
                                        <i class="right fa fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('treasures')
                                        <li class="nav-item">
                                            <a href="{{ route('treasure.index') }}" class="nav-link">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                <p>View</p>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endhasrole

                        @hasrole('Ledger')
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-tree"></i>
                                    <p>Ledger <i class="fa fa-angle-left right"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('stock-ledge.index') }}" class="nav-link">
                                            <i class="fa fa-plus nav-icon"></i>
                                            <p>Search</p>
                                        </a>
                                    </li>
                                </ul>

                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('stock-ledge.create') }}" class="nav-link">
                                            <i class="fa fa-plus nav-icon"></i>
                                            <p>Add</p>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('products-managers.index') }}" class="nav-link">
                                            <i class="fa fa-plus nav-icon"></i>
                                            <p>Managers</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endhasrole

                        @hasrole('Supply')
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-tree"></i>
                                    <p>
                                        Supply
                                        <i class="fa fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    @can('approve-supply')
                                        <li class="nav-item">
                                            <a href="{{ route('supply.index') }}" class="nav-link">
                                                <i class="fa fa-plus nav-icon"></i>
                                                <p>Approve Supply</p>
                                            </a>
                                        </li>
                                    @endcan

                                </ul>
                                <ul class="nav nav-treeview">
                                    @can('total-supply-product')
                                        <li class="nav-item">
                                            <a href="{{ route('TotalUnsupplyStock') }}" class="nav-link">
                                                <i class="fa fa-plus nav-icon"></i>
                                                <p>Total Unsupply Stock</p>
                                            </a>
                                        </li>
                                    @endcan

                                </ul>
                                <ul class="nav nav-treeview">
                                    @can('product-managers')
                                        <li class="nav-item">
                                            <a href="{{ route('products-managers.index') }}" class="nav-link">
                                                <i class="fa fa-plus nav-icon"></i>
                                                <p>Products Managers</p>
                                            </a>
                                        </li>
                                    @endcan

                                </ul>
                            </li>
                        @endhasrole

                        @hasrole('Product-Category')
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
                                            @can('category')
                                                <li class="nav-item">
                                                    <a href="{{ route('categories.index') }}" class="nav-link">
                                                        <i class="fa fa-dot-circle nav-icon"></i>
                                                        <p>View</p>
                                                    </a>
                                                </li>
                                            @endcan
                                        </ul>
                                    </li>


                                </ul>
                            </li>
                        @endhasrole

                        @hasrole('Products')
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
                                        <a href="{{ route('products.create') }}" class="nav-link">
                                            <i class="fa fa-plus nav-icon"></i>
                                            <p>Add Product</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('products.index') }}" class="nav-link">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>View Products</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('prices.index') }}" class="nav-link">
                                            <i class="fa fa-plus nav-icon"></i>
                                            <p>Price </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('prices.create') }}" class="nav-link">
                                            <i class="fa fa-plus nav-icon"></i>
                                            <p>View Price List </p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endhasrole

                        @hasrole('Invoice')
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
                                        <a href="{{ route('invoices.index') }}" class="nav-link">
                                            <i class="fa fa-plus nav-icon"></i>
                                            <p>View order invoice</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        @endhasrole

                        @hasrole('Customer')
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
                                        <a href="{{ route('customers.create') }}" class="nav-link">
                                            <i class="fa fa-plus nav-icon"></i>
                                            <p>Add Client</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('customers.index') }}" class="nav-link">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>View Client</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        @endhasrole

                        @hasrole('Borrow')
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-windows"></i>
                                    <p>Borrow <i class="fa fa-angle-left right"></i> </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('customers.create') }}" class="nav-link">
                                            <i class="fa fa-plus nav-icon"></i>
                                            <p>New Borrow </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('borrows.index') }}" class="nav-link">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>View Today Borrow</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('customers.index') }}" class="nav-link">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>View Borrow</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        @endhasrole

                        @hasrole('Expenses')
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
                                        <a href="{{ route('expenses.create') }}" class="nav-link">
                                            <i class="fa fa-plus nav-icon"></i>
                                            <p>Add Daily Expenses</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('expenses.index') }}" class="nav-link">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>View Today Expenses</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('expenses.index') }}" class="nav-link">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>View Expenses</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        @endhasrole

                        @hasrole('Suppliers')
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
                                        <a href="{{ route('suppliers.create') }}" class="nav-link">
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
                                        <a href="{{ route('suppliers.index') }}" class="nav-link">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>View Suppliers</p>
                                        </a>
                                    </li>
                                    {{-- <li class="nav-item">
                            <a href="pages/UI/sliders.html" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>View Stokes</p>
                            </a>
                        </li> --}}
                                </ul>
                            </li>
                        @endhasrole

                        @hasrole('Report')
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
                        @endhasrole

                        @hasrole('Credit-Date-Line')
                            <li class="nav-item has-treeview menu-open">
                                <a href="{{ route('listcustomerDateline') }}" class="nav-link active">
                                    <i class="nav-icon fa fa-calendar"></i>
                                    <p>Credit Date-Line</p>
                                </a>
                            </li>
                        @endhasrole

                        @hasrole('Promotion')
                            <li class="nav-item has-treeview menu-open">
                                <a href="{{ route('promotion.index') }}" class="nav-link active">
                                    <i class="nav-icon fa fa-credit-card"></i>
                                    <p>Promotions</p>
                                </a>

                            </li>
                        @endhasrole

                        @hasrole('System-Setting')
                            <li class="nav-item has-treeview">
                                <a href="{{ route('home') }}" class="nav-link active">
                                    <i class="nav-icon fa fa-cog"></i>
                                    <p>System Settings <i class="right fa fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('backup.index') }}" class="nav-link">
                                            <i class="fa fa-user nav-icon"></i>
                                            <p>Database Backup</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endhasrole


                        <li class="nav-item has-treeview menu-open">
                            <a href="{{ url('/logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="nav-link active">
                                <i class="nav-icon fa fa-minus-square"></i>
                                <p>Logout</p>
                            </a>
                        </li>


                    </ul>
                    {{-- @elseif (Auth::user()->is_admin == 3 || Auth::user()->is_admin == 14)
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @hasrole('Super-Admin|Admin|Users|Roles|Permissions')

                @hasrole('Users')
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-users"></i>
                        <p> User Management
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            @can('user-list')
                            <a href="{{ url('users') }}" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>Users</p>
                            </a>
                            @endcan

                        </li>
                    </ul>
                </li>
                @endhasrole

                @hasrole('Roles')
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-lock"></i>
                        <p> Role Management
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('roles') }}" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>Roles</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endhasrole

                @hasrole('Permissions')
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-gear"></i>
                        <p> Permission Mgt
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('permissions') }}" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>Permissions</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endhasrole

                @endhasrole

                @hasrole('Store')
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-th"></i>
                        <p>Store
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('stores')
                        <li class="nav-item">
                            <a href="{{ route('stores.index') }}" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>Stores</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endhasrole

                @hasrole('Store')
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-th"></i>
                        <p>Store
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('stores')
                        <li class="nav-item">
                            <a href="{{ route('stores.index') }}" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>Stores</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endhasrole

                @hasrole('Sales')
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-facebook-square"></i>
                        <p> Sales <i class="fa fa-angle-left right"></i> </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('sales')
                        <li class="nav-item">
                            <a href="{{route('sales.index')}}" class="nav-link">
                                <i class="fa fa-plus nav-icon"></i>
                                <p>Make Sales</p>
                            </a>
                        </li>
                        @endcan

                        @can('transaction-edit')
                        <li class="nav-item">
                            <a href="{{route('transactions.edit',1)}}" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>Today Sales</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endhasrole

                @hasrole('Transaction')
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-linkedin-square"></i>
                        <p>Transactions
                            <i class="fa fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        @can('transactions')
                        <li class="nav-item">
                            <a href="{{ route('transactions.index') }}" class="nav-link">
                                <i class="nav-icon fa fa-plus"></i>
                                <p>Today</p>
                            </a>
                        </li>
                        @endcan

                        @can('transaction-create')
                        <li class="nav-item">
                            <a href="{{ route('transactions.create') }}" class="nav-link">
                                <i class="nav-icon fa fa-search"></i>
                                <p>Search</p>
                            </a>
                        </li>
                        @endcan

                    </ul>
                </li>
                @endhasrole

                @hasrole('Treasure')
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-th"></i>
                        <p>Treasures
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('treasures')
                        <li class="nav-item">
                            <a href="{{ route('treasure.index') }}" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>View</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endhasrole

                @hasrole('Ledger')
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-tree"></i>
                        <p>Ledger <i class="fa fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('stock-ledge.index')}}" class="nav-link">
                                <i class="fa fa-plus nav-icon"></i>
                                <p>Search</p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('stock-ledge.create')}}" class="nav-link">
                                <i class="fa fa-plus nav-icon"></i>
                                <p>Add</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('products-managers.index')}}" class="nav-link">
                                <i class="fa fa-plus nav-icon"></i>
                                <p>Managers</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endhasrole

                @hasrole('Supply')
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-tree"></i>
                        <p>
                            Supply
                            <i class="fa fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('supply.index')}}" class="nav-link">
                                <i class="fa fa-plus nav-icon"></i>
                                <p>Approve Supply</p>
                            </a>
                        </li>

                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('TotalUnsupplyStock')}}" class="nav-link">
                                <i class="fa fa-plus nav-icon"></i>
                                <p>Total Unsupply Stock</p>
                            </a>
                        </li>

                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('terminustSupply')}}" class="nav-link">
                                <i class="fa fa-plus nav-icon"></i>
                                <p>View Terminus Supply</p>
                            </a>
                        </li>

                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('products-managers.index')}}" class="nav-link">
                                <i class="fa fa-plus nav-icon"></i>
                                <p>Product Manager</p>
                            </a>
                        </li>

                    </ul>
                </li>
                @endhasrole

                @hasrole('Products')
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-lemon-o"></i>
                        <p>
                            Products
                            <i class="fa fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('product-create')
                        <li class="nav-item">
                            <a href="{{route('products.create')}}" class="nav-link">
                                <i class="fa fa-plus nav-icon"></i>
                                <p>Add Product</p>
                            </a>
                        </li>
                        @endcan

                        @can('products')
                        <li class="nav-item">
                            <a href="{{route('products.index')}}" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>View Products</p>
                            </a>
                        </li>
                        @endcan

                        @can('prices')
                        <li class="nav-item">
                            <a href="{{route('prices.index')}}" class="nav-link">
                                <i class="fa fa-plus nav-icon"></i>
                                <p>Add Price </p>
                            </a>
                        </li>
                        @endcan

                        @can('products')
                        <li class="nav-item">
                            <a href="{{route('products.index')}}" class="nav-link">
                                <i class="fa fa-plus nav-icon"></i>
                                <p>Adjust Price </p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endhasrole

                @hasrole('Invoice')
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
                            <a href="{{route('invoices.index')}}" class="nav-link">
                                <i class="fa fa-plus nav-icon"></i>
                                <p>View order invoice</p>
                            </a>
                        </li>

                    </ul>
                </li>
                @endhasrole

                @hasrole('Customer')
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-apple"></i>
                        <p>Customers <i class="fa fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">

                        @can('customer-create')
                        <li class="nav-item">
                            <a href="{{route('customers.create')}}" class="nav-link">
                                <i class="fa fa-plus nav-icon"></i>
                                <p>Add Customer</p>
                            </a>
                        </li>
                        @endcan

                        @can('customers')
                        <li class="nav-item">
                            <a href="{{route('customers.index')}}" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>View Customers</p>
                            </a>
                        </li>
                        @endcan

                    </ul>
                </li>
                @endhasrole

                @hasrole('Borrow')
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-windows"></i>
                        <p>Borrow <i class="fa fa-angle-left right"></i> </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('borrow-create')
                        <li class="nav-item">
                            <a href="{{route('customers.create')}}" class="nav-link">
                                <i class="fa fa-plus nav-icon"></i>
                                <p>New Borrow </p>
                            </a>
                        </li>
                        @endcan

                        @can('borrow')
                        <li class="nav-item">
                            <a href="{{route('borrows.index')}}" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>View Today Borrow</p>
                            </a>
                        </li>
                        @endcan

                        @can('borrow')
                        <li class="nav-item">
                            <a href="{{route('customers.index')}}" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>View Borrow</p>
                            </a>
                        </li>
                        @endcan

                    </ul>
                </li>
                @endhasrole

                @hasrole('Expenses')
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-android"></i>
                        <p>
                            Expenses
                            <i class="fa fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('expenses-create')
                        <li class="nav-item">
                            <a href="{{route('expenses.create')}}" class="nav-link">
                                <i class="fa fa-plus nav-icon"></i>
                                <p>Add</p>
                            </a>
                        </li>
                        @endcan

                        @can('expenses')
                        <li class="nav-item">
                            <a href="{{route('expenses.index')}}" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>View</p>
                            </a>
                        </li>
                        @endcan

                    </ul>
                </li>
                @endhasrole

                @hasrole('Suppliers')
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
                            <a href="{{route('suppliers.create')}}" class="nav-link">
                                <i class="fa fa-plus nav-icon"></i>
                                <p>Add Suppliers</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('suppliers.index')}}" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>View Suppliers</p>
                            </a>
                        </li>

                    </ul>
                </li>
                @endhasrole

                @hasrole('Report')
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
                @endhasrole

                @hasrole('Credit-Date-Line')
                @can('credit-date-line')
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li class="nav-item has-treeview">
                        <a href="{{ route('home') }}" class="nav-link active">
                            <i class="nav-icon fa fa-calendar"></i>
                            <p>Credit-Date-Line <i class="right fa fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('listcustomerDateline') }}" class="nav-link">
                                    <i class="fa fa-arrow nav-icon"></i>
                                    View Credit Date-Line
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>

                @endcan
                @endhasrole

                @hasrole('Promotion')
                <li class="nav-item has-treeview menu-open">
                    <a href="{{route('promotion.index')}}" class="nav-link active">
                        <i class="nav-icon fa fa-credit-card"></i>
                        <p>Promotions</p>
                    </a>

                </li>
                @endhasrole

                @hasrole('System-Setting')
                <li class="nav-item has-treeview">
                    <a href="{{ route('home') }}" class="nav-link active">
                        <i class="nav-icon fa fa-cog"></i>
                        <p>System Settings <i class="right fa fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('backup.index')}}" class="nav-link">
                                <i class="fa fa-user nav-icon"></i>
                                <p>Database Backup</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endhasrole


                <li class="nav-item has-treeview menu-open">
                    <a href="{{ url('/logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="nav-link active">
                        <i class="nav-icon fa fa-minus-square"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul> --}}
                @endif
            </nav>
        </div>
    @endif
</aside>
