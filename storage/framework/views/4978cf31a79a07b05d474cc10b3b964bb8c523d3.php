<?php echo $__env->make('calendarioEvaluacions._common', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->startSection('header'); ?>

    <ol class="breadcrumb">
    	<li><a href="<?php echo e(route('home')); ?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        <?php if( $query_params = Request::input('q') ): ?>

            <li class="active"><a href="<?php echo e(route('calendarioEvaluacions.index')); ?>"><?php echo $__env->yieldContent('calendarioEvaluacionsAppTitle'); ?></a></li>
            <li class="active">condition(  

            <?php $__currentLoopData = $query_params; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(!$loop->first): ?> / <?php endif; ?> <?php echo e($key); ?> : <?php echo e($value); ?>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            )</li>
        <?php else: ?>
            <li class="active"><?php echo $__env->yieldContent('calendarioEvaluacionsAppTitle'); ?></li>
        <?php endif; ?>
        -->
        <li class="active"><?php echo $__env->yieldContent('calendarioEvaluacionsAppTitle'); ?></li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> <?php echo $__env->yieldContent('calendarioEvaluacionsAppTitle'); ?>
            <?php if (\Entrust::can('calendarioEvaluacions.create')) : ?>
            <a class="btn btn-success pull-right" href="<?php echo e(route('calendarioEvaluacions.create')); ?>"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="CalendarioEvaluacion_search" id="search" action="<?php echo e(route('calendarioEvaluacions.index')); ?>" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="<?php echo e(@(Request::input('q')['s']) ?: ''); ?>" />
                        <div class="form-horizontal">

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
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_lectivos.name_cont">LECTIVO_NAME</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['lectivos.name_cont']) ?: ''); ?>" name="q[lectivos.name_cont]" id="q_lectivos.name_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_ponderacions.name_gt">PONDERACION_NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['ponderacions.name_gt']) ?: ''); ?>" name="q[ponderacions.name_gt]" id="q_ponderacions.name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['ponderacions.name_lt']) ?: ''); ?>" name="q[ponderacions.name_lt]" id="q_ponderacions.name_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_ponderacions.name_cont">PONDERACION_NAME</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['ponderacions.name_cont']) ?: ''); ?>" name="q[ponderacions.name_cont]" id="q_ponderacions.name_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_carga_ponderacions.name_gt">CARGA_PONDERACION_NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['carga_ponderacions.name_gt']) ?: ''); ?>" name="q[carga_ponderacions.name_gt]" id="q_carga_ponderacions.name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['carga_ponderacions.name_lt']) ?: ''); ?>" name="q[carga_ponderacions.name_lt]" id="q_carga_ponderacions.name_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_carga_ponderacions.name_cont">CARGA_PONDERACION_NAME</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['carga_ponderacions.name_cont']) ?: ''); ?>" name="q[carga_ponderacions.name_cont]" id="q_carga_ponderacions.name_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_v_inicio_gt">V_INICIO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['v_inicio_gt']) ?: ''); ?>" name="q[v_inicio_gt]" id="q_v_inicio_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['v_inicio_lt']) ?: ''); ?>" name="q[v_inicio_lt]" id="q_v_inicio_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_v_inicio_cont">V_INICIO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['v_inicio_cont']) ?: ''); ?>" name="q[v_inicio_cont]" id="q_v_inicio_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_v_fin_gt">V_FIN</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['v_fin_gt']) ?: ''); ?>" name="q[v_fin_gt]" id="q_v_fin_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['v_fin_lt']) ?: ''); ?>" name="q[v_fin_lt]" id="q_v_fin_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_v_fin_cont">V_FIN</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['v_fin_cont']) ?: ''); ?>" name="q[v_fin_cont]" id="q_v_fin_cont" />
                                </div>
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
            <?php if($calendarioEvaluacions->count()): ?>
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th><?php echo $__env->make('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></th>
                            <th><?php echo $__env->make('CrudDscaffold::getOrderlink', ['column' => 'lectivos.name', 'title' => 'LECTIVO'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></th>
                            <th><?php echo $__env->make('CrudDscaffold::getOrderlink', ['column' => 'ponderacions.name', 'title' => 'PONDERACION'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></th>
                            <th><?php echo $__env->make('CrudDscaffold::getOrderlink', ['column' => 'carga_ponderacions.name', 'title' => 'CARGA PONDERACION'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></th>
                            <th><?php echo $__env->make('CrudDscaffold::getOrderlink', ['column' => 'v_inicio', 'title' => 'INICIO'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></th>
                            <th><?php echo $__env->make('CrudDscaffold::getOrderlink', ['column' => 'v_fin', 'title' => 'FIN'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $__currentLoopData = $calendarioEvaluacions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $calendarioEvaluacion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><a href="<?php echo e(route('calendarioEvaluacions.show', $calendarioEvaluacion->id)); ?>"><?php echo e($calendarioEvaluacion->id); ?></a></td>
                                <td><?php echo e($calendarioEvaluacion->lectivo->name); ?></td>
                                <td><?php echo e($calendarioEvaluacion->ponderacion->name); ?></td>
                                <td><?php echo e($calendarioEvaluacion->cargaPonderacion->name); ?></td>
                                <td><?php echo e($calendarioEvaluacion->v_inicio); ?></td>
                                <td><?php echo e($calendarioEvaluacion->v_fin); ?></td>
                                <td class="text-right">
                                    <?php if (\Entrust::can('calendarioEvaluacions.edit')) : ?>
                                    <a class="btn btn-xs btn-primary" href="<?php echo e(route('calendarioEvaluacions.duplicate', $calendarioEvaluacion->id)); ?>"><i class="glyphicon glyphicon-duplicate"></i> Duplicar</a>
                                    <?php endif; // Entrust::can ?>
                                    <?php if (\Entrust::can('calendarioEvaluacions.edit')) : ?>
                                    <a class="btn btn-xs btn-warning" href="<?php echo e(route('calendarioEvaluacions.edit', $calendarioEvaluacion->id)); ?>"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    <?php endif; // Entrust::can ?>
                                    <?php if (\Entrust::can('calendarioEvaluacions.destroy')) : ?>
                                    <?php echo Form::model($calendarioEvaluacion, array('route' => array('calendarioEvaluacions.destroy', $calendarioEvaluacion->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")); ?>

                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    <?php echo Form::close(); ?>

                                    <?php endif; // Entrust::can ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <?php echo $calendarioEvaluacions->appends(Request::except('page'))->render(); ?>

            <?php else: ?>
                <h3 class="text-center alert alert-info">Vacio!</h3>
            <?php endif; ?>

        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('plantillas.admin_template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>