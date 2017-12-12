                    <div class="form-group col-md-4 <?php if($errors->has('cliente_id')): ?> has-error <?php endif; ?>">
                       <label for="cliente_id-field">Alumno</label>
                       <?php echo Form::select("cliente_id", $list["Cliente"], null, array("class" => "form-control select_seguridad", "id" => "cliente_id-field")); ?>

                       <?php if($errors->has("cliente_id")): ?>
                        <span class="help-block"><?php echo e($errors->first("cliente_id")); ?></span>
                       <?php endif; ?>
                    </div>
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
                    <div class="form-group col-md-3 <?php if($errors->has('grupo_id')): ?> has-error <?php endif; ?>">
                       <label for="grupo_id-field" id="lbl_disponibles">Grupo </label>
                       <?php echo Form::select("grupo_id", $list["Grupo"], null, array("class" => "form-control select_seguridad", "id" => "grupo_id-field")); ?>

                       <?php if($errors->has("grupo_id")): ?>
                        <span class="help-block"><?php echo e($errors->first("grupo_id")); ?></span>
                       <?php endif; ?>
                    </div>
                    <div class="form-group col-md-3 <?php if($errors->has('periodo_estudio_id')): ?> has-error <?php endif; ?>">
                       <label for="grupo_id-field" id="lbl_disponibles">Perido Estudio </label>
                       <?php echo Form::select("periodo_estudio_id", $list["PeriodoEstudio"], null, array("class" => "form-control select_seguridad", "id" => "periodo_estudio_id-field")); ?>

                       <?php if($errors->has("periodo_estudio_id")): ?>
                        <span class="help-block"><?php echo e($errors->first("periodo_estudio_id")); ?></span>
                       <?php endif; ?>
                    </div>
                    <div class="form-group col-md-3 <?php if($errors->has('turno_id')): ?> has-error <?php endif; ?>">
                       <label for="grupo_id-field" id="lbl_disponibles">Turno </label>
                       <?php echo Form::select("turno_id", $list["Turno"], null, array("class" => "form-control select_seguridad", "id" => "turno_id-field")); ?>

                       <?php if($errors->has("turno_id")): ?>
                        <span class="help-block"><?php echo e($errors->first("periodo_estudio_id")); ?></span>
                       <?php endif; ?>
                    </div>
                    <div class="form-group col-md-1 <?php if($errors->has('disponibles')): ?> has-error <?php endif; ?>">
                       <label for="disponibles-field">Disponibles</label>
                       <?php echo Form::text("disponibles", null, array("class" => "form-control", "id" => "disponibles-field")); ?>

                    </div>
                    <div class="form-group col-md-4 <?php if($errors->has('fec_inscripcion')): ?> has-error <?php endif; ?>">
                       <label for="fec_inscripcion-field">F. Inscripcion</label>
                       <?php echo Form::text("fec_inscripcion", null, array("class" => "form-control", "id" => "fec_inscripcion-field")); ?>

                       <?php if($errors->has("fec_inscripcion")): ?>
                        <span class="help-block"><?php echo e($errors->first("fec_inscripcion")); ?></span>
                       <?php endif; ?>
                    </div>
                    <div class="form-group col-md-4 <?php if($errors->has('lectivo_id')): ?> has-error <?php endif; ?>">
                       <label for="lectivo_id-field">Periodo Lectivo</label>
                       <?php echo Form::select("lectivo_id", $list["Lectivo"], null, array("class" => "form-control select_seguridad", "id" => "lectivo_id-field")); ?>

                       <?php if($errors->has("lectivo_id")): ?>
                        <span class="help-block"><?php echo e($errors->first("lectivo_id")); ?></span>
                       <?php endif; ?>
                    </div>
<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">
    /*window.onbeforeunload=finalizar();
            function finalizar(){
                window.opener.location.reload();
            }*/
    $('#fec_inscripcion-field').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
      });
      
    $(document).ready(function() {
        getCmbGrupo();
        getCmbPeriodosEstudio();
        $('#grupo_id-field').change(function(){
          getDisponibles();
          getCmbPeriodosEstudio();
        });
        $('#plantel_id-field').change(function(){
          getCmbGrupo();
        });

    function getCmbGrupo(){
          //var $example = $("#especialidad_id-field").select2();
          var a= $('#frm_academica').serialize();
              $.ajax({
                  url: '<?php echo e(route("grupos.getCmbGrupo")); ?>',
                  type: 'GET',
                  data: "plantel_id=" + $('#plantel_id-field option:selected').val() + "&grupo_id=" + $('#grupo_id-field option:selected').val() + "",
                  dataType: 'json',
                  beforeSend : function(){$("#loading13").show();},
                  complete : function(){$("#loading13").hide();},
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

      function getCmbPeriodosEstudio(){
          //var $example = $("#especialidad_id-field").select2();
          var a= $('#frm_academica').serialize();
              $.ajax({
                  url: '<?php echo e(route("periodoEstudios.getCmbPeriodoInscripcion")); ?>',
                  type: 'GET',
                  data: "grupo_id=" + $('#grupo_id-field option:selected').val() + "&periodo_estudio_id=" + $('#periodo_estudio_id-field option:selected').val() + "",
                  dataType: 'json',
                  beforeSend : function(){$("#loading13").show();},
                  complete : function(){$("#loading13").hide();},
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

      function getDisponibles(){
          
          //var a= $('#frm_cliente').serialize();
              $.ajax({
                  url: '<?php echo e(route("grupos.getDisponibles")); ?>',
                  type: 'GET',
                  data: "grupo_id=" + $('#grupo_id-field option:selected').val() ,
                  dataType: 'json',
                  beforeSend : function(){$("#loading12").show();},
                  complete : function(){$("#loading12").hide();},
                  success: function(data){
                      $('#disponibles-field').val('');
                      $('#disponibles-field').val(data);
                  }
              });       
      }        
    });
</script>
<?php $__env->stopPush(); ?>
