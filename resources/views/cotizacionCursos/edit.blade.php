@extends('plantillas.admin_template')

@include('cotizacionCursos._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('cotizacionCursos.index') }}">@yield('cotizacionCursosAppTitle')</a></li>
	    <li><a href="{{ route('cotizacionCursos.show', $cotizacionCurso->id) }}">{{ $cotizacionCurso->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('cotizacionCursosAppTitle') / Editar {{$cotizacionCurso->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($cotizacionCurso, array('route' => array('cotizacionCursos.update', $cotizacionCurso->id),'method' => 'post')) !!}

@include('cotizacionCursos._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('cotizacionCursos.cotizacionesEmpresa',array('empresa'=>$empresa->id)) }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection