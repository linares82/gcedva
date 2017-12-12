<?php echo $__env->make('asignacionAcademicas._common', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->startSection('header'); ?>

	<ol class="breadcrumb">
		<li><a href="<?php echo e(route('home')); ?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="<?php echo e(route('asignacionAcademicas.index')); ?>"><?php echo $__env->yieldContent('asignacionAcademicasAppTitle'); ?></a></li>
	    <li class="active">Horario por Grupo</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> <?php echo $__env->yieldContent('asignacionAcademicasAppTitle'); ?> / Crear </h3>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('error', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="row">
        <div class="col-md-12">

            <?php echo Form::open(array('route' => 'horarios.horarioGrupoR', 'id'=>'frm_seguimiento')); ?>


                <div class="form-group col-md-6 <?php if($errors->has('plantel_f')): ?> has-error <?php endif; ?>">
                    <label for="plantel_f-field">Plantel</label>
                    <?php echo Form::select("plantel_f", $list["Plantel"], null, array("class" => "form-control select_seguridad", "id" => "plantel_f-field")); ?>

                    <?php if($errors->has("plantel_f")): ?>
                    <span class="help-block"><?php echo e($errors->first("plantel_f")); ?></span>
                    <?php endif; ?>
                </div>
                <div class="form-group col-md-6 <?php if($errors->has('grupo_f')): ?> has-error <?php endif; ?>">
                    <label for="grupo_f-field">Grupo:</label>
                    <?php echo Form::select("grupo_f", $list["Grupo"], null, array("class" => "form-control select_seguridad", "id" => "plantel_t-field")); ?>

                    <?php if($errors->has("grupo_f")): ?>
                    <span class="help-block"><?php echo e($errors->first("plantel_t")); ?></span>
                    <?php endif; ?>
                </div>
                <div class="form-group col-md-6 <?php if($errors->has('lectivo_f')): ?> has-error <?php endif; ?>">
                    <label for="lectivo_f-field">Lectivo:</label>
                    <?php echo Form::select("lectivo_f", $list["Lectivo"], null, array("class" => "form-control select_seguridad", "id" => "lectivo_t-field")); ?>

                    <?php if($errors->has("lectivo_f")): ?>
                    <span class="help-block"><?php echo e($errors->first("lectivo_t")); ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="row">
                </div>
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Tabla</button>
                </div>
            <?php echo Form::close(); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
  <script type="text/javascript">
    $(document).ready(function() {
    $('#fecha_f-field').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
      });
      $('#fecha_t-field').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
      });
    
    <?php if (\Entrust::can('IreporteFiltroXplantel')) : ?>
        $("#plantel_f-field").prop("disabled", true);
        $("#plantel_t-field").prop("disabled", true);
    <?php endif; // Entrust::can ?>
        
    });
    
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('plantillas.admin_template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>