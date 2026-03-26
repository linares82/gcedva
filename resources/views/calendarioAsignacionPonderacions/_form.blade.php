                <div class="form-group @if($errors->has('asignacion_academica_id')) has-error @endif">
                       <label for="asignacion_academica_id-field">Asignacion_academica_id</label>
                       {!! Form::text("asignacion_academica_id", null, array("class" => "form-control", "id" => "asignacion_academica_id-field")) !!}
                       @if($errors->has("asignacion_academica_id"))
                        <span class="help-block">{{ $errors->first("asignacion_academica_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('carga_ponderacion_id')) has-error @endif">
                       <label for="carga_ponderacion_id-field">Carga_ponderacion_id</label>
                       {!! Form::text("carga_ponderacion_id", null, array("class" => "form-control", "id" => "carga_ponderacion_id-field")) !!}
                       @if($errors->has("carga_ponderacion_id"))
                        <span class="help-block">{{ $errors->first("carga_ponderacion_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('fec_inicio')) has-error @endif">
                       <label for="fec_inicio-field">Fec_inicio</label>
                       {!! Form::text("fec_inicio", null, array("class" => "form-control", "id" => "fec_inicio-field")) !!}
                       @if($errors->has("fec_inicio"))
                        <span class="help-block">{{ $errors->first("fec_inicio") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('fec_fin')) has-error @endif">
                       <label for="fec_fin-field">Fec_fin</label>
                       {!! Form::text("fec_fin", null, array("class" => "form-control", "id" => "fec_fin-field")) !!}
                       @if($errors->has("fec_fin"))
                        <span class="help-block">{{ $errors->first("fec_fin") }}</span>
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