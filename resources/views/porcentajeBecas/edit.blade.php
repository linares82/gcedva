@extends('plantillas.admin_template')

@include('porcentajeBecas._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('porcentajeBecas.index') }}">@yield('porcentajeBecasAppTitle')</a></li>
	    <li><a href="{{ route('porcentajeBecas.show', $porcentajeBeca->id) }}">{{ $porcentajeBeca->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('porcentajeBecasAppTitle') / Editar {{$porcentajeBeca->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($porcentajeBeca, array('route' => array('porcentajeBecas.update', $porcentajeBeca->id),'method' => 'post')) !!}

@include('porcentajeBecas._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('porcentajeBecas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection