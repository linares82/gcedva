<?php $__env->startSection('heading', 'Roles'); ?>

<?php $__env->startSection('content'); ?>
<div class="models--actions">
    <a class="btn btn-labeled btn-primary" href="<?php echo e(route('entrust-gui::roles.create')); ?>"><span class="btn-label"><i class="fa fa-plus"></i></span><?php echo e(trans('entrust-gui::button.create-role')); ?></a>
</div>
<table class="table table-striped">
    <tr>
        <th>Name</th>
        <th>Actions</th>
    </tr>
    <?php $__currentLoopData = $models; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $model): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($model->name); ?></th>
            <td class="col-xs-3">
                <form action="<?php echo e(route('entrust-gui::roles.destroy', $model->id)); ?>" method="post">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                    <a class="btn btn-labeled btn-default" href="<?php echo e(route('entrust-gui::roles.edit', $model->id)); ?>"><span class="btn-label"><i class="fa fa-pencil"></i></span><?php echo e(trans('entrust-gui::button.edit')); ?></a>
                    <button type="submit" class="btn btn-labeled btn-danger"><span class="btn-label"><i class="fa fa-trash"></i></span><?php echo e(trans('entrust-gui::button.delete')); ?></button>
                </form>
            </td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</table>
<div class="text-center">
    <?php echo $models->render(); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(Config::get('entrust-gui.layout'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>