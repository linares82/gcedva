@extends('plantillas.admin_template')

@include('bsBajas._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('bsBajas.index') }}">@yield('bsBajasAppTitle')</a></li>
	    <li><a href="{{ route('bsBajas.show', $bsBaja->id) }}">{{ $bsBaja->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('bsBajasAppTitle') / Editar {{$bsBaja->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($bsBaja, array('route' => array('bsBajas.update', $bsBaja->id),'method' => 'post')) !!}

@include('bsBajas._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('bsBajas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection