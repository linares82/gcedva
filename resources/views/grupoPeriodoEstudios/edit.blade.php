@extends('plantillas.admin_template')

@include('grupoPeriodoEstudios._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('grupoPeriodoEstudios.index') }}">@yield('grupoPeriodoEstudiosAppTitle')</a></li>
	    <li><a href="{{ route('grupoPeriodoEstudios.show', $grupoPeriodoEstudio->id) }}">{{ $grupoPeriodoEstudio->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('grupoPeriodoEstudiosAppTitle') / Editar {{$grupoPeriodoEstudio->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($grupoPeriodoEstudio, array('route' => array('grupoPeriodoEstudios.update', $grupoPeriodoEstudio->id),'method' => 'post')) !!}

@include('grupoPeriodoEstudios._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('grupoPeriodoEstudios.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection