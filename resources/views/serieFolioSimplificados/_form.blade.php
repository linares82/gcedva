
                    <div class="form-group col-md-4 @if($errors->has('serie')) has-error @endif">
                       <label for="serie-field">Serie</label>
                       {!! Form::text("serie", null, array("class" => "form-control", "id" => "serie-field")) !!}
                       {!! Form::hidden("cuenta_p_id", $cuentap, array("class" => "form-control", "id" => "cuenta_p_id-field")) !!}
                       @if($errors->has("serie"))
                        <span class="help-block">{{ $errors->first("serie") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('folio_inicial')) has-error @endif">
                       <label for="folio_inicial-field">Folio Inicial</label>
                       {!! Form::text("folio_inicial", null, array("class" => "form-control", "id" => "folio_inicial-field")) !!}
                       @if($errors->has("folio_inicial"))
                        <span class="help-block">{{ $errors->first("folio_inicial") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('folio_actual')) has-error @endif">
                       <label for="folio_actual-field">Folio Actual</label>
                       {!! Form::text("folio_actual", null, array("class" => "form-control", "id" => "folio_actual-field")) !!}
                       @if($errors->has("folio_actual"))
                        <span class="help-block">{{ $errors->first("folio_actual") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('anio')) has-error @endif">
                       <label for="anio-field">Año</label>
                       {!! Form::text("anio", null, array("class" => "form-control", "id" => "anio-field")) !!}
                       @if($errors->has("anio"))
                        <span class="help-block">{{ $errors->first("anio") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('mese_id')) has-error @endif">
                       <label for="mese_id-field">Mes(s)</label>
                       {!! Form::select("mese_id", $meses, null, array("class" => "form-control select_seguridad", "id" => "mese_id-field")) !!}
                       @if($errors->has("mese_id"))
                        <span class="help-block">{{ $errors->first("mese_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('bnd_activo')) has-error @endif">
                       <label for="bnd_activo-field">Activo</label>
                       {!! Form::checkbox("bnd_activo", 1, null, [ "id" => "bnd_activo-field", 'class'=>'minimal']) !!}
                       @if($errors->has("bnd_activo"))
                        <span class="help-block">{{ $errors->first("bnd_activo") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('bnd_activo')) has-error @endif">
                     <label for="bnd_activo-field">Fiscal</label>
                     {!! Form::checkbox("bnd_fiscal", 1, null, [ "id" => "bnd_fiscal-field", 'class'=>'minimal']) !!}
                     @if($errors->has("bnd_activo"))
                      <span class="help-block">{{ $errors->first("bnd_activo") }}</span>
                     @endif
                  </div>
                    