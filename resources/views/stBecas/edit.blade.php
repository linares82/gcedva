@extends('plantillas.admin_template')

@include('stBecas._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('stBecas.index') }}">@yield('stBecasAppTitle')</a></li>
	    <li><a href="{{ route('stBecas.show', $stBeca->id) }}">{{ $stBeca->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('stBecasAppTitle') / Editar {{$stBeca->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($stBeca, array('route' => array('stBecas.update', $stBeca->id),'method' => 'post')) !!}

@include('stBecas._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('stBecas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection