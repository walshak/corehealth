<?php if(Session::has('message')): ?>
<div class="alert alert-<?php echo e(Session::get('message_type', 'danger')); ?> alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Message &nbsp;</strong> <?php echo e(Session::get('message')); ?>

</div>
<?php endif; ?><?php /**PATH /home/mrapollos/Documents/database/resources/views/partials/notification.blade.php ENDPATH**/ ?>