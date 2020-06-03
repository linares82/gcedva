                <div class="form-group @if($errors->has('name')) has-error @endif">
                       <label for="name-field">Name</label>
                       {!! Form::text("name", null, array("class" => "form-control", "id" => "name-field")) !!}
                       @if($errors->has("name"))
                        <span class="help-block">{{ $errors->first("name") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('porcentaje')) has-error @endif">
                       <label for="porcentaje-field">Porcentaje</label>
                       {!! Form::text("porcentaje", null, array("class" => "form-control", "id" => "porcentaje-field")) !!}
                       @if($errors->has("porcentaje"))
                        <span class="help-block">{{ $errors->first("porcentaje") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('justificacion')) has-error @endif">
                       <label for="justificacion-field">Justificacion</label>
                       {!! Form::text("justificacion", null, array("class" => "form-control", "id" => "justificacion-field")) !!}
                       @if($errors->has("justificacion"))
                        <span class="help-block">{{ $errors->first("justificacion") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('autorizado_por')) has-error @endif">
                       <label for="autorizado_por-field">Autorizado_por</label>
                       {!! Form::text("autorizado_por", null, array("class" => "form-control", "id" => "autorizado_por-field")) !!}
                       @if($errors->has("autorizado_por"))
                        <span class="help-block">{{ $errors->first("autorizado_por") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('autorizado_el')) has-error @endif">
                       <label for="autorizado_el-field">Autorizado_el</label>
                       {!! Form::text("autorizado_el", null, array("class" => "form-control", "id" => "autorizado_el-field")) !!}
                       @if($errors->has("autorizado_el"))
                        <span class="help-block">{{ $errors->first("autorizado_el") }}</span>
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