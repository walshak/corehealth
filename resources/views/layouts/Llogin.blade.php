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
<body class="hold-transition login-page">
<div id="app" class="wrapper">
  
    @yield('content')

</div>

<script src="{{ asset('/js/app.js') }}" defer></script>

<script>
    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>
</body>
</html>
