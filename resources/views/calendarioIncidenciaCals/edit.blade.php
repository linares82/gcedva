@extends('plantillas.admin_template')

@include('calendarioIncidenciaCals._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('calendarioIncidenciaCals.index') }}">@yield('calendarioIncidenciaCalsAppTitle')</a></li>
	    <li><a href="{{ route('calendarioIncidenciaCals.show', $calendarioIncidenciaCal->id) }}">{{ $calendarioIncidenciaCal->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('calendarioIncidenciaCalsAppTitle') / Editar {{$calendarioIncidenciaCal->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($calendarioIncidenciaCal, array('route' => array('calendarioIncidenciaCals.update', $calendarioIncidenciaCal->id),'method' => 'post')) !!}

@include('calendarioIncidenciaCals._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('calendarioIncidenciaCals.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection