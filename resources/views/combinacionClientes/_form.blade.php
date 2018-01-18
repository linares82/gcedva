                <div class="form-group @if($errors->has('cliente_id')) has-error @endif">
                       <label for="cliente_id-field">Cliente_nombre</label>
                       {!! Form::select("cliente_id", $list["Cliente"], null, array("class" => "form-control", "id" => "cliente_id-field")) !!}
                       @if($errors->has("cliente_id"))
                        <span class="help-block">{{ $errors->first("cliente_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('plantel_id')) has-error @endif">
                       <label for="plantel_id-field">Plantel_razon</label>
                       {!! Form::select("plantel_id", $list["Plantel"], null, array("class" => "form-control", "id" => "plantel_id-field")) !!}
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
                    <div class="form-group @if($errors->has('turno_id')) has-error @endif">
                       <label for="turno_id-field">Turno_id</label>
                       {!! Form::text("turno_id", null, array("class" => "form-control", "id" => "turno_id-field")) !!}
                       @if($errors->has("turno_id"))
                        <span class="help-block">{{ $errors->first("turno_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('bnd_inscrito')) has-error @endif">
                       <label for="bnd_inscrito-field">Bnd_inscrito</label>
                       {!! Form::text("bnd_inscrito", null, array("class" => "form-control", "id" => "bnd_inscrito-field")) !!}
                       @if($errors->has("bnd_inscrito"))
                        <span class="help-block">{{ $errors->first("bnd_inscrito") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('fec_inscrito')) has-error @endif">
                       <label for="fec_inscrito-field">Fec_inscrito</label>
                       {!! Form::text("fec_inscrito", null, array("class" => "form-control", "id" => "fec_inscrito-field")) !!}
                       @if($errors->has("fec_inscrito"))
                        <span class="help-block">{{ $errors->first("fec_inscrito") }}</span>
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