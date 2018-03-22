@extends('plantillas.admin_template')

@include('smsPredefinidos._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('smsPredefinidos.index') }}">@yield('smsPredefinidosAppTitle')</a></li>
	    <li><a href="{{ route('smsPredefinidos.show', $smsPredefinido->id) }}">{{ $smsPredefinido->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('smsPredefinidosAppTitle') / Editar {{$smsPredefinido->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($smsPredefinido, array('route' => array('smsPredefinidos.update', $smsPredefinido->id),'method' => 'post')) !!}

@include('smsPredefinidos._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('smsPredefinidos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection