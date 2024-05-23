                     <div class="form-group col-md-6 @if($errors->has('plantel_inventario_id')) has-error @endif">
                       <label for="plantel_inventario_id-field" class='col-md-3'>Plantel</label>
                       {!! Form::text("plantel_inventario_id", isset($cabecera) ? $cabecera->plantel_inventario_id : null, array("class" => "form-control", "id" => "plantel_inventario_id-field", 'readonly'=>true, 'class'=>'col-md-3')) !!}
                       {!! Form::select("plantel_inventario", $planteles, isset($cabecera) ? $cabecera->plantel_inventario_id : null, array("class" => "form-control", "id" => "plantel_inventario-field", 'readonly'=>true, 'class'=>'col-md-6')) !!}
                       @if($errors->has("plantel_inventario_id"))
                        <span class="help-block">{{ $errors->first("plantel_inventario_id") }}</span>
                       @endif
                    </div>

                    <div class="form-group col-md-12 @if($errors->has('observacion')) has-error @endif">
                       <label for="observacion-field">Observacion</label>
                       {!! Form::hidden("inventario_levantamiento_id", isset($inventarioLevantamiento) ? $inventarioLevantamiento : null, array("class" => "form-control", "id" => "inventario_levantamiento_id-field")) !!}
                       {!! Form::textArea("observacion", null, array("class" => "form-control", "id" => "observacion-field")) !!}
                       @if($errors->has("observacion"))
                        <span class="help-block">{{ $errors->first("observacion") }}</span>
                       @endif
                    </div>
                    