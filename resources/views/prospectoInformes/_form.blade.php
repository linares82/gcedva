                <div class="form-group @if($errors->has('prospecto_parte_informe_id')) has-error @endif">
                       <label for="prospecto_parte_informe_id-field">Prospecto_parte_informe_id</label>
                       {!! Form::text("prospecto_parte_informe_id", null, array("class" => "form-control", "id" => "prospecto_parte_informe_id-field")) !!}
                       @if($errors->has("prospecto_parte_informe_id"))
                        <span class="help-block">{{ $errors->first("prospecto_parte_informe_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('prospecto_etiqueta_id')) has-error @endif">
                       <label for="prospecto_etiqueta_id-field">Prospecto_etiqueta_id</label>
                       {!! Form::text("prospecto_etiqueta_id", null, array("class" => "form-control", "id" => "prospecto_etiqueta_id-field")) !!}
                       @if($errors->has("prospecto_etiqueta_id"))
                        <span class="help-block">{{ $errors->first("prospecto_etiqueta_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('detalle')) has-error @endif">
                       <label for="detalle-field">Detalle</label>
                       {!! Form::text("detalle", null, array("class" => "form-control", "id" => "detalle-field")) !!}
                       @if($errors->has("detalle"))
                        <span class="help-block">{{ $errors->first("detalle") }}</span>
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