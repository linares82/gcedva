                <div class="form-group @if($errors->has('doc_vinculacion_id')) has-error @endif">
                       <label for="doc_vinculacion_id-field">Doc_vinculacion_name</label>
                       {!! Form::select("doc_vinculacion_id", $list["DocVinculacion"], null, array("class" => "form-control", "id" => "doc_vinculacion_id-field")) !!}
                       @if($errors->has("doc_vinculacion_id"))
                        <span class="help-block">{{ $errors->first("doc_vinculacion_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('vinculacion_id')) has-error @endif">
                       <label for="vinculacion_id-field">Vinculacion_lugar_practica</label>
                       {!! Form::select("vinculacion_id", $list["Vinculacion"], null, array("class" => "form-control", "id" => "vinculacion_id-field")) !!}
                       @if($errors->has("vinculacion_id"))
                        <span class="help-block">{{ $errors->first("vinculacion_id") }}</span>
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