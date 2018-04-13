@extends('plantillas.admin_template')

@include('cajaLns._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('cajaLns.index') }}">@yield('cajaLnsAppTitle')</a></li>
	    <li><a href="{{ route('cajaLns.show', $cajaLn->id) }}">{{ $cajaLn->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('cajaLnsAppTitle') / Editar {{$cajaLn->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($cajaLn, array('route' => array('cajaLns.update', $cajaLn->id),'method' => 'post')) !!}

@include('cajaLns._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('cajaLns.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection