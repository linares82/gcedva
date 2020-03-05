
                    <div class="form-group col-md-4 @if($errors->has('monto_calculado')) has-error @endif">
                       <label for="monto_calculado-field">Monto Calculado</label>
                       {!! Form::text("monto_calculado", $suma_pagos-$suma_egresos, array("class" => "form-control", "id" => "monto_calculado-field", 'readonly'=>true)) !!}
                       @if($errors->has("monto_calculado"))
                        <span class="help-block">{{ $errors->first("monto_calculado") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('monto_real')) has-error @endif">
                       <label for="monto_real-field">Monto Real</label>
                       {!! Form::text("monto_real", null, array("class" => "form-control", "id" => "monto_real-field")) !!}
                       @if($errors->has("monto_real"))
                        <span class="help-block">{{ $errors->first("monto_real") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('faltante')) has-error @endif">
                       <label for="faltante-field">Faltante</label>
                       {!! Form::text("faltante", $ultimoCorte->faltante, array("class" => "form-control", "id" => "faltante-field", 'readonly'=>true)) !!}
                       @if($errors->has("faltante"))
                        <span class="help-block">{{ $errors->first("faltante") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('sobrante')) has-error @endif">
                       <label for="sobrante-field">Sobrante</label>
                       {!! Form::text("sobrante", $ultimoCorte->sobrante, array("class" => "form-control", "id" => "sobrante-field", 'readonly'=>true)) !!}
                       @if($errors->has("sobrante"))
                        <span class="help-block">{{ $errors->first("sobrante") }}</span>
                       @endif
                    </div>
                    