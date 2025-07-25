@extends('plantillas.admin_template')

@include('sepTituloLs._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('sepTituloLs.index') }}">@yield('sepTituloLsAppTitle')</a></li>
	    <li><a href="{{ route('sepTituloLs.show', $sepTituloL->id) }}">{{ $sepTituloL->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('sepTituloLsAppTitle') / Editar {{$sepTituloL->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($sepTituloL, array('route' => array('sepTituloLs.update', $sepTituloL->id),'method' => 'post')) !!}

@include('sepTituloLs._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('sepTituloLs.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection