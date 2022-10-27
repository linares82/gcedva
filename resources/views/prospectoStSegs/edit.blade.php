@extends('plantillas.admin_template')

@include('prospectoStSegs._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('prospectoStSegs.index') }}">@yield('prospectoStSegsAppTitle')</a></li>
	    <li><a href="{{ route('prospectoStSegs.show', $prospectoStSeg->id) }}">{{ $prospectoStSeg->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('prospectoStSegsAppTitle') / Editar {{$prospectoStSeg->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($prospectoStSeg, array('route' => array('prospectoStSegs.update', $prospectoStSeg->id),'method' => 'post')) !!}

@include('prospectoStSegs._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('prospectoStSegs.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection