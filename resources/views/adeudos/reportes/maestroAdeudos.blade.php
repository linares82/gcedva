@extends('plantillas.admin_template')

@include('seguimientos._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('seguimientos.index') }}">@yield('seguimientosAppTitle')</a></li>
	    <li class="active">Adeudos por Plantel</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> Maestro </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::open(array('route' => 'adeudos.maestroAdeudosR', 'id'=>'frm')) !!}

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
                <div class="form-group col-md-6 @if($errors->has('plantel_f')) has-error @endif">
                    <label for="plantel_f-field">Plantel de:*<input type="checkbox" id="seleccionar_planteles">Seleccionar Todo</label>
                    {!! Form::select("plantel_f[]", $planteles, null, array("class" => "form-control select_seguridad", "id" => "plantel_f-field", 'multiple'=>true)) !!}
                    @if($errors->has("plantel_f"))
                    <span class="help-block">{{ $errors->first("plantel_f") }}</span>
                    @endif
                </div>
                <!--
                <div class="form-group col-md-6 @if($errors->has('detalle_f')) has-error @endif">
                    <label for="detalle_f-field">Con detalle:</label>
                    @{!! Form::select("detalle_f", array('3'=>'Adeudos'), null, array("class" => "form-control select_seguridad", "id" => "detalle_f-field")) !!}
                    @if($errors->has("detalle_f"))
                    <span class="help-block">{{ $errors->first("detalle_f") }}</span>
                    @endif
                </div>
            -->
                <div class="form-group col-md-6 @if($errors->has('concepto_f')) has-error @endif">
                    <label for="concepto_f-field">Concepto de:*<input type="checkbox" id="seleccionar_conceptos">Seleccionar Todo</label>
                    {!! Form::select("concepto_f[]", $conceptos, null, array("class" => "form-control select_seguridad", "id" => "concepto_f-field", 'multiple'=>true)) !!}
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
        
        $('#seleccionar_conceptos').change(function(){
            if( $(this).is(':checked') ) {
            $("#concepto_f-field > option").prop("selected","selected");
                    $("#concepto_f-field").trigger("change");
            }else{
            $("#concepto_f-field > option").prop("selected","selected");
                    $('#concepto_f-field').val(null).trigger('change');
            }
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

    $('#concepto_f-field').select2();

    @permission('maestro.detalleTodo')
        let opciones=new Array(5);
        opciones[1]= 'Ambos';
        opciones[2]='Pagos';
        opciones[3]='Adeudos';
        opciones[4]='Sin Detalle';
        $('#detalle_f-field').empty();
        for(i=1;i<opciones.length;i++){
            $('#detalle_f-field').append("<option value='" + i + "'>" + opciones[i] + "</option>");
        }
        $('#detalle_f-field').val(1);
        $('#detalle_f-field').trigger('change');
    @endpermission

    @permission('maestro.detalleAdeudos')
    console.log('adeudos');
        let opciones=new Array(5);
        opciones[3]='Adeudos';
        $('#detalle_f-field').empty();
        //for(i=0;i<opciones.length;i++){
            $('#detalle_f-field').append("<option value='3'>" + opciones[3] + "</option>");
        //}
        $('#detalle_f-field').val(3);
        $('#detalle_f-field').trigger('change');
    @endpermission


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

