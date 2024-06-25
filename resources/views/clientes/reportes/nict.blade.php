@extends('plantillas.admin_template')

@include('seguimientos._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('clientes.index') }}">@yield('clientesAppTitle')</a></li>
	    <li class="active">Altas por Usuario</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> @yield('seguimientosAppTitle') / NICT </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::open(array('route' => 'clientes.nictR', 'id'=>'frm_reporte')) !!}

<!--                <div class="form-group col-md-6 @if($errors->has('estatus_f')) has-error @endif">
                    <label for="estatus_f-field">Estatus de:</label>
                    {!! Form::select("estatus_f", $list["StCliente"], null, array("class" => "form-control select_seguridad", "id" => "estatus_f-field", 'readonly'=>'readonly')) !!}
                    @if($errors->has("estatus_f"))
                    <span class="help-block">{{ $errors->first("estatus_f") }}</span>
                    @endif
                </div>
            
                <div class="form-group col-md-6 @if($errors->has('estatus_t')) has-error @endif">
                    <label for="estatus_t-field">Estatus a:</label>
                    {!! Form::select("estatus_t", $list["StCliente"], null, array("class" => "form-control select_seguridad", "id" => "estatus_t-field", 'readonly'=>'readonly')) !!}
                    @if($errors->has("estatus_t"))
                    <span class="help-block">{{ $errors->first("estatus_t") }}</span>
                    @endif
                </div>-->
            
                <div class="form-group col-md-6 @if($errors->has('plantel_f')) has-error @endif">
                    <label for="plantel_f-field">Plantel de:</label>
                    <a href='#' id='select-all'>Seleccionar todos</a> / 
                    <a href='#' id='deselect-all'>Deseleccionar todos</a>
                    {!! Form::select("plantel_f[]", $planteles, null, array("class" => "form-control select_seguridad", "id" => "plantel_f-field",'multiple'=>true)) !!}
                    @if($errors->has("plantel_f"))
                    <span class="help-block">{{ $errors->first("plantel_f") }}</span>
                    @endif
                </div>
            
                <div class="form-group col-md-6 @if($errors->has('inicio_matricula')) has-error @endif">
                    <label for="inicio_matricula-field">Inicio Matricula (4 digitos):</label>
                    {!! Form::text("inicio_matricula", null, array("class" => "form-control input-sm", "id" => "inicio_matricula-field")) !!}
                    @if($errors->has("inicio_matricula"))
                    <span class="help-block">{{ $errors->first("inicio_matricula") }}</span>
                    @endif
                </div>
               
                
                
                
                
                <div class="row">
                </div>
                <div class="well well-sm">
                    <button id="submit_tbl" type="submit" class="btn btn-primary">Tabla</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
@push('scripts')
  <script type="text/javascript">
    $(document).ready(function() {

        $('#select-all').click(function(){
            $('select#plantel_f-field').multiSelect('select_all');
            return false;
        });
        $('#deselect-all').click(function(){
            $('select#plantel_f-field').multiSelect('deselect_all');
            return false;
        });
        
    });
    
    </script>
@endpush