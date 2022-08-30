@extends('plantillas.admin_template')

@include('inventarioLevantamientos._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('inventarioLevantamientos.index') }}">@yield('inventarioLevantamientosAppTitle')</a></li>
	    <li class="active">Cargar Csv</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> @yield('inventarioLevantamientosAppTitle') / Cargar Csv </h3>
    </div>
@endsection

@section('content')
    @include('error')

    
@if (isset($nombre) and isset($total_lineas))
    <div class="alert alert-success">
        <p>Resultados, se procesaron {{$total_lineas}} lineas del archivo {{$nombre}}</p>
    </div>
@endif

    <div class="row">
        <div class="col-md-12">

            {!! Form::open(array('route' => 'inventarioLevantamientos.cargarLineas', 'files'=>true)) !!}
            <div class="form-group col-md-4 @if($errors->has('plantel_id')) has-error @endif">
                            <label for="plantel_id-field">Plantel</label>
                            {!! Form::hidden("inventario_levantamiento_id", $inventario_levantamiento_id, array("class" => "form-control input-sm", "id" => "inventario_levantamiento_id-field")) !!}
                            {!! Form::select("plantel_id", $plantels, null, array("class" => "form-control select_seguridad", "id" => "plantel_id-field")) !!}
                            @if($errors->has("plantel_id"))
                            <span class="help-block">{{ $errors->first("plantel_id") }}</span>
                            @endif
                        </div>
            <div class="form-group col-md-4 @if($errors->has('archivo')) has-error @endif">
                   <label for="archivo-field">Archivo</label>

                   {!! Form::file('archivo') !!}
                   @if($errors->has("archivo"))
                   <span class="help-block">{{ $errors->first("archivo") }}</span>
                   @endif
                </div>


                <div class="row">
                </div>
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Cargar</button>
                    <a class="btn btn-link pull-right" href="{{ route('inventarioLevantamientos.index') }}"><i class="glyphicon glyphicon-backward"></i> Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection