                <div class="form-group col-md-4 <?php if($errors->has('name')): ?> has-error <?php endif; ?>">
                       <label for="name-field">Name</label>
                       <?php echo Form::text("name", null, array("class" => "form-control", "id" => "name-field")); ?>

                       <?php if($errors->has("name")): ?>
                        <span class="help-block"><?php echo e($errors->first("name")); ?></span>
                       <?php endif; ?>
                    </div>
                    <div class="form-group col-md-4 <?php if($errors->has('ubicacion')): ?> has-error <?php endif; ?>">
                       <label for="ubicacion-field">Ubicacion</label>
                       <?php echo Form::text("ubicacion", null, array("class" => "form-control", "id" => "ubicacion-field")); ?>

                       <?php if($errors->has("ubicacion")): ?>
                        <span class="help-block"><?php echo e($errors->first("ubicacion")); ?></span>
                       <?php endif; ?>
                    </div>
                    <div class="form-group col-md-4 <?php if($errors->has('plantel_id')): ?> has-error <?php endif; ?>">
                       <label for="plantel_id-field">Plantel</label>
                       <?php echo Form::select("plantel_id", $list["Plantel"], null, array("class" => "form-control select_seguridad", "id" => "plantel_id-field", 'readonly'=>'readonly')); ?>

                       <?php if($errors->has("plantel_id")): ?>
                        <span class="help-block"><?php echo e($errors->first("plantel_id")); ?></span>
                       <?php endif; ?>
                    </div>
                    