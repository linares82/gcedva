<?php echo $__env->make('hacademicas._common', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->startSection('header'); ?>

    <ol class="breadcrumb">
    	<li><a href="<?php echo e(route('home')); ?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        <?php if( $query_params = Request::input('q') ): ?>

            <li class="active"><a href="<?php echo e(route('hacademicas.index')); ?>"><?php echo $__env->yieldContent('hacademicasAppTitle'); ?></a></li>
            <li class="active">condition(  

            <?php $__currentLoopData = $query_params; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(!$loop->first): ?> / <?php endif; ?> <?php echo e($key); ?> : <?php echo e($value); ?>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            )</li>
        <?php else: ?>
            <li class="active"><?php echo $__env->yieldContent('hacademicasAppTitle'); ?></li>
        <?php endif; ?>
        -->
        <li class="active"><?php echo $__env->yieldContent('hacademicasAppTitle'); ?></li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> <?php echo $__env->yieldContent('hacademicasAppTitle'); ?>
            <?php if (\Entrust::can('hacademicas.create')) : ?>
            <!--<a class="btn btn-success pull-right" href="<?php echo e(route('hacademicas.create')); ?>"><i class="glyphicon glyphicon-plus"></i> Crear</a>-->
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
                    <form class="Hacademica_search" id="search" action="<?php echo e(route('hacademicas.index')); ?>" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="<?php echo e(@(Request::input('q')['s']) ?: ''); ?>" />
                        <div class="">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_alumno_id_gt">ALUMNO_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['alumno_id_gt']) ?: ''); ?>" name="q[alumno_id_gt]" id="q_alumno_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['alumno_id_lt']) ?: ''); ?>" name="q[alumno_id_lt]" id="q_alumno_id_lt" />
                                </div>
                            </div>
                            -->
                            
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_plantels.razon_gt">PLANTEL_RAZON</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['plantels.razon_gt']) ?: ''); ?>" name="q[plantels.razon_gt]" id="q_plantels.razon_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['plantels.razon_lt']) ?: ''); ?>" name="q[plantels.razon_lt]" id="q_plantels.razon_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group col-md-4">
                                <label for="q_plantel_id_lt">PLANTEL</label>
                                    <?php echo Form::select("plantel_id", $list["Plantel"], "<?php echo e(@(Request::input('q')['plantel_id_lt']) ?: ''); ?>", array("class" => "form-control select_seguridad", "name"=>"q[plantel_id_lt]", "id"=>"q_plantel_id_lt", "style"=>"width:100%;" )); ?>

                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_especialidads.name_gt">ESPECIALIDAD_NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['especialidads.name_gt']) ?: ''); ?>" name="q[especialidads.name_gt]" id="q_especialidads.name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['especialidads.name_lt']) ?: ''); ?>" name="q[especialidads.name_lt]" id="q_especialidads.name_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group col-md-4">
                                <label  for="q_especialidad_id_lt">ESPECIALIDAD</label>
                                <?php echo Form::select("especialidad_id", $list["Especialidad"], "<?php echo e(@(Request::input('q')['especialidad_id_lt']) ?: ''); ?>", array("class" => "form-control select_seguridad", "name"=>"q[especialidad_id_lt]", "id"=>"q_especialidad_id_lt", "style"=>"width:100%;" )); ?>

                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_nivels.name_gt">NIVEL_NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['nivels.name_gt']) ?: ''); ?>" name="q[nivels.name_gt]" id="q_nivels.name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['nivels.name_lt']) ?: ''); ?>" name="q[nivels.name_lt]" id="q_nivels.name_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group col-md-4">
                                <label for="q_nivel_id_lt">NIVEL</label>
                                <?php echo Form::select("nivel_id", $list["Nivel"], "<?php echo e(@(Request::input('q')['nivel_id_lt']) ?: ''); ?>", array("class" => "form-control select_seguridad", "name"=>"q[nivel_id_lt]", "id"=>"q_nivel_id_lt", "style"=>"width:100%;" )); ?>

                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_grados.name_gt">GRADO_NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['grados.name_gt']) ?: ''); ?>" name="q[grados.name_gt]" id="q_grados.name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['grados.name_lt']) ?: ''); ?>" name="q[grados.name_lt]" id="q_grados.name_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group col-md-4">
                                <label  for="q_grado_id_lt">GRADO</label>
                                <?php echo Form::select("grado_id", $list["Grado"], "<?php echo e(@(Request::input('q')['grado_id_lt']) ?: ''); ?>", array("class" => "form-control select_seguridad", "name"=>"q[grado_id_lt]", "id"=>"q_grado_id_lt", "style"=>"width:100%;" )); ?>

                            </div>

                            <div class="form-group col-md-4">
                                <label  for="q_grupo_id_lt">GRUPO</label>
                                <?php echo Form::select("grupo_id", $list["Grupo"], "<?php echo e(@(Request::input('q')['grupo_id_lt']) ?: ''); ?>", array("class" => "form-control select_seguridad", "name"=>"q[grupo_id_lt]", "id"=>"q_grupo_id_lt", "style"=>"width:100%;" )); ?>

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
                            <div class="form-group col-md-4">
                                <label for="q_materia_id_lt">MATERIA</label>
                                <?php echo Form::select("materia_id", $list["Materium"], "<?php echo e(@(Request::input('q')['materia_id_lt']) ?: ''); ?>", array("class" => "form-control select_seguridad", "name"=>"q[materia_id_lt]", "id"=>"q_materia_id_lt", "style"=>"width:100%;" )); ?>

                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_st_materia_id_gt">ST_MATERIA_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['st_materia_id_gt']) ?: ''); ?>" name="q[st_materia_id_gt]" id="q_st_materia_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['st_materia_id_lt']) ?: ''); ?>" name="q[st_materia_id_lt]" id="q_st_materia_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group col-md-4">
                                <label for="q_st_materia_id_lt">ESTATUS MATERIA</label>
                                <?php echo Form::select("st_materia_id", $list["StMateria"], "<?php echo e(@(Request::input('q')['st_materia_id_lt']) ?: ''); ?>", array("class" => "form-control select_seguridad", "name"=>"q[st_materia_id_lt]", "id"=>"q_st_materia_id_lt", "style"=>"width:100%;" )); ?>

                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_lectivos.name_gt">LECTIVO_NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['lectivos.name_gt']) ?: ''); ?>" name="q[lectivos.name_gt]" id="q_lectivos.name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['lectivos.name_lt']) ?: ''); ?>" name="q[lectivos.name_lt]" id="q_lectivos.name_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group col-md-4">
                                <label for="q_lectivo_id_lt">LECTIVO</label>
                                <?php echo Form::select("lectivo_id", $list["Lectivo"], "<?php echo e(@(Request::input('q')['lectivo_id_lt']) ?: ''); ?>", array("class" => "form-control select_seguridad", "name"=>"q[lectivo_id_lt]", "id"=>"q_lectivo_id_lt", "style"=>"width:100%;" )); ?>

                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_usu_alta_id_gt">USU_ALTA_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['usu_alta_id_gt']) ?: ''); ?>" name="q[usu_alta_id_gt]" id="q_usu_alta_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['usu_alta_id_lt']) ?: ''); ?>" name="q[usu_alta_id_lt]" id="q_usu_alta_id_lt" />
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
            <?php if($hacademicas->count()): ?>
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th><?php echo $__env->make('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></th>
                            <th><?php echo $__env->make('CrudDscaffold::getOrderlink', ['column' => 'alumno_id', 'title' => 'ALUMNO'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></th>
                            <th><?php echo $__env->make('CrudDscaffold::getOrderlink', ['column' => 'plantels.razon', 'title' => 'PLANTEL'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></th>
                            <th><?php echo $__env->make('CrudDscaffold::getOrderlink', ['column' => 'especialidads.name', 'title' => 'ESPECIALIDAD'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></th>
                            <th><?php echo $__env->make('CrudDscaffold::getOrderlink', ['column' => 'nivels.name', 'title' => 'NIVEL'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></th>
                            <th><?php echo $__env->make('CrudDscaffold::getOrderlink', ['column' => 'grados.name', 'title' => 'GRADO'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></th>
                            <th><?php echo $__env->make('CrudDscaffold::getOrderlink', ['column' => 'materia_id', 'title' => 'MATERIA'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></th>
                            <th><?php echo $__env->make('CrudDscaffold::getOrderlink', ['column' => 'st_materia_id', 'title' => 'ESTATUS MATERIA'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></th>
                            <th><?php echo $__env->make('CrudDscaffold::getOrderlink', ['column' => 'lectivos.name', 'title' => 'LECTIVO'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $__currentLoopData = $hacademicas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hacademica): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><a href="<?php echo e(route('hacademicas.show', $hacademica->id)); ?>"><?php echo e($hacademica->id); ?></a></td>
                                <td><?php echo e($hacademica->cliente->nombre." ".$hacademica->cliente->ape_paterno." ".$hacademica->cliente->ape_materno); ?></td>
                                <td><?php echo e($hacademica->plantel->razon); ?></td>
                                <td><?php echo e($hacademica->especialidad->name); ?></td>
                                <td><?php echo e($hacademica->nivel->name); ?></td>
                                <td><?php echo e($hacademica->grado->name); ?></td>
                                <td><?php echo e($hacademica->materia->name); ?></td>
                                <td><?php echo e($hacademica->stMateria->name); ?></td>
                                <td><?php echo e($hacademica->lectivo->name); ?></td>
                                <td class="text-right">
                                    <!--
                                    <?php if (\Entrust::can('hacademicas.edit')) : ?>
                                    <a class="btn btn-xs btn-primary" href="<?php echo e(route('hacademicas.duplicate', $hacademica->id)); ?>"><i class="glyphicon glyphicon-duplicate"></i> Duplicar</a>
                                    <?php endif; // Entrust::can ?>
                                    <?php if (\Entrust::can('hacademicas.edit')) : ?>
                                    <a class="btn btn-xs btn-warning" href="<?php echo e(route('hacademicas.edit', $hacademica->id)); ?>"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    <?php endif; // Entrust::can ?>
                                    
                                    <?php if (\Entrust::can('hacademicas.destroy')) : ?>
                                    <?php echo Form::model($hacademica, array('route' => array('hacademicas.destroy', $hacademica->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")); ?>

                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    <?php echo Form::close(); ?>

                                    <?php endif; // Entrust::can ?>
                                    -->
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <?php echo $hacademicas->appends(Request::except('page'))->render(); ?>

            <?php else: ?>
                <h3 class="text-center alert alert-info">Vacio!</h3>
            <?php endif; ?>

        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
  
  <script type="text/javascript">
    
    $(document).ready(function() {
      getCmbEspecialidad();
      getCmbNivel();
      getCmbGrado();
      getCmbMateria();
      getCmbGrupo();
      getCmbAlumno();

      $('#q_plantel_id_lt').change(function(){
          getCmbEspecialidad();
          getCmbMateria();
          getCmbGrupo();
      });

      
      function getCmbGrupo(){
          //var $example = $("#q_especialidad_id_lt").select2();
          var a= $('#frm_academica').serialize();
              $.ajax({
                  url: '<?php echo e(route("grupos.getCmbGrupo")); ?>',
                  type: 'GET',
                  data: "plantel_id=" + $('#q_plantel_id_lt option:selected').val() + "&grupo_id=" + $('#q_grupo_id-lt option:selected').val() + "",
                  dataType: 'json',
                  beforeSend : function(){$("#loading13").show();},
                  complete : function(){$("#loading13").hide();},
                  success: function(data){
                      //$example.select2("destroy");
                      $('#q_grupo_id_lt').html('');
                      
                      //$('#q_especialidad_id_lt').empty();
                      $('#q_grupo_id_lt').append($('<option></option>').text('Seleccionar').val('0'));
                      
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#q_grupo_id_lt').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                      });
                      //$example.select2();
                  }
              });       
      }

      $('#q_grupo_id_lt').change(function(){
          getCmbAlumno();
      });
      
      function getCmbAlumno(){
          //var $example = $("#q_especialidad_id_lt").select2();
          var a= $('#frm_academica').serialize();
              $.ajax({
                  url: '<?php echo e(route("clientes.getCmbAlumno")); ?>',
                  type: 'GET',
                  data: a,
                  dataType: 'json',
                  beforeSend : function(){$("#loading13").show();},
                  complete : function(){$("#loading13").hide();},
                  success: function(data){
                      //$example.select2("destroy");
                      $('#alumno_id-field').html('');
                      
                      //$('#q_especialidad_id_lt').empty();
                      $('#alumno_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                      
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#alumno_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                      });
                      //$example.select2();
                  }
              });       
      }

      function getCmbMateria(){
          var $example = $("#q_especialidad_id_lt").select2();
          var a= $('#frm_academica').serialize();
              $.ajax({
                  url: '<?php echo e(route("materias.getCmbMateria")); ?>',
                  type: 'GET',
                  data: "plantel_id=" + $('#q_plantel_id_lt option:selected').val(),
                  dataType: 'json',
                  beforeSend : function(){$("#loading3").show();},
                  complete : function(){$("#loading3").hide();},
                  success: function(data){
                      //$example.select2("destroy");
                      $('#q_materia_id_lt').html('');
                      
                      //$('#q_especialidad_id_lt').empty();
                      $('#q_materia_id_lt').append($('<option></option>').text('Seleccionar Opción').val('0'));
                      
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#q_materia_id_lt').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                          
                      });
                      //$example.select2();
                  }
              });       
      }
      function getCmbEspecialidad(){
          //var $example = $("#q_especialidad_id_lt").select2();
          var a= $('#frm_academica').serialize();
              $.ajax({
                  url: '<?php echo e(route("especialidads.getCmbEspecialidad")); ?>',
                  type: 'GET',
                  data: "plantel_id=" + $('#q_plantel_id_lt option:selected').val() + "&especialidad_id=" + $('#q_especialidad_id_lt option:selected').val() + "",
                  dataType: 'json',
                  beforeSend : function(){$("#loading10").show();},
                  complete : function(){$("#loading10").hide();},
                  success: function(data){
                      //$example.select2("destroy");
                      $('#q_especialidad_id_lt').html('');
                      
                      //$('#q_especialidad_id_lt').empty();
                      $('#q_especialidad_id_lt').append($('<option></option>').text('Seleccionar').val('0'));
                      
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#q_especialidad_id_lt').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                          
                      });
                      //$example.select2();
                  }
              });       
      }
      $('#q_especialidad_id_lt').change(function(){
          getCmbNivel();
      });
      function getCmbNivel(){
          //var $example = $("#q_especialidad_id_lt").select2();
          var a= $('#frm_academica').serialize();
              $.ajax({
                  url: '<?php echo e(route("nivels.getCmbNivels")); ?>',
                  type: 'GET',
                  data: "plantel_id=" + $('#q_plantel_id_lt option:selected').val() + "&especialidad_id=" + $('#q_especialidad_id_lt option:selected').val() + "&nivel_id=" + $('#q_nivel_id_lt option:selected').val() + "",
                  dataType: 'json',
                  beforeSend : function(){$("#loading11").show();},
                  complete : function(){$("#loading11").hide();},
                  success: function(data){
                      //alert(data);
                      //$example.select2("destroy");
                      $('#q_nivel_id_lt').html('');
                      //$('#q_especialidad_id_lt').empty();
                      $('#q_nivel_id_lt').append($('<option></option>').text('Seleccionar').val('0'));
                      
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#q_nivel_id_lt').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                      });
                      //$example.select2();
                  }
              });       
      }
      
      $('#q_nivel_id_lt').change(function(){
          getCmbGrado();
      });
      function getCmbGrado(){
          //var $example = $("#q_especialidad_id_lt").select2();
          var a= $('#frm_academica').serialize();
              $.ajax({
                  url: '<?php echo e(route("grados.getCmbGrados")); ?>',
                  type: 'GET',
                  data: "plantel_id=" + $('#q_plantel_id_lt option:selected').val() + "&especialidad_id=" + $('#q_especialidad_id_lt option:selected').val() + "&nivel_id=" + $('#q_nivel_id_lt option:selected').val() + "&grado_id=" + $('#q_grado_id_lt option:selected').val() +"",
                  dataType: 'json',
                  beforeSend : function(){$("#loading12").show();},
                  complete : function(){$("#loading12").hide();},
                  success: function(data){
                      //alert(data);
                      //$example.select2("destroy");
                      $('#q_grado_id_lt').html('');
                      //$('#q_especialidad_id_lt').empty();
                      $('#q_grado_id_lt').append($('<option></option>').text('Seleccionar').val('0'));
                      
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#q_grado_id_lt').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                      });
                      //$example.select2();
                  }
              });       
      }

      

    });
    
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('plantillas.admin_template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>