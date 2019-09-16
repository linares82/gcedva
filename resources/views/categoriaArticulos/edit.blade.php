@extends('plantillas.admin_template')

@include('categoriaArticulos._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('categoriaArticulos.index') }}">@yield('categoriaArticulosAppTitle')</a></li>
	    <li><a href="{{ route('categoriaArticulos.show', $categoriaArticulo->id) }}">{{ $categoriaArticulo->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('categoriaArticulosAppTitle') / Editar {{$categoriaArticulo->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($categoriaArticulo, array('route' => array('categoriaArticulos.update', $categoriaArticulo->id),'method' => 'post')) !!}

@include('categoriaArticulos._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('categoriaArticulos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection