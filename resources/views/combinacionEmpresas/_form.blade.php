                <div class="form-group @if($errors->has('empresa_id')) has-error @endif">
                       <label for="empresa_id-field">Empresa_id</label>
                       {!! Form::text("empresa_id", null, array("class" => "form-control", "id" => "empresa_id-field")) !!}
                       @if($errors->has("empresa_id"))
                        <span class="help-block">{{ $errors->first("empresa_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('plantel_id')) has-error @endif">
                       <label for="plantel_id-field">Plantel_id</label>
                       {!! Form::text("plantel_id", null, array("class" => "form-control", "id" => "plantel_id-field")) !!}
                       @if($errors->has("plantel_id"))
                        <span class="help-block">{{ $errors->first("plantel_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('especialidad_id')) has-error @endif">
                       <label for="especialidad_id-field">Especialidad_id</label>
                       {!! Form::text("especialidad_id", null, array("class" => "form-control", "id" => "especialidad_id-field")) !!}
                       @if($errors->has("especialidad_id"))
                        <span class="help-block">{{ $errors->first("especialidad_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('nivel_id')) has-error @endif">
                       <label for="nivel_id-field">Nivel_id</label>
                       {!! Form::text("nivel_id", null, array("class" => "form-control", "id" => "nivel_id-field")) !!}
                       @if($errors->has("nivel_id"))
                        <span class="help-block">{{ $errors->first("nivel_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('grado_id')) has-error @endif">
                       <label for="grado_id-field">Grado_id</label>
                       {!! Form::text("grado_id", null, array("class" => "form-control", "id" => "grado_id-field")) !!}
                       @if($errors->has("grado_id"))
                        <span class="help-block">{{ $errors->first("grado_id") }}</span>
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