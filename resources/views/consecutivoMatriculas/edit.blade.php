@extends('plantillas.admin_template')

@include('consecutivoMatriculas._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('consecutivoMatriculas.index') }}">@yield('consecutivoMatriculasAppTitle')</a></li>
	    <li><a href="{{ route('consecutivoMatriculas.show', $consecutivoMatricula->id) }}">{{ $consecutivoMatricula->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('consecutivoMatriculasAppTitle') / Editar {{$consecutivoMatricula->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($consecutivoMatricula, array('route' => array('consecutivoMatriculas.update', $consecutivoMatricula->id),'method' => 'post')) !!}

@include('consecutivoMatriculas._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('consecutivoMatriculas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection