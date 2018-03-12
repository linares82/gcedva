@extends('plantillas.admin_template')

@include('planCondicionFiltros._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('planCondicionFiltros.index') }}">@yield('planCondicionFiltrosAppTitle')</a></li>
	    <li><a href="{{ route('planCondicionFiltros.show', $planCondicionFiltro->id) }}">{{ $planCondicionFiltro->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('planCondicionFiltrosAppTitle') / Editar {{$planCondicionFiltro->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($planCondicionFiltro, array('route' => array('planCondicionFiltros.update', $planCondicionFiltro->id),'method' => 'post')) !!}

@include('planCondicionFiltros._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('planCondicionFiltros.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection