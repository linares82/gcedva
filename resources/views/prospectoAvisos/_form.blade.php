                <div class="form-group @if($errors->has('prospecto_seguimiento_id')) has-error @endif">
                       <label for="prospecto_seguimiento_id-field">Prospecto_seguimiento_id</label>
                       {!! Form::text("prospecto_seguimiento_id", null, array("class" => "form-control", "id" => "prospecto_seguimiento_id-field")) !!}
                       @if($errors->has("prospecto_seguimiento_id"))
                        <span class="help-block">{{ $errors->first("prospecto_seguimiento_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('prospecto_asunto_id')) has-error @endif">
                       <label for="prospecto_asunto_id-field">Prospecto_asunto_id</label>
                       {!! Form::text("prospecto_asunto_id", null, array("class" => "form-control", "id" => "prospecto_asunto_id-field")) !!}
                       @if($errors->has("prospecto_asunto_id"))
                        <span class="help-block">{{ $errors->first("prospecto_asunto_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('detalle')) has-error @endif">
                       <label for="detalle-field">Detalle</label>
                       {!! Form::text("detalle", null, array("class" => "form-control", "id" => "detalle-field")) !!}
                       @if($errors->has("detalle"))
                        <span class="help-block">{{ $errors->first("detalle") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('fecha')) has-error @endif">
                       <label for="fecha-field">Fecha</label>
                       {!! Form::text("fecha", null, array("class" => "form-control", "id" => "fecha-field")) !!}
                       @if($errors->has("fecha"))
                        <span class="help-block">{{ $errors->first("fecha") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('activo')) has-error @endif">
                       <label for="activo-field">Activo</label>
                       {!! Form::text("activo", null, array("class" => "form-control", "id" => "activo-field")) !!}
                       @if($errors->has("activo"))
                        <span class="help-block">{{ $errors->first("activo") }}</span>
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