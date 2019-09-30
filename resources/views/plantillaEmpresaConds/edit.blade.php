@extends('plantillas.admin_template')

@include('plantillaEmpresaConds._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('plantillaEmpresaConds.index') }}">@yield('plantillaEmpresaCondsAppTitle')</a></li>
	    <li><a href="{{ route('plantillaEmpresaConds.show', $plantillaEmpresaCond->id) }}">{{ $plantillaEmpresaCond->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('plantillaEmpresaCondsAppTitle') / Editar {{$plantillaEmpresaCond->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($plantillaEmpresaCond, array('route' => array('plantillaEmpresaConds.update', $plantillaEmpresaCond->id),'method' => 'post')) !!}

@include('plantillaEmpresaConds._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('plantillaEmpresaConds.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection