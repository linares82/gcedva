@extends('plantillas.admin_template')

@include('stCuestionarios._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('stCuestionarios.index') }}">@yield('stCuestionariosAppTitle')</a></li>
	    <li><a href="{{ route('stCuestionarios.show', $stCuestionario->id) }}">{{ $stCuestionario->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('stCuestionariosAppTitle') / Editar {{$stCuestionario->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($stCuestionario, array('route' => array('stCuestionarios.update', $stCuestionario->id),'method' => 'post')) !!}

@include('stCuestionarios._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('stCuestionarios.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection