                <div class="form-group @if($errors->has('articulo_id')) has-error @endif">
                       <label for="articulo_id-field">Articulo_id</label>
                       {!! Form::text("articulo_id", null, array("class" => "form-control", "id" => "articulo_id-field")) !!}
                       @if($errors->has("articulo_id"))
                        <span class="help-block">{{ $errors->first("articulo_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('plantel_id')) has-error @endif">
                       <label for="plantel_id-field">Plantel_id</label>
                       {!! Form::text("plantel_id", null, array("class" => "form-control", "id" => "plantel_id-field")) !!}
                       @if($errors->has("plantel_id"))
                        <span class="help-block">{{ $errors->first("plantel_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('existencia')) has-error @endif">
                       <label for="existencia-field">Existencia</label>
                       {!! Form::text("existencia", null, array("class" => "form-control", "id" => "existencia-field")) !!}
                       @if($errors->has("existencia"))
                        <span class="help-block">{{ $errors->first("existencia") }}</span>
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