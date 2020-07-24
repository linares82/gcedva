                <div class="form-group col-md-4 @if($errors->has('name')) has-error @endif">
                       <label for="name-field">Nombre</label>
                       {!! Form::text("name", null, array("class" => "form-control input-sm", "id" => "name-field")) !!}
                       @if($errors->has("name"))
                        <span class="help-block">{{ $errors->first("name") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('desc_certificado')) has-error @endif">
                     <label for="desc_certificado-field">Descripcion Certificado</label>
                     {!! Form::text("desc_certificado", null, array("class" => "form-control", "id" => "desc_certificado-field")) !!}
                     @if($errors->has("desc_certificado"))
                      <span class="help-block">{{ $errors->first("inscripcion") }}</span>
                     @endif
                  </div>  
                    <div class="form-group col-md-1 @if($errors->has('activo')) has-error @endif">
                       <label for="activo-field">Activo</label>
                       {!! Form::checkbox("activo", 1, null, [ "id" => "activo-field"]) !!}
                       @if($errors->has("activo"))
                        <span class="help-block">{{ $errors->first("activo") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-2 @if($errors->has('bachillerato_bnd')) has-error @endif">
                       <label for="bachillerato_bnd-field">Bachillerato</label>
                       {!! Form::checkbox("bachillerato_bnd", 1, null, [ "id" => "bachillerato_bnd-field"]) !!}
                       @if($errors->has("bachillerato_bnd"))
                        <span class="help-block">{{ $errors->first("bachillerato_bnd") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-1 @if($errors->has('carrera_bnd')) has-error @endif">
                       <label for="activo-field">Carrera</label>
                       {!! Form::checkbox("carrera_bnd", 1, null, [ "id" => "activo-field"]) !!}
                       @if($errors->has("carrera_bnd"))
                        <span class="help-block">{{ $errors->first("carrera_bnd") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-1 @if($errors->has('grafica_bnd')) has-error @endif">
                       <label for="grafica_bnd-field">Grafica</label>
                       {!! Form::checkbox("grafica_bnd", 1, null, [ "id" => "grafica_bnd-field"]) !!}
                       @if($errors->has("grafica_bnd"))
                        <span class="help-block">{{ $errors->first("grafica_bnd") }}</span>
                       @endif
                    </div>
                    <div class="row"></div>
                    <div class="form-group col-md-4 @if($errors->has('inicio')) has-error @endif">
                       <label for="inicio-field">Inicio</label>
                       {!! Form::text("inicio", null, array("class" => "form-control input-sm", "id" => "inicio-field")) !!}
                       @if($errors->has("inicio"))
                        <span class="help-block">{{ $errors->first("inicio") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('fin')) has-error @endif">
                       <label for="fin-field">Fin</label>
                       {!! Form::text("fin", null, array("class" => "form-control input-sm", "id" => "fin-field")) !!}
                       @if($errors->has("fin"))
                        <span class="help-block">{{ $errors->first("fin") }}</span>
                       @endif
                    </div>
                    <div class="row"></div>
                    @if(isset($lectivo))
                    <div class="form-group col-md-12">
                     <strong>Capturar datos para periodos de examen </strong> 
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('calificacion_inicio')) has-error @endif">
                       <label for="calificacion_inicio-field">Calificacion Apertura</label>
                       {!! Form::text("calificacion_inicio", null, array("class" => "form-control input-sm", "id" => "calificacion_inicio-field")) !!}
                       @if($errors->has("calificacion_inicio"))
                        <span class="help-block">{{ $errors->first("calificacion_inicio") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('calificacion_fin')) has-error @endif">
                       <label for="calificacion_fin-field">Calificacion Cierre</label>
                       {!! Form::text("calificacion_fin", null, array("class" => "form-control input-sm", "id" => "calificacion_fin-field")) !!}
                       @if($errors->has("calificacion_fin"))
                        <span class="help-block">{{ $errors->first("calificacion_fin") }}</span>
                       @endif
                    </div>
                    
                    <table class="table table-condensed table-striped">
                       <thead>
                           <th>Inicio</th><th>Fin</th><th></th>
                       </thead>
                       <tbody>
                           @foreach($lectivo->periodoExamens as $periodoExamen)
                           <tr>
                           <td>{{$periodoExamen->inicio}}</td><td>{{$periodoExamen->fin}}</td>
                           <td>
                           <a href="{{route('periodoExamens.destroy', $periodoExamen->id)}}"  class="btn btn-xs btn-danger ">Eliminar</a>  
                           </td>
                           </tr>
                           @endforeach
                       </tbody>
                    </table>
                    @endif

@push('scripts')
<script>
  //  $(document).ready(function() {
      
      // assuming the controls you want to attach the plugin to
      // have the "datepicker" class set
      //Campo de fecha
      $('#inicio-field').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
      });

      $('#fin-field').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
      });

      $('#calificacion_inicio-field').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
      });

      $('#calificacion_fin-field').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
      });
//    )};
</script>

@endpush