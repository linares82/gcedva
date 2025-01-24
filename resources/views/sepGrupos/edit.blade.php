@extends('plantillas.admin_template')

@include('sepGrupos._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('sepGrupos.index') }}">@yield('sepGruposAppTitle')</a></li>
	    <li><a href="{{ route('sepGrupos.show', $sepGrupo->id) }}">{{ $sepGrupo->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('sepGruposAppTitle') / Editar {{$sepGrupo->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($sepGrupo, array('route' => array('sepGrupos.update', $sepGrupo->id),'method' => 'post')) !!}

@include('sepGrupos._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('sepGrupos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection