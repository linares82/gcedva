
                    <div class="form-group col-md-4 col-md-4 @if($errors->has('plantel_id')) has-error @endif">
                        <label for="plantel_id-field">Plantel</label>
                        {!! Form::select("plantel_id", $list["Plantel"], null, array("class" => "form-control select_seguridad", "id" => "plantel_id-field")) !!}
                        {!! Form::hidden("puesto_id", 3, array("class" => "form-control input-sm", "id" => "puesto_id-field")) !!}
                        @if($errors->has("plantel_id"))
                         <span class="help-block">{{ $errors->first("plantel_id") }}</span>
                        @endif
                     </div>
                     
                     <div class="form-group col-md-4 @if($errors->has('empleado_id')) has-error @endif">
                        <label for="empleado_id-field">Empleado</label>
                        {!! Form::select("empleado_id", $list["Empleado"], null, array("class" => "form-control select_seguridad", "id" => "empleado_id-field")) !!}             
                        @if($errors->has("empleado_id"))
                         <span class="help-block">{{ $errors->first("empleado_id") }}</span>
                        @endif
                     </div>
                     <div class="form-group col-md-4 @if($errors->has('docente_oficial')) has-error @endif">
                        <label for="docente_oficial-field">Docente Oficial</label>
                        {!! Form::text("docente_oficial", null, array("class" => "form-control input-sm", "id" => "docente_oficial-field")) !!}
                        @if($errors->has("docente_oficial"))
                         <span class="help-block">{{ $errors->first("docente_oficial") }}</span>
                        @endif
                     </div>
                     <div class="form-group col-md-4 @if($errors->has('docente_oficial_id')) has-error @endif">
                        <label for="docente_oficial_id-field">Docente Ofical</label>
                        {!! Form::select("docente_oficial_id", $list["Empleado"], null, array("class" => "form-control select_seguridad", "id" => "docente_oficial_id-field")) !!}             
                        @if($errors->has("docente_oficial_id"))
                         <span class="help-block">{{ $errors->first("docente_oficial_id") }}</span>
                        @endif
                     </div>
                     <div class="form-group col-md-4 @if($errors->has('grupo_id')) has-error @endif">
                        <label for="grupo_id-field">Grupo</label>
                        {!! Form::select("grupo_id", $list["Grupo"], null, array("class" => "form-control select_seguridad", "id" => "grupo_id-field")) !!}
                        @if($errors->has("grupo_id"))
                         <span class="help-block">{{ $errors->first("grupo_id") }}</span>
                        @endif
                     </div>
                     <div class="form-group col-md-4 @if($errors->has('materium_id')) has-error @endif">
                        <label for="materium_id-field">Materia</label>
                        {!! Form::select("materium_id", $list["Materium"], null, array("class" => "form-control select_seguridad", "id" => "materium_id-field")) !!}
                        @if($errors->has("materium_id"))
                         <span class="help-block">{{ $errors->first("materium_id") }}</span>
                        @endif
                     </div>
                     
                     <div class="form-group col-md-4 @if($errors->has('horas')) has-error @endif">
                        <label for="horas-field">Horas</label>
                        {!! Form::text("horas", null, array("class" => "form-control input-sm", "id" => "horas-field")) !!}
                        @if($errors->has("horas"))
                         <span class="help-block">{{ $errors->first("horas") }}</span>
                        @endif
                     </div>
                     <div class="form-group col-md-4 @if($errors->has('lectivo_id')) has-error @endif">
                        <label for="lectivo_id-field">Lectivo</label>
                        {!! Form::select("lectivo_id", $list["Lectivo"], null, array("class" => "form-control select_seguridad", "id" => "lectivo_id-field")) !!}
                        @if($errors->has("lectivo_id"))
                         <span class="help-block">{{ $errors->first("lectivo_id") }}</span>
                        @endif
                     </div>
                     <div class="form-group col-md-4 @if($errors->has('lectivo_oficial_id')) has-error @endif">
                        <label for="lectivo_oficial_id-field">Lectivo Oficial</label>
                        {!! Form::select("lectivo_oficial_id", $list["Lectivo"], null, array("class" => "form-control select_seguridad", "id" => "lectivo_oficial_id-field")) !!}
                        @if($errors->has("lectivo_oficial_id"))
                         <span class="help-block">{{ $errors->first("lectivo_oficial_id") }}</span>
                        @endif
                     </div>
                     <div class="form-group col-md-4 @if($errors->has('asistencias_max')) has-error @endif" style="clear:left;">
                        <label for="asistencias_max-field">Asistencias Maximo</label>
                        {!! Form::text("asistencias_max", null, array("class" => "form-control input-sm", "id" => "asistencias_max-field")) !!}
                        @if($errors->has("asistencias_max"))
                         <span class="help-block">{{ $errors->first("asistencias_max") }}</span>
                        @endif
                     </div>
                     <div class="form-group col-md-4 @if($errors->has('fec_inicio')) has-error @endif">
                             <label for="fec_inicio-field">Fecha Inicio Planeado</label>
                             {!! Form::text("fec_inicio", null, array("class" => "form-control input-sm", "id" => "fec_inicio-field")) !!}
                             @if($errors->has("fec_inicio"))
                             <span class="help-block">{{ $errors->first("fec_inicio") }}</span>
                             @endif
                         </div>
                     <div class="form-group col-md-4 @if($errors->has('fec_fin')) has-error @endif">
                             <label for="fec_fin-field">Fecha Fin Planeado</label>
                             {!! Form::text("fec_fin", null, array("class" => "form-control input-sm", "id" => "fec_fin-field")) !!}
                             @if($errors->has("fec_fin"))
                             <span class="help-block">{{ $errors->first("fec_fin") }}</span>
                             @endif
                         </div>
                     @if(isset($asignacionAcademica->horarios))
                     <div class="form-group col-md-12">
                         <div class="form-group col-md-4 @if($errors->has('dia_id')) has-error @endif">
                         <label for="dia_id-field">Dia</label>
                         {!! Form::select("dia_id", $list1["Dium"], null, array("class" => "form-control select_seguridad", "id" => "dia_id-field")) !!}
                         @if($errors->has("dia_id"))
                             <span class="help-block">{{ $errors->first("dia_id") }}</span>
                         @endif
                         </div>
                         <div class="form-group col-md-4 @if($errors->has('hora')) has-error @endif">
                         <label for="hora-field">Hora(formato de 24hrs. hh:mm:ss)</label>
                         <div class="input-group">
                         {!! Form::text("hora", null, array("class" => "form-control timepicker", "id" => "hora-field", "onblur"=>"valida(this.value);", 'placeholder'=>'hh:mm:ss')) !!}
                         <div class="input-group-addon">
                           <i class="fa fa-clock-o"></i>
                         </div>
                         </div>
                         @if($errors->has("hora"))
                             <span class="help-block">{{ $errors->first("hora") }}</span>
                         @endif
                         </div>
                         <div class="form-group col-md-4 @if($errors->has('duracion_clase')) has-error @endif">
                         <label for="duracion_clase-field">Duracion Clase</label>
                         {!! Form::text("duracion_clase", null, array("class" => "form-control input-sm", "id" => "duracion_clase-field")) !!}
                         @if($errors->has("duracion_clase"))
                             <span class="help-block">{{ $errors->first("duracion_clase") }}</span>
                         @endif
                         </div>
                     </div>
                     
                     <div class="col-md-12">
                         <table class="table table-condensed table-striped">
                             <thead>
                                 <th>Dia</th><th>Hora</th><th>Duracion</th><th></th>
                             </thead>
                             <tbody>
                                 @foreach($asignacionAcademica->horarios as $h)
                                     <tr>
                                         <td>{{$h->dia->name}}</td>
                                         <td>{{$h->hora}}</td>
                                         <td>{{$h->duracion_clase}}</td>
                                         <td><a href="{!! route('horarios.destroy', $h->id) !!}" class="btn btn-xs btn-danger">Eliminar</a></td>
                                     </tr>
                                 @endforeach
                             </tbody>
                         </table>
                     </div>
                     @endif
 
 
 @push('scripts')
   
   
   <script type="text/javascript">
     
     $(document).ready(function() {
       
 
         getCmbInstructores();
         getCmbMaterias();
         getCmbGrupos();
       
       $('#plantel_id-field').change(function(){
           getCmbInstructores();
           getCmbGrupos();
       });
 
       $('#grupo_id-field').change(function(){
        getCmbMaterias();
       });

       $('#lectivo_id-field').change(function(){
           getDatosLectivo();
       });
       function getCmbInstructores(){
           //$('#empleado_id_field option:selected').val($('#empleado_id_campo option:selected').val()).change();
           var a= $('#formulario').serialize();
               $.ajax({
                   url: '{{ route("empleados.getEmpleadosXplantel") }}',
                   type: 'GET',
                   data: a,
                   dataType: 'json',
                   beforeSend : function(){$("#loading3").show();},
                   complete : function(){$("#loading3").hide();},
                   success: function(data){
                       //$example.select2("destroy");
                       $('#empleado_id-field').html('');
                       
                       //$('#especialidad_id-field').empty();
                       $('#empleado_id-field').append($('<option></option>').text('Seleccionar OpciÃ³n').val('0'));
                       
                       $.each(data, function(i) {
                           //alert(data[i].name);
                           $('#empleado_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].nombre+"<\/option>");
                           
                       });
                       $('#empleado_id-field').change();
                       //$example.select2();
                   }
               });       
       }
       function getCmbMaterias(){
           //var $example = $("#especialidad_id-field").select2();
           //$('#materia_id_field option:selected').val($('#materium_id_campo option:selected').val()).change();
           var a= $('#formulario').serialize();
               $.ajax({
                   url: '{{ route("materias.getCmbMateria") }}',
                   type: 'GET',
                   data: {
                       plantel_id:$('#plantel_id-field').val(),
                       grupo_id:$('#grupo_id-field').val(),
                       materium_id:$('#materium_id-field').val()
                   },
                   dataType: 'json',
                   beforeSend : function(){$("#loading10").show();},
                   complete : function(){$("#loading10").hide();},
                   success: function(data){
                       //$example.select2("destroy");
                       $('#materium_id-field').html('');
                       
                       //$('#especialidad_id-field').empty();
                       $('#materium_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                       
                       $.each(data, function(i) {
                           //alert(data[i].name);
                           $('#materium_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                           
                       });
                       //$example.select2();
                   }
               });       
       }
       function getCmbGrupos(){
           //var $example = $("#especialidad_id-field").select2();
           var a= $('#formulario').serialize();
               $.ajax({
                   url: '{{ route("grupos.getCmbGrupo") }}',
                   type: 'GET',
                   data: a,
                   dataType: 'json',
                   beforeSend : function(){$("#loading10").show();},
                   complete : function(){$("#loading10").hide();},
                   success: function(data){
                       //$example.select2("destroy");
                       $('#grupo_id-field').html('');
                       
                       //$('#especialidad_id-field').empty();
                       $('#grupo_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                       
                       $.each(data, function(i) {
                           //alert(data[i].name);
                           $('#grupo_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                           
                       });
                       //$example.select2();
                   }
               });       
       }
 
       
 
     });
 
     function getDatosLectivo(){
           //$('#empleado_id_field option:selected').val($('#empleado_id_campo option:selected').val()).change();
           
               $.ajax({
                   url: '{{ route("lectivos.getLectivo") }}',
                   type: 'GET',
                   data: {lectivo:$("#lectivo_id-field option:selected").val()},
                   dataType: 'json',
                   beforeSend : function(){$("#loading3").show();},
                   complete : function(){$("#loading3").hide();},
                   success: function(data){
                       //console.log(data);
                       $('#asistencias_max-field').val(data.total_asistencias_lv+data.total_asistencias_s);
                       $('#fec_inicio-field').val(data.inicio);
                       $('#fec_fin-field').val(data.fin);
                   }
               });       
       }
 
     $('#fec_inicio-field').Zebra_DatePicker({
     days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
             months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
             readonly_element: false,
             lang_clear_date: 'Limpiar',
             show_select_today: 'Hoy',
     });
     
     $('#fec_fin-field').Zebra_DatePicker({
     days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
             months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
             readonly_element: false,
             lang_clear_date: 'Limpiar',
             show_select_today: 'Hoy',
     });
     
 </script>
 @endpush