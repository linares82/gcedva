@extends('plantillas.admin_template')

@include('cuentasEfectivoPlantels._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('cuentasEfectivoPlantels.index') }}">@yield('cuentasEfectivoPlantelsAppTitle')</a></li>
	    <li><a href="{{ route('cuentasEfectivoPlantels.show', $cuentasEfectivoPlantel->id) }}">{{ $cuentasEfectivoPlantel->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('cuentasEfectivoPlantelsAppTitle') / Editar {{$cuentasEfectivoPlantel->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($cuentasEfectivoPlantel, array('route' => array('cuentasEfectivoPlantels.update', $cuentasEfectivoPlantel->id),'method' => 'post')) !!}

@include('cuentasEfectivoPlantels._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('cuentasEfectivoPlantels.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection