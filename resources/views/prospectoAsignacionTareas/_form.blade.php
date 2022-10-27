                <div class="form-group @if($errors->has('prospecto_id')) has-error @endif">
                       <label for="prospecto_id-field">Prospecto_id</label>
                       {!! Form::text("prospecto_id", null, array("class" => "form-control", "id" => "prospecto_id-field")) !!}
                       @if($errors->has("prospecto_id"))
                        <span class="help-block">{{ $errors->first("prospecto_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('empleado_id')) has-error @endif">
                       <label for="empleado_id-field">Empleado_id</label>
                       {!! Form::text("empleado_id", null, array("class" => "form-control", "id" => "empleado_id-field")) !!}
                       @if($errors->has("empleado_id"))
                        <span class="help-block">{{ $errors->first("empleado_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('prospecto_tarea_id')) has-error @endif">
                       <label for="prospecto_tarea_id-field">Prospecto_tarea_id</label>
                       {!! Form::text("prospecto_tarea_id", null, array("class" => "form-control", "id" => "prospecto_tarea_id-field")) !!}
                       @if($errors->has("prospecto_tarea_id"))
                        <span class="help-block">{{ $errors->first("prospecto_tarea_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('prospecto_asunto_id')) has-error @endif">
                       <label for="prospecto_asunto_id-field">Prospecto_asunto_id</label>
                       {!! Form::text("prospecto_asunto_id", null, array("class" => "form-control", "id" => "prospecto_asunto_id-field")) !!}
                       @if($errors->has("prospecto_asunto_id"))
                        <span class="help-block">{{ $errors->first("prospecto_asunto_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('propecto_st_seg_id')) has-error @endif">
                       <label for="propecto_st_seg_id-field">Propecto_st_seg_id</label>
                       {!! Form::text("propecto_st_seg_id", null, array("class" => "form-control", "id" => "propecto_st_seg_id-field")) !!}
                       @if($errors->has("propecto_st_seg_id"))
                        <span class="help-block">{{ $errors->first("propecto_st_seg_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('obs')) has-error @endif">
                       <label for="obs-field">Obs</label>
                       {!! Form::text("obs", null, array("class" => "form-control", "id" => "obs-field")) !!}
                       @if($errors->has("obs"))
                        <span class="help-block">{{ $errors->first("obs") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('usu_alta_id')) has-error @endif">
                       <label for="usu_alta_id-field">Usu_alta_id</label>
                       {!! Form::text("usu_alta_id", null, array("class" => "form-control", "id" => "usu_alta_id-field")) !!}
                       @if($errors->has("usu_alta_id"))
                        <span class="help-block">{{ $errors->first("usu_alta_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('usu_mod_id')) has-error @endif">
                       <label for="usu_mod_id-field">Usu_mod_id</label>
                       {!! Form::text("usu_mod_id", null, array("class" => "form-control", "id" => "usu_mod_id-field")) !!}
                       @if($errors->has("usu_mod_id"))
                        <span class="help-block">{{ $errors->first("usu_mod_id") }}</span>
                       @endif
                    </div>