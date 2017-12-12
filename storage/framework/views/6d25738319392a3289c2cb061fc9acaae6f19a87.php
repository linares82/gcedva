
                    <div class="form-group col-md-4 col-md-4 <?php if($errors->has('plantel_id')): ?> has-error <?php endif; ?>">
                       <label for="plantel_id-field">Plantel</label>
                       <?php echo Form::select("plantel_id", $list["Plantel"], null, array("class" => "form-control select_seguridad", "id" => "plantel_id-field")); ?>

                       <?php echo Form::hidden("puesto_id", 3, array("class" => "form-control", "id" => "puesto_id-field")); ?>

                       <?php if($errors->has("plantel_id")): ?>
                        <span class="help-block"><?php echo e($errors->first("plantel_id")); ?></span>
                       <?php endif; ?>
                    </div>
                    
                    <div class="form-group col-md-4 <?php if($errors->has('empleado_id')): ?> has-error <?php endif; ?>">
                       <label for="empleado_id-field">Empleado</label>
                       <?php echo Form::select("empleado_id", $list["Empleado"], null, array("class" => "form-control select_seguridad", "id" => "empleado_id-field")); ?>             
                       <?php if($errors->has("empleado_id")): ?>
                        <span class="help-block"><?php echo e($errors->first("empleado_id")); ?></span>
                       <?php endif; ?>
                    </div>
                    <div class="form-group col-md-4 <?php if($errors->has('materium_id')): ?> has-error <?php endif; ?>">
                       <label for="materium_id-field">Materia</label>
                       <?php echo Form::select("materium_id", $list["Materium"], null, array("class" => "form-control select_seguridad", "id" => "materium_id-field")); ?>

                       <?php if($errors->has("materium_id")): ?>
                        <span class="help-block"><?php echo e($errors->first("materium_id")); ?></span>
                       <?php endif; ?>
                    </div>
                    <div class="form-group col-md-4 <?php if($errors->has('grupo_id')): ?> has-error <?php endif; ?>">
                       <label for="grupo_id-field">Grupo</label>
                       <?php echo Form::select("grupo_id", $list["Grupo"], null, array("class" => "form-control select_seguridad", "id" => "grupo_id-field")); ?>

                       <?php if($errors->has("grupo_id")): ?>
                        <span class="help-block"><?php echo e($errors->first("grupo_id")); ?></span>
                       <?php endif; ?>
                    </div>
                    <div class="form-group col-md-4 <?php if($errors->has('horas')): ?> has-error <?php endif; ?>">
                       <label for="horas-field">Horas</label>
                       <?php echo Form::text("horas", null, array("class" => "form-control", "id" => "horas-field")); ?>

                       <?php if($errors->has("horas")): ?>
                        <span class="help-block"><?php echo e($errors->first("horas")); ?></span>
                       <?php endif; ?>
                    </div>
                    <div class="form-group col-md-4 <?php if($errors->has('lectivo_id')): ?> has-error <?php endif; ?>">
                       <label for="lectivo_id-field">Lectivo</label>
                       <?php echo Form::select("lectivo_id", $list["Lectivo"], null, array("class" => "form-control select_seguridad", "id" => "lectivo_id-field")); ?>

                       <?php if($errors->has("lectivo_id")): ?>
                        <span class="help-block"><?php echo e($errors->first("lectivo_id")); ?></span>
                       <?php endif; ?>
                    </div>
                    <?php if(isset($asignacionAcademica->horarios)): ?>
                    <div class="form-group col-md-12">
                        <div class="form-group col-md-4 <?php if($errors->has('dia_id')): ?> has-error <?php endif; ?>">
                        <label for="dia_id-field">Dia</label>
                        <?php echo Form::select("dia_id", $list1["Dium"], null, array("class" => "form-control select_seguridad", "id" => "dia_id-field")); ?>

                        <?php if($errors->has("dia_id")): ?>
                            <span class="help-block"><?php echo e($errors->first("dia_id")); ?></span>
                        <?php endif; ?>
                        </div>
                        <div class="form-group col-md-4 <?php if($errors->has('hora')): ?> has-error <?php endif; ?>">
                        <label for="hora-field">Hora(formato de 24hrs. hh:mm:ss)</label>
                        <div class="input-group">
                        <?php echo Form::text("hora", null, array("class" => "form-control timepicker", "id" => "hora-field", "onblur"=>"valida(this.value);", 'placeholder'=>'hh:mm:ss')); ?>

                        <div class="input-group-addon">
                          <i class="fa fa-clock-o"></i>
                        </div>
                        </div>
                        <?php if($errors->has("hora")): ?>
                            <span class="help-block"><?php echo e($errors->first("hora")); ?></span>
                        <?php endif; ?>
                        </div>
                        <div class="form-group col-md-4 <?php if($errors->has('duracion_clase')): ?> has-error <?php endif; ?>">
                        <label for="duracion_clase-field">Duracion Clase</label>
                        <?php echo Form::text("duracion_clase", null, array("class" => "form-control", "id" => "duracion_clase-field")); ?>

                        <?php if($errors->has("duracion_clase")): ?>
                            <span class="help-block"><?php echo e($errors->first("duracion_clase")); ?></span>
                        <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <table class="table table-condensed table-striped">
                            <thead>
                                <th>Dia</th><th>Hora</th><th>Duracion</th><th></th>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $asignacionAcademica->horarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($h->dia->name); ?></td>
                                        <td><?php echo e($h->hora); ?></td>
                                        <td><?php echo e($h->duracion_clase); ?></td>
                                        <td><a href="<?php echo route('horarios.destroy', $h->id); ?>" class="btn btn-xs btn-danger">Eliminar</a></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>


<?php $__env->startPush('scripts'); ?>
  
  <script type="text/javascript" src="<?php echo e(asset('bower_components/AdminLTE/plugins/masktime/jquery.maskedinput.js')); ?>"></script>	
  <script type="text/javascript">
    /*function valida(valor) 
		{
		   //que no existan elementos sin escribir
		   if(valor.indexOf("_") == -1)
		   {		      
		      var hora = valor.split(":")[0];
		      if(parseInt(hora) > 23 )
		      {
		           $("#hora-field").val("");		      
		      } 
		   }
		}
        */
    $(document).ready(function() {
      /*  
        $.mask.definitions['H']='[012]';
        $.mask.definitions['N']='[012345]';
        $.mask.definitions['n']='[0123456789]';
        $("#hora-field").mask("Hn:Nn:Nn");
*/
        getCmbInstructores();
        getCmbMaterias();
        getCmbGrupos();
      
      $('#plantel_id-field').change(function(){
          getCmbInstructores();
          getCmbMaterias();
          getCmbGrupos();
      });
      function getCmbInstructores(){
          //$('#empleado_id_field option:selected').val($('#empleado_id_campo option:selected').val()).change();
          var a= $('#frm_asignacion_academica').serialize();
              $.ajax({
                  url: '<?php echo e(route("empleados.getEmpleadosXplantelXpuesto")); ?>',
                  type: 'GET',
                  data: a,
                  dataType: 'json',
                  beforeSend : function(){$("#loading3").show();},
                  complete : function(){$("#loading3").hide();},
                  success: function(data){
                      //$example.select2("destroy");
                      $('#empleado_id-field').html('');
                      
                      //$('#especialidad_id-field').empty();
                      $('#empleado_id-field').append($('<option></option>').text('Seleccionar Opción').val('0'));
                      
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#empleado_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].nombre+"<\/option>");
                          
                      });
                      $('#empleado_id-field').change();
                      //$example.select2();
                  }
              });       
      }
      function getCmbMaterias(){
          //var $example = $("#especialidad_id-field").select2();
          //$('#materia_id_field option:selected').val($('#materium_id_campo option:selected').val()).change();
          var a= $('#frm_asignacion_academica').serialize();
              $.ajax({
                  url: '<?php echo e(route("materias.getCmbMateria")); ?>',
                  type: 'GET',
                  data: a,
                  dataType: 'json',
                  beforeSend : function(){$("#loading10").show();},
                  complete : function(){$("#loading10").hide();},
                  success: function(data){
                      //$example.select2("destroy");
                      $('#materium_id-field').html('');
                      
                      //$('#especialidad_id-field').empty();
                      $('#materium_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                      
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#materium_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                          
                      });
                      //$example.select2();
                  }
              });       
      }
      function getCmbGrupos(){
          //var $example = $("#especialidad_id-field").select2();
          var a= $('#frm_asignacion_academica').serialize();
              $.ajax({
                  url: '<?php echo e(route("grupos.getCmbGrupo")); ?>',
                  type: 'GET',
                  data: a,
                  dataType: 'json',
                  beforeSend : function(){$("#loading10").show();},
                  complete : function(){$("#loading10").hide();},
                  success: function(data){
                      //$example.select2("destroy");
                      $('#grupo_id-field').html('');
                      
                      //$('#especialidad_id-field').empty();
                      $('#grupo_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                      
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#grupo_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                          
                      });
                      //$example.select2();
                  }
              });       
      }

      

    });
    
</script>
<?php $__env->stopPush(); ?>