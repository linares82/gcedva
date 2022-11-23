                <div class="form-group @if($errors->has('tabla')) has-error @endif">
                       <label for="tabla-field">Tabla</label>
                       {!! Form::text("tabla", null, array("class" => "form-control", "id" => "tabla-field")) !!}
                       @if($errors->has("tabla"))
                        <span class="help-block">{{ $errors->first("tabla") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('prospecto_id')) has-error @endif">
                       <label for="prospecto_id-field">Prospecto_id</label>
                       {!! Form::text("prospecto_id", null, array("class" => "form-control", "id" => "prospecto_id-field")) !!}
                       @if($errors->has("prospecto_id"))
                        <span class="help-block">{{ $errors->first("prospecto_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('seguimiento_id')) has-error @endif">
                       <label for="seguimiento_id-field">Seguimiento_id</label>
                       {!! Form::text("seguimiento_id", null, array("class" => "form-control", "id" => "seguimiento_id-field")) !!}
                       @if($errors->has("seguimiento_id"))
                        <span class="help-block">{{ $errors->first("seguimiento_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('estatus')) has-error @endif">
                       <label for="estatus-field">Estatus</label>
                       {!! Form::text("estatus", null, array("class" => "form-control", "id" => "estatus-field")) !!}
                       @if($errors->has("estatus"))
                        <span class="help-block">{{ $errors->first("estatus") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('estatus_id')) has-error @endif">
                       <label for="estatus_id-field">Estatus_id</label>
                       {!! Form::text("estatus_id", null, array("class" => "form-control", "id" => "estatus_id-field")) !!}
                       @if($errors->has("estatus_id"))
                        <span class="help-block">{{ $errors->first("estatus_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('fecha')) has-error @endif">
                       <label for="fecha-field">Fecha</label>
                       {!! Form::text("fecha", null, array("class" => "form-control", "id" => "fecha-field")) !!}
                       @if($errors->has("fecha"))
                        <span class="help-block">{{ $errors->first("fecha") }}</span>
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