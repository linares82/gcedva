<div class="row">
    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
    <div class="form-group col-md-6">
        <label for="name">Nombre</label>
        <input type="input" class="form-control" id="name" placeholder="Name" name="name" value="<?php echo e((Session::has('errors')) ? old('name', '') : $model->name); ?>">
    </div>
    <div class="form-group col-md-6">
        <label for="display_name">Nombre Desplegado</label>
        <input type="input" class="form-control" id="display_name" placeholder="Display Name" name="display_name" value="<?php echo e((Session::has('errors')) ? old('display_name', '') : $model->display_name); ?>">
    </div>
    <div class="form-group col-md-6">
        <label for="description">Descripción</label>
        <input type="input" class="form-control" id="description" placeholder="Description" name="description" value="<?php echo e((Session::has('errors')) ? old('description', '') : $model->description); ?>">
    </div>
    <div class="form-group col-md-12" >
        <label for="permissions">Permisos</label>
        <select class="select_seguridad" name="permissions[]" multiple class="form-control" style="width:100%;">
        <?php $__currentLoopData = $relations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $relation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($index); ?>" <?php echo e(((in_array($index, old('permissions', []))) || ( ! Session::has('errors') && $model->perms->contains('id', $index))) ? 'selected' : ''); ?>><?php echo e($relation); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
</div>