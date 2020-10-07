                <div class="form-group col-md-12 @if($errors->has('solicitud')) has-error @endif">
                       <label for="solicitud-field">Solicitud</label>
                       {!! Form::text("solicitud", null, array("class" => "form-control", "id" => "solicitud-field")) !!}
                       @if($errors->has("solicitud"))
                        <span class="help-block">{{ $errors->first("solicitud") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('tipo_beca_id')) has-error @endif">
                     <label for="tipo_beca_id-field">Tipo Beca:</label>
                     {!! Form::select("tipo_beca_id", $tipo_becas, null, array("class" => "form-control select_seguridad", "id" => "tipo_beca_id-field")) !!}
                     @if($errors->has("tipo_beca_id"))
                      <span class="help-block">{{ $errors->first("tipo_beca_id") }}</span>
                     @endif
                  </div>
                  <div class="form-group col-md-4 @if($errors->has('motivo_beca_id')) has-error @endif">
                     <label for="motivo_beca_id-field">Motivo:</label>
                     {!! Form::select("motivo_beca_id", $list['MotivoBeca'], null, array("class" => "form-control select_seguridad", "id" => "motivo_beca_id-field")) !!}
                     @if($errors->has("motivo_beca_id"))
                      <span class="help-block">{{ $errors->first("motivo_beca_id") }}</span>
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
                    <div class="form-group col-md-4 @if($errors->has('lectivo_id')) has-error @endif">
                     <label for="lectivo_id-field">Lectivo:</label>
                     {!! Form::select("lectivo_id", $lectivos, null, array("class" => "form-control select_seguridad", "id" => "lectivo_id-field")) !!}
                     @if($errors->has("lectivo_id"))
                      <span class="help-block">{{ $errors->first("lectivo_id") }}</span>
                     @endif
                  </div>
                    
                    <div class="form-group col-md-4 @if($errors->has('monto_mensualidad')) has-error @endif">
                       <label for="monto_mensualidad-field">Porcentaje Beca (formato decimal 0.00)</label>
                       @if(isset($autorizacionBeca) and $autorizacionBeca->st_beca_id==4)
                       {!! Form::text("monto_mensualidad", null, array("class" => "form-control", "id" => "monto_mensualidad-field",'readonly'=>true)) !!}
                       @else
                       {!! Form::text("monto_mensualidad", null, array("class" => "form-control", "id" => "monto_mensualidad-field")) !!}
                       @endif
                       @if($errors->has("monto_mensualidad"))
                        <span class="help-block">{{ $errors->first("monto_mensualidad") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('mensualidad_sep')) has-error @endif">
                        <label for="mensualidad_sep-field">SEP (formato decimal 0.00)</label>
                        {!! Form::text("mensualidad_sep", $monto_sep, array("class" => "form-control", "id" => "mensualidad_sep-field")) !!}
                        @if($errors->has("mensualidad_sep"))
                           <span class="help-block">{{ $errors->first("mensualidad_sep") }}</span>
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
                    