@extends('plantillas.admin_template')

@include('discapacidads._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('discapacidads.index') }}">@yield('discapacidadsAppTitle')</a></li>
	    <li><a href="{{ route('discapacidads.show', $discapacidad->id) }}">{{ $discapacidad->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('discapacidadsAppTitle') / Editar {{$discapacidad->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($discapacidad, array('route' => array('discapacidads.update', $discapacidad->id),'method' => 'post')) !!}

@include('discapacidads._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('discapacidads.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection