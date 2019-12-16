                    <div class="form-group col-md-4 @if($errors->has('plantel_id')) has-error @endif">
                    <label for="plantel_id-field">Plantel</label>
                    {!! Form::select("plantel_id", $list["Plantel"], null, array("class" => "form-control select_seguridad", "id" => "plantel_id-field", 'readonly'=>'readonly')) !!}
                    @if($errors->has("plantel_id"))
                        <span class="help-block">{{ $errors->first("plantel_id") }}</span>
                    @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('fecha')) has-error @endif">
                       <label for="fecha-field">Fecha</label>
                       {!! Form::text("fecha", null, array("class" => "form-control", "id" => "fecha-field")) !!}
                       @if($errors->has("fecha"))
                        <span class="help-block">{{ $errors->first("fecha") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('egresos_concepto_id')) has-error @endif">
                       <label for="egresos_concepto_id-field">Egreso Concepto</label>
                       {!! Form::select("egresos_concepto_id", $list["EgresosConcepto"], null, array("class" => "form-control select_seguridad", "id" => "egresos_concepto_id-field")) !!}
                       @if($errors->has("egresos_concepto_id"))
                        <span class="help-block">{{ $errors->first("egresos_concepto_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('detalle')) has-error @endif" style='clear:left;'>
                       <label for="detalle-field">Detalle</label>
                       {!! Form::text("detalle", null, array("class" => "form-control", "id" => "detalle-field")) !!}
                       @if($errors->has("detalle"))
                        <span class="help-block">{{ $errors->first("detalle") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('forma_pago_id')) has-error @endif">
                       <label for="forma_pago_id-field">Forma Pago</label>
                       {!! Form::select("forma_pago_id", $list["FormaPago"], null, array("class" => "form-control select_seguridad", "id" => "forma_pago_id-field")) !!}
                       @if($errors->has("forma_pago_id"))
                        <span class="help-block">{{ $errors->first("forma_pago_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('cuentas_efectivo_id')) has-error @endif">
                       <label for="cuentas_efectivo_id-field">Cuenta Efectivo</label>
                       {!! Form::select("cuentas_efectivo_id", $list["CuentasEfectivo"], null, array("class" => "form-control select_seguridad", "id" => "cuentas_efectivo_id-field")) !!}
                       Saldo Actualizado:<div id="origen"></div>
                       @if($errors->has("cuentas_efectivo_id"))
                        <span class="help-block">{{ $errors->first("cuentas_efectivo_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('monto')) has-error @endif" style='clear:left;'>
                       <label for="monto-field">Monto</label>
                       {!! Form::text("monto", null, array("class" => "form-control", "id" => "monto-field")) !!}
                       @if($errors->has("monto"))
                        <span class="help-block">{{ $errors->first("monto") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('empleado_id')) has-error @endif">
                       <label for="empleado_id-field">Responsable</label>
                       {!! Form::select("empleado_id", $list["Empleado"], null, array("class" => "form-control select_seguridad", "id" => "empleado_id-field")) !!}
                       @if($errors->has("empleado_id"))
                        <span class="help-block">{{ $errors->first("empleado_id") }}</span>
                       @endif
                    </div>

                    <div class="form-group col-md-4 @if($errors->has('logo')) has-error @endif">
                       <label for="comprobante-field">Comprobante</label>
                       {!! Form::text("archivo", null, array("class" => "form-control input-sm", "id" => "archivo-field", 'readonly'=>'readonly')) !!}
                       {!! Form::file('comprobante_file') !!}
                       @if (isset($egreso))
                       <img src="{!! asset('imagenes/egresos/'.$egreso->id.'/'.$egreso->archivo) !!}" alt="Logo" height="100"> </img>
                       @endif                       
                    </div>
@push('scripts')
<script type="text/javascript">
    
    $('#fecha-field').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
      });
      
      $('#plantel_id-field').change(function(){
          //alert('hola');
         $.ajax({
            type: 'GET',
                    url: '{{route("cuentasEfectivos.getCuentasPlantel")}}',
                    data: {
                    //'_token': $('input[name=_token]').val(),
                            'plantel': $('#plantel_id-field option:selected').val(),

                    },
                    beforeSend : function(){$("#loading3").show(); },
                    complete : function(){$("#loading3").hide(); },
                    success: function(data) {
                    
                        $('#cuentas_efectivo_id-field').empty();

                        $.each(data, function(i) {  
                            $('#cuentas_efectivo_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                        });
                        //$('#cuenta_efectivo_id-field').change();
                    }
            }); 
      });

      $('#cuentas_efectivo_id-field').change(function(){
            getSaldo($('#cuentas_efectivo_id-field option:selected').val(), $('#origen'));
      });

      function getSaldo(cuenta, obj){
        $.ajax({
            url: '{{ route("cuentasEfectivos.getSaldo") }}',
            type: 'GET',
            data: "cuenta=" + cuenta, 
            dataType: 'json',
            beforeSend : function(){$("#loading13").show();},
            complete : function(){$("#loading13").hide();},
            success: function(data){
                obj.html("<strong>"+data+"</strong>");

               //alert(saldo);
               if(data<=0){
                  $('.btn').attr("disabled", true);
                  alert('No es posible realizar esta operacion, revise saldos');
               }
            }
        });
    }
      
</script>
@endpush
                    