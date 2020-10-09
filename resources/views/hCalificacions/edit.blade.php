@extends('plantillas.admin_template')

@include('hCalificacions._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('hCalificacions.index') }}">@yield('hCalificacionsAppTitle')</a></li>
	    <li><a href="{{ route('hCalificacions.show', $hCalificacion->id) }}">{{ $hCalificacion->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('hCalificacionsAppTitle') / Editar {{$hCalificacion->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($hCalificacion, array('route' => array('hCalificacions.update', $hCalificacion->id),'method' => 'post')) !!}

@include('hCalificacions._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('hCalificacions.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection