@extends('plantillas.admin_template')

@include('prospectoSeguimientos._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('prospectoSeguimientos.index') }}">@yield('prospectoSeguimientosAppTitle')</a></li>
	    <li><a href="{{ route('prospectoSeguimientos.show', $prospectoSeguimiento->id) }}">{{ $prospectoSeguimiento->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('prospectoSeguimientosAppTitle') / Editar {{$prospectoSeguimiento->prospecto->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($prospectoSeguimiento, array('route' => array('prospectoSeguimientos.update', $prospectoSeguimiento->id),'method' => 'post')) !!}

@include('prospectoSeguimientos._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('prospectoSeguimientos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection