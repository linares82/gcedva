@extends('plantillas.admin_template')

@include('plantillaEmpresas._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('plantillaEmpresas.index') }}">@yield('plantillaEmpresasAppTitle')</a></li>
	    <li><a href="{{ route('plantillaEmpresas.show', $plantillaEmpresa->id) }}">{{ $plantillaEmpresa->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('plantillaEmpresasAppTitle') / Editar {{$plantillaEmpresa->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($plantillaEmpresa, array('route' => array('plantillaEmpresas.update', $plantillaEmpresa->id),'method' => 'post')) !!}

@include('plantillaEmpresas._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('plantillaEmpresas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection