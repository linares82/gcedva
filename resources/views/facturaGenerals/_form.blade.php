                <div class="form-group col-md-4 @if($errors->has('plantel_id')) has-error @endif">
                       <label for="plantel_id-field">Plantel</label>
                       {!! Form::select("plantel_id", $list["Plantel"], null, array("class" => "form-control select_seguridad", "id" => "plantel_id-field")) !!}
                       @if($errors->has("plantel_id"))
                        <span class="help-block">{{ $errors->first("plantel_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('fecha_factura')) has-error @endif">
                     <label for="fecha_factura-field">F. factura (formato aaaa-mm-dd hh:mm:ss)</label>
                     {!! Form::text("fecha_factura", null, array("class" => "form-control", "id" => "fecha_factura-field")) !!}
                     @if($errors->has("fecha_factura"))
                      <span class="help-block">{{ $errors->first("fecha_factura") }}</span>
                     @endif
                  </div>
                    <div class="form-group col-md-4 @if($errors->has('fec_inicio')) has-error @endif">
                       <label for="fec_inicio-field">F. Inicio</label>
                       {!! Form::text("fec_inicio", null, array("class" => "form-control fecha", "id" => "fec_inicio-field")) !!}
                       @if($errors->has("fec_inicio"))
                        <span class="help-block">{{ $errors->first("fec_inicio") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('fec_fin')) has-error @endif">
                       <label for="fec_fin-field">F. Fin</label>
                       {!! Form::text("fec_fin", null, array("class" => "form-control fecha", "id" => "fec_fin-field")) !!}
                       @if($errors->has("fec_fin"))
                        <span class="help-block">{{ $errors->first("fec_fin") }}</span>
                       @endif
                    </div>
                    