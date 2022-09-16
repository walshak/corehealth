<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>AdminLTE 3 | Dashboard 2</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('/css/font-awesome.css') }}">
  <link rel="stylesheet" href="{{ asset('/css/jquery.dataTables.css') }}">
  <link rel="stylesheet" href="{{ asset('/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/css/font-awesome.min.css') }}">


</head>
<body class="hold-transition sidebar-mini">
<div id="app" class="wrapper">
  <!-- Navbar -->
  @include('admin.layouts.partials.header')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  {{-- @include('admin.layouts.partials.sidebar') --}}

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
@section('scripts')
  <script src="{{ asset('/js/app.js') }}" defer></script>
  <script>
      window.Laravel = {!! json_encode([
          'csrfToken' => csrf_token(),
      ]) !!};
  </script>
  @show
</body>
</html>
