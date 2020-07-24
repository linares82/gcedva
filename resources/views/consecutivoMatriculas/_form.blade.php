                <div class="form-group @if($errors->has('plantel_id')) has-error @endif">
                       <label for="plantel_id-field">Plantel_id</label>
                       {!! Form::text("plantel_id", null, array("class" => "form-control", "id" => "plantel_id-field")) !!}
                       @if($errors->has("plantel_id"))
                        <span class="help-block">{{ $errors->first("plantel_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('anio')) has-error @endif">
                       <label for="anio-field">Anio</label>
                       {!! Form::text("anio", null, array("class" => "form-control", "id" => "anio-field")) !!}
                       @if($errors->has("anio"))
                        <span class="help-block">{{ $errors->first("anio") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('mes')) has-error @endif">
                       <label for="mes-field">Mes</label>
                       {!! Form::text("mes", null, array("class" => "form-control", "id" => "mes-field")) !!}
                       @if($errors->has("mes"))
                        <span class="help-block">{{ $errors->first("mes") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('seccion')) has-error @endif">
                       <label for="seccion-field">Seccion</label>
                       {!! Form::text("seccion", null, array("class" => "form-control", "id" => "seccion-field")) !!}
                       @if($errors->has("seccion"))
                        <span class="help-block">{{ $errors->first("seccion") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('consecutivo')) has-error @endif">
                       <label for="consecutivo-field">Consecutivo</label>
                       {!! Form::text("consecutivo", null, array("class" => "form-control", "id" => "consecutivo-field")) !!}
                       @if($errors->has("consecutivo"))
                        <span class="help-block">{{ $errors->first("consecutivo") }}</span>
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