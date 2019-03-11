                <div class="form-group @if($errors->has('autorizacion_beca_id')) has-error @endif">
                       <label for="autorizacion_beca_id-field">Autorizacion_beca_solicitud</label>
                       {!! Form::select("autorizacion_beca_id", $list["AutorizacionBeca"], null, array("class" => "form-control", "id" => "autorizacion_beca_id-field")) !!}
                       @if($errors->has("autorizacion_beca_id"))
                        <span class="help-block">{{ $errors->first("autorizacion_beca_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('comentario')) has-error @endif">
                       <label for="comentario-field">Comentario</label>
                       {!! Form::text("comentario", null, array("class" => "form-control", "id" => "comentario-field")) !!}
                       @if($errors->has("comentario"))
                        <span class="help-block">{{ $errors->first("comentario") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('monto_inscripcion')) has-error @endif">
                       <label for="monto_inscripcion-field">Monto_inscripcion</label>
                       {!! Form::text("monto_inscripcion", null, array("class" => "form-control", "id" => "monto_inscripcion-field")) !!}
                       @if($errors->has("monto_inscripcion"))
                        <span class="help-block">{{ $errors->first("monto_inscripcion") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('monto_mensualidad')) has-error @endif">
                       <label for="monto_mensualidad-field">Monto_mensualidad</label>
                       {!! Form::text("monto_mensualidad", null, array("class" => "form-control", "id" => "monto_mensualidad-field")) !!}
                       @if($errors->has("monto_mensualidad"))
                        <span class="help-block">{{ $errors->first("monto_mensualidad") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('st_beca_id')) has-error @endif">
                       <label for="st_beca_id-field">St_beca_name</label>
                       {!! Form::select("st_beca_id", $list["StBeca"], null, array("class" => "form-control", "id" => "st_beca_id-field")) !!}
                       @if($errors->has("st_beca_id"))
                        <span class="help-block">{{ $errors->first("st_beca_id") }}</span>
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