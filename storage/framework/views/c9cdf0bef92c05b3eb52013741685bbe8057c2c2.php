<link rel="stylesheet" type="text/css" href="asset('bower_components/AdminLTE/plugins/lou-multi-select/css/css/multi-select.css')">
                    <div class="form-group col-md-8">
<!--                    
                        <div class="form-group col-md-6 <?php if($errors->has('inicio')): ?> has-error <?php endif; ?>">
                            <label for="inicio-field">Inicio Vigencia</label>
                            <?php echo Form::text("inicio", null, array("class" => "form-control", "id" => "inicio-field")); ?>

                            <?php if($errors->has("inicio")): ?>
                                <span class="help-block"><?php echo e($errors->first("inicio")); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group col-md-6 <?php if($errors->has('fin')): ?> has-error <?php endif; ?>">
                            <label for="fin-field">Fin Vigencia</label>
                            <?php echo Form::text("fin", null, array("class" => "form-control", "id" => "fin-field")); ?>

                            <?php if($errors->has("fin")): ?>
                                <span class="help-block"><?php echo e($errors->first("fin")); ?></span>
                            <?php endif; ?>
                        </div>
-->
                        <div class="form-group col-md-6 <?php if($errors->has('plantel_id')): ?> has-error <?php endif; ?>">
                            <label for="plantel_id-field">Plantel</label>
                            <?php echo Form::select("plantel_id", $list["Plantel"], null, array("class" => "form-control select_seguridad", "id" => "plantel_id-field")); ?>

                            <?php if($errors->has("plantel_id")): ?>
                                <span class="help-block"><?php echo e($errors->first("st_cliente_id")); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group col-md-6 <?php if($errors->has('puesto_id')): ?> has-error <?php endif; ?>">
                            <label for="puesto_id-field">Puesto</label>
                            <?php echo Form::select("puesto_id", $list["Puesto"], null, array("class" => "form-control select_seguridad", "id" => "puesto_id-field")); ?>

                            <?php if($errors->has("puesto_id")): ?>
                                <span class="help-block"><?php echo e($errors->first("puesto_id")); ?></span>
                            <?php endif; ?>
                        </div>
                            
                        <div class="form-group col-md-12 <?php if($errors->has('empleado_id')): ?> has-error <?php endif; ?>">
                                <label for="empleado_id-field">Empleado</label>
                                <a href='#' id='select-all'>Seleccionar todos</a>
                                <div id="select_empleado">
                                    <?php echo Form::select("empleado_id", $list1['Empleado'], null, array("class" => "form-control", "id" => "empleado_id-field", "name"=>"empleado_id-field[]", 'multiple'=>'multiple')); ?> 
                                </div>
                                <div id='loading3' style='display: none'><img src="<?php echo e(asset('images/ajax-loader.gif')); ?>" title="Enviando" /></div>
                                <?php if($errors->has("empleado_id")): ?>
                                    <span class="help-block"><?php echo e($errors->first("empleado_id")); ?></span>
                                <?php endif; ?>
                        </div>
                        <?php if(isset($avisoGral->pivotAvisoGralEmpleado)): ?>

                            <div class="form-group col-md-12">
                                <table class="table table-condensed table-striped">
                                    <tr>
                                        <th>Destinatario</th><th>Plantel</th><th>Puesto</th>
                                        <th><a href="<?php echo e(route('pivotAvisoGralEmpleados.enviar', $avisoGral->id)); ?>" class="btn btn-xs btn-info">Enviar</a></th>
                                        <th>Leido</th>
                                        <th></th>
                                    </tr>
                                    <?php $__currentLoopData = $avisoGral->pivotAvisoGralEmpleado; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo $e->empleado->nombre." ".$e->empleado->ape_paterno." ".$e->empleado->ape_materno; ?></td>
                                            <td><?php echo $e->empleado->plantel->razon; ?></td>
                                            <td><?php echo $e->empleado->puesto->name; ?></td>
                                            <td>
                                                <?php echo Form::checkbox("enviado", 
                                                                    $e->enviado, 
                                                                    $e->enviado,
                                                                    array('disabled'=>'disabled')); ?>

                                            </td>
                                            <td><?php echo Form::checkbox("enviado", 
                                                                    $e->leido, 
                                                                    $e->leido,
                                                                    array('disabled'=>'disabled')); ?>

                                            </td>
                                            <td><a href="<?php echo e(route('pivotAvisoGralEmpleados.destroy', $e->id)); ?>" class="btn btn-xs btn-danger">Eliminar</a></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-group col-md-4">
                        <div class="form-group col-md-12 <?php if($errors->has('desc_corta')): ?> has-error <?php endif; ?>">
                            <label for="desc_corta-field">Asunto</label>
                            <?php echo Form::text("desc_corta", null, array("class" => "form-control", "id" => "desc_corta-field", 'rows'=>'3', 'maxlength'=>'255')); ?>

                            <?php if($errors->has("desc_corta")): ?>
                                <span class="help-block"><?php echo e($errors->first("desc_corta")); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group col-md-12 <?php if($errors->has('aviso')): ?> has-error <?php endif; ?>">
                            <label for="aviso-field">Aviso </label>
                            <?php echo Form::textArea("aviso", null, array("class" => "form-control", "id" => "aviso-field", 'rows'=>'10')); ?>

                            <?php if($errors->has("aviso")): ?>
                                <span class="help-block"><?php echo e($errors->first("aviso")); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    

                    
                    
<?php $__env->startPush('scripts'); ?>
  <script type="text/javascript" src="<?php echo e(asset ('/bower_components/AdminLTE/plugins/lou-multi-select/js/jquery.multi-select.js')); ?>"></script>
  <script type="text/javascript">
    $('#select-all').click(function(){
        $('select#empleado_id-field').multiSelect('select_all');
        return false;
    });
    $(document).ready(function() {
        
        var contenido_empleado=$('#select_empleado').html();
        $("#puesto_id-field").change(function(event) {
            //var id = $("select#tpo_bitacora_id option:selected").val(); 
            var a= $('#frm_avisos').serialize();
            $.ajax({
                url: '<?php echo e(route("empleados.getEmpleadosXplantelXpuesto")); ?>',
                type: 'GET',
                data: a, 
                dataType: 'json',
                beforeSend : function(){$("#loading3").show();},
                complete : function(){$("#loading3").hide();},
                success: function(e){
                    $('#select_empleado').empty();
                    $('#select_empleado').html(contenido_empleado);
                    $('select#empleado_id-field').html('');
                    //$('select#empleado_id-field').append($('<option></option>').text('Seleccionar opción').val(''));
                    $.each(e, function(i) {
                        $('select#empleado_id-field').append("<option value=\""+e[i].id+"\">"+e[i].nombre+"<\/option>");
                    });
                    $('#empleado_id-field').multiSelect();
                }
            });
        }); 
    
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

      $('#search').multiselect({
          search: {
              left: '<input type="text" name="q" class="form-control" placeholder="Buscar..." />',
              right: '<input type="text" name="q" class="form-control" placeholder="Buscar..." />',
          },
          fireSearch: function(value) {
              return value.length > 3;
          }
       });
    });
    </script>
<?php $__env->stopPush(); ?>