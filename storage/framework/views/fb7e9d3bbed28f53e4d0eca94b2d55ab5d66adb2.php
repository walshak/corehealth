<?php $__env->startSection('content'); ?>

<div class="login-box">

    <div class="login-logo">
      <a href="<?php echo e(route('home')); ?>"><em><?php echo e($app->site_name); ?></em></a>
    </div>

    <div class="card">
      
      <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in</p>

        <form method="POST" action="<?php echo e(route('login')); ?>" aria-label="<?php echo e(__('Login')); ?>">
            <?php echo csrf_field(); ?>
            <div class="input-group mb-3">
                <input type="email" class="form-control<?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>" placeholder="Email" name="email" value="<?php echo e(old('email')); ?>" required autofocus>
                <div class="input-group-append">
                    <span class="fa fa-envelope input-group-text"></span>
                </div>
                <?php if($errors->has('email')): ?>
                    <span class="invalid-feedback" role="alert">
                        <strong><?php echo e($errors->first('email')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>

            <div class="input-group mb-3">
                <input type="password" class="form-control<?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>" placeholder="Password" name="password" required>
                <div class="input-group-append">
                    <span class="fa fa-lock input-group-text"></span>
                </div>
                <?php if($errors->has('password')): ?>
                    <span class="invalid-feedback" role="alert">
                        <strong><?php echo e($errors->first('password')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>
            <div class="row">
                <div class="col-8">
                  <div class="checkbox icheck">
                    <label>
                      <input type="checkbox" name="remember" id="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>> <?php echo e(__('Remember Me')); ?>

                    </label>
                  </div>
                </div>

                <div class="col-4">
                  <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div>

            </div>
        </form>

        
        <!-- /.social-auth-links -->

        <p class="mb-1">
            <a class="text-center" href="<?php echo e(route('password.request')); ?>"><?php echo e(__('Forgot Your Password?')); ?></a>
        </p>
        <p class="mb-0">
            
        </p>
      </div>
      <!-- /.login-card-body -->
    </div>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.login', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mrapollos/Documents/database/resources/views/auth/login.blade.php ENDPATH**/ ?>