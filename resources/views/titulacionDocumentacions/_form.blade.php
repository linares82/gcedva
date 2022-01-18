                <div class="form-group @if($errors->has('titulacion_id')) has-error @endif">
                       <label for="titulacion_id-field">Titulacion_id</label>
                       {!! Form::select("titulacion_id", $list["Titulacion"], null, array("class" => "form-control", "id" => "titulacion_id-field")) !!}
                       @if($errors->has("titulacion_id"))
                        <span class="help-block">{{ $errors->first("titulacion_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('titulacion_documento_id')) has-error @endif">
                       <label for="titulacion_documento_id-field">Titulacion_documento_name</label>
                       {!! Form::select("titulacion_documento_id", $list["TitulacionDocumento"], null, array("class" => "form-control", "id" => "titulacion_documento_id-field")) !!}
                       @if($errors->has("titulacion_documento_id"))
                        <span class="help-block">{{ $errors->first("titulacion_documento_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('archivo')) has-error @endif">
                       <label for="archivo-field">Archivo</label>
                       {!! Form::text("archivo", null, array("class" => "form-control", "id" => "archivo-field")) !!}
                       @if($errors->has("archivo"))
                        <span class="help-block">{{ $errors->first("archivo") }}</span>
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