@extends('plantillas.admin_template')

@include('moodleBajas._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('moodleBajas.index') }}">@yield('moodleBajasAppTitle')</a></li>
	    <li><a href="{{ route('moodleBajas.show', $moodleBaja->id) }}">{{ $moodleBaja->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('moodleBajasAppTitle') / Editar {{$moodleBaja->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($moodleBaja, array('route' => array('moodleBajas.update', $moodleBaja->id),'method' => 'post')) !!}

@include('moodleBajas._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('moodleBajas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection