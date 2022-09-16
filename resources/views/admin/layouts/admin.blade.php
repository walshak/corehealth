<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $app->site_name }} | Dashboard </title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/font-awesome.css') }}">
    <!-- <link rel="stylesheet" href="{{ asset('/css/jquery.dataTables.css') }}"> -->
    <link rel="stylesheet"
        href="{{ asset('plugins/bootstrap-switch-master/dist/css/bootstrap4/bootstrap-switch.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/datatables/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('../node_modules/sweetalert2/dist/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('/plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/datepicker/datepicker3.css') }}">
    <style>
        code {
            cursor:  !important pointer;
            color:  !important gray;
        }

        td {
            white-space: pre-wrap;
        }
    </style>
    @yield('style')

</head>

<body class="hold-transition sidebar-mini">
    <div id="app" class="wrapper">
        <!-- Navbar -->
        @include('admin.layouts.partials.header')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('admin.layouts.partials.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Content Header (Page header) -->
            {{-- @include('admin.layouts.partials.contentHeader') --}}
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Info boxes -->
                    {{-- @include('admin.layouts.partials.infoBox') --}}


                    @yield('main-content')


                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        @include('admin.layouts.partials.controlSidebar')
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        @include('admin.layouts.partials.footer')

    </div>
    <script src="{{ asset('/js/app.js') }}"></script>
    <script src="{{ asset('js/adminlte.min.js') }}"></script>
    <!-- <script src="{{ asset('../node_modules/sweetalert2/dist/sweetalert2.all.js') }}"></script> -->
    @include('sweetalert::alert')
    <script>
        window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};
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
                var url = "{{route('notifications.clear')}}";
            }else{
                var url = "{{url('notifications/clear')}}/"+notice_id;
            }
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
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
    <!-- <script src="{{ asset('js/adminlte.min.js') }}"></script> -->
    @yield('scripts')
</body>

</html>
