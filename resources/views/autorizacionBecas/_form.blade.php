                <div class="form-group col-md-12 @if($errors->has('solicitud')) has-error @endif">
                       <label for="solicitud-field">Solicitud</label>
                       {!! Form::text("solicitud", null, array("class" => "form-control", "id" => "solicitud-field")) !!}
                       @if($errors->has("solicitud"))
                        <span class="help-block">{{ $errors->first("solicitud") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('cliente_id')) has-error @endif">
                       <label for="cliente_id-field">Cliente:</label>
                       {{$cliente->nombre." ".$cliente->nombre2." ".$cliente->ape_paterno." ".$cliente->ape_materno}}
                       {!! Form::hidden("cliente_id", $cliente->id, array("class" => "form-control", "id" => "cliente_id-field")) !!}
                       @if($errors->has("cliente_id"))
                        <span class="help-block">{{ $errors->first("cliente_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('monto_inscripcion')) has-error @endif">
                       <label for="monto_inscripcion-field">Monto Inscripcion</label>
                       {!! Form::text("monto_inscripcion", null, array("class" => "form-control", "id" => "monto_inscripcion-field")) !!}
                       @if($errors->has("monto_inscripcion"))
                        <span class="help-block">{{ $errors->first("monto_inscripcion") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('monto_mensualidad')) has-error @endif">
                       <label for="monto_mensualidad-field">Monto Mensualidad</label>
                       {!! Form::text("monto_mensualidad", null, array("class" => "form-control", "id" => "monto_mensualidad-field")) !!}
                       @if($errors->has("monto_mensualidad"))
                        <span class="help-block">{{ $errors->first("monto_mensualidad") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('file')) has-error @endif">
                       <label for="file-field">Archivo</label>
                       {!! Form::text("file", null, array("class" => "form-control input-sm", "id" => "file-field", 'readonly'=>'readonly')) !!}
                       {!! Form::file('archivo_file') !!}
                       @if($errors->has("file"))
                        <span class="help-block">{{ $errors->first("file") }}</span>
                       @endif
                    </div>
                    