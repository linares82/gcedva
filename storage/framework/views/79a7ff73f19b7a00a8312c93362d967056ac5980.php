<?php $__env->startSection('content'); ?>

    <div class="error-page">
        <h2 class="headline text-yellow"> 404</h2>
        <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i> Oops! Página no encontrada.</h3>
            <p>
                Página no Encontrada
                Mientras tanto <a href='<?php echo e(url('/home')); ?>'>Regresar al tablero principal </a> 
            </p>
           
        </div><!-- /.error-content -->
    </div><!-- /.error-page -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('plantillas.admin_template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>