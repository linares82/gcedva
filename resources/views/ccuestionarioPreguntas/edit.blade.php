@extends('plantillas.admin_template')

@include('ccuestionarioPreguntas._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('ccuestionarioPreguntas.index') }}">@yield('ccuestionarioPreguntasAppTitle')</a></li>
	    <li><a href="{{ route('ccuestionarioPreguntas.show', $ccuestionarioPreguntum->id) }}">{{ $ccuestionarioPreguntum->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('ccuestionarioPreguntasAppTitle') / Editar {{$ccuestionarioPreguntum->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($ccuestionarioPreguntum, array('route' => array('ccuestionarioPreguntas.update', $ccuestionarioPreguntum->id),'method' => 'post')) !!}

@include('ccuestionarioPreguntas._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('ccuestionarioPreguntas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection