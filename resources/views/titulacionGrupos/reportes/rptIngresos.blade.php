@extends('plantillas.admin_template')

@include('seguimientos._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li class="active">Reporte de Ingresos</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i>  Reporte de Ingresos </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::open(array('route' => 'titulacionGrupos.rptIngresosR')) !!}

                
                <div class="form-group col-md-6 @if($errors->has('plantel_f')) has-error @endif">
                    <label for="plantel_f-field">Plantel de:</label>
                    {!! Form::select("plantel_f[]", $plantels, null, array("class" => "form-control select_seguridad", "id" => "plantel_f-field", 'multiple'=>true)) !!}
                    @if($errors->has("plantel_f"))
                    <span class="help-block">{{ $errors->first("plantel_f") }}</span>
                    @endif
                </div>
                
                <div class="form-group col-md-6 @if($errors->has('titulacion_grupo_f')) has-error @endif">
                    <label for="titulacion_grupo_f-field">Grupo:</label>
                    {!! Form::select("titulacion_grupo_f[]", $grupos, null, array("class" => "form-control select_seguridad", "id" => "titulacion_grupo_f-field",'multiple'=>true)) !!}
                    @if($errors->has("plantel_t"))
                    <span class="help-block">{{ $errors->first("titulacion_grupo_f") }}</span>
                    @endif
                </div>
                
                
                <div class="row">
                </div>
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Tabla</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
@push('scripts')
  <script type="text/javascript">
    $(document).ready(function() {
        
    });
    
    </script>
@endpush