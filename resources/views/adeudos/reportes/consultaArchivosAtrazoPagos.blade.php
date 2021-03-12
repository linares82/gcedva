@extends('plantillas.admin_template')

@include('seguimientos._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('seguimientos.index') }}">@yield('seguimientosAppTitle')</a></li>
	    <li class="active">Adeudos por Plantel</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> Clientes con Adeudos Detectados y Cambiados de Estatus </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">
        <ul>
                @foreach($ficheros as $fichero)
                @if($loop->index>1)
                <li>
                    <a href="{{ asset('storage/atrazoPagos/'.$fichero) }}" target="_blank">{{$fichero}}</a>
                    <a class="btn btn-danger btn-xs" href="{{ route('adeudos.borrarArchivoAtrazoPago', array('archivo'=>$fichero)) }}" >Borrar</a>
                </li>
                @endif
                @endforeach
            </ul>
            
        </div>
    </div>
@endsection

@push('scripts')
  <script type="text/javascript">
    $(document).ready(function() {
    

    $('#concepto_f-field').select2();

    
    $('#fecha_f-field').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
      });
      $('#fecha_t-field').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
      });
        
    });

    

    </script>
@endpush

