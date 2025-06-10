                <div class="form-group @if($errors->has('sep_titulo_id')) has-error @endif">
                       <label for="sep_titulo_id-field">Sep_titulo_id</label>
                       {!! Form::text("sep_titulo_id", null, array("class" => "form-control", "id" => "sep_titulo_id-field")) !!}
                       @if($errors->has("sep_titulo_id"))
                        <span class="help-block">{{ $errors->first("sep_titulo_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('cliente_id')) has-error @endif">
                       <label for="cliente_id-field">Cliente_id</label>
                       {!! Form::text("cliente_id", null, array("class" => "form-control", "id" => "cliente_id-field")) !!}
                       @if($errors->has("cliente_id"))
                        <span class="help-block">{{ $errors->first("cliente_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('bnd_descargar')) has-error @endif">
                       <label for="bnd_descargar-field">Bnd_descargar</label>
                       {!! Form::text("bnd_descargar", null, array("class" => "form-control", "id" => "bnd_descargar-field")) !!}
                       @if($errors->has("bnd_descargar"))
                        <span class="help-block">{{ $errors->first("bnd_descargar") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('usu_mod_id')) has-error @endif">
                       <label for="usu_mod_id-field">Usu_mod_id</label>
                       {!! Form::text("usu_mod_id", null, array("class" => "form-control", "id" => "usu_mod_id-field")) !!}
                       @if($errors->has("usu_mod_id"))
                        <span class="help-block">{{ $errors->first("usu_mod_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('usu_alta_id')) has-error @endif">
                       <label for="usu_alta_id-field">Usu_alta_id</label>
                       {!! Form::text("usu_alta_id", null, array("class" => "form-control", "id" => "usu_alta_id-field")) !!}
                       @if($errors->has("usu_alta_id"))
                        <span class="help-block">{{ $errors->first("usu_alta_id") }}</span>
                       @endif
                    </div>