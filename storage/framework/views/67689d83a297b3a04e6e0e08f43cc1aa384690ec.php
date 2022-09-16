<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <!-- CSRF Token -->
  <meta id="csrf-token" name="csrf-token" content="<?php echo e(csrf_token()); ?>">

  <title><?php echo e($app->site_name); ?> | POS </title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo e(asset('/css/app.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('/css/font-awesome.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('/css/adminlte.min.css')); ?>">


</head>
<body class="hold-transition login-page">
<div id="app" class="wrapper">

    <?php echo $__env->yieldContent('content'); ?>

</div>

<script src="<?php echo e(asset('/js/app.js')); ?>" defer></script>

<script>
    window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>;
</script>
</body>
</html>
<?php /**PATH /home/mrapollos/Documents/database/resources/views/layouts/login.blade.php ENDPATH**/ ?>