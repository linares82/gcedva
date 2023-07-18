                <div class="form-group col-md-4 @if($errors->has('name')) has-error @endif">
                   <label for="name-field">Estatus Clientes</label>
                   {!! Form::text("name", null, array("class" => "form-control input-sm", "id" => "name-field")) !!}
                   @if($errors->has("name"))
                   <span class="help-block">{{ $errors->first("name") }}</span>
                   @endif
                </div>
                <div class="row"></div>
                <div class="form-group col-md-4 @if($errors->has('bnd_automatizar_baja')) has-error @endif">
                   <label for="bnd_automatizar_baja-field">Automatizar baja</label>
                   {!! Form::checkbox("bnd_automatizar_baja", 1, null, [ "id" => "bnd_automatizar_baja-field", 'class'=>'minimal']) !!}
                   @if($errors->has("bnd_automatizar_baja"))
                   <span class="help-block">{{ $errors->first("bnd_automatizar_baja") }}</span>
                   @endif
                </div>
                <div class="form-group col-md-4 @if($errors->has('orden_ejecucion')) has-error @endif">
                   <label for="orden_ejecucion-field">Orden Ejecución</label>
                   {!! Form::text("orden_ejecucion", null, array("class" => "form-control input-sm", "id" => "orden_ejecucion-field")) !!}
                   @if($errors->has("orden_ejecucion"))
                   <span class="help-block">{{ $errors->first("orden_ejecucion") }}</span>
                   @endif
                </div>
                <div class="form-group col-md-4 @if($errors->has('dias_ejecucion')) has-error @endif">
                   <label for="dias_ejecucion-field">Dias Ejecutar(1,2,3...)</label>
                   {!! Form::text("dias_ejecucion", null, array("class" => "form-control input-sm", "id" => "dias_ejecucion-field")) !!}
                   @if($errors->has("dias_ejecucion"))
                   <span class="help-block">{{ $errors->first("dias_ejecucion") }}</span>
                   @endif
                </div>
                <div class="form-group col-md-4 @if($errors->has('bnd_mensualidades')) has-error @endif">
                   <label for="bnd_mensualidades-field">Considera Solo Adeudos/Mensualidades</label>
                   {!! Form::checkbox("bnd_mensualidades", 1, null, [ "id" => "bnd_mensualidades-field", 'class'=>'minimal']) !!}
                   @if($errors->has("bnd_mensualidades"))
                   <span class="help-block">{{ $errors->first("bnd_mensualidades") }}</span>
                   @endif
                </div>
                <div class="form-group col-md-4 @if($errors->has('cantidad_adeudos')) has-error @endif">
                   <label for="cantidad_adeudos-field">Cantidad de Adeudos(1,2,3...)</label>
                   {!! Form::text("cantidad_adeudos", null, array("class" => "form-control input-sm", "id" => "cantidad_adeudos-field")) !!}
                   @if($errors->has("cantidad_adeudos"))
                   <span class="help-block">{{ $errors->first("cantidad_adeudos") }}</span>
                   @endif
                </div>
                
                <div class="form-group col-md-4 @if($errors->has('siguiente_cliente_id')) has-error @endif">
                   <label for="siguiente_cliente_id-field">Siguiente Estatus Cliente</label>
                   {!! Form::select("siguiente_cliente_id", $stClientes, null, array("class" => "form-control select_seguridad", "id" => "siguiente_cliente_id-field")) !!}
                   @if($errors->has("siguiente_cliente_id"))
                   <span class="help-block">{{ $errors->first("siguiente_cliente_id") }}</span>
                   @endif
                </div>
                <div class="form-group col-md-6 @if($errors->has('siguiente_seguimiento_id')) has-error @endif">
                        <label for="siguiente_seguimiento_id-field">Siguiente Estatus seguimiento</label>
                        {!! Form::select("siguiente_seguimiento_id", $stSeguimientos,null, array("class" => "form-control select_seguridad", "id" => "siguiente_seguimiento_id-field")) !!}
                        @if($errors->has("siguiente_seguimiento_id"))
                        <span class="help-block">{{ $errors->first("siguiente_seguimiento_id") }}</span>
                        @endif
                    </div>