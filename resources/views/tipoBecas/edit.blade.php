@extends('plantillas.admin_template')

@include('tipoBecas._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('tipoBecas.index') }}">@yield('tipoBecasAppTitle')</a></li>
	    <li><a href="{{ route('tipoBecas.show', $tipoBeca->id) }}">{{ $tipoBeca->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('tipoBecasAppTitle') / Editar {{$tipoBeca->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($tipoBeca, array('route' => array('tipoBecas.update', $tipoBeca->id),'method' => 'post')) !!}

@include('tipoBecas._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('tipoBecas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection