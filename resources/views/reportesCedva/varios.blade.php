@extends('plantillas.admin_template')

@include('seguimientos._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('seguimientos.index') }}">@yield('seguimientosAppTitle')</a></li>
	    <li class="active">Reporte de Seguimientos</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> @yield('seguimientosAppTitle') / Reporte de Seguimientos por Empleado para Planteles </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::open(array('route' => 'reportesCedva.reportesR', 'id'=>'frm_analitica')) !!}

            <div class="form-group col-md-6 @if($errors->has('reportes_f')) has-error @endif">
                <label for="reportes_f-field">Reporte:</label>
                {!! Form::select("reportes_f", $reportes, null, array("class" => "form-control select_seguridad", "id" => "reportes_f-field")) !!}
                @if($errors->has("reportes_f"))
                <span class="help-block">{{ $errors->first("plantel_f") }}</span>
                @endif
            </div>

            <div class="form-group col-md-6 @if($errors->has('agrupamiento_plantel_id')) has-error @endif">
                <label for="agrupamiento_plantel_id-field">Agrupamiento Planteles<i id="lbl_trabajando"></i></label>
                {!! Form::select("agrupamiento_plantel_id", $agrupamientoPlantels, null, array("class" => "form-control select_seguridad", "id" => "agrupamiento_plantel_id-field")) !!}
                @if($errors->has("agrupamiento_plantel_id"))
                    <span class="help-block">{{ $errors->first("agrupamiento_plantel_id") }}</span>
                @endif
            </div>


            <div class="form-group col-md-6 @if($errors->has('plantel_f')) has-error @endif">
                <label for="plantel_f-field">Plantel de:</label>
                {!! Form::select("plantel_f[]", $planteles, null, array("class" => "form-control select_seguridad", "id" => "plantel_f-field", 'multiple'=>true)) !!}
                @if($errors->has("plantel_f"))
                <span class="help-block">{{ $errors->first("plantel_f") }}</span>
                @endif
            </div>

            <div class="form-group col-md-6 @if($errors->has('ciclo_f')) has-error @endif">
                <label for="ciclo_f-field">Ciclo de:</label>
                <a href='#' id='select-allCiclos'>Seleccionar todos</a>
                {!! Form::select("ciclo_f[]", $ciclos, null, array("class" => "form-control select_seguridad", "id" => "ciclo_f-field", 'multiple'=>true)) !!}
                @if($errors->has("ciclo_f"))
                <span class="help-block">{{ $errors->first("ciclo_f") }}</span>
                @endif
            </div>
            <div class="form-group col-md-6 @if($errors->has('estatus_f')) has-error @endif">
                <label for="estatus_f-field">Estatus:</label>
                {!! Form::select("estatus_f", $estatus, null, array("class" => "form-control select_seguridad", "id" => "estatus_f-field")) !!}
                @if($errors->has("estatus_f"))
                <span class="help-block">{{ $errors->first("estatus_f") }}</span>
                @endif
            </div>

            <div class="form-group col-md-6 @if($errors->has('pagos_f')) has-error @endif" style="clear:left;">
                <label for="pagos_f-field">Pagos:</label>
                {!! Form::select("pagos_f", $pagos, null, array("class" => "form-control select_seguridad", "id" => "pagos_f-field")) !!}
                @if($errors->has("pagos_f"))
                <span class="help-block">{{ $errors->first("pagos_f") }}</span>
                @endif
            </div>
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
                <div class="form-group col-md-6 @if($errors->has('concepto_caja_f')) has-error @endif">
                    <label for="concepto_caja-field">Conceptos:</label>
                    {!! Form::select("concepto_caja_f[]", $caja_conceptos, null, array("class" => "form-control select_seguridad", "id" => "concepto_caja_f-field",'multiple'=>true)) !!}
                    @if($errors->has("concepto_caja_f"))
                    <span class="help-block">{{ $errors->first("concepto_caja_f") }}</span>
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

    cambioAgrupamiento();

    $('#select-allCiclos').click(function(){
        $('select#ciclo_f-field').multiSelect('select_all');
        return false;
    });

    $('#reportes_f-field').change(function(){
        if($('#reportes_f-field option:selected').val()==6 || $('#reportes_f-field option:selected').val()==7){
            $('#concepto_caja_f-field').val(['5','6','7','8','9','10','11','12','13','14','15','16']).trigger('change');
            $('select#ciclo_f-field').multiSelect('select_all');
            $('#estatus_f-field').val('1').trigger('change');
            $('#pagos_f-field').val('1').trigger('change');
        }
        
        
    });

    $("#agrupamiento_plantel_id-field").change(function(event) {
        cambioAgrupamiento();
   });

   function cambioAgrupamiento(){
    $.ajax({
                  url: '{{ route("plantels.PlantelXAgrupamiento") }}',
                  type: 'GET',
                  data: {
                      'plantel_agrupamiento_id': $("#agrupamiento_plantel_id-field option:selected").val(), 
                  },
                  dataType: 'json',
                  beforeSend : function(){
                    $('#lbl_trabajando').html('...');
                    $("#fact_usuario").text('Procesando');
                    
                },
                  complete : function(datos){
                    $('#lbl_trabajando').html('');
                    $("#plantel_f-field").val(datos.responseJSON).change();

                  },
                  success: function(data){
                    
                  }
              });
   }

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