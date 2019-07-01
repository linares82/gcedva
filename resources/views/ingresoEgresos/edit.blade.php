@extends('plantillas.admin_template')

@include('ingresoEgresos._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('ingresoEgresos.index') }}">@yield('ingresoEgresosAppTitle')</a></li>
	    <li><a href="{{ route('ingresoEgresos.show', $ingresoEgreso->id) }}">{{ $ingresoEgreso->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('ingresoEgresosAppTitle') / Editar {{$ingresoEgreso->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($ingresoEgreso, array('route' => array('ingresoEgresos.update', $ingresoEgreso->id),'method' => 'post')) !!}

@include('ingresoEgresos._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('ingresoEgresos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection