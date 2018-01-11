@extends('plantillas.admin_template')

@include('cuestionarioDatos._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('cuestionarioDatos.index') }}">@yield('cuestionarioDatosAppTitle')</a></li>
	    <li><a href="{{ route('cuestionarioDatos.show', $cuestionarioDato->id) }}">{{ $cuestionarioDato->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('cuestionarioDatosAppTitle') / Editar {{$cuestionarioDato->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($cuestionarioDato, array('route' => array('cuestionarioDatos.update', $cuestionarioDato->id),'method' => 'post')) !!}

@include('cuestionarioDatos._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('cuestionarioDatos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection