                <div class="form-group col-md-4 @if($errors->has('orden')) has-error @endif">
                       <label for="orden-field">Orden</label>
                       {!! Form::text("orden", null, array("class" => "form-control", "id" => "orden-field")) !!}
                       @if($errors->has("orden"))
                        <span class="help-block">{{ $errors->first("orden") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('dias_despues')) has-error @endif">
                       <label for="dias_despues-field">Dias Despues</label>
                       {!! Form::text("dias_despues", null, array("class" => "form-control", "id" => "dias_despues-field")) !!}
                       @if($errors->has("dias_despues"))
                        <span class="help-block">{{ $errors->first("dias_despues") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('asunto_id')) has-error @endif">
                       <label for="asunto_id-field">Asunto</label>
                       {!! Form::select("asunto_id", $list["Asunto"], null, array("class" => "form-control select_seguridad", "id" => "asunto_id-field")) !!}
                       @if($errors->has("asunto_id"))
                        <span class="help-block">{{ $errors->first("asunto_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('detalle')) has-error @endif" style="clear:left;">
                       <label for="detalle-field">Detalle</label>
                       {!! Form::textArea("detalle", null, array("class" => "form-control", "id" => "detalle-field", 'rows'=>'3')) !!}
                       @if($errors->has("detalle"))
                        <span class="help-block">{{ $errors->first("detalle") }}</span>
                       @endif
                    </div>
                    
                    