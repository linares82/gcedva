
@extends('plantillas.admin_template')

@include('clientes._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('clientes.index') }}">@yield('clientesAppTitle')</a></li>
	    <li class="active">Crear</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> @yield('clientesAppTitle') / Crear </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::open(array('route' => 'captacions.carga', 'files'=>true)) !!}

                
                <div class="form-group col-md-4 @if($errors->has('archivo')) has-error @endif">
                   <label for="membrete-field">Archivo</label>
                   {!! Form::file('archivo') !!}
                   @if($errors->has("archivo"))
                    <span class="help-block">{{ $errors->first("archivo") }}</span>
                   @endif
                </div>
                
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Procesar
                        @if(isset($procesados))
                            Registros Cargados: {{ $procesados }}
                        @endif
                    </button>
                    <a class="btn btn-link pull-right" href="{{ route('captacions.index') }}"><i class="glyphicon glyphicon-backward"></i> Regresar</a>
                </div>

                

                 {!! Form::close() !!}
            <div class="box box-default">
              <div class="box-body">
                <div class="form-group col-md-12">
                   
                   <div class="info-box">
                      <a href="{!! asset('files/carga/captacion/layout_captacion.csv') !!}">
                        <span class="info-box-icon bg-green">
                        <i class="glyphicon glyphicon glyphicon-download-alt"></i>
                        </span>
                      </a>
                      <div class="info-box-content">
                        
                        <span class="progress-description">
                          <span class="info-box-text"><p>El archivo tiene la extensión csv y puede abrirse con excel, <br/> 
                            Contiene 2 lineas de encabezados que no deben ser borradas.</p></span>
                        </span>
                      </div>
                      
                   </div>
                </div>
              </div>
            </div> 
        </div>
    </div>
@endsection

@push('scripts')

@endpush