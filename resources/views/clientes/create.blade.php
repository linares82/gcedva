@extends('plantillas.admin_template')

@include('clientes._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('clientes.index') }}">@yield('clientesAppTitle')</a></li>
	    <li class="active">Crear</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> @yield('clientesAppTitle') / Crear </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::open(array('route' => 'clientes.store', 'id'=>'frm_cliente')) !!}
            

@include('clientes._form')

                <div class="row">
                </div>
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary submitForm">Crear</button>
                    <a class="btn btn-link pull-right" href="{{ route('clientes.index') }}"><i class="glyphicon glyphicon-backward"></i> Clientes</a>
                    <a class="btn btn-link pull-right" href="{{ route('clientes.index', array('p'=>1)) }}"><i class="glyphicon glyphicon-backward"></i> Inscritos</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection