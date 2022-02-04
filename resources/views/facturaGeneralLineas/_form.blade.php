
                    <div class="form-group col-md-4 @if($errors->has('cliente_id')) has-error @endif">
                       <label for="cliente_id-field">Cliente Id</label>
                       {!! Form::hidden("factura_general_id", $facturaGeneral, array("class" => "form-control", "id" => "factura_general_id-field")) !!}
                       {!! Form::text("cliente_id", null, array("class" => "form-control", "id" => "cliente_id-field")) !!}
                       @if($errors->has("cliente_id"))
                        <span class="help-block">{{ $errors->first("cliente_id") }}</span>
                       @endif
                    </div>

                    <div class="form-group col-md-4 @if($errors->has('serie_factura')) has-error @endif">
                     <label for="serie_factura-field">Serie</label>
                     {!! Form::text("serie_factura", null, array("class" => "form-control", "id" => "serie_factura-field")) !!}
                     @if($errors->has("serie_factura"))
                      <span class="help-block">{{ $errors->first("serie_factura") }}</span>
                     @endif
                  </div>

                  <div class="form-group col-md-4 @if($errors->has('folio_facturado')) has-error @endif">
                     <label for="folio_facturado-field">Folio</label>
                     {!! Form::text("folio_facturado", null, array("class" => "form-control", "id" => "folio_facturado-field")) !!}
                     @if($errors->has("folio_facturado"))
                      <span class="help-block">{{ $errors->first("folio_facturado") }}</span>
                     @endif
                  </div>

                    <div class="form-group col-md-4 @if($errors->has('monto')) has-error @endif">
                     <label for="monto-field">Monto</label>
                     {!! Form::text("monto", null, array("class" => "form-control", "id" => "monto-field")) !!}
                     @if($errors->has("monto"))
                      <span class="help-block">{{ $errors->first("monto") }}</span>
                     @endif
                  </div>
                    