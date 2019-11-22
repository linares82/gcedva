@extends('plantillas.admin_template')

@include('stAutorizacionBecas._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('stAutorizacionBecas.index') }}">@yield('stAutorizacionBecasAppTitle')</a></li>
	    <li><a href="{{ route('stAutorizacionBecas.show', $stAutorizacionBeca->id) }}">{{ $stAutorizacionBeca->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('stAutorizacionBecasAppTitle') / Editar {{$stAutorizacionBeca->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($stAutorizacionBeca, array('route' => array('stAutorizacionBecas.update', $stAutorizacionBeca->id),'method' => 'post')) !!}

@include('stAutorizacionBecas._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('stAutorizacionBecas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection