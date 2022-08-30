                <div class="form-group col-md-4 @if($errors->has('fecha')) has-error @endif">
                       <label for="fecha-field">Fecha</label>
                       {!! Form::text("fecha", null, array("class" => "form-control fecha", "id" => "fecha-field")) !!}
                       @if($errors->has("fecha"))
                        <span class="help-block">{{ $errors->first("fecha") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('inventario_levantamiento_st_id')) has-error @endif">
                            <label for="inventario_levantamiento_st_id-field">Estatus</label>
                            {!! Form::select("inventario_levantamiento_st_id", $list['InventarioLevantamientoSt'], null, array("class" => "form-control select_seguridad", "id" => "inventario_levantamiento_st_id-field")) !!}
                            @if($errors->has("inventario_levantamiento_st_id"))
                            <span class="help-block">{{ $errors->first("inventario_levantamiento_st_id") }}</span>
                            @endif
                        </div>
                    