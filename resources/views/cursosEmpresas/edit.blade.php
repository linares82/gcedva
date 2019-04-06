@extends('plantillas.admin_template')

@include('cursosEmpresas._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('cursosEmpresas.index') }}">@yield('cursosEmpresasAppTitle')</a></li>
	    <li><a href="{{ route('cursosEmpresas.show', $cursosEmpresa->id) }}">{{ $cursosEmpresa->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('cursosEmpresasAppTitle') / Editar {{$cursosEmpresa->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($cursosEmpresa, array('route' => array('cursosEmpresas.update', $cursosEmpresa->id),'method' => 'post')) !!}

@include('cursosEmpresas._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('cursosEmpresas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection