@extends('plantillas.admin_template')

@include('seguimientos._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('clientes.index') }}">@yield('clientesAppTitle')</a></li>
	    <li class="active">Altas por Usuario</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> @yield('seguimientosAppTitle') / Clientes con  Concepto Planeado </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::open(array('route' => 'clientes.alumnosConceptoPlaneadoR', 'id'=>'frm_reporte')) !!}

            <div class="form-group col-md-6 @if($errors->has('plantel_f')) has-error @endif">
                <label for="plantel_f-field">Plantel de:*<input type="checkbox" id="seleccionar_planteles">Seleccionar Todo</label>
                {!! Form::select("plantel_f[]", $planteles, null, array("class" => "form-control select_seguridad", "id" => "plantel_f-field", 'multiple'=>true)) !!}
                @if($errors->has("plantel_f"))
                <span class="help-block">{{ $errors->first("plantel_f") }}</span>
                @endif
            </div>

            <div class="form-group col-md-6 @if($errors->has('concepto_f')) has-error @endif">
                <label for="concepto_f-field">Concepto de:</label>
                {!! Form::select("concepto_f", $conceptos, null, array("class" => "form-control select_seguridad", "id" => "concepto_f-field")) !!}
                @if($errors->has("concepto_f"))
                <span class="help-block">{{ $errors->first("concepto_f") }}</span>
                @endif
            </div>
         
                <div class="form-group col-md-6 @if($errors->has('fecha_f')) has-error @endif" style="clear:left;">
                    <label for="fecha_f-field">Fecha Planeada:</label>
                    {!! Form::text("fecha_f", null, array("class" => "form-control input-sm", "id" => "fecha_f-field")) !!}
                    @if($errors->has("fecha_f"))
                    <span class="help-block">{{ $errors->first("fecha_f") }}</span>
                    @endif
                </div>

                <div class="form-group col-md-6 @if($errors->has('fecha_t')) has-error @endif">
                    <label for="fecha_t-field">Fecha A:</label>
                    {!! Form::text("fecha_t", null, array("class" => "form-control input-sm", "id" => "fecha_t-field")) !!}
                    @if($errors->has("fecha_t"))
                    <span class="help-block">{{ $errors->first("fecha_t") }}</span>
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

      $('#seleccionar_planteles').change(function(){
            if( $(this).is(':checked') ) {
            $("#plantel_f-field > option").prop("selected","selected");
                    $("#plantel_f-field").trigger("change");
            }else{
            $("#plantel_f-field > option").prop("selected","selected");
                    $('#plantel_f-field').val(null).trigger('change');
            }
        });

      $('#plantel_f-field').change(function(){
        getCmbEspecialidad();
      });

      function getCmbEspecialidad(){
        $.ajax({
        url: '{{ route("especialidads.getCmbEspecialidad") }}',
                type: 'GET',
                data: "plantel_id=" + $('#plantel_f-field option:selected').val() + "&especialidad_id=" + $('#especialidad_f-field option:selected').val() + "",
                dataType: 'json',
                beforeSend : function(){$("#loading10").show(); },
                complete : function(){$("#loading10").hide(); },
                success: function(data){
                $('#especialidad_f-field').empty();
                $('#especialidad_f-field').append($('<option></option>').text('Seleccionar').val('0'));
                $.each(data, function(i) {
                $('#especialidad_f-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                });
                
                }
        });
        }
        
    });
    
    </script>
@endpush