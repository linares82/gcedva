
                    <div class="form-group col-md-4 @if($errors->has('fecha_operacion')) has-error @endif">
                       <label for="fecha_operacion-field">Fecha Operacion</label>
                       {!! Form::hidden("factura_g_id", $factura_g, array("class" => "form-control ", "id" => "fcatura_g_id-field")) !!}
                       {!! Form::text("fecha_operacion", null, array("class" => "form-control fecha", "id" => "fecha_operacion-field")) !!}
                       @if($errors->has("fecha_operacion"))
                        <span class="help-block">{{ $errors->first("fecha_operacion") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('concepto')) has-error @endif">
                       <label for="concepto-field">Concepto</label>
                       {!! Form::text("concepto", null, array("class" => "form-control", "id" => "concepto-field")) !!}
                       @if($errors->has("concepto"))
                        <span class="help-block">{{ $errors->first("concepto") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('referencia')) has-error @endif">
                       <label for="referencia-field">Referencia</label>
                       {!! Form::text("referencia", null, array("class" => "form-control", "id" => "referencia-field")) !!}
                       @if($errors->has("referencia"))
                        <span class="help-block">{{ $errors->first("referencia") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('referencia_ampliada')) has-error @endif">
                       <label for="referencia_ampliada-field">Referencia Ampliada</label>
                       {!! Form::text("referencia_ampliada", null, array("class" => "form-control", "id" => "referencia_ampliada-field")) !!}
                       @if($errors->has("referencia_ampliada"))
                        <span class="help-block">{{ $errors->first("referencia_ampliada") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('cargo')) has-error @endif">
                       <label for="cargo-field">Cargo </label>
                       {!! Form::text("cargo", 0, array("class" => "form-control", "id" => "cargo-field")) !!}
                       @if($errors->has("cargo"))
                        <span class="help-block">{{ $errors->first("cargo") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('abono')) has-error @endif">
                       <label for="abono-field">Abono</label>
                       {!! Form::text("abono", 0, array("class" => "form-control", "id" => "abono-field")) !!}
                       @if($errors->has("abono"))
                        <span class="help-block">{{ $errors->first("abono") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('saldo')) has-error @endif">
                       <label for="saldo-field">Saldo</label>
                       {!! Form::text("saldo", 0, array("class" => "form-control", "id" => "saldo-field")) !!}
                       @if($errors->has("saldo"))
                        <span class="help-block">{{ $errors->first("saldo") }}</span>
                       @endif
                    </div>
                    