@extends('plantillas.admin_template')

@include('pagosLectivosLns._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('pagosLectivosLns.index') }}">@yield('pagosLectivosLnsAppTitle')</a></li>
	    <li><a href="{{ route('pagosLectivosLns.show', $pagosLectivosLn->id) }}">{{ $pagosLectivosLn->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('pagosLectivosLnsAppTitle') / Editar {{$pagosLectivosLn->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($pagosLectivosLn, array('route' => array('pagosLectivosLns.update', $pagosLectivosLn->id),'method' => 'post')) !!}

@include('pagosLectivosLns._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('pagosLectivosLns.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection