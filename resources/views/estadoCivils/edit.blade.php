@extends('plantillas.admin_template')

@include('estadoCivils._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('estadoCivils.index') }}">@yield('estadoCivilsAppTitle')</a></li>
	    <li><a href="{{ route('estadoCivils.show', $estadoCivil->id) }}">{{ $estadoCivil->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('estadoCivilsAppTitle') / Editar {{$estadoCivil->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($estadoCivil, array('route' => array('estadoCivils.update', $estadoCivil->id),'method' => 'post')) !!}

@include('estadoCivils._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('estadoCivils.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection