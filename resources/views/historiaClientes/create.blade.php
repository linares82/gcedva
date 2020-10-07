@extends('plantillas.admin_template')

@include('historiaClientes._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('historiaClientes.index') }}">@yield('historiaClientesAppTitle')</a></li>
	    <li class="active">Crear</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> @yield('historiaClientesAppTitle') / Crear </h3>
    </div>
@endsection

@section('content')
    @include('error')
    @php
       $cliente_actual=App\Cliente::find($cliente); 
    @endphp
    @if ($bajas_existentes->count() > 0 and $cliente_actual->st_cliente_id<>3)
    <div class="callout callout-info">
        <i class="glyphicon glyphicon-remove"></i> Existen procesos de Baja
    </div>
    @endif

    <div class="row">
        <div class="col-md-12">

            {!! Form::open(array('route' => 'historiaClientes.store', 'files'=>true)) !!}

@include('historiaClientes._form')

                <div class="row">
                </div>
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Crear</button>
                    <a class="btn btn-link pull-right" href="{{ route('clientes.indexEventos') }}"><i class="glyphicon glyphicon-backward"></i> Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection

