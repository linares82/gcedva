                <div class="form-group @if($errors->has('cliente_id')) has-error @endif">
                       <label for="cliente_id-field">Cliente_id</label>
                       {!! Form::text("cliente_id", null, array("class" => "form-control", "id" => "cliente_id-field")) !!}
                       @if($errors->has("cliente_id"))
                        <span class="help-block">{{ $errors->first("cliente_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('motivo_beca_id')) has-error @endif">
                       <label for="motivo_beca_id-field">Motivo_beca_id</label>
                       {!! Form::text("motivo_beca_id", null, array("class" => "form-control", "id" => "motivo_beca_id-field")) !!}
                       @if($errors->has("motivo_beca_id"))
                        <span class="help-block">{{ $errors->first("motivo_beca_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('observaciones')) has-error @endif">
                       <label for="observaciones-field">Observaciones</label>
                       {!! Form::text("observaciones", null, array("class" => "form-control", "id" => "observaciones-field")) !!}
                       @if($errors->has("observaciones"))
                        <span class="help-block">{{ $errors->first("observaciones") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('procentaje_beca_id')) has-error @endif">
                       <label for="procentaje_beca_id-field">Procentaje_beca_id</label>
                       {!! Form::text("procentaje_beca_id", null, array("class" => "form-control", "id" => "procentaje_beca_id-field")) !!}
                       @if($errors->has("procentaje_beca_id"))
                        <span class="help-block">{{ $errors->first("procentaje_beca_id") }}</span>
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