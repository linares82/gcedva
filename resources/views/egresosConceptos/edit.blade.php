@extends('plantillas.admin_template')

@include('egresosConceptos._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('egresosConceptos.index') }}">@yield('egresosConceptosAppTitle')</a></li>
	    <li><a href="{{ route('egresosConceptos.show', $egresosConcepto->id) }}">{{ $egresosConcepto->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('egresosConceptosAppTitle') / Editar {{$egresosConcepto->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($egresosConcepto, array('route' => array('egresosConceptos.update', $egresosConcepto->id),'method' => 'post')) !!}

@include('egresosConceptos._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('egresosConceptos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection