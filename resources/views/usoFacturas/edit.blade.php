@extends('plantillas.admin_template')

@include('usoFacturas._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('usoFacturas.index') }}">@yield('usoFacturasAppTitle')</a></li>
	    <li><a href="{{ route('usoFacturas.show', $usoFactura->id) }}">{{ $usoFactura->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('usoFacturasAppTitle') / Editar {{$usoFactura->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($usoFactura, array('route' => array('usoFacturas.update', $usoFactura->id),'method' => 'post')) !!}

@include('usoFacturas._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('usoFacturas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection