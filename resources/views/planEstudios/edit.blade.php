@extends('plantillas.admin_template')

@include('planEstudios._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('planEstudios.index') }}">@yield('planEstudiosAppTitle')</a></li>
	    <li><a href="{{ route('planEstudios.show', $planEstudio->id) }}">{{ $planEstudio->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('planEstudiosAppTitle') / Editar {{$planEstudio->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($planEstudio, array('route' => array('planEstudios.update', $planEstudio->id),'method' => 'post')) !!}

@include('planEstudios._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('planEstudios.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection