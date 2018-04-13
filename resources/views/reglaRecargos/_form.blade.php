                <div class="form-group col-md-4 @if($errors->has('name')) has-error @endif">
                       <label for="name-field">Regla recargo</label>
                       {!! Form::text("name", null, array("class" => "form-control", "id" => "name-field")) !!}
                       @if($errors->has("name"))
                        <span class="help-block">{{ $errors->first("name") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('dia_inicio')) has-error @endif">
                       <label for="dia_inicio-field">Dia inicio</label>
                       {!! Form::text("dia_inicio", null, array("class" => "form-control", "id" => "dia_inicio-field")) !!}
                       @if($errors->has("dia_inicio"))
                        <span class="help-block">{{ $errors->first("dia_inicio") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('dia_fin')) has-error @endif">
                       <label for="dia_fin-field">Dia fin</label>
                       {!! Form::text("dia_fin", null, array("class" => "form-control", "id" => "dia_fin-field")) !!}
                       @if($errors->has("dia_fin"))
                        <span class="help-block">{{ $errors->first("dia_fin") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('tipo_regla_id')) has-error @endif">
                        <label for="tipo_regla_id-field">Tipo Regla</label>
                        {!! Form::select("tipo_regla_id", $list["TipoRegla"], null, array("class" => "form-control select_seguridad", "id" => "tipo_regla_id-field")) !!}
                        @if($errors->has("tipo_regla_id"))
                        <span class="help-block">{{ $errors->first("tipo_regla_id") }}</span>
                        @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('porcentaje')) has-error @endif">
                       <label for="porcentaje-field">Porcentaje(formato 0.00)</label>
                       {!! Form::text("porcentaje", null, array("class" => "form-control", "id" => "porcentaje-field")) !!}
                       @if($errors->has("porcentaje"))
                        <span class="help-block">{{ $errors->first("porcentaje") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('monto')) has-error @endif">
                       <label for="porcentaje-field">Monto(formato 0.00)</label>
                       {!! Form::text("monto", null, array("class" => "form-control", "id" => "monto-field")) !!}
                       @if($errors->has("monto"))
                        <span class="help-block">{{ $errors->first("monto") }}</span>
                       @endif
                    </div>