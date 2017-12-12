<?php echo $__env->make('inscripcions._common', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->startSection('header'); ?>

	<ol class="breadcrumb">
		<li><a href="<?php echo e(route('home')); ?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="<?php echo e(route('inscripcions.index')); ?>"><?php echo $__env->yieldContent('inscripcionsAppTitle'); ?></a></li>
	    <li class="active">Crear</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> <?php echo $__env->yieldContent('inscripcionsAppTitle'); ?> / Crear </h3>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('error', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="row">
        <div class="col-md-12">

            <?php echo Form::open(array('route' => 'inscripcions.reinscripcion')); ?>


            <div class="box box-success box-solid">
                <div class="box-header">
                    <h3 class="box-title">De</h3>
                    <div class="box-tools">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
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
                        <div class="form-group col-md-4 <?php if($errors->has('lectivo_id')): ?> has-error <?php endif; ?>">
                            <label for="lectivo_id-field">Periodo Lectivo</label>
                            <?php echo Form::select("lectivo_id", $list["Lectivo"], null, array("class" => "form-control select_seguridad", "id" => "lectivo_id-field")); ?>

                            <?php if($errors->has("lectivo_id")): ?>
                            <span class="help-block"><?php echo e($errors->first("lectivo_id")); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group col-md-4 <?php if($errors->has('grupo_id')): ?> has-error <?php endif; ?>">
                            <label for="grupo_id-field" id="lbl_disponibles">De Grupo </label>
                            <?php echo Form::select("grupo_id", $list["Grupo"], null, array("class" => "form-control select_seguridad", "id" => "grupo_id-field")); ?>

                            <?php if($errors->has("grupo_id")): ?>
                            <span class="help-block"><?php echo e($errors->first("grupo_id")); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div class="box box-warning box-solid">
                <div class="box-header">
                    <h3 class="box-title">A</h3>
                    <div class="box-tools">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                        <div class="form-group col-md-4 <?php if($errors->has('grupo_to')): ?> has-error <?php endif; ?>">
                            <label for="grupo_to-field" id="lbl_disponibles">A Grupo </label>
                            <?php echo Form::select("grupo_to", $list["Grupo"], null, array("class" => "form-control select_seguridad", "id" => "grupo_to-field")); ?>

                            <?php if($errors->has("grupo_to")): ?>
                            <span class="help-block"><?php echo e($errors->first("grupo_to")); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group col-md-4 <?php if($errors->has('lectivo_to')): ?> has-error <?php endif; ?>">
                            <label for="lectivo_to-field">A Periodo Lectivo</label>
                            <?php echo Form::select("lectivo_to", $list["Lectivo"], null, array("class" => "form-control select_seguridad", "id" => "lectivo_to-field")); ?>

                            <?php if($errors->has("lectivo_to")): ?>
                            <span class="help-block"><?php echo e($errors->first("lectivo_to")); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="row">
                        </div>
                        <div class="well well-sm">
                            <button type="submit" class="btn btn-primary">Procesar</button>
                            <a class="btn btn-link pull-right" href="<?php echo e(route('inscripcions.index')); ?>"><i class="glyphicon glyphicon-backward"></i> Regresar</a>
                        </div>
                    </div>
                </div>
                <?php if(isset($clientes)): ?>
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <td><input type="checkbox" id="select-all" /> Todos<br/></td>
                            <td>Cliente</td><td>Aprobadas</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e(Form::checkbox("id[]", $c->id)); ?></td>
                            <td><?php echo e($c->nombre); ?></td>
                            <td> <?php echo e($c->materias_aprobadas); ?> </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <?php endif; ?>
            <?php echo Form::close(); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
  
  <script type="text/javascript">
    
    $(document).ready(function() {
      getCmbEspecialidad();
      getCmbNivel();
      getCmbGrado();
      getCmbGrupo();


      $('#plantel_id-field').change(function(){
          getCmbGrupo();
      });

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
                $(':checkbox').each(function() {
                    this.checked = true;                        
                });
            }else{
                $(':checkbox').each(function() {
                    this.checked = false;                        
                });
            }
        });

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
                      $('#grupo_to-field').html('');
                      //$('#especialidad_id-field').empty();
                      $('#grupo_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                      $('#grupo_to-field').append($('<option></option>').text('Seleccionar').val('0'));
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#grupo_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                          $('#grupo_to-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                      });
                      //$example.select2();
                  }
              });       
      }
      $('#plantel_id-field').change(function(){
          getCmbEspecialidad();
      });
      function getCmbEspecialidad(){
          //var $example = $("#especialidad_id-field").select2();
          var a= $('#frm_academica').serialize();
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
          var a= $('#frm_academica').serialize();
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
          var a= $('#frm_academica').serialize();
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
      
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('plantillas.admin_template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>