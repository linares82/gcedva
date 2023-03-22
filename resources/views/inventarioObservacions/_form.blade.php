                     <div class="form-group col-md-4 @if($errors->has('plantel_inventario_id')) has-error @endif">
                       <label for="plantel_inventario_id-field">Plantel</label>
                       {!! Form::select("plantel_inventario_id", $planteles, isset($cabecera) ? $cabecera->plantel_inventario_id : null, array("class" => "form-control", "id" => "plantel_inventario_id-field")) !!}
                       @if($errors->has("plantel_inventario_id"))
                        <span class="help-block">{{ $errors->first("plantel_inventario_id") }}</span>
                       @endif
                    </div>

                    <div class="form-group @if($errors->has('observacion')) has-error @endif">
                       <label for="observacion-field">Observacion</label>
                       {!! Form::hidden("inventario_levantamiento_id", isset($inventarioLevantamiento) ? $inventarioLevantamiento : null, array("class" => "form-control", "id" => "inventario_levantamiento_id-field")) !!}
                       {!! Form::textArea("observacion", null, array("class" => "form-control", "id" => "observacion-field")) !!}
                       @if($errors->has("observacion"))
                        <span class="help-block">{{ $errors->first("observacion") }}</span>
                       @endif
                    </div>
                    