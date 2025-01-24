@extends('plantillas.admin_template')

@include('sepMaterias._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('sepMaterias.index') }}">@yield('sepMateriasAppTitle')</a></li>
	    <li><a href="{{ route('sepMaterias.show', $sepMaterium->id) }}">{{ $sepMaterium->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('sepMateriasAppTitle') / Editar {{$sepMaterium->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($sepMaterium, array('route' => array('sepMaterias.update', $sepMaterium->id),'method' => 'post')) !!}

@include('sepMaterias._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('sepMaterias.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection