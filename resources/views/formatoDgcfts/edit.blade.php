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
                    <a class="btn btn-link btn-default" href="{{ route('formatoDgcfts.ieap04',array('id'=>$formatoDgcft->id)) }}" target="_blank"><i class="glyphicon"></i>  IEAP-04</a>
                    <a class="btn btn-link btn-warning" href="{{ route('formatoDgcfts.riap02',array('id'=>$formatoDgcft->id)) }}" target="_blank"><i class="glyphicon"></i>  RIAP-02</a>
                    <a class="btn btn-link btn-info" href="{{ route('formatoDgcfts.icp08',array('id'=>$formatoDgcft->id)) }}" target="_blank"><i class="glyphicon"></i>  ICP08</a>

                    <a class="btn btn-link pull-right" href="{{ route('formatoDgcfts.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                    <a class="btn btn-info pull-right" href="{{ route('formatoDgcfts.limpiarLineas', array('id'=>$formatoDgcft->id)) }}"> Limpiar Lineas </a>
                    <a class="btn btn-warning pull-right" href="{{ route('formatoDgcfts.generarCalificaciones',array('id'=>$formatoDgcft->id)) }}">  Generar Calificaciones</a>
                    <a class="btn btn-primary pull-right" href="{{ route('formatoDgcfts.generarLineas',array('id'=>$formatoDgcft->id)) }}">  Generar Lineas</a>
                    
                    
                    
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection