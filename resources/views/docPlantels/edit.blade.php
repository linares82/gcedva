@extends('plantillas.admin_template')

@include('docPlantels._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('docPlantels.index') }}">@yield('docPlantelsAppTitle')</a></li>
	    <li><a href="{{ route('docPlantels.show', $docPlantel->id) }}">{{ $docPlantel->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('docPlantelsAppTitle') / Editar {{$docPlantel->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($docPlantel, array('route' => array('docPlantels.update', $docPlantel->id),'method' => 'post')) !!}

@include('docPlantels._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('docPlantels.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection