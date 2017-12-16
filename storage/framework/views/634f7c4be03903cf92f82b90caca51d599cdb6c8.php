<?php echo $__env->make('seguimientos._common', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->startSection('header'); ?>

<ol class="breadcrumb">
	<li><a href="<?php echo e(route('home')); ?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="<?php echo e(route('seguimientos.index')); ?>"><?php echo $__env->yieldContent('seguimientosAppTitle'); ?></a></li>
    <li class="active"><?php echo e($seguimiento->id); ?></li>
</ol>

<div class="page-header">
        <h1><?php echo $__env->yieldContent('seguimientosAppTitle'); ?> / 
            <?php if($seguimiento->st_seguimiento_id==1): ?>
                <small class="label label-info"> 
            <?php elseif($seguimiento->st_seguimiento_id==2): ?>
                <small class="label label-success"> 
            <?php elseif($seguimiento->st_seguimiento_id==3): ?>
                <small class="label label-danger">
            <?php elseif($seguimiento->st_seguimiento_id==4): ?>
                 <small class="label label-warning"> 
            <?php endif; ?>    
                Estatus: <?php echo e($seguimiento->stSeguimiento->name); ?>

            </small>
            /<a href="<?php echo e(route('seguimientos.showPrint', $seguimiento->cliente_id)); ?>"> Imprimir</a>

            <?php echo Form::model($seguimiento, array('route' => array('seguimientos.destroy', $seguimiento->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")); ?>

                <div class="btn-group pull-right" role="group" aria-label="...">
                    <?php if (\Entrust::can('seguimiento.edit')) : ?>
                    <a class="btn btn-warning btn-group" role="group" href="<?php echo e(route('seguimientos.edit', $seguimiento->id)); ?>"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    <?php endif; // Entrust::can ?>
                    <?php if (\Entrust::can('seguimiento.destroy')) : ?>
                    <button type="submit" class="btn btn-danger">Borrar <i class="glyphicon glyphicon-trash"></i><
                    /button>
                    <?php endif; // Entrust::can ?>
                </div>
            <?php echo Form::close(); ?>


        </h1>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group col-md-2 ">
                <div class="box box-default">
                    <div class="box-body">
                        <?php echo Form::model($seguimiento, array('route' => array('seguimientos.update', $seguimiento->id),'method' => 'post')); ?>

                            <label for="cliente_id">CLIENTE</label>
                            <a class="btn btn-xs btn-warning" href="<?php echo e(route('clientes.edit', $seguimiento->cliente_id)); ?>"><i class="glyphicon glyphicon-edit"></i>Editar Cliente</a>
                            <?php if($seguimiento->st_seguimiento_id==2): ?>
                            <a class="btn btn-xs btn-success" href="<?php echo e(route('alumnos.inscribir', array('c'=>$seguimiento->cliente_id))); ?>"><i class="glyphicon glyphicon-edit"></i>Inscribir Cliente</a>
                            <?php endif; ?>
                            <p class="form-control-static"><label for="cliente_id">Nombre Completo:</label> <?php echo e($seguimiento->cliente->nombre." ".$seguimiento->cliente->nombre2." ".$seguimiento->cliente->ape_paterno." ".$seguimiento->cliente->ape_materno); ?></p>
                            <p class="form-control-static"><label for="cliente_id">Tel. Fijo:</label> <?php echo e($seguimiento->cliente->tel_fijo); ?></p>
                            <p class="form-control-static"><label for="cliente_id">Tel. Celular:</label> <?php echo e($seguimiento->cliente->tel_cel); ?></p>
                            <p class="form-control-static"><label for="cliente_id">E-mail:</label> <?php echo e($seguimiento->cliente->mail); ?></p>
                            <p class="form-control-static"><label for="cliente_id">Dirección:</label> <?php echo e($seguimiento->cliente->calle." ".$seguimiento->cliente->no_ext." ".$seguimiento->cliente->colonia." ".$seguimiento->cliente->municipio->name); ?>

                            </p>
                            <div class="form-group col-md-12 <?php if($errors->has('st_seguimiento_id')): ?> has-error <?php endif; ?>">
                            <label for="st_seguimiento_id-field">Estatus del seguimiento</label>
                            <?php echo Form::select("st_seguimiento_id", $sts,null, array("class" => "form-control select_seguridad", "id" => "st_seguimiento_id-field")); ?>

                            <?php if($errors->has("st_seguimiento_id")): ?>
                                <span class="help-block"><?php echo e($errors->first("st_seguimiento_id")); ?></span>
                            <?php endif; ?>
                            </div>
                            <div class="row">
                            </div>

                            <div class="well well-sm">
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="form-group col-md-6">
                <div class="box box-success">
                    <div class="box-body">
                        <div class="table-responsive">
                            <button 
                            type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#favoritesModal">
                                Agregar Tarea
                            </button>
                        
                            <table class="table table-bordered table-striped dataTable">
                                <thead>
                                    <tr>
                                        <th>Tarea</th>
                                        <th>Asunto</th>
                                        <th>Detalle</th>
                                        <th>Estatus</th>
                                        <th>Fecha</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $asignacionTareas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $at): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($at->tarea->name); ?></td>
                                        <td><?php echo e($at->asunto->name); ?></td>
                                        <td><?php echo e($at->detalle); ?></td>
                                        <td><?php echo e($at->stTarea->name); ?></td>
                                        <td><?php echo e($at->created_at); ?></td>
                                        <td>
                                        <?php if (\Entrust::can('asignacionTareas.destroy')) : ?>   
                                        <?php echo Form::model($at, array('route' => array('asignacionTareas.destroyModal', $at->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")); ?>

                                            <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                        <?php echo Form::close(); ?>

                                        <?php endif; // Entrust::can ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                   </div>
                </div>
            </div>
            <div class="form-group col-md-4">
                <div class="box box-warning">
                    <div class="box-body">
                        <div class="table-responsive">
                            <button 
                            type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#favoritesModal1">
                                Agregar Aviso
                            </button>
                        
                            <table class="table table-bordered table-striped dataTable">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Asunto</th>
                                        <th>Detalle</th>
                                        <th>Cerrar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $avisos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                        <?php if($a->dias_restantes<=0): ?>
                                            <small class="label label-danger">
                                        <?php elseif($a->dias_restantes==1): ?>
                                            <small class="label label-warning"> 
                                        <?php elseif($a->dias_restantes>=2): ?>
                                            <small class="label label-success"> 
                                        <?php endif; ?>
                                            <?php echo e($a->fecha); ?>

                                        </small>
                                        </td>
                                        <td><?php echo e($a->name); ?></td>
                                        <td><?php echo e($a->detalle); ?></td>
                                        <td>
                                            <a class="btn btn-xs btn-primary" href="<?php echo e(route('avisos.inactivo', array('id'=>$a->id, 'cliente'=>$seguimiento->cliente_id))); ?>"><i class="glyphicon glyphicon-trash"></i> Cerrar</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                   </div>
                </div>
            </div>
        </div>
<!--        Inicia timeline-->
		
        <?php if(isset($actividades)): ?>
        
		<div class="row">
            <div class="col-md-12">
                <ul class="timeline">
                    <?php $__currentLoopData = $actividades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					
						<li class="time-label">
                            <span class="bg-red">
                              <?php echo e($a->fecha); ?>

                            </span>
                        </li>
                        <li>
                            <?php if($a->tarea=='Seguimiento'): ?>
                                <i class="fa  fa-check-square-o bg-blue"></i>
                            <?php elseif($a->tarea=='Aviso'): ?>
                                <i class="fa fa-envelope bg-green"></i>
                            <?php else: ?>
                                <i class="fa fa-tasks bg-orange"></i>
                            <?php endif; ?>


                            <div class="timeline-item">
                              <span class="time"><i class="fa fa-clock-o"></i> <?php echo e($a->hora); ?></span>
                              <h3 class="timeline-header"><strong>Actividad:</strong> <?php echo e($a->tarea); ?></h3>
                              <div class="timeline-body">
                                <b><?php echo e($a->asunto); ?></b> : <?php echo e($a->detalle); ?>

                              </div>
                            </div>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <!-- END timeline item -->
                    <li>
                      <i class="fa fa-clock-o bg-gray"></i>
                    </li>
                  </ul>    
    <!--        Termina time line-->
            </div>
        </div>
        
        <?php endif; ?>
        <div class="row">
        </div>
        <a class="btn btn-link" href="<?php echo e(route('clientes.index', $seguimiento->cliente_id)); ?>"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>
    <!-- Ventana para crear Tarea -->
            <div class="modal fade" id="favoritesModal" 
                 tabindex="-1" role="dialog" 
                 aria-labelledby="favoritesModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" 
                      data-dismiss="modal" 
                      aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" 
                    id="favoritesModalLabel">Agregar Tarea</h4>
                  </div>
                  <div class="modal-body">
                    <?php echo Form::open(array('route' => 'asignacionTareas.storeModal')); ?>

                    <div class="form-group col-md-6 <?php if($errors->has('tarea_id')): ?> has-error <?php endif; ?>">
                       <label for="tarea_id-field">Tarea</label>
                       <?php echo Form::select("tarea_id", $list["Tarea"], null, array("class" => "form-control select_seguridad", "id" => "tarea_id-field", 'style'=>'width:100%')); ?>

                       <?php echo Form::hidden("cliente_id", $seguimiento->cliente_id, array("class" => "form-control", "id" => "cliente_id-field")); ?>

                       <?php echo Form::hidden("empleado_id", $seguimiento->cliente->empleado_id, array("class" => "form-control", "id" => "empleado_id-field")); ?>

                       <?php if($errors->has("tarea_id")): ?>
                        <span class="help-block"><?php echo e($errors->first("tarea_id")); ?></span>
                       <?php endif; ?>
                    </div>
                    <div class="form-group col-md-6 <?php if($errors->has('asunto_id')): ?> has-error <?php endif; ?>">
                       <label for="asunto_id-field">Asunto</label>
                       <?php echo Form::select("asunto_id", $list["Asunto"], null, array("class" => "form-control select_seguridad", "id" => "asunto_id-field", 'style'=>'width:100%')); ?>

                       <?php if($errors->has("asunto_id")): ?>
                        <span class="help-block"><?php echo e($errors->first("asunto_id")); ?></span>
                       <?php endif; ?>
                    </div>
                    <div class="form-group col-md-6 <?php if($errors->has('st_tarea_id')): ?> has-error <?php endif; ?>">
                       <label for="st_tarea_id-field">Estatus</label>
                       <?php echo Form::select("st_tarea_id", $list["StTarea"], null, array("class" => "form-control select_seguridad", "id" => "st_tarea_id-field", 'style'=>'width:100%')); ?>

                       <?php if($errors->has("st_tarea_id")): ?>
                        <span class="help-block"><?php echo e($errors->first("st_tarea_id")); ?></span>
                       <?php endif; ?>
                    </div>
                    <div class="form-group col-md-12 <?php if($errors->has('detalle')): ?> has-error <?php endif; ?>">
                       <label for="detalle-field">Detalle</label>
                       <?php echo Form::textArea("detalle", null, array("class" => "form-control", "id" => "detalle-field", 'rows'=>'3')); ?>

                       <?php echo Form::hidden("observaciones", null, array("class" => "form-control", "id" => "observaciones-field", 'value'=>"default")); ?>

                       <?php if($errors->has("detalle")): ?>
                        <span class="help-block"><?php echo e($errors->first("detalle")); ?></span>
                       <?php endif; ?>
                    </div>
                    <div class="row">
                    </div>
                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary">Crear</button>
                    </div>
                    <?php echo Form::close(); ?>

                  </div>
                  <div class="modal-footer">
                    
                  </div>
                </div>
              </div>
            </div>
            
            
<!-- Ventana para crear Aviso -->
            <div class="modal fade" id="favoritesModal1" 
                 tabindex="-1" role="dialog" 
                 aria-labelledby="favoritesModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" 
                      data-dismiss="modal" 
                      aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" 
                    id="favoritesModalLabel">Agregar Aviso</h4>
                  </div>
                  <div class="modal-body">
                    <?php echo Form::open(array('route' => 'avisos.store')); ?>

                        <div class="form-group col-md-6 <?php if($errors->has('asunto_id')): ?> has-error <?php endif; ?>">
                            <?php echo Form::hidden("seguimiento_id", $seguimiento->id, array("class" => "form-control", "id" => "seguimiento_id-field")); ?>

                            <?php echo Form::hidden("cliente_id", $seguimiento->cliente_id, array("class" => "form-control", "id" => "cliente_id-field")); ?>

                            <label for="asunto_id-field">Asunto</label>
                            <?php echo Form::select("asunto_id", $list["Asunto"], null, array("class" => "form-control select_seguridad", "id" => "asunto_id-field", 'style'=>'width:100%')); ?>

                            <?php if($errors->has("asunto_id")): ?>
                                <span class="help-block"><?php echo e($errors->first("asunto_id")); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group col-md-6 <?php if($errors->has('fecha')): ?> has-error <?php endif; ?>">
                            <label for="fecha-field">Fecha</label>
                            <?php echo Form::text("fecha", null, array("class" => "form-control", "id" => "fecha-field")); ?>

                            <?php if($errors->has("fecha")): ?>
                                <span class="help-block"><?php echo e($errors->first("fecha")); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group col-md-12 <?php if($errors->has('detalle')): ?> has-error <?php endif; ?>">
                            <label for="detalle-field">Detalle</label>
                            <?php echo Form::textArea("detalle", null, array("class" => "form-control", "id" => "detalle-field", 'rows'=>3)); ?>

                            <?php if($errors->has("detalle")): ?>
                                <span class="help-block"><?php echo e($errors->first("detalle")); ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="row">
                        </div>
                        <div class="well well-sm">
                            <button type="submit" class="btn btn-primary">Crear</button>
                        </div>
                    <?php echo Form::close(); ?>

                    <div class="modal-footer">
                    
                    </div>
                  
                  </div>
                </div>
              </div>
            </div>
            
        
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
  <script type="text/javascript">
    $(document).ready(function() {
    $('#fecha-field').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
      });
    });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('plantillas.admin_template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>