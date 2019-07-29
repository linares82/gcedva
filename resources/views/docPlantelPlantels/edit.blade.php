@extends('plantillas.admin_template')

@include('docPlantelPlantels._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('docPlantelPlantels.index') }}">@yield('docPlantelPlantelsAppTitle')</a></li>
	    <li><a href="{{ route('docPlantelPlantels.show', $docPlantelPlantel->id) }}">{{ $docPlantelPlantel->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('docPlantelPlantelsAppTitle') / Editar {{$docPlantelPlantel->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($docPlantelPlantel, array('route' => array('docPlantelPlantels.update', $docPlantelPlantel->id),'method' => 'post')) !!}

@include('docPlantelPlantels._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('docPlantelPlantels.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection