                <div class="form-group col-md-4 <?php if($errors->has('name')): ?> has-error <?php endif; ?>">
                       <label for="name-field">Materia</label>
                       <?php echo Form::text("name", null, array("class" => "form-control", "id" => "name-field")); ?>

                       <?php if($errors->has("name")): ?>
                        <span class="help-block"><?php echo e($errors->first("name")); ?></span>
                       <?php endif; ?>
                    </div>
                    <div class="form-group col-md-4 <?php if($errors->has('abreviatura')): ?> has-error <?php endif; ?>">
                       <label for="abreviatura-field">Abreviatura</label>
                       <?php echo Form::text("abreviatura", null, array("class" => "form-control", "id" => "abreviatura-field")); ?>

                       <?php if($errors->has("abreviatura")): ?>
                        <span class="help-block"><?php echo e($errors->first("abreviatura")); ?></span>
                       <?php endif; ?>
                    </div>
                    <div class="form-group col-md-4 <?php if($errors->has('seriada_bnd')): ?> has-error <?php endif; ?>">
                       <label for="seriada_bnd-field">Seriada</label>
                       <?php echo Form::checkbox("seriada_bnd", 1, null, [ "id" => "seriada_bnd-field"]); ?>

                       <?php if($errors->has("seriada_bnd")): ?>
                        <span class="help-block"><?php echo e($errors->first("seriada_bnd")); ?></span>
                       <?php endif; ?>
                    </div>
                    <div class="form-group col-md-4 <?php if($errors->has('serie_anterior')): ?> has-error <?php endif; ?>">
                       <label for="serie_anterior-field">Serie anterior</label>
                       <?php echo Form::select("serie_anterior", $materiales_ls, null, array("class" => "form-control select_seguridad", "id" => "serie_anterior-field")); ?>

                       <?php if($errors->has("serie_anterior")): ?>
                        <span class="help-block"><?php echo e($errors->first("serie_anterior")); ?></span>
                       <?php endif; ?>
                    </div>
                    <div class="form-group col-md-4 <?php if($errors->has('modulo_id')): ?> has-error <?php endif; ?>">
                       <label for="modulo_id-field">Modulo</label>
                       <?php echo Form::select("modulo_id", $list["Modulo"], null, array("class" => "form-control select_seguridad", "id" => "modulo_id-field")); ?>

                       <?php if($errors->has("modulo_id")): ?>
                        <span class="help-block"><?php echo e($errors->first("modulo_id")); ?></span>
                       <?php endif; ?>
                    </div>
                    <div class="form-group col-md-4 <?php if($errors->has('plantel_id')): ?> has-error <?php endif; ?>">
                       <label for="plantel_id-field">Plantel</label>
                       <?php echo Form::select("plantel_id", $list["Plantel"], null, array("class" => "form-control select_seguridad", "id" => "plantel_id-field")); ?>

                       <?php if($errors->has("plantel_id")): ?>
                        <span class="help-block"><?php echo e($errors->first("plantel_id")); ?></span>
                       <?php endif; ?>
                    </div>
                    <div class="form-group col-md-4 <?php if($errors->has('ponderacion_id')): ?> has-error <?php endif; ?>">
                       <label for="ponderacion_id-field">Ponderacion</label>
                       <?php echo Form::select("ponderacion_id", $list["Ponderacion"], null, array("class" => "form-control select_seguridad", "id" => "ponderacion_id-field")); ?>

                       <?php if($errors->has("ponderacion_id")): ?>
                        <span class="help-block"><?php echo e($errors->first("ponderacion_id")); ?></span>
                       <?php endif; ?>
                    </div>