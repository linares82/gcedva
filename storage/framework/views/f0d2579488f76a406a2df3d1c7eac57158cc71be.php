<?php echo $__env->make('materias._common', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->startSection('header'); ?>

    <ol class="breadcrumb">
    	<li><a href="<?php echo e(route('home')); ?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        <?php if( $query_params = Request::input('q') ): ?>

            <li class="active"><a href="<?php echo e(route('materias.index')); ?>"><?php echo $__env->yieldContent('materiasAppTitle'); ?></a></li>
            <li class="active">condition(  

            <?php $__currentLoopData = $query_params; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(!$loop->first): ?> / <?php endif; ?> <?php echo e($key); ?> : <?php echo e($value); ?>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            )</li>
        <?php else: ?>
            <li class="active"><?php echo $__env->yieldContent('materiasAppTitle'); ?></li>
        <?php endif; ?>
        -->
        <li class="active"><?php echo $__env->yieldContent('materiasAppTitle'); ?></li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> <?php echo $__env->yieldContent('materiasAppTitle'); ?>
            <?php if (\Entrust::can('materias.create')) : ?>
            <a class="btn btn-success pull-right" href="<?php echo e(route('materias.create')); ?>"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="Materium_search" id="search" action="<?php echo e(route('materias.index')); ?>" accept-charset="UTF-8" method="get">
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
                                <label class="col-sm-2 control-label" for="q_name_cont">MATERIA</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['name_cont']) ?: ''); ?>" name="q[name_cont]" id="q_name_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_abreviatura_gt">ABREVIATURA</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['abreviatura_gt']) ?: ''); ?>" name="q[abreviatura_gt]" id="q_abreviatura_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['abreviatura_lt']) ?: ''); ?>" name="q[abreviatura_lt]" id="q_abreviatura_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_abreviatura_cont">ABREVIATURA</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['abreviatura_cont']) ?: ''); ?>" name="q[abreviatura_cont]" id="q_abreviatura_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_seriada_bnd_gt">SERIADA_BND</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['seriada_bnd_gt']) ?: ''); ?>" name="q[seriada_bnd_gt]" id="q_seriada_bnd_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['seriada_bnd_lt']) ?: ''); ?>" name="q[seriada_bnd_lt]" id="q_seriada_bnd_lt" />
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
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_plantels.razon_cont">PLANTEL_RAZON</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="<?php echo e(@(Request::input('q')['plantels.razon_cont']) ?: ''); ?>" name="q[plantels.razon_cont]" id="q_plantels.razon_cont" />
                                </div>
                            </div>
                                 

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
            <?php if($materias->count()): ?>
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th><?php echo $__env->make('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></th>
                            <th><?php echo $__env->make('CrudDscaffold::getOrderlink', ['column' => 'name', 'title' => 'MATERIA'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></th>
                            <th><?php echo $__env->make('CrudDscaffold::getOrderlink', ['column' => 'abreviatura', 'title' => 'ABREVIATURA'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></th>
                            <th><?php echo $__env->make('CrudDscaffold::getOrderlink', ['column' => 'plantels.razon', 'title' => 'PLANTEL_RAZON'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></th>
                        
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $__currentLoopData = $materias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $materium): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><a href="<?php echo e(route('materias.show', $materium->id)); ?>"><?php echo e($materium->id); ?></a></td>
                                <td><?php echo e($materium->name); ?></td>
                                <td><?php echo e($materium->abreviatura); ?></td>
                                <td><?php echo e($materium->plantel->razon); ?></td>
                    
                                <td class="text-right">
                                    <?php if (\Entrust::can('materias.edit')) : ?>
                                    <a class="btn btn-xs btn-primary" href="<?php echo e(route('materias.duplicate', $materium->id)); ?>"><i class="glyphicon glyphicon-duplicate"></i> Duplicar</a>
                                    <?php endif; // Entrust::can ?>
                                    <?php if (\Entrust::can('materias.edit')) : ?>
                                    <a class="btn btn-xs btn-warning" href="<?php echo e(route('materias.edit', $materium->id)); ?>"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    <?php endif; // Entrust::can ?>
                                    <?php if (\Entrust::can('materias.destroy')) : ?>
                                    <?php echo Form::model($materium, array('route' => array('materias.destroy', $materium->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")); ?>

                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    <?php echo Form::close(); ?>

                                    <?php endif; // Entrust::can ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <?php echo $materias->appends(Request::except('page'))->render(); ?>

            <?php else: ?>
                <h3 class="text-center alert alert-info">Vacio!</h3>
            <?php endif; ?>

        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('plantillas.admin_template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>