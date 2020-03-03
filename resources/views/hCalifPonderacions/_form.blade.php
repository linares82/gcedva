                <div class="form-group @if($errors->has('calificacion_ponderacion_id')) has-error @endif">
                       <label for="calificacion_ponderacion_id-field">Calificacion_ponderacion_id</label>
                       {!! Form::text("calificacion_ponderacion_id", null, array("class" => "form-control", "id" => "calificacion_ponderacion_id-field")) !!}
                       @if($errors->has("calificacion_ponderacion_id"))
                        <span class="help-block">{{ $errors->first("calificacion_ponderacion_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('calificacion_id')) has-error @endif">
                       <label for="calificacion_id-field">Calificacion_id</label>
                       {!! Form::text("calificacion_id", null, array("class" => "form-control", "id" => "calificacion_id-field")) !!}
                       @if($errors->has("calificacion_id"))
                        <span class="help-block">{{ $errors->first("calificacion_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('carga_pondercaion_id')) has-error @endif">
                       <label for="carga_pondercaion_id-field">Carga_pondercaion_id</label>
                       {!! Form::text("carga_pondercaion_id", null, array("class" => "form-control", "id" => "carga_pondercaion_id-field")) !!}
                       @if($errors->has("carga_pondercaion_id"))
                        <span class="help-block">{{ $errors->first("carga_pondercaion_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('calificacion_parcial')) has-error @endif">
                       <label for="calificacion_parcial-field">Calificacion_parcial</label>
                       {!! Form::text("calificacion_parcial", null, array("class" => "form-control", "id" => "calificacion_parcial-field")) !!}
                       @if($errors->has("calificacion_parcial"))
                        <span class="help-block">{{ $errors->first("calificacion_parcial") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('calificacon_parcial_calculada')) has-error @endif">
                       <label for="calificacon_parcial_calculada-field">Calificacon_parcial_calculada</label>
                       {!! Form::text("calificacon_parcial_calculada", null, array("class" => "form-control", "id" => "calificacon_parcial_calculada-field")) !!}
                       @if($errors->has("calificacon_parcial_calculada"))
                        <span class="help-block">{{ $errors->first("calificacon_parcial_calculada") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('ponderacion')) has-error @endif">
                       <label for="ponderacion-field">Ponderacion</label>
                       {!! Form::text("ponderacion", null, array("class" => "form-control", "id" => "ponderacion-field")) !!}
                       @if($errors->has("ponderacion"))
                        <span class="help-block">{{ $errors->first("ponderacion") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('tiene_detalle')) has-error @endif">
                       <label for="tiene_detalle-field">Tiene_detalle</label>
                       {!! Form::text("tiene_detalle", null, array("class" => "form-control", "id" => "tiene_detalle-field")) !!}
                       @if($errors->has("tiene_detalle"))
                        <span class="help-block">{{ $errors->first("tiene_detalle") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('padre_id')) has-error @endif">
                       <label for="padre_id-field">Padre_id</label>
                       {!! Form::text("padre_id", null, array("class" => "form-control", "id" => "padre_id-field")) !!}
                       @if($errors->has("padre_id"))
                        <span class="help-block">{{ $errors->first("padre_id") }}</span>
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