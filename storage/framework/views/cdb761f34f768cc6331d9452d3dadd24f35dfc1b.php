<?php echo $__env->make('hacademicas._common', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->startSection('header'); ?>

	<ol class="breadcrumb">
		<li><a href="<?php echo e(route('home')); ?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="<?php echo e(route('hacademicas.index')); ?>"><?php echo $__env->yieldContent('hacademicasAppTitle'); ?></a></li>
	    <li class="active">Calificaciones</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> <?php echo $__env->yieldContent('hacademicasAppTitle'); ?> / Calificaciones </h3>
    </div>

    <style>
      table tr:hover {
        background-color: #A9D0F5;
        cursor: pointer;
    }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('error', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="row">
        <div class="col-md-12">
            
            <?php echo Form::open(array('route' => 'hacademicas.calificaciones', "id"=>"frm_academica")); ?>

            <!--
                    <div class="form-group col-md-4 <?php if($errors->has('plantel_id')): ?> has-error <?php endif; ?>">
                       <label for="plantel_id-field">Plantel</label>
                       <?php echo Form::select("plantel_id", $list["Plantel"], null, array("class" => "form-control select_seguridad", "id" => "plantel_id-field")); ?>

                       <?php if($errors->has("plantel_id")): ?>
                        <span class="help-block"><?php echo e($errors->first("plantel_id")); ?></span>
                       <?php endif; ?>
                    </div>
                    <div class="form-group col-md-4 <?php if($errors->has('grupo_id')): ?> has-error <?php endif; ?>">
                       <label for="grupo_id-field">Grupo</label>
                       <?php echo Form::select("grupo_id", $list["Grupo"], null, array("class" => "form-control select_seguridad", "id" => "grupo_id-field")); ?>

                       <?php if($errors->has("grupo_id")): ?>
                        <span class="help-block"><?php echo e($errors->first("grupo_id")); ?></span>
                       <?php endif; ?>
                    </div>
                    <div class="form-group col-md-4 <?php if($errors->has('lectivo_id')): ?> has-error <?php endif; ?>">
                       <label for="lectivo_id-field">Lectivo</label>
                       <?php echo Form::select("lectivo_id", $list["Lectivo"], null, array("class" => "form-control select_seguridad", "id" => "lectivo_id-field")); ?>

                       <?php if($errors->has("lectivo_id")): ?>
                        <span class="help-block"><?php echo e($errors->first("lectivo_id")); ?></span>
                       <?php endif; ?>
                    </div>
                    <div class="form-group col-md-4 <?php if($errors->has('materium_id')): ?> has-error <?php endif; ?>">
                       <label for="materium_id-field">Materia</label>
                       <?php echo Form::select("materium_id", $list["Materium"], null, array("class" => "form-control select_seguridad", "id" => "materium_id-field")); ?>

                       <?php if($errors->has("materium_id")): ?>
                        <span class="help-block"><?php echo e($errors->first("materium_id")); ?></span>
                       <?php endif; ?>
                    </div>
                -->
                    <div class="form-group col-md-4 <?php if($errors->has('cve_alumno')): ?> has-error <?php endif; ?>">
                       <label for="cve_alumno-field">Clave Alumno</label>
                       <?php echo Form::text("cve_alumno", null, array("class" => "form-control", "id" => "cve_alumno-field")); ?>

                       <?php if($errors->has("cve_alumno")): ?>
                        <span class="help-block"><?php echo e($errors->first("cve_alumno")); ?></span>
                       <?php endif; ?>
                    </div>
                    <div class="form-group col-md-4 <?php if($errors->has('materium_id')): ?> has-error <?php endif; ?>">
                       <label for="materium_id-field">Materia</label>
                       <?php echo Form::select("materium_id", $list["Materium"], null, array("class" => "form-control select_seguridad", "id" => "materium_id-field")); ?>

                       <?php if($errors->has("materium_id")): ?>
                        <span class="help-block"><?php echo e($errors->first("materium_id")); ?></span>
                       <?php endif; ?>
                    </div>
                    <div class="form-group col-md-4 <?php if($errors->has('tpo_examen_id')): ?> has-error <?php endif; ?>">
                       <label for="tpo_examen_id-field">Examen</label>
                       <?php echo Form::select("tpo_examen_id", $examen, null, array("class" => "form-control select_seguridad", "id" => "tpo_examen_id-field")); ?>

                       <?php if($errors->has("tpo_examen_id")): ?>
                        <span class="help-block"><?php echo e($errors->first("st_materium_id")); ?></span>
                       <?php endif; ?>
                    </div>
                    <?php if (\Entrust::can('calificacions.excepcion')) : ?>
                    <div class="form-group col-md-4 <?php if($errors->has('excepcion')): ?> has-error <?php endif; ?>">
                       <label for="excepcion-field">Exepcion</label>
                       <?php echo Form::checkbox("excepcion", 1, false); ?>

                       <?php if($errors->has("excepcion")): ?>
                        <span class="help-block"><?php echo e($errors->first("excepcion")); ?></span>
                       <?php endif; ?>
                    </div>
                    <?php endif; // Entrust::can ?>
<!--   
                    <div class="form-group col-md-4 <?php if($errors->has('st_materium_id')): ?> has-error <?php endif; ?>">
                       <label for="st_materium_id-field">Estatus Materia</label>
                       <?php echo Form::select("st_materium_id", $list["StMateria"], null, array("class" => "form-control select_seguridad", "id" => "st_materium_id-field")); ?>

                       <?php if($errors->has("st_materium_id")): ?>
                        <span class="help-block"><?php echo e($errors->first("st_materium_id")); ?></span>
                       <?php endif; ?>
                    </div>
-->
                <div class="row">
                </div>
                <?php if(isset($hacademicas)): ?>
                    <table class="table table-condensed table-striped">
                        <theader>
                            <tr>
                                <td>
                                    
                                </td>
                                <td>Alumno</td><td>Grado</td><td>Materia</td><td>Examen</td><td>Calificacion</td>
                                <td>Fecha</td><td>Reportar</td>
                                <td><input type="checkbox" id="select-all" /> Todos<br/></td><td>Evaluacion Parcial</td>
                                <td>Ponderacion</td><td>Calificacion Parcial</td>
                            </tr>
                        </theader>
                        <tbody>
                            <?php 
                                $materia="";
                            ?>
                            <?php $__currentLoopData = $hacademicas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <?php if($materia==$h->materia.$h->examen): ?>
                                        <td colspan="8">
                                        </td>
                                    <?php else: ?>
                                    <td>
                                        <?php echo Form::hidden("id", $h->id, array("class" => "form-control", "id" => "id-field")); ?>

                                    </td>
                                    <td>
                                        <?php echo e($h->nombre); ?>

                                    </td>
                                    <td>
                                        <?php echo e($h->grado); ?>

                                    </td>
                                    <td>
                                        <?php echo e($h->materia); ?>

                                    </td>
                                    <td>
                                        <?php echo e($h->examen); ?>

                                    </td>
                                    <td>
                                        <input type="text" name="calificacion" value=<?php echo e($h->calificacion); ?> class="from-control">
                                    </td>
                                    <td>
                                        <input type="text" name="fecha" value=<?php echo e($h->fecha); ?> class="from-control fecha">
                                    </td>
                                    <td>
                                        <?php echo Form::checkbox("reporte_bnd", $h->id, $h->reporte_bnd); ?>

                                    </td>
                                    <?php endif; ?>
                                    <td>
                                        <?php echo Form::checkbox("calificacion_parcial_id[]", $h->calificacion_parcial_id, true, array('class'=>'checkbox')); ?>

                                    </td>
                                    <td>
                                        <?php echo e($h->nombre_ponderacion); ?>

                                    </td>
                                    <td>
                                        <?php echo e($h->ponderacion); ?>

                                    </td>
                                    <td>
                                        <input type="text" name="calificacion_parcial[]" value=<?php echo e($h->calificacion_parcial); ?> class="from-control">
                                    </td>
                                </tr>
                                <?php 
                                $materia=$h->materia.$h->examen;
                                ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <?php endif; ?>
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Procesar</button>
                </div>
            <?php echo Form::close(); ?>

        </div>
    </div>
    
    
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
  
  <script type="text/javascript">
    
    $(document).ready(function() {
      //getCmbGrupo();
      getCmbMateria();
      $('#cve_alumno-field').focusout(function() {
          getCmbMateria();
      });
      /*$('#plantel_id-field').change(function(){
          getCmbGrupo();
          getCmbMateria();
          if($('#plantel_id-field').val()>0){
              $('#cve_alumno-field').prop('disabled', true);
          }else{
              $('#cve_alumno-field').prop('disabled', false);
          }
      });
        */
      //$("tr td").parent().addClass('has-sub');
      $('.fecha').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
      });
     


      $('#select-all').click(function(event) {   
            if(this.checked) {
                // Iterate each checkbox
                $('.checkbox').each(function() {
                    this.checked = true;                        
                });
            }else{
                $('.checkbox').each(function() {
                    this.checked = false;                        
                });
            }
        });

    });

    function getCmbMateria(){
          var $example = $("#especialidad_id-field").select2();
          var a= $('#frm_academica').serialize();
              $.ajax({
                  url: '<?php echo e(route("materias.getCmbMateriaXalumno2")); ?>',
                  type: 'GET',
                  data: "cve_alumno=" + $('#cve_alumno-field').val()+"&materium_id="+ $('#materium_id-field option:selected').val(),
                  dataType: 'json',
                  beforeSend : function(){$("#loading3").show();},
                  complete : function(){$("#loading3").hide();},
                  success: function(data){
                      //$example.select2("destroy");
                      $('#materium_id-field').html('');
                      
                      //$('#especialidad_id-field').empty();
                      $('#materium_id-field').append($('<option></option>').text('Seleccionar Opción').val('0'));
                      
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#materium_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                          
                      });
                      //$example.select2();
                  }
              });       
      }

    /*function getCmbGrupo(){
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
    function getCmbMateria(){
          var $example = $("#especialidad_id-field").select2();
          var a= $('#frm_academica').serialize();
              $.ajax({
                  url: '<?php echo e(route("materias.getCmbMateria")); ?>',
                  type: 'GET',
                  data: "plantel_id=" + $('#plantel_id-field option:selected').val()+"&materium_id="+ $('#materium_id-field option:selected').val(),
                  dataType: 'json',
                  beforeSend : function(){$("#loading3").show();},
                  complete : function(){$("#loading3").hide();},
                  success: function(data){
                      //$example.select2("destroy");
                      $('#materium_id-field').html('');
                      
                      //$('#especialidad_id-field').empty();
                      $('#materium_id-field').append($('<option></option>').text('Seleccionar Opción').val('0'));
                      
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#materium_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                          
                      });
                      //$example.select2();
                  }
              });       
      }
      */
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('plantillas.admin_template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>