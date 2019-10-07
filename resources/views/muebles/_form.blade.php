                <div class="form-group col-md-4 @if($errors->has('plantel_id')) has-error @endif">
                       <label for="plantel_id-field">Plantel</label>
                       {!! Form::select("plantel_id", $list["Plantel"], null, array("class" => "form-control select_seguridad", "id" => "plantel_id-field")) !!}
                       <div id='loading1' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                       @if($errors->has("plantel_id"))
                        <span class="help-block">{{ $errors->first("plantel_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('articulo_id')) has-error @endif">
                       <label for="articulo_id-field">Articulo</label>
                       {!! Form::select("articulo_id", $articulos, null, array("class" => "form-control select_seguridad", "id" => "articulo_id-field")) !!}
                       @if($errors->has("articulo_id"))
                        <span class="help-block">{{ $errors->first("articulo_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('costo')) has-error @endif">
                       <label for="costo-field">Costo Referencia</label>
                       {!! Form::text("costo", null, array("class" => "form-control", "id" => "costo-field")) !!}
                       @if($errors->has("costo"))
                        <span class="help-block">{{ $errors->first("costo") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('fecha_alta')) has-error @endif">
                       <label for="fecha_alta-field">Fecha Alta</label>
                       {!! Form::text("fecha_alta", null, array("class" => "form-control", "id" => "fecha_alta-field")) !!}
                       @if($errors->has("fecha_alta"))
                        <span class="help-block">{{ $errors->first("fecha_alta") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('ubicacion_art_id')) has-error @endif">
                       <label for="ubicacion_art_id-field">Ubicacion</label>
                       {!! Form::select("ubicacion_art_id", $list["UbicacionArt"], null, array("class" => "form-control select_seguridad", "id" => "ubicacion_art_id-field")) !!}
                       @if($errors->has("ubicacion_art_id"))
                        <span class="help-block">{{ $errors->first("ubicacion_art_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('empleado_id')) has-error @endif">
                       <label for="empleado_id-field">Responsable</label>
                       {!! Form::select("empleado_id", $list["Empleado"], null, array("class" => "form-control select_seguridad", "id" => "empleado_id-field")) !!}
                       @if($errors->has("empleado_id"))
                        <span class="help-block">{{ $errors->first("empleado_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('marca')) has-error @endif">
                       <label for="marca-field">Marca</label>
                       {!! Form::text("marca", null, array("class" => "form-control", "id" => "marca-field")) !!}
                       @if($errors->has("marca"))
                        <span class="help-block">{{ $errors->first("marca") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('modelo')) has-error @endif">
                       <label for="modelo-field">Modelo</label>
                       {!! Form::text("modelo", null, array("class" => "form-control", "id" => "modelo-field")) !!}
                       @if($errors->has("modelo"))
                        <span class="help-block">{{ $errors->first("modelo") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('no_serie')) has-error @endif">
                       <label for="no_serie-field">No. Serie</label>
                       {!! Form::text("no_serie", null, array("class" => "form-control", "id" => "no_serie-field")) !!}
                       @if($errors->has("no_serie"))
                        <span class="help-block">{{ $errors->first("no_serie") }}</span>
                       @endif
                    </div>
                    
                    <div class="form-group col-md-4 @if($errors->has('st_mueble_id')) has-error @endif">
                       <label for="st_mueble_id-field">Estatus</label>
                       {!! Form::select("st_mueble_id", $list["StMueble"], null, array("class" => "form-control select_seguridad", "id" => "st_mueble_id-field")) !!}
                       @if($errors->has("st_mueble_id"))
                        <span class="help-block">{{ $errors->first("st_mueble_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('st_mueble_uso_id')) has-error @endif">
                       <label for="st_mueble_uso_id-field">Estatus Uso</label>
                       {!! Form::select("st_mueble_uso_id", $list["StMuebleUso"], null, array("class" => "form-control select_seguridad", "id" => "st_mueble_uso_id-field")) !!}
                       @if($errors->has("st_mueble_uso_id"))
                        <span class="help-block">{{ $errors->first("st_mueble_uso_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('no_inv')) has-error @endif">
                       <label for="no_inv-field">No. Inventario</label>
                       {!! Form::text("no_inv", null, array("class" => "form-control", "id" => "no_inv-field", 'readonly'=>true)) !!}
                       @if($errors->has("no_inv"))
                        <span class="help-block">{{ $errors->first("no_inv") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('observaciones')) has-error @endif">
                       <label for="observaciones-field">Observaciones</label>
                       {!! Form::text("observaciones", null, array("class" => "form-control", "id" => "observaciones-field")) !!}
                       @if($errors->has("observaciones"))
                        <span class="help-block">{{ $errors->first("observaciones") }}</span>
                       @endif
                    </div>
@push('scripts')
<script>
   $('#fecha_alta-field').Zebra_DatePicker({
      days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
               months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
               readonly_element: false,
               lang_clear_date: 'Limpiar',
               show_select_today: 'Hoy',
      });

   $(document).ready(function(){
      
      getUbicaciones();
      $('#plantel_id-field').change(function(){
         getUbicaciones();
         
      });
      getEmpleados();
      $('#plantel_id-field').change(function(){
         getEmpleados();
      });
   }) ;  
   function getEmpleados(){
      $.ajax({
                url: '{{ route("empleados.getEmpleadosXplantel") }}',
                type: 'GET',
                data: {
                   'empleado_id':$('#empleado_id-field option:selected').val(),
                   'plantel_id':$('#plantel_id-field option:selected').val()
                },
                dataType: 'json',
                beforeSend : function(){$("#loading1").show();},
                complete : function(){$("#loading1").hide();},
                success: function(data){
                   
                      $('#empleado_id-field').html('');
                      $('#empleado_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                      
                      $.each(data, function(i) {
                          $('#empleado_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].nombre+"<\/option>");
                      });
                      
                }
            });
   }
   function getUbicaciones(){
      $.ajax({
                url: '{{ route("ubicacionArts.getUbicacionesXPlantel") }}',
                type: 'GET',
                data: {
                   'plantel':$('#plantel_id-field option:selected').val(),
                   'ubicacion':$('#ubicacion_art_id-field option:selected').val()
                },
                dataType: 'json',
                beforeSend : function(){$("#loading1").show();},
                complete : function(){$("#loading1").hide();},
                success: function(data){
                   console.log(data);
                      $('#ubicacion_art_id-field').html('');
                      
                      $('#ubicacion_art_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                      
                      $.each(data, function(i) {
                          $('#ubicacion_art_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                      });
                      
                }
            });
   }
</script>

@endpush
