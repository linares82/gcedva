@extends('plantillas.admin_template')

@include('ccuestionarioDatos._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('ccuestionarioDatos.index') }}">@yield('ccuestionarioDatosAppTitle')</a></li>
	    <li><a href="{{ route('ccuestionarioDatos.show', $ccuestionarioDato->id) }}">{{ $ccuestionarioDato->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('ccuestionarioDatosAppTitle') / Editar {{$ccuestionarioDato->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($ccuestionarioDato, array('route' => array('ccuestionarioDatos.update', $ccuestionarioDato->id),'method' => 'post')) !!}

@include('ccuestionarioDatos._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('ccuestionarioDatos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection