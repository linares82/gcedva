@extends('plantillas.admin_template')

@include('comenMuebles._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('comenMuebles.index') }}">@yield('comenMueblesAppTitle')</a></li>
	    <li><a href="{{ route('comenMuebles.show', $comenMueble->id) }}">{{ $comenMueble->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('comenMueblesAppTitle') / Editar {{$comenMueble->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($comenMueble, array('route' => array('comenMuebles.update', $comenMueble->id),'method' => 'post')) !!}

@include('comenMuebles._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('comenMuebles.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection