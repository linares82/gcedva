@extends('plantillas.admin_template')

@include('bsBajas._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    
    <li class="active"></li>
</ol>

<div class="page-header">
        <h1>@yield('bsBajasAppTitle') / Mostrar 


        </h1>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                {!! Form::open(array('route' => 'bsBajas.prospectosBajasR', 'id'=>'frm_reporte')) !!}

<!--                <div class="form-group col-md-6 @if($errors->has('estatus_f')) has-error @endif">
                    <label for="estatus_f-field">Estatus de:</label>
                    @{!! Form::select("estatus_f", $list["StCliente"], null, array("class" => "form-control select_seguridad", "id" => "estatus_f-field", 'readonly'=>'readonly')) !!}
                    @if($errors->has("estatus_f"))
                    <span class="help-block">{{ $errors->first("estatus_f") }}</span>
                    @endif
                </div>
            
                <div class="form-group col-md-6 @if($errors->has('estatus_t')) has-error @endif">
                    <label for="estatus_t-field">Estatus a:</label>
                    @{!! Form::select("estatus_t", $list["StCliente"], null, array("class" => "form-control select_seguridad", "id" => "estatus_t-field", 'readonly'=>'readonly')) !!}
                    @if($errors->has("estatus_t"))
                    <span class="help-block">{{ $errors->first("estatus_t") }}</span>
                    @endif
                </div>-->
            
                <div class="form-group col-md-6 @if($errors->has('plantel_f')) has-error @endif">
                    <label for="plantel_f-field">Plantel de:</label>
                    {!! Form::select("plantel_f", $planteles, null, array("class" => "form-control select_seguridad", "id" => "plantel_f-field")) !!}
                    <div id='loading10' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                    @if($errors->has("plantel_f"))
                    <span class="help-block">{{ $errors->first("plantel_f") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-6 @if($errors->has('cantidad_adeudos_f')) has-error @endif">
                    <label for="cantidad_adeudos_f-field">Cantidad Adeudos:</label>
                    {!! Form::text("cantidad_adeudos_f", null, array("class" => "form-control input-sm", "id" => "cantidad_adeudos_f-field", "value"=>2)) !!}
                    @if($errors->has("cantidad_adeudos_f"))
                    <span class="help-block">{{ $errors->first("cantidad_adeudos_f") }}</span>
                    @endif
                </div>
            <!--
                <div class="form-group col-md-6 @if($errors->has('fecha_f')) has-error @endif">
                    <label for="fecha_f-field">Fecha de:</label>
                    {!! Form::text("fecha_f", null, array("class" => "form-control input-sm", "id" => "fecha_f-field")) !!}
                    @if($errors->has("fecha_f"))
                    <span class="help-block">{{ $errors->first("fecha_f") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-6 @if($errors->has('fecha_t')) has-error @endif">
                    <label for="fecha_t-field">Fecha a:</label>
                    {!! Form::text("fecha_t", null, array("class" => "form-control input-sm", "id" => "fecha_t-field")) !!}
                    @if($errors->has("fecha_t"))
                    <span class="help-block">{{ $errors->first("fecha_t") }}</span>
                    @endif
                </div>
            -->
                
                
                
                
                <div class="row">
                </div>
                <div class="well well-sm">
                    <button id="submit_tbl" type="submit" class="btn btn-primary">Tabla</button>
		    @permission('bsBajas.id_key_bs')
                    <a href="{{ route('bsBajas.apiAutenticar') }}" class="btn btn-success ">Autenticar API Brigthspace</a>
                    <a href="{{ route('bsBajas.apiDesautenticar') }}" class="btn btn-danger ">Salir API Brigthspace</a>
		    @endpermission
                </div>
            {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script type="text/javascript">
    document.getElementById('cantidad_adeudos_f-field').value=2;
    
</script>
@endpush