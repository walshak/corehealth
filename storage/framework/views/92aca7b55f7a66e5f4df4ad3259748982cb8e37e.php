<!doctype html>
<html lang="<?php echo e(app()->getLocale()); ?>">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo e($app->site_name); ?> | POS</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links>a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <div class="flex-center position-ref full-height">
        <?php if(Route::has('login')): ?>
        <div class="top-right links">
            <?php if(auth()->guard()->check()): ?>
            <a href="<?php echo e(url('/home')); ?>">Home</a>
            <?php else: ?>
            <a href="<?php echo e(route('login')); ?>">Login</a>
            
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <div class="content">
            <div class=" m-b-md">
                <h1>
                    <?php echo e($app->site_name); ?>

                </h1>

            </div>
            

            <p class="bg-info"><small>
                    <h3>Hospital Management System</h3>
                </small>
            </p>
            <br>
            <div class="title m-b-md">
                
                <img src="<?php echo e(asset('img/CoreHealth.png')); ?>" width="" height=""  alt="HMS">
                
            </div>
            <div>
                <p class="bg-info"><small>
                        <h4>...<?php echo e($app->version); ?></h4>
                    </small></p>
            </div>
        </div>
    </div>
</body>

</html><?php /**PATH /home/mrapollos/Documents/database/resources/views/welcome.blade.php ENDPATH**/ ?>