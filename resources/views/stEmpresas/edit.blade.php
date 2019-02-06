@extends('plantillas.admin_template')

@include('stEmpresas._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('stEmpresas.index') }}">@yield('stEmpresasAppTitle')</a></li>
	    <li><a href="{{ route('stEmpresas.show', $stEmpresa->id) }}">{{ $stEmpresa->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('stEmpresasAppTitle') / Editar {{$stEmpresa->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($stEmpresa, array('route' => array('stEmpresas.update', $stEmpresa->id),'method' => 'post')) !!}

@include('stEmpresas._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('stEmpresas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection