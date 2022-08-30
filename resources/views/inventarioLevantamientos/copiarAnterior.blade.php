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

            {!! Form::open(array('route' => 'inventarioLevantamientos.copiarLineas')) !!}
            <div class="form-group col-md-4 @if($errors->has('plantel_id')) has-error @endif">
                            <label for="plantel_id-field">Levantamiento Origen</label>
                            {!! Form::hidden("destino", $destino, array("class" => "form-control input-sm", "id" => "destino-field")) !!}
                            {!! Form::select("origen", $inventarioLevantamiento, null, array("class" => "form-control select_seguridad", "id" => "origen-field")) !!}
                            @if($errors->has("origen"))
                            <span class="help-block">{{ $errors->first("origen") }}</span>
                            @endif
                        </div>
            
                <div class="row">
                </div>
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Copiar</button>
                    <a class="btn btn-link pull-right" href="{{ route('inventarioLevantamientos.index') }}"><i class="glyphicon glyphicon-backward"></i> Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection