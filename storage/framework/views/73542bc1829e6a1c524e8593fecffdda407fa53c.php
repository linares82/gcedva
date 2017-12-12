<?php $__env->startSection('heading', 'Edit Role'); ?>

<?php $__env->startSection('content'); ?>
<form action="<?php echo e(route('entrust-gui::roles.update', $model->id)); ?>" method="post" role="form">
<input type="hidden" name="_method" value="put">
  <?php echo $__env->make('entrust-gui::roles.partials.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <button type="submit" class="btn btn-labeled btn-primary"><span class="btn-label"><i class="fa fa-check"></i></span><?php echo e(trans('entrust-gui::button.save')); ?></button>
  <a class="btn btn-labeled btn-default" href="<?php echo e(route('entrust-gui::roles.index')); ?>"><span class="btn-label"><i class="fa fa-chevron-left"></i></span><?php echo e(trans('entrust-gui::button.cancel')); ?></a>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(Config::get('entrust-gui.layout'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>