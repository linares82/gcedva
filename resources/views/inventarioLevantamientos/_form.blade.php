                    <div class="form-group col-md-4 @if($errors->has('fecha')) has-error @endif">
                       <label for="name-field">Nombre</label>
                       {!! Form::text("name", null, array("class" => "form-control", "id" => "name-field")) !!}
                       @if($errors->has("name"))
                        <span class="help-block">{{ $errors->first("name") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('fecha')) has-error @endif">
                       <label for="fecha-field">Fecha</label>
                       {!! Form::text("fecha", null, array("class" => "form-control fecha", "id" => "fecha-field")) !!}
                       @if($errors->has("fecha"))
                        <span class="help-block">{{ $errors->first("fecha") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('plantel_inventario_id')) has-error @endif">
                            <label for="plantel_inventario_id-field">Plantel</label>
                            {!! Form::select("plantel_inventario_id", $planteles, null, array("class" => "form-control select_seguridad", "id" => "plantel_inventario_id-field")) !!}
                            @if($errors->has("plantel_inventario_id"))
                            <span class="help-block">{{ $errors->first("plantel_inventario_id") }}</span>
                            @endif
                        </div>
                    @permission('inventarioLevantamientos.cambioEstatus')
                    <div class="form-group col-md-4 @if($errors->has('inventario_levantamiento_st_id')) has-error @endif">
                            <label for="inventario_levantamiento_st_id-field">Estatus</label>
                            {!! Form::select("inventario_levantamiento_st_id", $list['InventarioLevantamientoSt'], null, array("class" => "form-control select_seguridad", "id" => "inventario_levantamiento_st_id-field")) !!}
                            @if($errors->has("inventario_levantamiento_st_id"))
                            <span class="help-block">{{ $errors->first("inventario_levantamiento_st_id") }}</span>
                            @endif
                        </div>
                    @endpermission