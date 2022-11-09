@extends('plantillas.admin_template')

@include('inventarioLevantamientos._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('inventarioLevantamientos.index') }}">@yield('inventarioLevantamientosAppTitle')</a></li>
	    <li class="active">Actualizar con Csv</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> @yield('inventarioLevantamientosAppTitle') / Actualizar con Csv </h3>
    </div>
@endsection

@section('content')
    @include('error')

    
@if (isset($nombre) and isset($total_lineas))
    <div class="alert alert-success">
        <p>Resultados, se procesaron {{$total_lineas}} lineas del archivo {{$nombre}}, se actualizaron {{$total_campos}} campos</p>
    </div>
@endif

    <div class="row">
        <div class="col-md-12">

            {!! Form::open(array('route' => 'inventarioLevantamientos.actualizarLineas', 'files'=>true)) !!}
            
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