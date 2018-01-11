@extends('plantillas.admin_template')

@include('cuestionarioPreguntas._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('cuestionarioPreguntas.index') }}">@yield('cuestionarioPreguntasAppTitle')</a></li>
	    <li><a href="{{ route('cuestionarioPreguntas.show', $cuestionarioPregunta->id) }}">{{ $cuestionarioPregunta->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('cuestionarioPreguntasAppTitle') / Editar {{$cuestionarioPregunta->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($cuestionarioPregunta, array('route' => array('cuestionarioPreguntas.update', $cuestionarioPregunta->id),'method' => 'post')) !!}

@include('cuestionarioPreguntas._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('cuestionarioPreguntas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection