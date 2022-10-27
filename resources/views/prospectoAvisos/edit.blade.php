@extends('plantillas.admin_template')

@include('prospectoAvisos._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('prospectoAvisos.index') }}">@yield('prospectoAvisosAppTitle')</a></li>
	    <li><a href="{{ route('prospectoAvisos.show', $prospectoAviso->id) }}">{{ $prospectoAviso->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('prospectoAvisosAppTitle') / Editar {{$prospectoAviso->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($prospectoAviso, array('route' => array('prospectoAvisos.update', $prospectoAviso->id),'method' => 'post')) !!}

@include('prospectoAvisos._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('prospectoAvisos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection