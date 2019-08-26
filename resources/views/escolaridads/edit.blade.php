@extends('plantillas.admin_template')

@include('escolaridads._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('escolaridads.index') }}">@yield('escolaridadsAppTitle')</a></li>
	    <li><a href="{{ route('escolaridads.show', $escolaridad->id) }}">{{ $escolaridad->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('escolaridadsAppTitle') / Editar {{$escolaridad->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($escolaridad, array('route' => array('escolaridads.update', $escolaridad->id),'method' => 'post')) !!}

@include('escolaridads._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('escolaridads.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection