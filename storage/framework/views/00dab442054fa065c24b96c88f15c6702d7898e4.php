                <div class="form-group col-md-4 <?php if($errors->has('name')): ?> has-error <?php endif; ?>">
                       <label for="name-field">Grupo</label>
                       <?php echo Form::text("name", null, array("class" => "form-control", "id" => "name-field")); ?>

                       <?php if($errors->has("name")): ?>
                        <span class="help-block"><?php echo e($errors->first("name")); ?></span>
                       <?php endif; ?>
                    </div>
                    <div class="form-group col-md-4 <?php if($errors->has('desc_corta')): ?> has-error <?php endif; ?>">
                       <label for="desc_corta-field">Descripción Corta</label>
                       <?php echo Form::text("desc_corta", null, array("class" => "form-control", "id" => "desc_corta-field")); ?>

                       <?php if($errors->has("desc_corta")): ?>
                        <span class="help-block"><?php echo e($errors->first("desc_corta")); ?></span>
                       <?php endif; ?>
                    </div>
                    <div class="form-group col-md-4 <?php if($errors->has('limite_alumnos')): ?> has-error <?php endif; ?>">
                       <label for="limite_alumnos-field">Limite Alumnos</label>
                       <?php echo Form::text("limite_alumnos", null, array("class" => "form-control", "id" => "limite_alumnos-field")); ?>

                       <?php if($errors->has("limite_alumnos")): ?>
                        <span class="help-block"><?php echo e($errors->first("limite_alumnos")); ?></span>
                       <?php endif; ?>
                    </div>
                    <div class="form-group col-md-4 <?php if($errors->has('minimo_alumnos')): ?> has-error <?php endif; ?>">
                       <label for="minimo_alumnos-field">Mínimo Alumnos</label>
                       <?php echo Form::text("minimo_alumnos", null, array("class" => "form-control", "id" => "minimo_alumnos-field")); ?>

                       <?php if($errors->has("minimo_alumnos")): ?>
                        <span class="help-block"><?php echo e($errors->first("minimo_alumnos")); ?></span>
                       <?php endif; ?>
                    </div>
                    <div class="form-group col-md-4 <?php if($errors->has('plantel_id')): ?> has-error <?php endif; ?>">
                       <label for="plantel_id-field">Plantel</label>
                       <?php echo Form::select("plantel_id", $list["Plantel"], null, array("class" => "form-control select_seguridad", "id" => "plantel_id-field")); ?>

                       <?php if($errors->has("plantel_id")): ?>
                        <span class="help-block"><?php echo e($errors->first("plantel_id")); ?></span>
                       <?php endif; ?>
                    </div>
                    <div class="form-group col-md-4 <?php if($errors->has('jornada_id')): ?> has-error <?php endif; ?>">
                       <label for="jornada_id-field">Jornada</label>
                       <?php echo Form::select("jornada_id", $list["Jornada"], null, array("class" => "form-control select_seguridad", "id" => "jornada_id-field")); ?>

                       <?php if($errors->has("jornada_id")): ?>
                        <span class="help-block"><?php echo e($errors->first("jornada_id")); ?></span>
                       <?php endif; ?>
                    </div>
                    <div class="form-group col-md-4 <?php if($errors->has('salon_id')): ?> has-error <?php endif; ?>">
                       <label for="salon_id-field">Salon</label>
                       <?php echo Form::select("salon_id", $list["Salon"], null, array("class" => "form-control select_seguridad", "id" => "salon_id-field")); ?>

                       <div id='loading3' style='display: none'><img src="<?php echo e(asset('images/ajax-loader.gif')); ?>" title="Enviando" /></div> 
                       <?php if($errors->has("salon_id")): ?>
                        <span class="help-block"><?php echo e($errors->first("salon_id")); ?></span>
                       <?php endif; ?>
                    </div>
                    <div class="form-group col-md-4 <?php if($errors->has('periodo_estudio_id')): ?> has-error <?php endif; ?>">
                       <label for="periodo_estudio_id-field">Periodo</label>
                       <?php echo Form::select("periodo_estudio_id", $list["PeriodoEstudio"], null, array("class" => "form-control select_seguridad", "id" => "periodo_estudio_id-field")); ?>

                       <div id='loading10' style='display: none'><img src="<?php echo e(asset('images/ajax-loader.gif')); ?>" title="Enviando" /></div> 
                       <?php if($errors->has("periodo_estudio_id")): ?>
                        <span class="help-block"><?php echo e($errors->first("periodo_estudio_id")); ?></span>
                       <?php endif; ?>
                    </div>
<?php if(isset($grupo->periodosEstudio)): ?>
<table class="table table-condensed table-striped">
    <thead>
    <td>Periodo</td><td></td>
    </thead>
    <tbody>
        <?php $__currentLoopData = $grupo->periodosEstudio; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
        <td> <?php echo e($p->name); ?> </td>
        <td>
            <a href="<?php echo e(route('grupos.destroyPeriodo', array('g'=>$grupo->id, 'p'=>$p->id))); ?>" class="btn btn-xs btn-danger">Eliminar</a>
        </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        
    </tbody>
</table>
<?php endif; ?>                   
<?php $__env->startPush('scripts'); ?>
  
  <script type="text/javascript">
    
    $(document).ready(function() {
      getCmbSalon();
      getCmbPeriodo();
      
      $('#plantel_id-field').change(function(){
          getCmbSalon();
          getCmbPeriodo();
      });
      function getCmbSalon(){
          var $example = $("#especialidad_id-field").select2();
          var a= $('#frm_grupos').serialize();
              $.ajax({
                  url: '<?php echo e(route("salons.getCmbSalon")); ?>',
                  type: 'GET',
                  data: a,
                  dataType: 'json',
                  beforeSend : function(){$("#loading3").show();},
                  complete : function(){$("#loading3").hide();},
                  success: function(data){
                      //$example.select2("destroy");
                      $('#salon_id-field').html('');
                      
                      //$('#especialidad_id-field').empty();
                      $('#salon_id-field').append($('<option></option>').text('Seleccionar Opción').val('0'));
                      
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#salon_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                          
                      });
                      //$example.select2();
                  }
              });       
      }
      function getCmbPeriodo(){
          //var $example = $("#especialidad_id-field").select2();
          var a= $('#frm_grupos').serialize();
              $.ajax({
                  url: '<?php echo e(route("periodoEstudios.getCmbPeriodo")); ?>',
                  type: 'GET',
                  data: a,
                  dataType: 'json',
                  beforeSend : function(){$("#loading10").show();},
                  complete : function(){$("#loading10").hide();},
                  success: function(data){
                      //$example.select2("destroy");
                      $('#periodo_estudio_id-field').html('');
                      
                      //$('#especialidad_id-field').empty();
                      $('#periodo_estudio_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                      
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#periodo_estudio_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                          
                      });
                      //$example.select2();
                  }
              });       
      }
      

    });
    
</script>
<?php $__env->stopPush(); ?>