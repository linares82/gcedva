@extends('plantillas.admin_template')

@include('docVinculacions._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('docVinculacions.index') }}">@yield('docVinculacionsAppTitle')</a></li>
	    <li><a href="{{ route('docVinculacions.show', $docVinculacion->id) }}">{{ $docVinculacion->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('docVinculacionsAppTitle') / Editar {{$docVinculacion->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($docVinculacion, array('route' => array('docVinculacions.update', $docVinculacion->id),'method' => 'post')) !!}

@include('docVinculacions._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('docVinculacions.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection