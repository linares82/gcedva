@extends('plantillas.admin_template')

@include('setyceTitulos._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('setyceTitulos.index') }}">@yield('setyceTitulosAppTitle')</a></li>
	    <li><a href="{{ route('setyceTitulos.show', $setyceTitulo->id) }}">{{ $setyceTitulo->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('setyceTitulosAppTitle') / Editar {{$setyceTitulo->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($setyceTitulo, array('route' => array('setyceTitulos.update', $setyceTitulo->id),'method' => 'post')) !!}

@include('setyceTitulos._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('setyceTitulos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection