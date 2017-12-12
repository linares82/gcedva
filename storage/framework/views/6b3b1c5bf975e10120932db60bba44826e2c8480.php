<link rel="stylesheet" type="text/css" href="asset('bower_components/AdminLTE/plugins/lou-multi-select/css/css/multi-select.css')">                
                    <div class="form-group col-md-4 <?php if($errors->has('plantel_id')): ?> has-error <?php endif; ?>">
                       <label for="plantel_id-field">Plantel</label>
                       <?php echo Form::select("plantel_id", $list["Plantel"], null, array("class" => "form-control select_seguridad", "id" => "plantel_id-field", 'readonly'=>'readonly')); ?>

                       <?php if($errors->has("plantel_id")): ?>
                        <span class="help-block"><?php echo e($errors->first("plantel_id")); ?></span>
                       <?php endif; ?>
                    </div>
                    <div class="form-group col-md-4 <?php if($errors->has('especialidad')): ?> has-error <?php endif; ?>">
                       <label for="especialidad-field">Especialidad</label>
                       <?php echo Form::select("especialidad_id", $list["Especialidad"], null, array("class" => "form-control select_seguridad", "id" => "especialidad_id-field")); ?>

                       <div id='loading10' style='display: none'><img src="<?php echo e(asset('images/ajax-loader.gif')); ?>" title="Enviando" /></div> 
                       <?php if($errors->has("especialidad")): ?>
                        <span class="help-block"><?php echo e($errors->first("especialidad")); ?></span>
                       <?php endif; ?>
                    </div>
                    <div class="form-group col-md-4 <?php if($errors->has('nivel_id')): ?> has-error <?php endif; ?>">
                       <label for="nivel_id-field">Nivel</label>
                       <?php echo Form::select("nivel_id", $list["Nivel"], null, array("class" => "form-control select_seguridad", "id" => "nivel_id-field")); ?>

                       <div id='loading11' style='display: none'><img src="<?php echo e(asset('images/ajax-loader.gif')); ?>" title="Enviando" /></div> 
                       <?php if($errors->has("nivel_id")): ?>
                        <span class="help-block"><?php echo e($errors->first("nivel_id")); ?></span>
                       <?php endif; ?>
                    </div>
                    <div class="form-group col-md-4 <?php if($errors->has('grado_id')): ?> has-error <?php endif; ?>">
                       <label for="grado_id-field">Grado</label>
                       <?php echo Form::select("grado_id", $list["Grado"], null, array("class" => "form-control select_seguridad", "id" => "grado_id-field")); ?>

                       <div id='loading12' style='display: none'><img src="<?php echo e(asset('images/ajax-loader.gif')); ?>" title="Enviando" /></div> 
                       <?php if($errors->has("grado_id")): ?>
                        <span class="help-block"><?php echo e($errors->first("grado_id")); ?></span>
                       <?php endif; ?>
                    </div>
                    <div class="form-group col-md-4 <?php if($errors->has('name')): ?> has-error <?php endif; ?>">
                       <label for="name-field">Periodo</label>
                       <?php echo Form::text("name", null, array("class" => "form-control", "id" => "name-field")); ?>

                       <?php if($errors->has("name")): ?>
                        <span class="help-block"><?php echo e($errors->first("name")); ?></span>
                       <?php endif; ?>
                    </div>
                    <?php if(isset($materias_ls)): ?>
                    <div class="form-group col-md-4 <?php if($errors->has('materia_id')): ?> has-error <?php endif; ?>">
                        <label for="materia_id-field">Materias</label>
                        <div id="select_materia">
                            <?php echo Form::select("materia_id", $materias_ls, null, array("class" => "form-control select_seguridad", "id" => "materia_id-field", "name"=>"materia_id-field[]", 'multiple'=>'multiple')); ?> 
                        </div>
                        <div id='loading3' style='display: none'><img src="<?php echo e(asset('images/ajax-loader.gif')); ?>" title="Enviando" /></div>
                        <?php if($errors->has("materia_id")): ?>
                            <span class="help-block"><?php echo e($errors->first("materia_id")); ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-group col-md-4">
                    <table class="table table-condensed table-striped">
                        <thead>
                            <tr>
                                <th>Materia</th><th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $materias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($m->materia); ?></td>
                                <td><a href="<?php echo e(route('periodoEstudios.destroyMateria', $m->id)); ?>" class="btn btn-xs btn-danger">Eliminar</a></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    </div>
                    <?php endif; ?>

<?php $__env->startPush('scripts'); ?>
  
  <script type="text/javascript">
    
    $(document).ready(function() {
      getCmbEspecialidad();
      getCmbNivel();
      getCmbGrado();
      getCmbMateria();
      
      $('#plantel_id-field').change(function(){
          getCmbEspecialidad();
          getCmbMateria();
      });
      function getCmbMateria(){
          var $example = $("#especialidad_id-field").select2();
          var a= $('#frm_periodo_estudios').serialize();
              $.ajax({
                  url: '<?php echo e(route("materias.getCmbMateria")); ?>',
                  type: 'GET',
                  data: "plantel_id=" + $('#plantel_id-field option:selected').val(),
                  dataType: 'json',
                  beforeSend : function(){$("#loading3").show();},
                  complete : function(){$("#loading3").hide();},
                  success: function(data){
                      //$example.select2("destroy");
                      $('#materia_id-field').html('');
                      
                      //$('#especialidad_id-field').empty();
                      $('#materia_id-field').append($('<option></option>').text('Seleccionar Opción').val('0'));
                      
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#materia_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                          
                      });
                      //$example.select2();
                  }
              });       
      }
      function getCmbEspecialidad(){
          //var $example = $("#especialidad_id-field").select2();
          var a= $('#frm_periodo_estudios').serialize();
              $.ajax({
                  url: '<?php echo e(route("especialidads.getCmbEspecialidad")); ?>',
                  type: 'GET',
                  data: "plantel_id=" + $('#plantel_id-field option:selected').val() + "&especialidad_id=" + $('#especialidad_id-field option:selected').val() + "",
                  dataType: 'json',
                  beforeSend : function(){$("#loading10").show();},
                  complete : function(){$("#loading10").hide();},
                  success: function(data){
                      //$example.select2("destroy");
                      $('#especialidad_id-field').html('');
                      
                      //$('#especialidad_id-field').empty();
                      $('#especialidad_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                      
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#especialidad_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                          
                      });
                      //$example.select2();
                  }
              });       
      }
      $('#especialidad_id-field').change(function(){
          getCmbNivel();
      });
      function getCmbNivel(){
          //var $example = $("#especialidad_id-field").select2();
          var a= $('#frm_periodo_estudios').serialize();
              $.ajax({
                  url: '<?php echo e(route("nivels.getCmbNivels")); ?>',
                  type: 'GET',
                  data: "plantel_id=" + $('#plantel_id-field option:selected').val() + "&especialidad_id=" + $('#especialidad_id-field option:selected').val() + "&nivel_id=" + $('#nivel_id-field option:selected').val() + "",
                  dataType: 'json',
                  beforeSend : function(){$("#loading11").show();},
                  complete : function(){$("#loading11").hide();},
                  success: function(data){
                      //alert(data);
                      //$example.select2("destroy");
                      $('#nivel_id-field').html('');
                      //$('#especialidad_id-field').empty();
                      $('#nivel_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                      
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#nivel_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                      });
                      //$example.select2();
                  }
              });       
      }
      
      $('#nivel_id-field').change(function(){
          getCmbGrado();
      });
      function getCmbGrado(){
          //var $example = $("#especialidad_id-field").select2();
          var a= $('#frm_periodo_estudios').serialize();
              $.ajax({
                  url: '<?php echo e(route("grados.getCmbGrados")); ?>',
                  type: 'GET',
                  data: "plantel_id=" + $('#plantel_id-field option:selected').val() + "&especialidad_id=" + $('#especialidad_id-field option:selected').val() + "&nivel_id=" + $('#nivel_id-field option:selected').val() + "&grado_id=" + $('#grado_id-field option:selected').val() +"",
                  dataType: 'json',
                  beforeSend : function(){$("#loading12").show();},
                  complete : function(){$("#loading12").hide();},
                  success: function(data){
                      //alert(data);
                      //$example.select2("destroy");
                      $('#grado_id-field').html('');
                      //$('#especialidad_id-field').empty();
                      $('#grado_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                      
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#grado_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                      });
                      //$example.select2();
                  }
              });       
      }

      

    });
    
</script>
<?php $__env->stopPush(); ?>