                <div class="form-group col-md-4 <?php if($errors->has('name')): ?> has-error <?php endif; ?>">
                       <label for="name-field">Name</label>
                       <?php echo Form::text("name", null, array("class" => "form-control", "id" => "name-field")); ?>

                       <?php if($errors->has("name")): ?>
                        <span class="help-block"><?php echo e($errors->first("name")); ?></span>
                       <?php endif; ?>
                    </div>
                    <div class="form-group col-md-4 <?php if($errors->has('activo')): ?> has-error <?php endif; ?>">
                       <label for="activo-field">Activo</label>
                       <?php echo Form::checkbox("activo", 1, null, [ "id" => "activo-field"]); ?>

                       <?php if($errors->has("activo")): ?>
                        <span class="help-block"><?php echo e($errors->first("activo")); ?></span>
                       <?php endif; ?>
                    </div>
                    <div class="form-group col-md-4 <?php if($errors->has('bachillerato_bnd')): ?> has-error <?php endif; ?>">
                       <label for="bachillerato_bnd-field">bachillerato</label>
                       <?php echo Form::checkbox("bachillerato_bnd", 1, null, [ "id" => "bachillerato_bnd-field"]); ?>

                       <?php if($errors->has("bachillerato_bnd")): ?>
                        <span class="help-block"><?php echo e($errors->first("bachillerato_bnd")); ?></span>
                       <?php endif; ?>
                    </div>
                    <div class="form-group col-md-4 <?php if($errors->has('carrera_bnd')): ?> has-error <?php endif; ?>">
                       <label for="activo-field">Carrera</label>
                       <?php echo Form::checkbox("carrera_bnd", 1, null, [ "id" => "activo-field"]); ?>

                       <?php if($errors->has("carrera_bnd")): ?>
                        <span class="help-block"><?php echo e($errors->first("carrera_bnd")); ?></span>
                       <?php endif; ?>
                    </div>
                    <div class="form-group col-md-4 <?php if($errors->has('inicio')): ?> has-error <?php endif; ?>">
                       <label for="inicio-field">Inicio</label>
                       <?php echo Form::text("inicio", null, array("class" => "form-control", "id" => "inicio-field")); ?>

                       <?php if($errors->has("inicio")): ?>
                        <span class="help-block"><?php echo e($errors->first("inicio")); ?></span>
                       <?php endif; ?>
                    </div>
                    <div class="form-group col-md-4 <?php if($errors->has('fin')): ?> has-error <?php endif; ?>">
                       <label for="fin-field">Fin</label>
                       <?php echo Form::text("fin", null, array("class" => "form-control", "id" => "fin-field")); ?>

                       <?php if($errors->has("fin")): ?>
                        <span class="help-block"><?php echo e($errors->first("fin")); ?></span>
                       <?php endif; ?>
                    </div>

<?php $__env->startPush('scripts'); ?>
<script>
  //  $(document).ready(function() {
      
      // assuming the controls you want to attach the plugin to
      // have the "datepicker" class set
      //Campo de fecha
      $('#inicio-field').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
      });

      $('#fin-field').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
      });
//    )};
</script>

<?php $__env->stopPush(); ?>