                <div class="form-group @if($errors->has('conciliacion_multipago_id')) has-error @endif">
                       <label for="conciliacion_multipago_id-field">Conciliacion_multipago_id</label>
                       {!! Form::text("conciliacion_multipago_id", null, array("class" => "form-control", "id" => "conciliacion_multipago_id-field")) !!}
                       @if($errors->has("conciliacion_multipago_id"))
                        <span class="help-block">{{ $errors->first("conciliacion_multipago_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('fecha_pago')) has-error @endif">
                       <label for="fecha_pago-field">Fecha_pago</label>
                       {!! Form::text("fecha_pago", null, array("class" => "form-control", "id" => "fecha_pago-field")) !!}
                       @if($errors->has("fecha_pago"))
                        <span class="help-block">{{ $errors->first("fecha_pago") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('razon_social')) has-error @endif">
                       <label for="razon_social-field">Razon_social</label>
                       {!! Form::text("razon_social", null, array("class" => "form-control", "id" => "razon_social-field")) !!}
                       @if($errors->has("razon_social"))
                        <span class="help-block">{{ $errors->first("razon_social") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('mp_node')) has-error @endif">
                       <label for="mp_node-field">Mp_node</label>
                       {!! Form::text("mp_node", null, array("class" => "form-control", "id" => "mp_node-field")) !!}
                       @if($errors->has("mp_node"))
                        <span class="help-block">{{ $errors->first("mp_node") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('mp_concept')) has-error @endif">
                       <label for="mp_concept-field">Mp_concept</label>
                       {!! Form::text("mp_concept", null, array("class" => "form-control", "id" => "mp_concept-field")) !!}
                       @if($errors->has("mp_concept"))
                        <span class="help-block">{{ $errors->first("mp_concept") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('mp_paymentmethod')) has-error @endif">
                       <label for="mp_paymentmethod-field">Mp_paymentmethod</label>
                       {!! Form::text("mp_paymentmethod", null, array("class" => "form-control", "id" => "mp_paymentmethod-field")) !!}
                       @if($errors->has("mp_paymentmethod"))
                        <span class="help-block">{{ $errors->first("mp_paymentmethod") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('mp_reference')) has-error @endif">
                       <label for="mp_reference-field">Mp_reference</label>
                       {!! Form::text("mp_reference", null, array("class" => "form-control", "id" => "mp_reference-field")) !!}
                       @if($errors->has("mp_reference"))
                        <span class="help-block">{{ $errors->first("mp_reference") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('mp_order')) has-error @endif">
                       <label for="mp_order-field">Mp_order</label>
                       {!! Form::text("mp_order", null, array("class" => "form-control", "id" => "mp_order-field")) !!}
                       @if($errors->has("mp_order"))
                        <span class="help-block">{{ $errors->first("mp_order") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('no_aprobacion')) has-error @endif">
                       <label for="no_aprobacion-field">No_aprobacion</label>
                       {!! Form::text("no_aprobacion", null, array("class" => "form-control", "id" => "no_aprobacion-field")) !!}
                       @if($errors->has("no_aprobacion"))
                        <span class="help-block">{{ $errors->first("no_aprobacion") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('identificador_venta')) has-error @endif">
                       <label for="identificador_venta-field">Identificador_venta</label>
                       {!! Form::text("identificador_venta", null, array("class" => "form-control", "id" => "identificador_venta-field")) !!}
                       @if($errors->has("identificador_venta"))
                        <span class="help-block">{{ $errors->first("identificador_venta") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('ref_medio_pago')) has-error @endif">
                       <label for="ref_medio_pago-field">Ref_medio_pago</label>
                       {!! Form::text("ref_medio_pago", null, array("class" => "form-control", "id" => "ref_medio_pago-field")) !!}
                       @if($errors->has("ref_medio_pago"))
                        <span class="help-block">{{ $errors->first("ref_medio_pago") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('comicion')) has-error @endif">
                       <label for="comicion-field">Comicion</label>
                       {!! Form::text("comicion", null, array("class" => "form-control", "id" => "comicion-field")) !!}
                       @if($errors->has("comicion"))
                        <span class="help-block">{{ $errors->first("comicion") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('iva_comision')) has-error @endif">
                       <label for="iva_comision-field">Iva_comision</label>
                       {!! Form::text("iva_comision", null, array("class" => "form-control", "id" => "iva_comision-field")) !!}
                       @if($errors->has("iva_comision"))
                        <span class="help-block">{{ $errors->first("iva_comision") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('fecha_dispersion')) has-error @endif">
                       <label for="fecha_dispersion-field">Fecha_dispersion</label>
                       {!! Form::text("fecha_dispersion", null, array("class" => "form-control", "id" => "fecha_dispersion-field")) !!}
                       @if($errors->has("fecha_dispersion"))
                        <span class="help-block">{{ $errors->first("fecha_dispersion") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('periodo_financiamiento')) has-error @endif">
                       <label for="periodo_financiamiento-field">Periodo_financiamiento</label>
                       {!! Form::text("periodo_financiamiento", null, array("class" => "form-control", "id" => "periodo_financiamiento-field")) !!}
                       @if($errors->has("periodo_financiamiento"))
                        <span class="help-block">{{ $errors->first("periodo_financiamiento") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('moneda')) has-error @endif">
                       <label for="moneda-field">Moneda</label>
                       {!! Form::text("moneda", null, array("class" => "form-control", "id" => "moneda-field")) !!}
                       @if($errors->has("moneda"))
                        <span class="help-block">{{ $errors->first("moneda") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('banco_emisor')) has-error @endif">
                       <label for="banco_emisor-field">Banco_emisor</label>
                       {!! Form::text("banco_emisor", null, array("class" => "form-control", "id" => "banco_emisor-field")) !!}
                       @if($errors->has("banco_emisor"))
                        <span class="help-block">{{ $errors->first("banco_emisor") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('mp_customername')) has-error @endif">
                       <label for="mp_customername-field">Mp_customername</label>
                       {!! Form::text("mp_customername", null, array("class" => "form-control", "id" => "mp_customername-field")) !!}
                       @if($errors->has("mp_customername"))
                        <span class="help-block">{{ $errors->first("mp_customername") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('mail')) has-error @endif">
                       <label for="mail-field">Mail</label>
                       {!! Form::text("mail", null, array("class" => "form-control", "id" => "mail-field")) !!}
                       @if($errors->has("mail"))
                        <span class="help-block">{{ $errors->first("mail") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('tel_customername')) has-error @endif">
                       <label for="tel_customername-field">Tel_customername</label>
                       {!! Form::text("tel_customername", null, array("class" => "form-control", "id" => "tel_customername-field")) !!}
                       @if($errors->has("tel_customername"))
                        <span class="help-block">{{ $errors->first("tel_customername") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('usu_alta_id')) has-error @endif">
                       <label for="usu_alta_id-field">Usu_alta_id</label>
                       {!! Form::text("usu_alta_id", null, array("class" => "form-control", "id" => "usu_alta_id-field")) !!}
                       @if($errors->has("usu_alta_id"))
                        <span class="help-block">{{ $errors->first("usu_alta_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('usu_mod_id')) has-error @endif">
                       <label for="usu_mod_id-field">Usu_mod_id</label>
                       {!! Form::text("usu_mod_id", null, array("class" => "form-control", "id" => "usu_mod_id-field")) !!}
                       @if($errors->has("usu_mod_id"))
                        <span class="help-block">{{ $errors->first("usu_mod_id") }}</span>
                       @endif
                    </div>