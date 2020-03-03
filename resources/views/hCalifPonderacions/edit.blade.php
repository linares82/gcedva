@extends('plantillas.admin_template')

@include('hCalifPonderacions._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('hCalifPonderacions.index') }}">@yield('hCalifPonderacionsAppTitle')</a></li>
	    <li><a href="{{ route('hCalifPonderacions.show', $hCalifPonderacion->id) }}">{{ $hCalifPonderacion->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('hCalifPonderacionsAppTitle') / Editar {{$hCalifPonderacion->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($hCalifPonderacion, array('route' => array('hCalifPonderacions.update', $hCalifPonderacion->id),'method' => 'post')) !!}

@include('hCalifPonderacions._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('hCalifPonderacions.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection