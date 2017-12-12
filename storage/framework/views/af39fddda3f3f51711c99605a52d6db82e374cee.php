<?php echo $__env->make('clientes._common', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->startSection('header'); ?>

    <ol class="breadcrumb">
    	<li><a href="<?php echo e(route('home')); ?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        <?php if( $query_params = Request::input('q') ): ?>

            <li class="active"><a href="<?php echo e(route('clientes.index')); ?>"><?php echo $__env->yieldContent('clientesAppTitle'); ?></a></li>
            <li class="active">condition(  

            <?php $__currentLoopData = $query_params; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(!$loop->first): ?> / <?php endif; ?> <?php echo e($key); ?> : <?php echo e($value); ?>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            )</li>
        <?php else: ?>
            <li class="active"><?php echo $__env->yieldContent('clientesAppTitle'); ?></li>
        <?php endif; ?>
        -->
        <li class="active"><?php echo $__env->yieldContent('clientesAppTitle'); ?></li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> <?php echo $__env->yieldContent('clientesAppTitle'); ?>
            <?php if (\Entrust::can('clientes.create')) : ?>
            <a class="btn btn-success pull-right" href="<?php echo e(route('clientes.create')); ?>"><i class="glyphicon glyphicon-plus"></i> Crear</a>
            <?php endif; // Entrust::can ?>
            <?php if (\Entrust::can('clientes.carga')) : ?>
            <a class="btn btn-warning pull-right" href="<?php echo e(route('clientes.carga')); ?>"><i class="glyphicon glyphicon-plus"></i> Carga Archivo</a>
            <a class="btn btn-primary pull-right" href="<?php echo e(route('clientes.descargaClientes')); ?>"><i class="fa fa-long-arrow-down"></i> Descarga</a>
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
                    <form class="Cliente_search" id="search" action="<?php echo e(route('clientes.index')); ?>" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="<?php echo e(@(Request::input('q')['s']) ?: ''); ?>" />
                        <div class="row">
                            <div class="col-md-12">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cve_cliente_gt">CVE_CLIENTE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['cve_cliente_gt']) ?: ''); ?>" name="q[cve_cliente_gt]" id="q_cve_cliente_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['cve_cliente_lt']) ?: ''); ?>" name="q[cve_cliente_lt]" id="q_cve_cliente_lt" />
                                </div>
                            </div>
                            -->
                            
                    

                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_nombre_gt">NOMBRE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['nombre_gt']) ?: ''); ?>" name="q[nombre_gt]" id="q_nombre_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['nombre_lt']) ?: ''); ?>" name="q[nombre_lt]" id="q_nombre_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group col-md-4">
                                <label for="q_clientes.id_cont">ID</label>
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['clientes.id_lt']) ?: ''); ?>" name="q[clientes.id_lt]" id="q_clientes.id_lt" />
                            </div>
                            <div class="form-group col-md-4">
                                <label for="q_clientes.nombre_cont">PRIMER NOMBRE</label>
                                
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['clientes.nombre_cont']) ?: ''); ?>" name="q[clientes.nombre_cont]" id="q_clientes.nombre_cont" />
                                
                            </div>
                            <div class="form-group col-md-4">
                                <label for="q_clientes.nombre2_cont">SEGUNDO NOMBRE</label>
                                
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['clientes.nombre2_cont']) ?: ''); ?>" name="q[clientes.nombre2_cont]" id="q_clientes.nombre2_cont" />
                                
                            </div>
                            <div class="form-group col-md-4">
                                <label for="q_clientes.ape_paterno_cont">APELLIDO PATERNO</label>
                                
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['clientes.ape_paterno_cont']) ?: ''); ?>" name="q[clientes.ape_paterno_cont]" id="q_clientes.ape_paterno_cont" />
                                
                            </div>
                            <div class="form-group col-md-4">
                                <label for="q_clientes.ape_materno_cont">APELLIDO MATERNO</label>
                                
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['clientes.ape_materno_cont']) ?: ''); ?>" name="q[clientes.ape_materno_cont]" id="q_clientes.ape_materno_cont" />
                                
                            </div>
                            <div class="form-group col-md-4">
                                <label for="q_clientes.matricula_cont">MATRICULA</label>
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['clientes.matricula_cont']) ?: ''); ?>" name="q[clientes.matricula_cont]" id="q_clientes.matricula_cont" />
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fec_registro_gt">FEC_REGISTRO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['fec_registro_gt']) ?: ''); ?>" name="q[fec_registro_gt]" id="q_fec_registro_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['fec_registro_lt']) ?: ''); ?>" name="q[fec_registro_lt]" id="q_fec_registro_lt" />
                                </div>
                            </div>
                            -->
                            
                            <div class="form-group col-md-4">
                                <label for="q_clientes.medio_id_lt">MEDIO</label>
                                    <?php echo Form::select("medio_id", $list1["Medio"], "<?php echo e(@(Request::input('q')['clientes.medio_id_lt']) ?: ''); ?>", array("class" => "form-control select_seguridad", "name"=>"q[clientes.medio_id_lt]", "id"=>"q_clientes.medio_id_lt", "style"=>"width:100%;" )); ?>

                            </div>
                            
                            <div class="form-group col-md-4">
                                <label for="q_clientes.st_cliente_id_lt">ESTATUS</label>
                                    <?php echo Form::select("st_cliente_id", $list1["StCliente"], "<?php echo e(@(Request::input('q')['clientes.st_cliente_id_lt']) ?: ''); ?>", array("class" => "form-control select_seguridad", "name"=>"q[clientes.st_cliente_id_lt]", "id"=>"q_clientes.st_cliente_id_lt", "style"=>"width:100%;" )); ?>

                            </div>
                        
                            <div class="form-group col-md-4">
                                <label for="q_st_seguimiento_id_lt">ESTATUS SEGUIMIENTO</label>
                                    <?php echo Form::select("st_seguimiento_id", $list["StSeguimiento"], "<?php echo e(@(Request::input('q')['st_seguimiento_id_lt']) ?: ''); ?>", array("class" => "form-control select_seguridad", "name"=>"q[st_seguimiento_id_lt]", "id"=>"q_st_seguimiento_id_lt", "style"=>"width:100%;" )); ?>

                            </div>

                            
                            <div class="form-group col-md-4" >
                                <label for="q_clientes.plantel_id_lt">PLANTEL</label>
                                
                                    <?php echo Form::select("clientes.plantel_id", $list1["Plantel"], "<?php echo e(@(Request::input('q')['clientes.plantel_id_lt']) ?: ''); ?>", array("class" => "form-control select_seguridad", "name"=>"q[clientes.plantel_id_lt]", "id"=>"q_clientes.plantel_id_lt", "style"=>"width:100%;")); ?>

                                
                            </div>
                            
                            <div class="form-group col-md-4">
                                <label for="q_clientes.empleado_id_lt">EMPLEADO</label>
                                    <?php echo Form::select("clientes.empleado_id", $list1["Empleado"], "<?php echo e(@(Request::input('q')['clientes.empleado_id_lt']) ?: ''); ?>", array("class" => "form-control select_seguridad", "name"=>"q[clientes.empleado_id_lt]", "id"=>"q_clientes.empleado_id_lt", "style"=>"width:100%;" )); ?>

                            </div>
                            

                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-2">
                                    <input type="submit" name="commit" value="Buscar" class="btn btn-default btn-xs" />
                                </div>
                            </div>
                        </div></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div>
        <?php if(session('message')): ?>
            <div class="alert alert-danger">
                <?php echo session('message'); ?>

            </div>
        <?php endif; ?>
        
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <?php if($clientes->count()): ?>
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th><?php echo $__env->make('plantillas.getOrderLink', ['column' => 'cliente_id', 'title' => 'ID'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></th>
                            <th><?php echo $__env->make('CrudDscaffold::getOrderlink', ['column' => 'clientes.nombre', 'title' => 'PRIMER NOMBRE'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></th>
                            <th><?php echo $__env->make('CrudDscaffold::getOrderlink', ['column' => 'clientes.nombre2', 'title' => 'SEGUNDO NOMBRE'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></th>
                            <th><?php echo $__env->make('CrudDscaffold::getOrderlink', ['column' => 'clientes.ape_paterno', 'title' => 'APELLIDO PATERNO'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></th>
                            <th><?php echo $__env->make('CrudDscaffold::getOrderlink', ['column' => 'clientes.ape_materno', 'title' => 'APELLIDO MATERNO'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></th>
                            <th><?php echo $__env->make('CrudDscaffold::getOrderlink', ['column' => 'st_seguimiento_id', 'title' => 'ESTATUS SEGUIMIENTO'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></th>
                            <th><?php echo $__env->make('CrudDscaffold::getOrderlink', ['column' => 'clientes.st_cliente_id', 'title' => 'ESTATUS CLIENTE'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></th>
                            <th><?php echo $__env->make('CrudDscaffold::getOrderlink', ['column' => 'clientes.plantel_id', 'title' => 'PLANTEL'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></th>
                            <th><?php echo $__env->make('CrudDscaffold::getOrderlink', ['column' => 'clientes.empleado_id', 'title' => 'EMPLEADO'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></th>
                            
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><a href="<?php echo e(route('clientes.edit', $cliente->cliente_id)); ?>"><?php echo e($cliente->cliente_id); ?></a></td>
                                <td><?php echo e($cliente->cliente->nombre); ?></td>
                                <td><?php echo e($cliente->cliente->nombre2); ?></td>
                                <td><?php echo e($cliente->cliente->ape_paterno); ?></td>
                                <td><?php echo e($cliente->cliente->ape_materno); ?></td>
                                <td>
                                
                                <span class="label" style="background:<?php echo e($cliente->stSeguimiento->color); ?>;">
                                    <?php echo e($cliente->stSeguimiento->name); ?>

                                </span>
                                </td>
                                <td><?php echo e($cliente->cliente->stCliente->name); ?></td>
                                <td>
                                <?php if(isset($cliente->cliente->plantel)): ?>
                                <?php echo e($cliente->cliente->plantel->razon); ?>

                                <?php endif; ?>
                                </td>
                                <td><?php echo e($cliente->cliente->empleado->nombre." ".$cliente->cliente->empleado->ape_paterno." ".$cliente->cliente->empleado->ape_materno); ?></td>
                                <td class="text-right">
                                    <?php if (\Entrust::can('correos.redactar')) : ?>
                                    <?php if(isset($cliente->cliente->mail)): ?>
                                    <a class="btn btn-xs btn-success" href="<?php echo e(url('correos/redactar').'/'.$cliente->cliente->mail.'/'.$cliente->cliente->nombre.'/0'); ?>"><i class="glyphicon glyphicon-envelope"></i> Correo </a>
                                    <?php endif; ?>
                                    <?php endif; // Entrust::can ?>
                                    <?php if (\Entrust::can('seguimientos.show')) : ?>
                                    <a class="btn btn-xs btn-default" href="<?php echo e(route('seguimientos.show', $cliente->cliente->id)); ?>"><i class="glyphicon glyphicon-edit"></i> Seguimiento</a>
                                    <?php endif; // Entrust::can ?>
                                    <?php if (\Entrust::can('clientes.edit')) : ?>
                                    <a class="btn btn-xs btn-primary" href="<?php echo e(route('clientes.duplicate', $cliente->cliente->id)); ?>"><i class="glyphicon glyphicon-duplicate"></i> Duplicar</a>
                                    <?php endif; // Entrust::can ?>
                                    <?php if (\Entrust::can('clientes.edit')) : ?>
                                    <a class="btn btn-xs btn-warning" href="<?php echo e(route('clientes.edit', $cliente->cliente->id)); ?>"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    <?php endif; // Entrust::can ?>
                                    <?php if (\Entrust::can('clientes.destroy')) : ?>
                                    <?php echo Form::model($cliente, array('route' => array('clientes.destroy', $cliente->cliente->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")); ?>

                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    <?php echo Form::close(); ?>

                                    <?php endif; // Entrust::can ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <?php echo $clientes->appends(Request::except('page'))->render(); ?>

            <?php else: ?>
                <h3 class="text-center alert alert-info">Vacio!</h3>
            <?php endif; ?>

        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
  <script>
  
    $(document).ready(function() {
        // assuming the controls you want to attach the plugin to
          // have the "datepicker" class set
          //Campo de fecha
          $('#q_fec_registro_cont').Zebra_DatePicker({
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