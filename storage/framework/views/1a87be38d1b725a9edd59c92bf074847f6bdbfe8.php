<?php echo $__env->make('calendarioEvaluacions._common', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->startSection('header'); ?>

	<ol class="breadcrumb">
	    <li><a href="<?php echo e(route('home')); ?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="<?php echo e(route('calendarioEvaluacions.index')); ?>"><?php echo $__env->yieldContent('calendarioEvaluacionsAppTitle'); ?></a></li>
	    <li><a href="<?php echo e(route('calendarioEvaluacions.show', $calendarioEvaluacion->id)); ?>"><?php echo e($calendarioEvaluacion->id); ?></a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> <?php echo $__env->yieldContent('calendarioEvaluacionsAppTitle'); ?> / Editar <?php echo e($calendarioEvaluacion->id); ?></h3>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('error', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="row">
        <div class="col-md-12">

            <?php echo Form::model($calendarioEvaluacion, array('route' => array('calendarioEvaluacions.update', $calendarioEvaluacion->id),'method' => 'post')); ?>


<?php echo $__env->make('calendarioEvaluacions._form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="<?php echo e(route('calendarioEvaluacions.index')); ?>"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            <?php echo Form::close(); ?>


        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('plantillas.admin_template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>