@extends('plantillas.admin_template')

@include('segmentoMercados._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('segmentoMercados.index') }}">@yield('segmentoMercadosAppTitle')</a></li>
	    <li><a href="{{ route('segmentoMercados.show', $segmentoMercado->id) }}">{{ $segmentoMercado->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('segmentoMercadosAppTitle') / Editar {{$segmentoMercado->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($segmentoMercado, array('route' => array('segmentoMercados.update', $segmentoMercado->id),'method' => 'post')) !!}

@include('segmentoMercados._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('segmentoMercados.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection