<div class="form-group col-md-4 @if($errors->has('name')) has-error @endif">
      <label for="name-field">Identificador</label>
      {!! Form::text("name", null, array("class" => "form-control", "id" => "name-field")) !!}
      @if($errors->has("name"))
      <span class="help-block">{{ $errors->first("name") }}</span>
      @endif
   </div>
<div class="form-group col-md-4 @if($errors->has('enlace_operativo')) has-error @endif">
   <label for="enlace_operativo-field">Enlace Operativo</label>
   {!! Form::text("enlace_operativo", null, array("class" => "form-control", "id" => "enlace_operativo-field")) !!}
   @if($errors->has("enlace_operativo"))
      <span class="help-block">{{ $errors->first("enlace_operativo") }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if($errors->has('directora_nombre')) has-error @endif">
   <label for="directora_nombre-field">Director</label>
   {!! Form::text("directora_nombre", null, array("class" => "form-control", "id" => "directora_nombre-field")) !!}
   @if($errors->has("directora_nombre"))
      <span class="help-block">{{ $errors->first("directora_nombre") }}</span>
   @endif
</div> 
<div class="form-group col-md-4 @if($errors->has('sceo_nombre')) has-error @endif">
   <label for="sceo_nombre-field">SCEO</label>
   {!! Form::text("sceo_nombre", null, array("class" => "form-control", "id" => "sceo_nombre-field")) !!}
   @if($errors->has("sceo_nombre"))
      <span class="help-block">{{ $errors->first("sceo_nombre") }}</span>
   @endif
</div>  
<div class="form-group col-md-3 @if($errors->has('cct')) has-error @endif">
   <label for="cct-field">CCT</label>
   {!! Form::text("cct", null, array("class" => "form-control", "id" => "cct-field")) !!}
   @if($errors->has("cct"))
      <span class="help-block">{{ $errors->first("cct") }}</span>
   @endif
</div>  

<div class="form-group col-md-5 @if($errors->has('plantel')) has-error @endif">
   <label for="plantel-field">Plantel</label>
   {!! Form::text("plantel", null, array("class" => "form-control", "id" => "plantel-field")) !!}
   @if($errors->has("plantel"))
      <span class="help-block">{{ $errors->first("plantel") }}</span>
   @endif
</div>  
<div class="form-group col-md-6 @if($errors->has('direccion')) has-error @endif">
   <label for="direccion-field">Direccion</label>
   {!! Form::text("direccion", null, array("class" => "form-control", "id" => "direccion-field")) !!}
   @if($errors->has("direccion"))
      <span class="help-block">{{ $errors->first("direccion") }}</span>
   @endif
</div>  
<div class="form-group col-md-3 @if($errors->has('especialidad')) has-error @endif">
   <label for="especialidad-field">Especialidad</label>
   {!! Form::text("especialidad", null, array("class" => "form-control", "id" => "especialidad-field")) !!}
   @if($errors->has("especialidad"))
      <span class="help-block">{{ $errors->first("especialidad") }}</span>
   @endif
</div>  
<div class="form-group col-md-3 @if($errors->has('grupo')) has-error @endif">
   <label for="grupo-field">Grupo</label>
   {!! Form::text("grupo", null, array("class" => "form-control", "id" => "grupo-field")) !!}
   @if($errors->has("grupo"))
      <span class="help-block">{{ $errors->first("grupo") }}</span>
   @endif
</div> 
<div class="form-group col-md-3 @if($errors->has('fec_elaboracion')) has-error @endif">
   <label for="fec_elaboracion-field">F. Elaboracion</label>
   {!! Form::text("fec_elaboracion", null, array("class" => "form-control fecha", "id" => "fec_elaboracion-field")) !!}
   @if($errors->has("fec_elaboracion"))
      <span class="help-block">{{ $errors->first("fec_elaboracion") }}</span>
   @endif
</div>   
<div class="form-group col-md-3 @if($errors->has('fec_inicio')) has-error @endif">
   <label for="fec_inicio-field">F. Inicio</label>
   {!! Form::text("fec_inicio", null, array("class" => "form-control fecha", "id" => "fec_inicio-field")) !!}
   @if($errors->has("fec_inicio"))
      <span class="help-block">{{ $errors->first("fec_inicio") }}</span>
   @endif
</div> 
<div class="form-group col-md-3 @if($errors->has('fec_fin')) has-error @endif">
   <label for="fec_fin-field">F. Fin</label>
   {!! Form::text("fec_fin", null, array("class" => "form-control fecha", "id" => "fec_fin-field")) !!}
   @if($errors->has("fec_fin"))
      <span class="help-block">{{ $errors->first("fec_fin") }}</span>
   @endif
</div>  
<div class="form-group col-md-3 @if($errors->has('ciclo_escolar')) has-error @endif">
   <label for="ciclo_escolar-field">Ciclo Escolar</label>
   {!! Form::text("ciclo_escolar", null, array("class" => "form-control", "id" => "ciclo_escolar-field")) !!}
   @if($errors->has("ciclo_escolar"))
      <span class="help-block">{{ $errors->first("ciclo_escolar") }}</span>
   @endif
</div>
<div class="form-group col-md-3 @if($errors->has('fec_edad')) has-error @endif">
   <label for="fec_edad-field">F. Referencia Edad</label>
   {!! Form::text("fec_edad", null, array("class" => "form-control fecha", "id" => "fec_edad-field")) !!}
   @if($errors->has("fec_edad"))
      <span class="help-block">{{ $errors->first("fec_edad") }}</span>
   @endif
</div> 

<div class="form-group col-md-3 @if($errors->has('duracion')) has-error @endif">
   <label for="duracion-field">Duracion Horas</label>
   {!! Form::text("duracion", null, array("class" => "form-control", "id" => "duracion-field")) !!}
   @if($errors->has("duracion"))
      <span class="help-block">{{ $errors->first("duracion") }}</span>
   @endif
</div>

<div class="form-group col-md-3 @if($errors->has('horario')) has-error @endif">
   <label for="horario-field">Horario</label>
   {!! Form::text("horario", null, array("class" => "form-control", "id" => "horario-field")) !!}
   @if($errors->has("horario"))
      <span class="help-block">{{ $errors->first("horario_inicio") }}</span>
   @endif
</div>
<div class="form-group col-md-3 @if($errors->has('horario_inicio')) has-error @endif">
   <label for="horario_inicio-field">Horario Inicio</label>
   {!! Form::text("horario_inicio", null, array("class" => "form-control", "id" => "horario_inicio-field")) !!}
   @if($errors->has("horario_inicio"))
      <span class="help-block">{{ $errors->first("horario_inicio") }}</span>
   @endif
</div>
<div class="form-group col-md-3 @if($errors->has('horario_fin')) has-error @endif">
   <label for="horario_fin-field">Horario Fin</label>
   {!! Form::text("horario_fin", null, array("class" => "form-control", "id" => "horario_fin-field")) !!}
   @if($errors->has("horario_fin"))
      <span class="help-block">{{ $errors->first("horario_fin") }}</span>
   @endif
</div> 

<div class="form-group col-md-3 @if($errors->has('cantidad_clientes')) has-error @endif">
   <label for="cantidad_clientes-field">Cantidad Clientes</label>
   {!! Form::text("cantidad_clientes", null, array("class" => "form-control", "id" => "cantidad_clientes-field")) !!}
   @if($errors->has("cantidad_clientes"))
      <span class="help-block">{{ $errors->first("cantidad_clientes") }}</span>
   @endif
</div> 
<div class="form-group col-md-4 @if($errors->has('clientes')) has-error @endif">
   <label for="clientes-field">Clientes(separados por ",")
   @if(isset($formatoDgcft))
         @if(count(explode(',',$formatoDgcft->clientes))<>$formatoDgcft->cantidad_clientes)
         <code>*Cantidad de datos, diferente de Candidad Clientes</code>
         @endif
      @endif
   </label>
   {!! Form::textArea("clientes", null, array("class" => "form-control", "id" => "clientes-field", 'rows'=>3)) !!}
   
   @if($errors->has("clientes"))
      <span class="help-block">{{ $errors->first("clientes") }}</span>
   @endif
</div> 
<div class="form-group col-md-4 @if($errors->has('control')) has-error @endif">
   <label for="control-field">No. Control (separados por ",")
   @if(isset($formatoDgcft))
         @if(count(explode(',',$formatoDgcft->control))<>$formatoDgcft->cantidad_clientes)
         <code>*Cantidad de datos, diferente de Candidad Clientes</code>
         @endif
      @endif
   </label>
   {!! Form::textArea("control", null, array("class" => "form-control", "id" => "control-field", 'rows'=>3)) !!}
   @if($errors->has("control"))
      <span class="help-block">{{ $errors->first("control") }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if($errors->has('escolaridad')) has-error @endif">
   <label for="escolaridad-field">Escolaridad (separados por ",")
   @if(isset($formatoDgcft))
         @if(count(explode(',',$formatoDgcft->escolaridad))<>$formatoDgcft->cantidad_clientes)
         <code>*Cantidad de datos, diferente de Candidad Clientes</code>
         @endif
      @endif
   </label>
   {!! Form::textArea("escolaridad", null, array("class" => "form-control", "id" => "escolaridad-field", 'rows'=>3)) !!}
   @if($errors->has("escolaridad"))
      <span class="help-block">{{ $errors->first("escolaridad") }}</span>
   @endif
</div> 
<div class="form-group col-md-4 @if($errors->has('beca')) has-error @endif">
   <label for="beca-field">Beca (separados por ",")
   @if(isset($formatoDgcft))
         @if(count(explode(',',$formatoDgcft->beca))<>$formatoDgcft->cantidad_clientes)
         <code>*Cantidad de datos, diferente de Candidad Clientes</code>
         @endif
      @endif
   </label>
   {!! Form::textArea("beca", null, array("class" => "form-control", "id" => "beca-field", 'rows'=>3)) !!}
   @if($errors->has("beca"))
      <span class="help-block">{{ $errors->first("beca") }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if($errors->has('materias')) has-error @endif">
   <label for="materias-field">Materias(separados por ",")
   </label>
   {!! Form::textArea("materias", null, array("class" => "form-control", "id" => "materias-field", 'rows'=>3)) !!}
   @if($errors->has("materias"))
      <span class="help-block">{{ $errors->first("materias") }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if($errors->has('grados')) has-error @endif">
   <label for="grados-field">Grados(separados por ",")
   </label>
   {!! Form::textArea("grados", null, array("class" => "form-control", "id" => "grados-field", 'rows'=>3)) !!}
   @if($errors->has("grados"))
      <span class="help-block">{{ $errors->first("grados") }}</span>
   @endif
</div> 
<div class="form-group col-md-3 @if($errors->has('duracion_materias')) has-error @endif">
   <label for="duracion_materias-field">Duracion Horas por Materia(separados por ",")</label>
   {!! Form::textArea("duracion_materias", null, array("class" => "form-control", "id" => "duracion_materias-field", 'rows'=>3)) !!}
   @if($errors->has("duracion_materias"))
      <span class="help-block">{{ $errors->first("duracion_materias") }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if($errors->has('calificaciones')) has-error @endif">
   <label for="calificaciones-field">Calificaciones(Series separadas por "-" y calificaciones separadas por ",")
   @if(isset($formatoDgcft))
         @php
            $calificacionesXmateria=explode('-',$formatoDgcft->calificaciones);
            //dd($calificacionesXmateria);
            $serie_contador=1;
            foreach($calificacionesXmateria as $serie){
               $contador_calificacion=0;
               $calificaciones=explode(',',$serie);
               foreach($calificaciones as $calificacion){
                  $contador_calificacion++;
               }
               //dd($contador_calificacion);
               if($contador_calificacion<>$formatoDgcft->cantidad_clientes){
                echo "<code>  *Cantidad de datos, diferente de Candidad Clientes y Materias</code>";
               }
               $serie_contador++;
            }
         @endphp
      @endif
   </label>
   {!! Form::textArea("calificaciones", null, array("class" => "form-control", "id" => "calificaciones-field", 'rows'=>3)) !!}
   @if($errors->has("calificaciones"))
      <span class="help-block">{{ $errors->first("calificaciones") }}</span>
   @endif
</div> 
<div class="form-group col-md-4 @if($errors->has('resultados')) has-error @endif">
   <label for="resultados-field">Resultados(separados por ",")
   @if(isset($formatoDgcft))
         @if(count(explode(',',$formatoDgcft->resultados))<>$formatoDgcft->cantidad_clientes)
         <code>*Cantidad de datos, diferente de Candidad Clientes</code>
         @endif
      @endif
   </label>
   {!! Form::textArea("resultados", null, array("class" => "form-control", "id" => "resultados-field", 'rows'=>3)) !!}
   @if($errors->has("resultados"))
      <span class="help-block">{{ $errors->first("resultados") }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if($errors->has('final')) has-error @endif">
   <label for="final-field">Final(separados por ",")
   @if(isset($formatoDgcft))
         @if(count(explode(',',$formatoDgcft->final))<>$formatoDgcft->cantidad_clientes)
         <code>*Cantidad de datos, diferente de Candidad Clientes</code>
         @endif
      @endif
   </label>
   {!! Form::textArea("final", null, array("class" => "form-control", "id" => "final-field", 'rows'=>3)) !!}
   @if($errors->has("final"))
      <span class="help-block">{{ $errors->first("final") }}</span>
   @endif
</div> 
@php
   $contador=0;
@endphp
@if(isset($formatoDgcft->formatoDgcftDetalles))
<table class="table table-condensed table-striped">
   <thead>
      <th>NUM</th>
      <th>NUMERO DE CONTROL</th>
      <th>NOMBRE DEL ALUMNO</th>
      <th>CURP</th>
      <th>EDAD</th>
      <th>SEXO</th>
      <th>ESCOLARIDAD</th>
      <th>BECA %</th>
      <th>Calificaciones</th>
      @if($formatoDgcft->materias)
         @php
            $materias=explode(',',$formatoDgcft->materias);
         @endphp
         @foreach($materias as $materia)
            <th>{{$materia}}</th>
         @endforeach
      @endif
      <th>RESULTADO</th>
      <th>FINAL</th>
   </thead>
   <tbody>
      @foreach($formatoDgcft->formatoDgcftDetalles as $detalle)
         <tr>
            <td>{{++$contador}}</td>
            <td>{{$detalle->control}}</td>
            <td>{{$detalle->nombre}}</td>
            <td>{{$detalle->curp}}</td>
            <td>{{$detalle->edad}}</td>
            <td>{{$detalle->fec_sexo}}</td>
            <td>{{$detalle->escolaridad}}</td>
            <td>{{$detalle->beca}}</td>
            <td><a href="{{route('clientes.edit',$detalle->cliente_id)}}" target="blank">Ver</a></td>
            @foreach($materias as $materia)
               @php
                  $calificacion=App\FormatoDgcftMatCalif::where('materia',trim($materia))
                  ->where('formato_dgcft_detalle_id',$detalle->id)
                  ->first();
               @endphp
               <td>
                  @if(!is_null($calificacion))
                     {{$calificacion->calificacion }}
                     <a href="{{route('formatoDgcfts.destroyCalificacion',array('id'=>$calificacion->id,'formato_dgcft_id'=>$formatoDgcft->id))}}" class="btn btn-danger btn-xs" tooltip="Eliminar">X</a>
                  @endif
               </td>
            @endforeach
            <td>{{$detalle->resultado}}</td>
            <td>{{$detalle->final}}</td>
         </tr>
      @endforeach
   </tbody>
</table>                  
@endif
                  