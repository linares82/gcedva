@extends('plantillas.admin_template')

@include('facturaGenerals._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('facturaGenerals.index') }}">@yield('facturaGeneralsAppTitle')</a></li>
	    <li><a href="{{ route('facturaGenerals.show', $facturaGeneral->id) }}">{{ $facturaGeneral->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('facturaGeneralsAppTitle') / Editar {{$facturaGeneral->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($facturaGeneral, array('route' => array('facturaGenerals.update', $facturaGeneral->id),'method' => 'post')) !!}

@include('facturaGenerals._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('facturaGenerals.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection