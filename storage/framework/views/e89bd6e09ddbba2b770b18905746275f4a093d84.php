                    <div class="box box-default box-solid">
                        <div class="box-header">
                            <h3 class="box-title">DATOS ESPECILIDAD</h3>
                            <div class="box-tools">
                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group col-md-4 <?php if($errors->has('plantel_id')): ?> has-error <?php endif; ?>">
                                  <label for="plantel_id-field">Plantel</label>
                                  <?php echo Form::select("plantel_id", $list["Plantel"], null, array("class" => "form-control select_seguridad", "id" => "plantel_id-field")); ?>

                                  <?php if($errors->has("plantel_id")): ?>
                                    <span class="help-block"><?php echo e($errors->first("plantel_id")); ?></span>
                                  <?php endif; ?>
                                </div>
                            <div class="form-group col-md-4 <?php if($errors->has('name')): ?> has-error <?php endif; ?>">
                               <label for="name-field">Especialidad</label>
                               <?php echo Form::text("name", null, array("class" => "form-control", "id" => "name-field")); ?>

                               <?php if($errors->has("name")): ?>
                                <span class="help-block"><?php echo e($errors->first("name")); ?></span>
                               <?php endif; ?>
                            </div>
                            <div class="form-group col-md-4 <?php if($errors->has('rvoe')): ?> has-error <?php endif; ?>">
                               <label for="rvoe-field">RVOE</label>
                               <?php echo Form::text("rvoe", null, array("class" => "form-control", "id" => "rvoe-field")); ?>

                               <?php if($errors->has("rvoe")): ?>
                                <span class="help-block"><?php echo e($errors->first("rvoe")); ?></span>
                               <?php endif; ?>
                            </div>
                            <div class="form-group col-md-4 <?php if($errors->has('ccte')): ?> has-error <?php endif; ?>">
                               <label for="ccte-field">CCTE</label>
                               <?php echo Form::text("ccte", null, array("class" => "form-control", "id" => "ccte-field")); ?>

                               <?php if($errors->has("ccte")): ?>
                                <span class="help-block"><?php echo e($errors->first("ccte")); ?></span>
                               <?php endif; ?>
                            </div>
                            <div class="form-group col-md-4 <?php if($errors->has('meta')): ?> has-error <?php endif; ?>">
                               <label for="meta-field">Meta Empleado</label>
                               <?php echo Form::text("meta", null, array("class" => "form-control", "id" => "meta-field")); ?>

                               <?php if($errors->has("meta")): ?>
                                <span class="help-block"><?php echo e($errors->first("meta")); ?></span>
                               <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="box box-default box-solid">
                        <div class="box-header">
                            <h3 class="box-title">PARAMETROS GRAFICAS</h3>
                            <div class="box-tools">
                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <!--
                            <div class="form-group col-md-2 <?php if($errors->has('bnd_usar_lectivo')): ?> has-error <?php endif; ?>">
                                <label for="bnd_usar_lectivo-field">Usar Lectivo</label>
                                <?php echo Form::checkbox("bnd_usar_lectivo", 1, null, [ "id" => "bnd_usar_lectivo-field"]); ?>

                                <?php if($errors->has("bnd_usar_lectivo")): ?>
                                 <span class="help-block"><?php echo e($errors->first("bnd_usar_lectivo")); ?></span>
                                <?php endif; ?>
                             </div>
                            -->
                            <div class="form-group col-md-4 <?php if($errors->has('lectivo_id')): ?> has-error <?php endif; ?>">
                                  <label for="lectivo_id-field">Lectivo</label>
                                  <?php echo Form::select("lectivo_id", $list["Lectivo"], null, array("class" => "form-control select_seguridad", "id" => "lectivo_id-field")); ?>

                                  <?php if($errors->has("lectivo_id")): ?>
                                    <span class="help-block"><?php echo e($errors->first("lectivo_id")); ?></span>
                                  <?php endif; ?>
                                </div>
                            <!-- 
                            <div class="form-group col-md-4 <?php if($errors->has('f_inicio')): ?> has-error <?php endif; ?>">
                                <label for="f_inicio-field">Fecha Inicio</label>
                                <?php echo Form::text("f_inicio", null, array("class" => "form-control", "id" => "f_inicio-field")); ?>

                                <?php if($errors->has("f_inicio")): ?>
                                 <span class="help-block"><?php echo e($errors->first("f_inicio")); ?></span>
                                <?php endif; ?>
                             </div>
                             <div class="form-group col-md-4 <?php if($errors->has('f_fin')): ?> has-error <?php endif; ?>">
                                <label for="f_fin-field">Fecha Fin</label>
                                <?php echo Form::text("f_fin", null, array("class" => "form-control", "id" => "f_fin-field")); ?>

                                <?php if($errors->has("f_fin")): ?>
                                 <span class="help-block"><?php echo e($errors->first("f_fin")); ?></span>
                                <?php endif; ?>
                             </div>
                            -->
                        </div>
                    </div>
                    
<?php $__env->startPush('scripts'); ?>
  <script type="text/javascript">
    $(document).ready(function() {
    $('#f_fin-field').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
      });
      $('#f_inicio-field').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
      });
    
    });
    
    </script>
<?php $__env->stopPush(); ?>                