@extends('plantillas.admin_template')

@include('seguimientos._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('avisos.index') }}">@yield('avisosAppTitle')</a></li>
	    <li class="active">Consulta de avisos</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> @yield('avisosAppTitle') / Consulta de Avisos </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            <table class="table table-bordered table-striped dataTable">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Plantel</th>
                        <th>Empleado</th>
                        <th>Asunto</th>
                        <th>Detalle</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($avisos as $a)
                    <tr>
                        <td>
                        @if($a->dias_restantes<=0)
                            <small class="label label-danger">
                        @elseif($a->dias_restantes==1)
                            <small class="label label-warning"> 
                        @elseif($a->dias_restantes>=2)
                            <small class="label label-success"> 
                        @endif
                            {{$a->fecha}}
                        </small>
                        </td>
                        <td>{{$a->razon}}</td>
                        <td>{{$a->empleado}}</td>
                        <td>{{$a->name}}</td>
                        <td>{{$a->detalle}}</td>
                        <td>
                            <a class="btn btn-xs btn-primary" href="{{ route('seguimientos.show', $a->cliente_id) }}"><i class="glyphicon glyphicon-edit"></i> Ver Seguimiento</a>
                        </td>
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