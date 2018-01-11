@extends('plantillas.admin_template')

@include('combinacionEmpresas._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('combinacionEmpresas.index') }}">@yield('combinacionEmpresasAppTitle')</a></li>
	    <li><a href="{{ route('combinacionEmpresas.show', $combinacionEmpresa->id) }}">{{ $combinacionEmpresa->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('combinacionEmpresasAppTitle') / Editar {{$combinacionEmpresa->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($combinacionEmpresa, array('route' => array('combinacionEmpresas.update', $combinacionEmpresa->id),'method' => 'post')) !!}

@include('combinacionEmpresas._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('combinacionEmpresas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection