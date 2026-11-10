                
                    <div class="form-group col-md-4 @if($errors->has('caja_id')) has-error @endif">
                       <label for="caja_id-field">Caja: </label>{{isset($devolucionesCaja) ? $devolucionesCaja->caja->consecutivo : $caja->consecutivo}}
                       {!! Form::hidden("caja_id", isset($devolucionesCaja) ? $devolucionesCaja->caja_id : $caja->id, array("class" => "form-control", "id" => "caja_id-field")) !!}
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('plantel_id')) has-error @endif">
                       <label for="plantel_id-field">Plantel: </label> {{ isset($devolucionesCaja) ? $devolucionesCaja->plantel->razon : $caja->plantel->razon }}
                       {!! Form::hidden("plantel_id", isset($devolucionesCaja) ? $devolucionesCaja->plantel_id : $caja->plantel_id, array("class" => "form-control", "id" => "plantel_id-field")) !!}
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('cliente_id')) has-error @endif">
                       <label for="cliente_id-field">Cliente: </label>{{ isset($devolucionesCaja) ? $devolucionesCaja->cliente->id : $caja->cliente->id }} - {{ isset($devolucionesCaja) ? $devolucionesCaja->cliente->nombre : $caja->cliente->nombre }}
                       {{ isset($devolucionesCaja) ? $devolucionesCaja->cliente->nombre2 : $caja->cliente->nombre2 }} {{ isset($devolucionesCaja) ? $devolucionesCaja->cliente->ape_paterno : $caja->cliente->ape_paterno }} {{ isset($devolucionesCaja) ? $devolucionesCaja->cliente->ape_materno : $caja->cliente->ape_materno }}
                       {!! Form::hidden("cliente_id", isset($devolucionesCaja) ? $devolucionesCaja->cliente_id : $caja->cliente_id, array("class" => "form-control", "id" => "cliente_id-field")) !!}
                    </div>
                    
                    <div class="form-group col-md-4 @if($errors->has('grado_id')) has-error @endif">
                       <label for="grado_id-field">Grado: </label> {{ isset($devolucionesCaja) ? $devolucionesCaja->cliente->combinacionCliente->grado->seccion : $caja->cliente->combinacionCliente->grado->seccion }} - {{ isset($devolucionesCaja) ? $devolucionesCaja->cliente->combinacionCliente->grado->name : $caja->cliente->combinacionCliente->grado->name }}
                       {!! Form::hidden("grado_id", isset($devolucionesCaja) ? $devolucionesCaja->grado_id : $caja->cliente->combinacionCliente->grado_id, array("class" => "form-control", "id" => "grado_id-field")) !!}
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('caja_concepto_id')) has-error @endif">
                       <label for="caja_concepto_id-field">Concepto: </label> {{ isset($devolucionesCaja) ? $devolucionesCaja->cajaConcepto->name : $caja->cajaLn->cajaConcepto->name }}
                       {!! Form::hidden("caja_concepto_id", isset($devolucionesCaja) ? $devolucionesCaja->caja_concepto_id : $caja->cajaLn->caja_concepto_id, array("class" => "form-control", "id" => "caja_concepto_id-field")) !!}
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('monto')) has-error @endif">
                       <label for="monto-field">Monto</label>
                       {!! Form::text("monto", isset($devolucionesCaja) ? $devolucionesCaja->monto : $caja->total, array("class" => "form-control", "id" => "monto-field")) !!}
                       @if($errors->has("monto"))
                        <span class="help-block">{{ $errors->first("monto") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('motivos_dev_caja_id')) has-error @endif">
                       <label for="motivos_dev_caja_id-field">Motivo</label>
                       {!! Form::select("motivos_dev_caja_id", $list["MotivosDevCaja"], null, array("class" => "form-control", "id" => "motivos_dev_caja_id-field")) !!}
                       @if($errors->has("motivos_dev_caja_id"))
                        <span class="help-block">{{ $errors->first("motivos_dev_caja_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('vobo')) has-error @endif">
                       <label for="vobo-field">Vobo</label>
                       {!! Form::text("vobo", null, array("class" => "form-control", "id" => "vobo-field")) !!}
                       @if($errors->has("vobo"))
                        <span class="help-block">{{ $errors->first("vobo") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('obs')) has-error @endif">
                       <label for="obs-field">Obs</label>
                       {!! Form::text("obs", null, array("class" => "form-control", "id" => "obs-field")) !!}
                       @if($errors->has("obs"))
                        <span class="help-block">{{ $errors->first("obs") }}</span>
                       @endif
                    </div>
                    