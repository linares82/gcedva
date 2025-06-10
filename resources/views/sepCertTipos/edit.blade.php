@extends('plantillas.admin_template')

@include('sepCertTipos._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('sepCertTipos.index') }}">@yield('sepCertTiposAppTitle')</a></li>
	    <li><a href="{{ route('sepCertTipos.show', $sepCertTipo->id) }}">{{ $sepCertTipo->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('sepCertTiposAppTitle') / Editar {{$sepCertTipo->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($sepCertTipo, array('route' => array('sepCertTipos.update', $sepCertTipo->id),'method' => 'post')) !!}

@include('sepCertTipos._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('sepCertTipos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection