@extends('plantillas.admin_template')

@include('cuentaPs._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('cuentaPs.index') }}">@yield('cuentaPsAppTitle')</a></li>
	    <li><a href="{{ route('cuentaPs.show', $cuentaP->id) }}">{{ $cuentaP->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('cuentaPsAppTitle') / Editar {{$cuentaP->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($cuentaP, array('route' => array('cuentaPs.update', $cuentaP->id),'method' => 'post')) !!}

@include('cuentaPs._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('cuentaPs.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection