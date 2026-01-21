@extends('plantillas.admin_template')

@include('formatoDgcfts._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('formatoDgcfts.index') }}">DGCFT</a></li>
	    <li><a href="{{ route('formatoDgcfts.show', $formatoDgcft->id) }}">{{ $formatoDgcft->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> DGCFT / Editar {{$formatoDgcft->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($formatoDgcft, array('route' => array('formatoDgcfts.update', $formatoDgcft->id),'method' => 'post')) !!}

            @include('formatoDgcfts._form')

                <div class="row">
                </div>
                <div class="well well-sm">
                <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
                
            {!! Form::close() !!}
            
        </div>
    </div>
    @php
   $contador=0;
@endphp


<!--
<div class="row">
   <div class="well well-sm">
   
   <a class="btn btn-link btn-default" href="{{ route('formatoDgcfts.ieap04',array('id'=>$formatoDgcft->id,'v'=>1)) }}" target="_blank"><i class="glyphicon"></i>  IEAP-04</a>
   <a class="btn btn-link btn-warning" href="{{ route('formatoDgcfts.riap02',array('id'=>$formatoDgcft->id,'v'=>2)) }}" target="_blank"><i class="glyphicon"></i>  RIAP-02</a>
   <a class="btn btn-link btn-info" href="{{ route('formatoDgcfts.icp08',array('id'=>$formatoDgcft->id,'v'=>2)) }}" target="_blank"><i class="glyphicon"></i>  ICP08</a>

   <a class="btn btn-link pull-right" href="{{ route('formatoDgcfts.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
   <a class="btn btn-info pull-right" href="{{ route('formatoDgcfts.limpiarLineas', array('id'=>$formatoDgcft->id)) }}"> Limpiar Lineas </a>
   <a class="btn btn-warning pull-right" href="{{ route('formatoDgcfts.generarCalificaciones',array('id'=>$formatoDgcft->id)) }}">  Generar Calificaciones</a>
   <a class="btn btn-primary pull-right" 
   href="{{ route('formatoDgcfts.generarLineas',
      array('id'=>$formatoDgcft->id,
                        'control_parte_fija'=>$formatoDgcft->control_parte_fija,
                        'control_inicio'=>$formatoDgcft->control_inicio)) }}">  
                        Generar Lineas
   </a>
   </div>
   <div class="col-md-12 table-responsive">
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
      <th>Ver Cliente</th>
      @if(!is_null($formatoDgcft->materias))
         @php
            $materias=explode(',',$formatoDgcft->materias);
         @endphp
         @foreach($materias as $materia)
            <th><a class="" href="{{route('formatoDgcfts.icp08XMateria',array('id'=>$formatoDgcft->id,'materia'=>$materia))}}" target="blank">ICP-08 {{$materia}}</a> </th>
         @endforeach
      @endif
      
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
            <td><a href="{{route('clientes.edit',$detalle->cliente_id)}}" target="blank">{{$detalle->cliente_id}}</a></td>
            @if(!is_null($formatoDgcft->materias))
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
            @endif
         </tr>
      @endforeach
   </tbody>
</table>                  
@endif
   </div>
</div>
-->
@php
$contador=0;
@endphp

<div class="row">
<div class="well well-sm">
<a class="btn btn-link btn-default" href="{{ route('formatoDgcfts.ieap04',array('id'=>$formatoDgcft->id,'v'=>2)) }}" target="_blank"><i class="glyphicon"></i>  IEAP-04</a>
   <a class="btn btn-link btn-warning" href="{{ route('formatoDgcfts.riap02',array('id'=>$formatoDgcft->id,'v'=>2)) }}" target="_blank"><i class="glyphicon"></i>  RIAP-02</a>
   <a class="btn btn-link btn-info" href="{{ route('formatoDgcfts.icp08',array('id'=>$formatoDgcft->id,'v'=>2)) }}" target="_blank"><i class="glyphicon"></i>  ICP08</a>


   <a class="btn btn-link pull-right" href="{{ route('formatoDgcfts.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
   <a class="btn btn-info pull-right" href="{{ route('formatoDgcfts.limpiarLineas', array('id'=>$formatoDgcft->id)) }}"> Limpiar Lineas </a>
   <a class="btn btn-default pull-right" href="{{ route('formatoDgcfts.buscarAlumnos',array('id'=>$formatoDgcft->id)) }}">Buscar Alumnos</a>
      
   </div>
   <div class="col-md-12 table-responsive">
   @if(isset($formatoDgcft->formatoDgcftDetalles))
   <table class="table table-condensed table-striped" width="100%">
   
   <thead>
      <th>NUM</th>
      <th>NUMERO DE CONTROL</th>
      <th>NOMBRE DEL ALUMNO</th>
      <th>CURP</th>
      <th>EDAD</th>
      <th>SEXO</th>
      <th>ESCOLARIDAD</th>
      <th>BECA %</th>
      <th>Ver Cliente</th>
      
         @foreach($sep_materias as $sep_materia)
            <th><a class="" href="{{route('formatoDgcfts.icp08XMateria',
            array('id'=>$formatoDgcft->id,
            'v'=>2,
            'sep_materia_id'=>$sep_materia->id))}}" 
            target="blank">ICP-08 {{$sep_materia->name}}</a> </th>
         @endforeach
      
      <th>SATISFACTORIO</th>
      
   </thead>
   <tbody>
      @foreach($formatoDgcft->formatoDgcftDetalles as $detalle)
         <tr>
            <td>{{++$contador}}</td>
            <td> {{ $formatoDgcft->control_parte_fija }} {{$detalle->control}}</td>
            <td>{{$detalle->nombre}}</td>
            <td>{{$detalle->curp}}</td>
            <td>{{$detalle->edad}}</td>
            <td>{{$detalle->fec_sexo}}</td>
            <td>{{$detalle->escolaridad}}</td>
            <td>{{$detalle->beca}}</td>
            <td><a class="btn btn-info" href="{{route('clientes.edit',$detalle->cliente_id)}}" target="blank">{{$detalle->cliente_id}}</a>
                
            </td>
            @foreach($sep_materias as $sep_materia)
               @php
                  $calificacion=App\FormatoDgcftMatCalif::where('sep_materia_id',$sep_materia->id)
                  ->where('formato_dgcft_detalle_id',$detalle->id)
                  ->first();
               @endphp
               <td>
                  @if(!is_null($calificacion))
                     {{round($calificacion->calificacion) }}
                  @endif
               </td>
            @endforeach
            <td>
            @if ($detalle->bnd_satisfactorio==1)
                    <a class="btn btn-success">Si</a>
                @else
                    <a class="btn btn-danger">No</a>
                @endif        
            </td>
            
         </tr>
      @endforeach
   </tbody>
</table>                  
@endif
   </div>
</div>
@endsection