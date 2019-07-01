@extends('plantillas.admin_template')

@include('hCuentasEfectivos._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('hCuentasEfectivos.index') }}">@yield('hCuentasEfectivosAppTitle')</a></li>
	    <li><a href="{{ route('hCuentasEfectivos.show', $hCuentasEfectivo->id) }}">{{ $hCuentasEfectivo->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('hCuentasEfectivosAppTitle') / Editar {{$hCuentasEfectivo->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($hCuentasEfectivo, array('route' => array('hCuentasEfectivos.update', $hCuentasEfectivo->id),'method' => 'post')) !!}

@include('hCuentasEfectivos._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('hCuentasEfectivos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection