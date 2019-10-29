                    <div class="form-group col-md-4 @if($errors->has('plantel_id')) has-error @endif">
                       <label for="plantel_id-field">Plantel Origen</label>
                       {!! Form::select("plantel_id", $plantels, null, array("class" => "form-control select_seguridad", "id" => "plantel_id-field")) !!}
                       @if($errors->has("plantel_id"))
                        <span class="help-block">{{ $errors->first("plantel_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('origen_id')) has-error @endif">
                       <label for="origen_id-field">Origen</label>
                       {!! Form::select("origen_id", $cuentasEfectivo, null, array("class" => "form-control select_seguridad", "id" => "origen_id-field")) !!}
                       Saldo Actualizado:<div id="origen"></div>
                       @if($errors->has("origen_id"))
                        <span class="help-block">{{ $errors->first("origen_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('plantel_destino_id')) has-error @endif">
                       <label for="plantel_destino_id-field">Plantel Destino</label>
                       {!! Form::select("plantel_destino_id", $plantels, null, array("class" => "form-control select_seguridad", "id" => "plantel_destino_id-field")) !!}
                       @if($errors->has("plantel_destino_id"))
                        <span class="help-block">{{ $errors->first("plantel_destino_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('destino_id')) has-error @endif">
                       <label for="destino_id-field">Destino</label>
                       {!! Form::select("destino_id", $cuentasEfectivo, null, array("class" => "form-control select_seguridad", "id" => "destino_id-field")) !!}
                       Saldo Actualizado:<div id="destino"></div>
                       @if($errors->has("destino_id"))
                        <span class="help-block">{{ $errors->first("destino_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('monto')) has-error @endif">
                       <label for="monto-field">Monto</label>
                       {!! Form::text("monto", null, array("class" => "form-control", "id" => "monto-field")) !!}
                       
                       @if($errors->has("monto"))
                        <span class="help-block">{{ $errors->first("monto") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('fecha')) has-error @endif">
                       <label for="fecha-field">Fecha</label>
                       {!! Form::text("fecha", null, array("class" => "form-control", "id" => "fecha-field")) !!}
                       @if($errors->has("fecha"))
                        <span class="help-block">{{ $errors->first("fecha") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('responsable_id')) has-error @endif">
                       <label for="responsable_id-field">Responsable</label>
                       {!! Form::select("responsable_id", $empleados, null, array("class" => "form-control select_seguridad", "id" => "responsable_id-field")) !!}
                       @if($errors->has("responsable_id"))
                        <span class="help-block">{{ $errors->first("responsable_id") }}</span>
                       @endif
                    </div>
                    
                    <div class="form-group col-md-12 @if($errors->has('motivo')) has-error @endif" style="clear:left;">
                       <label for="motivo-field">Motivo</label>
                       {!! Form::text("motivo", null, array("class" => "form-control", "id" => "motivo-field")) !!}
                       @if($errors->has("motivo"))
                        <span class="help-block">{{ $errors->first("motivo") }}</span>
                       @endif
                    </div>
@push('scripts')
<script type="text/javascript">
    /*window.onbeforeunload=finalizar();
            function finalizar(){
                window.opener.location.reload();
            }*/
    $('#fecha-field').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
      });
    
    
    
    $('#origen_id-field').change(function(){
         getSaldo($('#origen_id-field option:selected').val(), $('#origen'));
    });
    
    $('#destino_id-field').change(function(){
         
         getSaldo($('#destino_id-field option:selected').val(), $('#destino'));
         
    });
    
    $('#monto-field').change(function(){
         o=$('#origen').text();
         d=$('#destino').text();
         m=$('#monto-field').val();
         saldo=parseFloat(o)-parseFloat(m);
         //alert(saldo);
         if(saldo<0){
             $('.btn').attr("disabled", true);
             alert('No es posible realizar esta operacion, revise saldos');
         }else{
             $('.btn').attr("disabled", false);
         }
         
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
            }
        });
    }
    
$('#plantel_id-field').change(function(){
    $.ajax({
    type: 'GET',
            url: '{{route("cuentasEfectivos.getCuentasPlantel")}}',
            data: {
            //'_token': $('input[name=_token]').val(),
                    'plantel': $('#plantel_id-field').val(),    
            },
            beforeSend : function(){$("#loading3").show(); },
            complete : function(){$("#loading3").hide(); },
            success: function(data) {
            
            //$example.select2("destroy");
                $('#origen_id-field').empty();

                //$('#especialidad_id-field').empty();
                $('#origen_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                //alert(data);
                
                $.each(data, function(i) {  
                    //alert(data[i].name);
                    $('#origen_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                });
                //$('#cuenta_efectivo_id-field').change();
            }
    });
});

$('#plantel_destino_id-field').change(function(){
    $.ajax({
    type: 'GET',
            url: '{{route("cuentasEfectivos.getCuentasPlantel")}}',
            data: {
            //'_token': $('input[name=_token]').val(),
                    'plantel': $('#plantel_destino_id-field').val(),    
            },
            beforeSend : function(){$("#loading3").show(); },
            complete : function(){$("#loading3").hide(); },
            success: function(data) {
            
            //$example.select2("destroy");
                $('#destino_id-field').empty();

                //$('#especialidad_id-field').empty();
                $('#destino_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                //alert(data);
                
                $.each(data, function(i) {  
                    //alert(data[i].name);
                    $('#destino_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                });
                //$('#cuenta_efectivo_id-field').change();
            }
    });
});
</script>
@endpush                    