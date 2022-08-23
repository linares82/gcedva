@extends('plantillas.admin_template')

@include('titulacionGrupos._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('titulacionGrupos.index') }}">@yield('titulacionGruposAppTitle')</a></li>
	    <li><a href="{{ route('titulacionGrupos.show', $titulacionGrupo->id) }}">{{ $titulacionGrupo->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('titulacionGruposAppTitle') / Editar {{$titulacionGrupo->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($titulacionGrupo, array('route' => array('titulacionGrupos.update', $titulacionGrupo->id),'method' => 'post')) !!}

@include('titulacionGrupos._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('titulacionGrupos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection