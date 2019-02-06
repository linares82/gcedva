@extends('plantillas.admin_template')

@include('tareasEmpresas._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('tareasEmpresas.index') }}">@yield('tareasEmpresasAppTitle')</a></li>
	    <li><a href="{{ route('tareasEmpresas.show', $tareasEmpresa->id) }}">{{ $tareasEmpresa->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('tareasEmpresasAppTitle') / Editar {{$tareasEmpresa->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($tareasEmpresa, array('route' => array('tareasEmpresas.update', $tareasEmpresa->id),'method' => 'post')) !!}

@include('tareasEmpresas._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('tareasEmpresas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection