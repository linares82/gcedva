<?php echo $__env->make('asignacionAcademicas._common', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->startSection('header'); ?>

    <ol class="breadcrumb">
    	<li><a href="<?php echo e(route('home')); ?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        <?php if( $query_params = Request::input('q') ): ?>

            <li class="active"><a href="<?php echo e(route('asignacionAcademicas.index')); ?>"><?php echo $__env->yieldContent('asignacionAcademicasAppTitle'); ?></a></li>
            <li class="active">condition(  

            <?php $__currentLoopData = $query_params; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(!$loop->first): ?> / <?php endif; ?> <?php echo e($key); ?> : <?php echo e($value); ?>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            )</li>
        <?php else: ?>
            <li class="active"><?php echo $__env->yieldContent('asignacionAcademicasAppTitle'); ?></li>
        <?php endif; ?>
        -->
        <li class="active"><?php echo $__env->yieldContent('asignacionAcademicasAppTitle'); ?></li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> <?php echo $__env->yieldContent('asignacionAcademicasAppTitle'); ?>
            <?php if (\Entrust::can('asignacionAcademicas.create')) : ?>
            <a class="btn btn-success pull-right" href="<?php echo e(route('asignacionAcademicas.create')); ?>"><i class="glyphicon glyphicon-plus"></i> Crear</a>
            <?php endif; // Entrust::can ?>
        </h3>

    </div>

    <div aria-multiselectable="true" role="tablist" id="accordion" class="panel-group">
        <div class="panel panel-default">
            <div id="headingOne" role="tab" class="panel-heading">
                <h4 class="panel-title">
                <a aria-controls="collapseOne" aria-expanded="true" href="#collapseOne" data-parent="#accordion" data-toggle="collapse" role="button">
                    <span aria-hidden="true" class="glyphicon glyphicon-search"></span> Buscar
                </a>
                </h4>
            </div>
            <div aria-labelledby="headingOne" role="tabpanel" class="panel-collapse collapse" id="collapseOne">
                <div class="panel-body">
                    <form class="AsignacionAcademica_search" id="search" action="<?php echo e(route('asignacionAcademicas.index')); ?>" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="<?php echo e(@(Request::input('q')['s']) ?: ''); ?>" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_empleados.nombre_gt">EMPLEADO_NOMBRE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['empleados.nombre_gt']) ?: ''); ?>" name="q[empleados.nombre_gt]" id="q_empleados.nombre_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['empleados.nombre_lt']) ?: ''); ?>" name="q[empleados.nombre_lt]" id="q_empleados.nombre_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_empleados.nombre_cont">EMPLEADO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="hidden" value="<?php echo e($e->plantel_id); ?>" name="plantel_id" id="plantel_id" />
                                    <?php echo Form::select("empleado_id", $list["Empleado"], "<?php echo e(@(Request::input('q')['asignacion_academicas.empleado_id_lt']) ?: 0); ?>", array("class" => "form-control select_seguridad", "name"=>"q[asignacion_academicas.empleado_id_lt]", "id"=>"q_asignacion_academicas.empleado_id_lt", "style"=>"width:100%;" )); ?>

                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_materia_id_gt">MATERIA_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['materia_id_gt']) ?: ''); ?>" name="q[materia_id_gt]" id="q_materia_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['materia_id_lt']) ?: ''); ?>" name="q[materia_id_lt]" id="q_materia_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_materium_id_cont">MATERIA</label>
                                <div class=" col-sm-9">
                                    <?php echo Form::select("materium_id", $list["Materium"], "<?php echo e(@(Request::input('q')['asignacion_academicas.materium_id_lt']) ?: ''); ?>", array("class" => "form-control select_seguridad", "name"=>"q[asignacion_academicas.materium_id_lt]", "id"=>"q_asignacion_academicas.materium_id_lt", "style"=>"width:100%;" )); ?>

                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_grupos.name_gt">GRUPO_NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['grupos.name_gt']) ?: ''); ?>" name="q[grupos.name_gt]" id="q_grupos.name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['grupos.name_lt']) ?: ''); ?>" name="q[grupos.name_lt]" id="q_grupos.name_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_grupos.name_cont">GRUPO</label>
                                <div class=" col-sm-9">
                                    <?php echo Form::select("grupo_id", $list["Grupo"], "<?php echo e(@(Request::input('q')['asignacion_academicas.grupo_id_lt']) ?: ''); ?>", array("class" => "form-control select_seguridad", "name"=>"q[asignacion_academicas.grupo_id_lt]", "id"=>"q_asignacion_academicas.grupo_id_lt", "style"=>"width:100%;" )); ?>

                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_horas_gt">HORAS</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['horas_gt']) ?: ''); ?>" name="q[horas_gt]" id="q_horas_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['horas_lt']) ?: ''); ?>" name="q[horas_lt]" id="q_horas_lt" />
                                </div>
                            </div>
                            -->
                            
                             

                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-2">
                                    <input type="submit" name="commit" value="Buscar" class="btn btn-default btn-xs" />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <?php if($asignacionAcademicas->count()): ?>
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th><?php echo $__env->make('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></th>
                            <th><?php echo $__env->make('CrudDscaffold::getOrderlink', ['column' => 'plantel.razon', 'title' => 'PLANTEL'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></th>
                            <th><?php echo $__env->make('CrudDscaffold::getOrderlink', ['column' => 'empleados.nombre', 'title' => 'EMPLEADO'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></th>
                            <th><?php echo $__env->make('CrudDscaffold::getOrderlink', ['column' => 'materium_id', 'title' => 'MATERIA'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></th>
                            <th><?php echo $__env->make('CrudDscaffold::getOrderlink', ['column' => 'grupos.name', 'title' => 'GRUPO'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></th>
                            <th><?php echo $__env->make('CrudDscaffold::getOrderlink', ['column' => 'lectivos.name', 'title' => 'PERIODO LECTIVO'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></th>
                        
                        
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $__currentLoopData = $asignacionAcademicas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asignacionAcademica): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><a href="<?php echo e(route('asignacionAcademicas.show', $asignacionAcademica->id)); ?>"><?php echo e($asignacionAcademica->id); ?></a></td>
                                <td><?php echo e($asignacionAcademica->plantel->razon); ?></td>
                                <td><?php echo e($asignacionAcademica->empleado->nombre." ".$asignacionAcademica->empleado->ape_paterno." ".$asignacionAcademica->empleado->ape_materno); ?></td>
                                <td><?php echo e($asignacionAcademica->materia->name); ?></td>
                                <td><?php echo e($asignacionAcademica->grupo->name); ?></td>
                                <td><?php echo e($asignacionAcademica->lectivo->name); ?></td>
                                <td class="text-right">
                                    <?php if (\Entrust::can('asignacionAcademicas.edit')) : ?>
                                    <a class="btn btn-xs btn-primary" href="<?php echo e(route('asignacionAcademicas.duplicate', $asignacionAcademica->id)); ?>"><i class="glyphicon glyphicon-duplicate"></i> Duplicar</a>
                                    <?php endif; // Entrust::can ?>
                                    <?php if (\Entrust::can('asignacionAcademicas.edit')) : ?>
                                    <a class="btn btn-xs btn-warning" href="<?php echo e(route('asignacionAcademicas.edit', $asignacionAcademica->id)); ?>"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    <?php endif; // Entrust::can ?>
                                    <?php if (\Entrust::can('asignacionAcademicas.destroy')) : ?>
                                    <?php echo Form::model($asignacionAcademica, array('route' => array('asignacionAcademicas.destroy', $asignacionAcademica->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")); ?>

                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    <?php echo Form::close(); ?>

                                    <?php endif; // Entrust::can ?>
                                    <?php if (\Entrust::can('asistenciasRs.index')) : ?>
                                    <a class="btn btn-xs btn-success" href="<?php echo e(route('asistenciaRs.create', $asignacionAcademica->id)); ?>"><i class="glyphicon glyphicon-edit"></i>Asistencias</a>
                                    <?php endif; // Entrust::can ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <?php echo $asignacionAcademicas->appends(Request::except('page'))->render(); ?>

            <?php else: ?>
                <h3 class="text-center alert alert-info">Vacio!</h3>
            <?php endif; ?>

        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#accordion').on('shown.bs.collapse', function () {
            getCmbEmpleados();
         });
         
        
        getCmbMaterias();
        getCmbGrupos();
        
      function getCmbEmpleados(){
          //$('#empleado_id_field option:selected').val($('#empleado_id_campo option:selected').val()).change();
          var a= $('#search').serialize();
              $.ajax({
                  url: '<?php echo e(route("empleados.getEmpleadosXplantel")); ?>',
                  type: 'GET',
                  //data: "plantel_id=" + $('#plantel_id').val() + "&empleado_id=" + $('#q_asignacion_academicas.empleado_id_lt option:selected').val() + "",
                  data:a,
                  dataType: 'json',
                  beforeSend : function(){$("#loading3").show();},
                  complete : function(){$("#loading3").hide();},
                  success: function(data){
                      //$example.select2("destroy");
                      
                      $('#search #q_asignacion_academicas.empleado_id_lt').html('');
                      $('#search #q_asignacion_academicas.empleado_id_lt').empty();
                      //$('#q_asignacion_academicas.empleado_id_lt').append($('<option></option>').text('Seleccionar Opción').val('0'));
                      //alert($('#q_asignacion_academicas.empleado_id_lt option:selected').val());
                      $.each(data, function(i) {
                          //alert(data[i].nombre);
                          $('#q_asignacion_academicas.empleado_id_lt').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].nombre+"<\/option>");  
                      });
                      //$('#q_asignacion_academicas.empleado_id_lt').change();
                      //$example.select2();
                  }
              });       
      }
      function getCmbMaterias(){
          //var $example = $("#especialidad_id-field").select2();
          //$('#materia_id_field option:selected').val($('#materium_id_campo option:selected').val()).change();
          var a= $('#frm_asistencias_c').serialize();
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
          var a= $('#frm_asistencias_c').serialize();
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
<?php echo $__env->make('plantillas.admin_template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>