@extends('plantillas.admin_template')

@include('planCampoFiltros._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('planCampoFiltros.index') }}">@yield('planCampoFiltrosAppTitle')</a></li>
	    <li><a href="{{ route('planCampoFiltros.show', $planCampoFiltro->id) }}">{{ $planCampoFiltro->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('planCampoFiltrosAppTitle') / Editar {{$planCampoFiltro->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($planCampoFiltro, array('route' => array('planCampoFiltros.update', $planCampoFiltro->id),'method' => 'post')) !!}

@include('planCampoFiltros._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('planCampoFiltros.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection