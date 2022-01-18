                <div class="form-group @if($errors->has('titulacion_id')) has-error @endif">
                       <label for="titulacion_id-field">Titulacion_id</label>
                       {!! Form::select("titulacion_id", $list["Titulacion"], null, array("class" => "form-control", "id" => "titulacion_id-field")) !!}
                       @if($errors->has("titulacion_id"))
                        <span class="help-block">{{ $errors->first("titulacion_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('intento')) has-error @endif">
                       <label for="intento-field">Intento</label>
                       {!! Form::text("intento", null, array("class" => "form-control", "id" => "intento-field")) !!}
                       @if($errors->has("intento"))
                        <span class="help-block">{{ $errors->first("intento") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('fec_examen')) has-error @endif">
                       <label for="fec_examen-field">Fec_examen</label>
                       {!! Form::text("fec_examen", null, array("class" => "form-control", "id" => "fec_examen-field")) !!}
                       @if($errors->has("fec_examen"))
                        <span class="help-block">{{ $errors->first("fec_examen") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('opcion_titulacion_id')) has-error @endif">
                       <label for="opcion_titulacion_id-field">Opcion_titulacion_id</label>
                       {!! Form::text("opcion_titulacion_id", null, array("class" => "form-control", "id" => "opcion_titulacion_id-field")) !!}
                       @if($errors->has("opcion_titulacion_id"))
                        <span class="help-block">{{ $errors->first("opcion_titulacion_id") }}</span>
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