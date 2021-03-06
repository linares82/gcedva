@extends('plantillas.admin_template')

@include('cicloMatriculas._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('cicloMatriculas.index') }}">@yield('cicloMatriculasAppTitle')</a></li>
	    <li><a href="{{ route('cicloMatriculas.show', $cicloMatricula->id) }}">{{ $cicloMatricula->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('cicloMatriculasAppTitle') / Editar {{$cicloMatricula->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($cicloMatricula, array('route' => array('cicloMatriculas.update', $cicloMatricula->id),'method' => 'post')) !!}

@include('cicloMatriculas._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('cicloMatriculas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection