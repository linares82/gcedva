@extends('plantillas.admin_template')

@include('seguimientos._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('seguimientos.index') }}">@yield('seguimientosAppTitle')</a></li>
	    <li class="active">CCXEP</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> @yield('seguimientosAppTitle') / Clientes - Comprobante de Estudios </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::open(array('route' => 'clientes.comprobanteEstudiosR', 'id'=>'frm_reporte')) !!}

                <div class="form-group col-md-6 @if($errors->has('cliente')) has-error @endif">
                    <label for="cliente-field">Cliente:</label>
                    {!! Form::text("cliente", null, null, array("class" => "form-control", "id" => "cliente-field")) !!}
                    @if($errors->has("cliente"))
                    <span class="help-block">{{ $errors->first("cliente") }}</span>
                    @endif
                </div>
                
                
                
                
                
                <div class="row">
                </div>
                <div class="well well-sm">
                    <button id="submit_tbl" type="submit" class="btn btn-primary">Ver</button>
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
