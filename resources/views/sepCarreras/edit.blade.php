@extends('plantillas.admin_template')

@include('sepCarreras._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('sepCarreras.index') }}">@yield('sepCarrerasAppTitle')</a></li>
	    <li><a href="{{ route('sepCarreras.show', $sepCarrera->id) }}">{{ $sepCarrera->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('sepCarrerasAppTitle') / Editar {{$sepCarrera->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($sepCarrera, array('route' => array('sepCarreras.update', $sepCarrera->id),'method' => 'post')) !!}

@include('sepCarreras._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('sepCarreras.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection