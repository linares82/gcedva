@extends('plantillas.admin_template')

@include('sepCertInstitucions._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('sepCertInstitucions.index') }}">@yield('sepCertInstitucionsAppTitle')</a></li>
	    <li><a href="{{ route('sepCertInstitucions.show', $sepCertInstitucion->id) }}">{{ $sepCertInstitucion->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('sepCertInstitucionsAppTitle') / Editar {{$sepCertInstitucion->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($sepCertInstitucion, array('route' => array('sepCertInstitucions.update', $sepCertInstitucion->id),'method' => 'post')) !!}

@include('sepCertInstitucions._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('sepCertInstitucions.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection