@extends('plantillas.admin_template')

@include('seguimientos._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('seguimientos.index') }}">@yield('seguimientosAppTitle')</a></li>
	    <li class="active">Reporte de Seguimientos</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> @yield('seguimientosAppTitle') / Ingresos VS. Egresos </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::open(array('route' => 'pagos.postRptPagos', 'id'=>'frm_analitica')) !!}

                <div class="form-group col-md-6 @if($errors->has('plantel_f')) has-error @endif">
                    <label for="plantel_f-field">Plantel de:</label>
                    {!! Form::select("plantel_f", $plantels, null, array("class" => "form-control select_seguridad", "id" => "plantel_f-field")) !!}
                    @if($errors->has("plantel_f"))
                    <span class="help-block">{{ $errors->first("plantel_f") }}</span>
                    @endif
                </div>
                
<!--                <div class="form-group col-md-6 @if($errors->has('plantel_t')) has-error @endif">
                    <label for="plantel_t-field">Plantel a:</label>
                    {!! Form::select("plantel_t", $list["Plantel"], null, array("class" => "form-control select_seguridad", "id" => "plantel_t-field")) !!}
                    @if($errors->has("plantel_t"))
                    <span class="help-block">{{ $errors->first("plantel_t") }}</span>
                    @endif
                </div>-->
            
<!--                <div class="form-group col-md-6 @if($errors->has('empleado_f')) has-error @endif">
                    <label for="empleado_f-field">Colaborador de:</label>
                    {!! Form::select("empleado_f[]", $empleados, null, array("class" => "form-control select_seguridad", "id" => "empleado_f-field", 'multiple'=>true)) !!}
                    @if($errors->has("empleado_f"))
                    <span class="help-block">{{ $errors->first("empleado_f") }}</span>
                    @endif
                </div>-->
<!--                <div class="form-group col-md-6 @if($errors->has('lectivo_f')) has-error @endif">
                    <label for="lectivo_f-field">Lectivo:</label>
                    {!! Form::select("lectivo_f", $list["Lectivo"], null, array("class" => "form-control select_seguridad", "id" => "lectivo_f-field")) !!}
                    @if($errors->has("lectivo_f"))
                    <span class="help-block">{{ $errors->first("lectivo_f") }}</span>
                    @endif
                </div>-->
                <div class="form-group col-md-6 @if($errors->has('fecha_pago')) has-error @endif">
                     <label>Fecha Pago {!!Form::radio('fecha_pago', '1')!!}</label>
                     <label>Fecha Pago Creacion {!!Form::radio('fecha_pago', '2')!!}</label>
                    @if($errors->has("fecha_pago"))
                    <span class="help-block">{{ $errors->first("fecha_pago") }}</span>
                    @endif
                </div>

                <div class="row"></div>
                
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
                
                <div class="form-group col-md-12 @if($errors->has('empleado_f')) has-error @endif">
                    <label for="empleado_f-field">Colaborador(s):</label>
                    <a href='#' id='select-all-empleados'>Seleccionar todos</a> / 
                    <a href='#' id='deselect-all-empleados'>Deseleccionar todos</a>
                    <label>{!! Form::checkbox("bnd-todos-empleados", 1, null, [ "id" => "bnd-todos-empleados-field", 'class'=>'minimal']) !!} Todos</label>
                    <div id="select_empleado">
                    {!! Form::select("empleado_f[]", $empleados, null, array("class" => "form-control select_seguridad", "id" => "empleado_f-field", 'multiple'=>true)) !!}
                    </div>
                    @if($errors->has("empleado_f"))
                    <span class="help-block">{{ $errors->first("empleado_f") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-12 @if($errors->has('concepto_f')) has-error @endif">
                    <label for="concepto_f-field">Concepto:</label>
                    <a href='#' id='select-all-conceptos'>Seleccionar todos</a> /
                    <a href='#' id='deselect-all-conceptos'>Deseleccionar todos</a>
                    <div id="select_conceptos">
                    {!! Form::select("concepto_f[]", $conceptos, null, array("class" => "form-control select_seguridad", "id" => "concepto_f-field", 'multiple'=>true)) !!}
                    </div>
                    @if($errors->has("concepto_f"))
                    <span class="help-block">{{ $errors->first("concepto_f") }}</span>
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
        $('#select-all-empleados').click(function(){
            $('select#empleado_f-field').multiSelect('select_all');
            return false;
        });

        $('#deselect-all-empleados').click(function(){
            $('select#empleado_f-field').multiSelect('deselect_all');
            return false;
        });

        $('#select-all-conceptos').click(function(){
            $('select#concepto_f-field').multiSelect('select_all');
            return false;
        });

        $('#deselect-all-conceptos').click(function(){
            $('select#concepto_f-field').multiSelect('deselect_all');
            return false;
        });


        @permission('IreporteFiltroXplantel')
        $("#plantel_f-field").prop("disabled", true);
        //$("#plantel_t-field").prop("disabled", true);
        @endpermission

        $('#plantel_f-field').change(function(){
            getCmbEmpleados()
        });
        
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

    function getCmbEmpleados(){
        $.ajax({
        url: '{{ route("empleados.getEmpleadosXplantel") }}',
        type: 'GET',
        data: "empleado_id="+$('#empleado_f-field option:selected').val()+"&plantel_id=" + $('#plantel_f-field option:selected').val()  +"&puesto_id=5" + "",
        dataType: 'json',
        beforeSend : function(){$("#loading3").show();},
        complete : function(){$("#loading3").hide();},
        success: function(data){

            $('#empleado_f-field').html('');
            //$('#especialidad_id-field').empty();
            $('#empleado_f-field').append($('<option></option>').text('Seleccionar OpciÃ³n').val('0'));


            $.each(data, function(i) {

                $('#empleado_f-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].nombre+"<\/option>");

            });

        }
        });       
    }

    </script>
@endpush

