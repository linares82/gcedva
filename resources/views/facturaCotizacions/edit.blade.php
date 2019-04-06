@extends('plantillas.admin_template')

@include('facturaCotizacions._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('facturaCotizacions.index') }}">@yield('facturaCotizacionsAppTitle')</a></li>
	    <li><a href="{{ route('facturaCotizacions.show', $facturaCotizacion->id) }}">{{ $facturaCotizacion->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('facturaCotizacionsAppTitle') / Editar {{$facturaCotizacion->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($facturaCotizacion, array('route' => array('facturaCotizacions.update', $facturaCotizacion->id),'method' => 'post')) !!}

@include('facturaCotizacions._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('facturaCotizacions.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection