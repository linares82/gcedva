                <div class="form-group @if($errors->has('materium_id')) has-error @endif">
                       <label for="materium_id-field">Materium_id</label>
                       {!! Form::text("materium_id", null, array("class" => "form-control input-sm", "id" => "materium_id-field")) !!}
                       @if($errors->has("materium_id"))
                        <span class="help-block">{{ $errors->first("materium_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('periodo_estudio_id')) has-error @endif">
                       <label for="periodo_estudio_id-field">Periodo_estudio_id</label>
                       {!! Form::text("periodo_estudio_id", null, array("class" => "form-control input-sm", "id" => "periodo_estudio_id-field")) !!}
                       @if($errors->has("periodo_estudio_id"))
                        <span class="help-block">{{ $errors->first("periodo_estudio_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('usu_alta_id')) has-error @endif">
                       <label for="usu_alta_id-field">Usu_alta_id</label>
                       {!! Form::text("usu_alta_id", null, array("class" => "form-control input-sm", "id" => "usu_alta_id-field")) !!}
                       @if($errors->has("usu_alta_id"))
                        <span class="help-block">{{ $errors->first("usu_alta_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('usu_mod_id')) has-error @endif">
                       <label for="usu_mod_id-field">Usu_mod_id</label>
                       {!! Form::text("usu_mod_id", null, array("class" => "form-control input-sm", "id" => "usu_mod_id-field")) !!}
                       @if($errors->has("usu_mod_id"))
                        <span class="help-block">{{ $errors->first("usu_mod_id") }}</span>
                       @endif
                    </div>