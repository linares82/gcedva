<div class="form-group col-md-4 @if($errors->has('cve_multipagos')) has-error @endif">
   <label for="cve_multipagos-field">Clave Multipagos</label>
   {!! Form::select("cve_multipagos", $listaMultipagos, isset($cajaConcepto->cve_multipagos) ? $cajaConcepto->cve_multipagos : null, array("class" => "form-control select_seguridad", "id" => "cve_multipagos-crear")) !!}
   @if($errors->has("cve_multipagos"))
    <span class="help-block">{{ $errors->first("cve_multipagos") }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if($errors->has('uso_factura')) has-error @endif">
   <label for="uso_factura-field">Uso Factura</label>
   {!! Form::text("uso_factura", null, array("class" => "form-control", "id" => "uso_factura-field")) !!}
   @if($errors->has("uso_factura"))
    <span class="help-block">{{ $errors->first("uso_factura") }}</span>
   @endif
</div> 
                     <div class="form-group col-md-4 @if($errors->has('name')) has-error @endif">
                       <label for="name-field">Concepto</label>
                       {!! Form::text("name", null, array("class" => "form-control", "id" => "name-field")) !!}
                       @if($errors->has("name"))
                        <span class="help-block">{{ $errors->first("name") }}</span>
                       @endif
                    </div>

                    <div class="form-group col-md-4 @if($errors->has('leyenda_factura')) has-error @endif">
                     <label for="leyenda_factura-field">Leyenda Factura</label>
                     {!! Form::text("leyenda_factura", null, array("class" => "form-control", "id" => "leyenda_factura-field")) !!}
                     @if($errors->has("leyenda_factura"))
                      <span class="help-block">{{ $errors->first("leyenda_factura") }}</span>
                     @endif
                  </div> 

                    <div class="form-group col-md-4 @if($errors->has('monto')) has-error @endif">
                       <label for="monto-field">Monto</label>
                       {!! Form::text("monto", null, array("class" => "form-control", "id" => "monto-field")) !!}
                       @if($errors->has("monto"))
                        <span class="help-block">{{ $errors->first("monto") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('bnd_aplicar_beca')) has-error @endif">
                       <label for="bnd_aplicar_beca-field">Aplicar Beca</label>
                       {!! Form::checkbox("bnd_aplicar_beca", 1, null, [ "id" => "bnd_aplicar_beca-field"]) !!}
                       @if($errors->has("bnd_aplicar_beca"))
                        <span class="help-block">{{ $errors->first("bnd_aplicar_beca") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('activo')) has-error @endif">
                       <label for="activo-field">Activo</label>
                       {!! Form::checkbox("activo", 1, null, [ "id" => "activo-field"]) !!}
                       @if($errors->has("activo"))
                        <span class="help-block">{{ $errors->first("activo") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('bnd_mensualidad')) has-error @endif">
                       <label for="bnd_mensualidad-field">Mensualidad</label>
                       {!! Form::checkbox("bnd_mensualidad", 1, null, [ "id" => "bnd_mensualidad-field"]) !!}
                       @if($errors->has("bnd_mensualidad"))
                        <span class="help-block">{{ $errors->first("bnd_mensualidad") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('reglas')) has-error @endif">
                     <label for="reglas-field">Reglas Descuento/Recargo</label><br/>
                     {!! Form::select("reglas[]", $reglas, null, array("class" => "form-control select_seguridad", 'multiple'=>true, "id" => "reglas-field")) !!}
                  </div>
                  