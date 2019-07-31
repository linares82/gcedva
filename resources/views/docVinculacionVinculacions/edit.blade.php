@extends('plantillas.admin_template')

@include('docVinculacionVinculacions._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('docVinculacionVinculacions.index') }}">@yield('docVinculacionVinculacionsAppTitle')</a></li>
	    <li><a href="{{ route('docVinculacionVinculacions.show', $docVinculacionVinculacion->id) }}">{{ $docVinculacionVinculacion->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('docVinculacionVinculacionsAppTitle') / Editar {{$docVinculacionVinculacion->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($docVinculacionVinculacion, array('route' => array('docVinculacionVinculacions.update', $docVinculacionVinculacion->id),'method' => 'post')) !!}

@include('docVinculacionVinculacions._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('docVinculacionVinculacions.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection