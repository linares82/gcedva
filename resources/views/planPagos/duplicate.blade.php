@extends('plantillas.admin_template')

@include('planPagos._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('planPagos.index') }}">@yield('planPagosAppTitle')</a></li>
	    <li class="active">Duplicate</li>
	</ol>

    <div class="page-header">
        <h1><i class="glyphicon glyphicon-duplicate"></i> @yield('planPagosAppTitle') / GENERAR LINEAS EN BASE A PLAN  {{$planPago->id}}</h1>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">
            
            {!! Form::model($planPago, array('route' => array('planPagos.fullDuplicate'))) !!}
            {!! Form::hidden("id_duplicado", optional($planPago)->id, array("class" => "form-control", "id" => "id_duplicado-field")) !!}
            

            @include('planPagos._form')

            <div class="box box-default box-solid">
                <div class="box-header">
                    <h3 class="box-title">GENERAR LINEAS EN BASE A OTRO PLAN</h3>
                    <div class="box-tools">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group col-md-4">
                        <label for="linea_id-field">Linea de Tiempo</label><br/>
                           {!! Form::select("linea_id", array(1=>'Futuro',-1=>'Pasado'), null, array("class" => "form-control select_seguridad", "id" => "linea_id-crear",)) !!}
                           
                     </div>
                    <div class="form-group col-md-4 @if($errors->has('fecha_pago')) has-error @endif">
                        <label for="fecha_pago-field">Dia Pago Mensualidad</label>
                        {!! Form::text("fecha_pago", null, array("class" => "form-control", "id" => "fecha_pago-field")) !!}
                        @if($errors->has("fecha_pago"))
                        <span class="help-block">{{ $errors->first("fecha_pago") }}</span>
                        @endif
                    </div>
                </div>
            </div>


            <div class="row">
            </div>

            <div class="well well-sm">
                <button type="submit" class="btn btn-primary">Duplicar</button>
                <a class="btn btn-link pull-right" href="{{ route('planPagos.index') }}"><i class="glyphicon glyphicon-backward"></i> Regresar</a>
            </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection