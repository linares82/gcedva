@extends('plantillas.admin_template')

@include('avisosEmpresas._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('avisosEmpresas.index') }}">@yield('avisosEmpresasAppTitle')</a></li>
	    <li><a href="{{ route('avisosEmpresas.show', $avisosEmpresa->id) }}">{{ $avisosEmpresa->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('avisosEmpresasAppTitle') / Editar {{$avisosEmpresa->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($avisosEmpresa, array('route' => array('avisosEmpresas.update', $avisosEmpresa->id),'method' => 'post')) !!}

@include('avisosEmpresas._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('avisosEmpresas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection