@extends('plantillas.admin_template')

@include('seguimientos._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('seguimientos.index') }}">@yield('seguimientosAppTitle')</a></li>
	    <li class="active">Reporte de Seguimientos</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> @yield('seguimientosAppTitle') / Altas de Prospectos </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

        <table class="table table-striped table-condensed">
            <thead>
                <th>Plantel</span></th>
                <th><span class="label bg-purple"> Asesores Hoy</span></th>
                <th><span class="label bg-purple"> Asesores Ayer</span></th>
                <th><span class="label label-info">Call Center -> Asesores Hoy</span></th>
                <th><span class="label label-info">Call Center -> Asesores Ayer</span></th>
            </thead>
            <tbody>
                @foreach($resumen as $registro)
                <tr>
                    <td>{{$registro['plantel']}}</td>
                    <td><span class="label label-success">{{$registro['asesoresHoy']}}</span></td>
                    <td><span class="label label-warning">{{$registro['asesoresAyer']}}</span></td>
                    <td><span class="label label-warning">{{$registro['callToAsesorHoy']}}</span></td>
                    <td><span class="label label-success">{{$registro['callToAsesorAyer']}}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
@endsection
@push('scripts')
  <script type="text/javascript">
    $(document).ready(function() {
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
    
    @permission('IreporteFiltroXplantel')
        $("#plantel_f-field").prop("disabled", true);
        $("#plantel_t-field").prop("disabled", true);
    @endpermission
        
    });
    
    </script>
@endpush