                <div class="form-group @if($errors->has('plantilla_empresa_id')) has-error @endif">
                       <label for="plantilla_empresa_id-field">Plantilla_empresa_nombre</label>
                       {!! Form::select("plantilla_empresa_id", $list["PlantillaEmpresa"], null, array("class" => "form-control", "id" => "plantilla_empresa_id-field")) !!}
                       @if($errors->has("plantilla_empresa_id"))
                        <span class="help-block">{{ $errors->first("plantilla_empresa_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('operador_condicion')) has-error @endif">
                       <label for="operador_condicion-field">Operador_condicion</label>
                       {!! Form::text("operador_condicion", null, array("class" => "form-control", "id" => "operador_condicion-field")) !!}
                       @if($errors->has("operador_condicion"))
                        <span class="help-block">{{ $errors->first("operador_condicion") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('plantilla_empresa_campo_id')) has-error @endif">
                       <label for="plantilla_empresa_campo_id-field">Plantilla_empresa_campo_campo</label>
                       {!! Form::select("plantilla_empresa_campo_id", $list["PlantillaEmpresaCampo"], null, array("class" => "form-control", "id" => "plantilla_empresa_campo_id-field")) !!}
                       @if($errors->has("plantilla_empresa_campo_id"))
                        <span class="help-block">{{ $errors->first("plantilla_empresa_campo_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('signo_comparacion')) has-error @endif">
                       <label for="signo_comparacion-field">Signo_comparacion</label>
                       {!! Form::text("signo_comparacion", null, array("class" => "form-control", "id" => "signo_comparacion-field")) !!}
                       @if($errors->has("signo_comparacion"))
                        <span class="help-block">{{ $errors->first("signo_comparacion") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('valor_condicion')) has-error @endif">
                       <label for="valor_condicion-field">Valor_condicion</label>
                       {!! Form::text("valor_condicion", null, array("class" => "form-control", "id" => "valor_condicion-field")) !!}
                       @if($errors->has("valor_condicion"))
                        <span class="help-block">{{ $errors->first("valor_condicion") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('interpretacion')) has-error @endif">
                       <label for="interpretacion-field">Interpretacion</label>
                       {!! Form::text("interpretacion", null, array("class" => "form-control", "id" => "interpretacion-field")) !!}
                       @if($errors->has("interpretacion"))
                        <span class="help-block">{{ $errors->first("interpretacion") }}</span>
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