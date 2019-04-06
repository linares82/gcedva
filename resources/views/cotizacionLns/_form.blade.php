                <div class="form-group @if($errors->has('cotizacion_curso_id')) has-error @endif">
                       <label for="cotizacion_curso_id-field">Cotizacion_curso_no_coti</label>
                       {!! Form::select("cotizacion_curso_id", $list["CotizacionCurso"], null, array("class" => "form-control", "id" => "cotizacion_curso_id-field")) !!}
                       @if($errors->has("cotizacion_curso_id"))
                        <span class="help-block">{{ $errors->first("cotizacion_curso_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('consecutivo')) has-error @endif">
                       <label for="consecutivo-field">Consecutivo</label>
                       {!! Form::text("consecutivo", null, array("class" => "form-control", "id" => "consecutivo-field")) !!}
                       @if($errors->has("consecutivo"))
                        <span class="help-block">{{ $errors->first("consecutivo") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('cursos_empresa_id')) has-error @endif">
                       <label for="cursos_empresa_id-field">Cursos_empresa_name</label>
                       {!! Form::select("cursos_empresa_id", $list["CursosEmpresa"], null, array("class" => "form-control", "id" => "cursos_empresa_id-field")) !!}
                       @if($errors->has("cursos_empresa_id"))
                        <span class="help-block">{{ $errors->first("cursos_empresa_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('tipo_precio_coti_id')) has-error @endif">
                       <label for="tipo_precio_coti_id-field">Tipo_precio_coti_name</label>
                       {!! Form::select("tipo_precio_coti_id", $list["TipoPrecioCoti"], null, array("class" => "form-control", "id" => "tipo_precio_coti_id-field")) !!}
                       @if($errors->has("tipo_precio_coti_id"))
                        <span class="help-block">{{ $errors->first("tipo_precio_coti_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('cantidad')) has-error @endif">
                       <label for="cantidad-field">Cantidad</label>
                       {!! Form::text("cantidad", null, array("class" => "form-control", "id" => "cantidad-field")) !!}
                       @if($errors->has("cantidad"))
                        <span class="help-block">{{ $errors->first("cantidad") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('precio')) has-error @endif">
                       <label for="precio-field">Precio</label>
                       {!! Form::text("precio", null, array("class" => "form-control", "id" => "precio-field")) !!}
                       @if($errors->has("precio"))
                        <span class="help-block">{{ $errors->first("precio") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('total')) has-error @endif">
                       <label for="total-field">Total</label>
                       {!! Form::text("total", null, array("class" => "form-control", "id" => "total-field")) !!}
                       @if($errors->has("total"))
                        <span class="help-block">{{ $errors->first("total") }}</span>
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