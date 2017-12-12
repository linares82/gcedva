<?php echo $__env->make('grupos._common', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->startSection('header'); ?>

    <ol class="breadcrumb">
    	<li><a href="<?php echo e(route('home')); ?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        <?php if( $query_params = Request::input('q') ): ?>

            <li class="active"><a href="<?php echo e(route('grupos.index')); ?>"><?php echo $__env->yieldContent('gruposAppTitle'); ?></a></li>
            <li class="active">condition(  

            <?php $__currentLoopData = $query_params; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(!$loop->first): ?> / <?php endif; ?> <?php echo e($key); ?> : <?php echo e($value); ?>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            )</li>
        <?php else: ?>
            <li class="active"><?php echo $__env->yieldContent('gruposAppTitle'); ?></li>
        <?php endif; ?>
        -->
        <li class="active"><?php echo $__env->yieldContent('gruposAppTitle'); ?></li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> <?php echo $__env->yieldContent('gruposAppTitle'); ?>
            <?php if (\Entrust::can('grupos.create')) : ?>
            <a class="btn btn-success pull-right" href="<?php echo e(route('grupos.create')); ?>"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="Grupo_search" id="search" action="<?php echo e(route('grupos.index')); ?>" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="<?php echo e(@(Request::input('q')['s']) ?: ''); ?>" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_name_gt">NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['name_gt']) ?: ''); ?>" name="q[name_gt]" id="q_name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['name_lt']) ?: ''); ?>" name="q[name_lt]" id="q_name_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_name_cont">GRUPO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['name_cont']) ?: ''); ?>" name="q[name_cont]" id="q_name_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_desc_corta_gt">DESC_CORTA</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['desc_corta_gt']) ?: ''); ?>" name="q[desc_corta_gt]" id="q_desc_corta_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['desc_corta_lt']) ?: ''); ?>" name="q[desc_corta_lt]" id="q_desc_corta_lt" />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_desc_corta_cont">DESC_CORTA</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['desc_corta_cont']) ?: ''); ?>" name="q[desc_corta_cont]" id="q_desc_corta_cont" />
                                </div>
                            </div>
                            -->                        <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_limite_alumnos_gt">LIMITE_ALUMNOS</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['limite_alumnos_gt']) ?: ''); ?>" name="q[limite_alumnos_gt]" id="q_limite_alumnos_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['limite_alumnos_lt']) ?: ''); ?>" name="q[limite_alumnos_lt]" id="q_limite_alumnos_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_limite_alumnos_cont">LIMITE ALUMNOS</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['limite_alumnos_cont']) ?: ''); ?>" name="q[limite_alumnos_cont]" id="q_limite_alumnos_cont" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_minimo_alumnos_cont">MINIMO ALUMNOS</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['minimo_alumnos_cont']) ?: ''); ?>" name="q[minimo_alumnos_cont]" id="q_minimo_alumnos_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_jornadas.name_gt">JORNADA_NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['jornadas.name_gt']) ?: ''); ?>" name="q[jornadas.name_gt]" id="q_jornadas.name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['jornadas.name_lt']) ?: ''); ?>" name="q[jornadas.name_lt]" id="q_jornadas.name_lt" />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_jornadas.name_cont">JORNADA_NAME</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['jornadas.name_cont']) ?: ''); ?>" name="q[jornadas.name_cont]" id="q_jornadas.name_cont" />
                                </div>
                            </div>
                            -->                        <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_salons.name_gt">SALON_NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['salons.name_gt']) ?: ''); ?>" name="q[salons.name_gt]" id="q_salons.name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['salons.name_lt']) ?: ''); ?>" name="q[salons.name_lt]" id="q_salons.name_lt" />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_salons.name_cont">SALON_NAME</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['salons.name_cont']) ?: ''); ?>" name="q[salons.name_cont]" id="q_salons.name_cont" />
                                </div>
                            </div>
                            -->                        <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_periodo_id_gt">PERIODO_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['periodo_id_gt']) ?: ''); ?>" name="q[periodo_id_gt]" id="q_periodo_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['periodo_id_lt']) ?: ''); ?>" name="q[periodo_id_lt]" id="q_periodo_id_lt" />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_periodo_id_cont">PERIODO_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['periodo_id_cont']) ?: ''); ?>" name="q[periodo_id_cont]" id="q_periodo_id_cont" />
                                </div>
                            </div>
                            -->
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
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_usu_alta_id_cont">USU_ALTA_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['usu_alta_id_cont']) ?: ''); ?>" name="q[usu_alta_id_cont]" id="q_usu_alta_id_cont" />
                                </div>
                            </div>-->
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_usu_mod_id_gt">USU_MOD_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['usu_mod_id_gt']) ?: ''); ?>" name="q[usu_mod_id_gt]" id="q_usu_mod_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['usu_mod_id_lt']) ?: ''); ?>" name="q[usu_mod_id_lt]" id="q_usu_mod_id_lt" />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_usu_mod_id_cont">USU_MOD_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['usu_mod_id_cont']) ?: ''); ?>" name="q[usu_mod_id_cont]" id="q_usu_mod_id_cont" />
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
            <?php if($grupos->count()): ?>
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th><?php echo $__env->make('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></th>
                            <th><?php echo $__env->make('CrudDscaffold::getOrderlink', ['column' => 'name', 'title' => 'GRUPO'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></th>
                            <th><?php echo $__env->make('CrudDscaffold::getOrderlink', ['column' => 'limite_alumnos', 'title' => 'LIMITE ALUMNOS'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></th>
                            <th><?php echo $__env->make('CrudDscaffold::getOrderlink', ['column' => 'minimo_alumnos', 'title' => 'MINIMO ALUMNOS'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $__currentLoopData = $grupos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grupo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><a href="<?php echo e(route('grupos.show', $grupo->id)); ?>"><?php echo e($grupo->id); ?></a></td>
                                <td><?php echo e($grupo->name); ?></td>
                                <td><?php echo e($grupo->limite_alumnos); ?></td>
                                <td><?php echo e($grupo->minimo_alumnos); ?></td>
                                <td class="text-right">
                                    <?php if (\Entrust::can('grupos.edit')) : ?>
                                    <a class="btn btn-xs btn-primary" href="<?php echo e(route('grupos.duplicate', $grupo->id)); ?>"><i class="glyphicon glyphicon-duplicate"></i> Duplicar</a>
                                    <?php endif; // Entrust::can ?>
                                    <?php if (\Entrust::can('grupos.edit')) : ?>
                                    <a class="btn btn-xs btn-warning" href="<?php echo e(route('grupos.edit', $grupo->id)); ?>"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    <?php endif; // Entrust::can ?>
                                    <?php if (\Entrust::can('grupos.destroy')) : ?>
                                    <?php echo Form::model($grupo, array('route' => array('grupos.destroy', $grupo->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")); ?>

                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    <?php echo Form::close(); ?>

                                    <?php endif; // Entrust::can ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <?php echo $grupos->appends(Request::except('page'))->render(); ?>

            <?php else: ?>
                <h3 class="text-center alert alert-info">Vacio!</h3>
            <?php endif; ?>

        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('plantillas.admin_template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>