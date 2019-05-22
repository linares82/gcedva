@extends('plantillas.admin_template')

@include('seguimientos._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('seguimientos.index') }}">@yield('seguimientosAppTitle')</a></li>
	    <li class="active">Adeudos por Plantel</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> Lista </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::open(array('route' => 'adeudos.reporteAdeudosPlanr', 'id'=>'frm', 'method'=>'get')) !!}

<!--                <div class="form-group col-md-6 @if($errors->has('fecha_f')) has-error @endif">
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
                </div>-->
                <div class="form-group col-md-6 @if($errors->has('plantel_f')) has-error @endif">
                    <label for="plantel_f-field">Plantel de:</label>
                    {!! Form::select("plantel_f", $planteles, null, array("class" => "form-control select_seguridad", "id" => "plantel_f-field")) !!}
                    @if($errors->has("plantel_f"))
                    <span class="help-block">{{ $errors->first("plantel_f") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-6 @if($errors->has('plan_f')) has-error @endif">
                    <label for="plan_f-field">Plan de:</label>
                    {!! Form::select("plan_f", $planes, null, array("class" => "form-control select_seguridad", "id" => "plan_f", 'multiple'=>'multiple','name'=>'plan_f[]')) !!}
                    @if($errors->has("plan_f"))
                    <span class="help-block">{{ $errors->first("plan_f") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-6 @if($errors->has('concepto_f')) has-error @endif">
                    <label for="concepto_f-field">Concepto de:</label>
                    {!! Form::select("concepto_f", $conceptos, null, array("class" => "form-control select_seguridad", "id" => "concepto_f-field")) !!}
                    <div id='loading1' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                    @if($errors->has("concepto_f"))
                    <span class="help-block">{{ $errors->first("concepto_f") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-6 @if($errors->has('concepto_t')) has-error @endif">
                    <label for="concepto_t-field">Concepto de:</label>
                    {!! Form::select("concepto_t", $conceptos, null, array("class" => "form-control select_seguridad", "id" => "concepto_t-field")) !!}
                    <div id='loading1' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                    @if($errors->has("concepto_t"))
                    <span class="help-block">{{ $errors->first("concepto_t") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-6 @if($errors->has('estatus_f')) has-error @endif">
                    <label for="estatus_f-field">Estatus Caja de:</label>
                    {!! Form::select("estatus_f", $estatus, null, array("class" => "form-control select_seguridad", "id" => "estatus_f-field")) !!}
                    @if($errors->has("estatus_f"))
                    <span class="help-block">{{ $errors->first("estatus_f") }}</span>
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
    /*$('#fecha_f-field').Zebra_DatePicker({
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
      */
     //cmbConceptos();
     $('#plan_f-field').change(function(){
         //cmbConceptos();
     });
    function cmbConceptos(){
                        var a = $('#frm').serialize();
                        $.ajax({
                        url: '{{ route("planPagoLns.getCmbConceptosPlan") }}',
                                type: 'GET',
                                data: a,
                                dataType: 'json',
                                beforeSend : function(){$("#loading1").show(); },
                                complete : function(){$("#loading1").hide(); },
                                success: function(data){
                                    $('#concepto_f-field').html('');

                                    //$('#especialidad_id-field').empty();
                                    $('#concepto_f-field').append($('<option></option>').text('Seleccionar').val('0'));

                                    $.each(data, function(i) {
                                        //alert(data[i].name);
                                        $('#concepto_f-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                                    });
                                }
                        });
                        }    
    });
    
    </script>
@endpush