                <div class="form-group @if($errors->has('cliente_id')) has-error @endif">
                       <label for="cliente_id-field">Cliente_nombre</label>
                       {!! Form::select("cliente_id", $list["Cliente"], null, array("class" => "form-control", "id" => "cliente_id-field")) !!}
                       @if($errors->has("cliente_id"))
                        <span class="help-block">{{ $errors->first("cliente_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('calificacion_id')) has-error @endif">
                       <label for="calificacion_id-field">Calificacion_calificacion</label>
                       {!! Form::select("calificacion_id", $list["Calificacion"], null, array("class" => "form-control", "id" => "calificacion_id-field")) !!}
                       @if($errors->has("calificacion_id"))
                        <span class="help-block">{{ $errors->first("calificacion_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('carga_ponderacion_id')) has-error @endif">
                       <label for="carga_ponderacion_id-field">Carga_ponderacion_name</label>
                       {!! Form::select("carga_ponderacion_id", $list["CargaPonderacion"], null, array("class" => "form-control", "id" => "carga_ponderacion_id-field")) !!}
                       @if($errors->has("carga_ponderacion_id"))
                        <span class="help-block">{{ $errors->first("carga_ponderacion_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('calificacion_parcial_anterior')) has-error @endif">
                       <label for="calificacion_parcial_anterior-field">Calificacion_parcial_anterior</label>
                       {!! Form::text("calificacion_parcial_anterior", null, array("class" => "form-control", "id" => "calificacion_parcial_anterior-field")) !!}
                       @if($errors->has("calificacion_parcial_anterior"))
                        <span class="help-block">{{ $errors->first("calificacion_parcial_anterior") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('calificacion_parcial_actual')) has-error @endif">
                       <label for="calificacion_parcial_actual-field">Calificacion_parcial_actual</label>
                       {!! Form::text("calificacion_parcial_actual", null, array("class" => "form-control", "id" => "calificacion_parcial_actual-field")) !!}
                       @if($errors->has("calificacion_parcial_actual"))
                        <span class="help-block">{{ $errors->first("calificacion_parcial_actual") }}</span>
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