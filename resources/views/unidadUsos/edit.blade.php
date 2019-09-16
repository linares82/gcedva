@extends('plantillas.admin_template')

@include('unidadUsos._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('unidadUsos.index') }}">@yield('unidadUsosAppTitle')</a></li>
	    <li><a href="{{ route('unidadUsos.show', $unidadUso->id) }}">{{ $unidadUso->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('unidadUsosAppTitle') / Editar {{$unidadUso->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($unidadUso, array('route' => array('unidadUsos.update', $unidadUso->id),'method' => 'post')) !!}

@include('unidadUsos._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('unidadUsos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection