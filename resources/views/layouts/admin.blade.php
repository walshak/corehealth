<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta id="csrf-token" name="csrf-token" content="{{ csrf_token() }}">

    <title>AdminLTE 3 | Dashboard 2</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/font-awesome.css') }}">
    <!-- <link rel="stylesheet" href="{{ asset('/css/adminlte.min.css') }}"> -->



</head>

<body class="hold-transition sidebar-mini">
    <div id="app" class="wrapper">
        <!-- Navbar -->
        @include('layouts.partials.header')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <!-- include('layouts.partials.sidebar') -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Content Header (Page header) -->
            @include('layouts.partials.contentHeader')
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Info boxes -->

                    @yield('main-content')


                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        @include('layouts.partials.controlSidebar')
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        @include('layouts.partials.footer')

    </div>
    <script src="{{ asset('/js/app.js') }}" defer></script>
    <script>
        window.Laravel = {!! json_encode([
    'csrfToken' => csrf_token(),
]) !!};
    </script>
    
    @yield('scripts')
</body>

</html>
