@extends('plantillas.admin_template')

@include('pagosLectivos._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('pagosLectivos.index') }}">@yield('pagosLectivosAppTitle')</a></li>
	    <li><a href="{{ route('pagosLectivos.show', $pagosLectivo->id) }}">{{ $pagosLectivo->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('pagosLectivosAppTitle') / Editar {{$pagosLectivo->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($pagosLectivo, array('route' => array('pagosLectivos.update', $pagosLectivo->id),'method' => 'post')) !!}

@include('pagosLectivos._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('pagosLectivos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection