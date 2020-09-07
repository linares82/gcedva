                <div class="form-group @if($errors->has('codigo_posta')) has-error @endif">
                       <label for="codigo_posta-field">Codigo_posta</label>
                       {!! Form::text("codigo_posta", null, array("class" => "form-control", "id" => "codigo_posta-field")) !!}
                       @if($errors->has("codigo_posta"))
                        <span class="help-block">{{ $errors->first("codigo_posta") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('clave_entidad_federativa')) has-error @endif">
                       <label for="clave_entidad_federativa-field">Clave_entidad_federativa</label>
                       {!! Form::text("clave_entidad_federativa", null, array("class" => "form-control", "id" => "clave_entidad_federativa-field")) !!}
                       @if($errors->has("clave_entidad_federativa"))
                        <span class="help-block">{{ $errors->first("clave_entidad_federativa") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('clave_municipo')) has-error @endif">
                       <label for="clave_municipo-field">Clave_municipo</label>
                       {!! Form::text("clave_municipo", null, array("class" => "form-control", "id" => "clave_municipo-field")) !!}
                       @if($errors->has("clave_municipo"))
                        <span class="help-block">{{ $errors->first("clave_municipo") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('clave_mun_del')) has-error @endif">
                       <label for="clave_mun_del-field">Clave_mun_del</label>
                       {!! Form::text("clave_mun_del", null, array("class" => "form-control", "id" => "clave_mun_del-field")) !!}
                       @if($errors->has("clave_mun_del"))
                        <span class="help-block">{{ $errors->first("clave_mun_del") }}</span>
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