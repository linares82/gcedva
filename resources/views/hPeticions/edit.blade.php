@extends('plantillas.admin_template')

@include('hPeticions._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('hPeticions.index') }}">@yield('hPeticionsAppTitle')</a></li>
	    <li><a href="{{ route('hPeticions.show', $hPeticion->id) }}">{{ $hPeticion->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('hPeticionsAppTitle') / Editar {{$hPeticion->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($hPeticion, array('route' => array('hPeticions.update', $hPeticion->id),'method' => 'post')) !!}

@include('hPeticions._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('hPeticions.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection