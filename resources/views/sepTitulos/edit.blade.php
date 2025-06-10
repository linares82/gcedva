@extends('plantillas.admin_template')

@include('sepTitulos._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('sepTitulos.index') }}">@yield('sepTitulosAppTitle')</a></li>
	    <li><a href="{{ route('sepTitulos.show', $sepTitulo->id) }}">{{ $sepTitulo->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('sepTitulosAppTitle') / Editar {{$sepTitulo->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($sepTitulo, array('route' => array('sepTitulos.update', $sepTitulo->id),'method' => 'post','id'=>'frm')) !!}

@include('sepTitulos._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('sepTitulos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection