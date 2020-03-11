@extends('plantillas.admin_template')

@include('seguimientos._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('seguimientos.index') }}">@yield('seguimientosAppTitle')</a></li>
	    <li class="active">Adeudos por Plantel</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> Pagos Plan </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::open(array('route' => 'adeudos.adeudosXClienteR', 'id'=>'frm', 'method'=>'post')) !!}

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
                <div class="form-group col-md-6 @if($errors->has('cliente')) has-error @endif">
                    <label for="cliente-field">Cliente:</label>
                    {!! Form::text("cliente", null, array("class" => "form-control input-sm", "id" => "cliente-field")) !!}
                    @if($errors->has("cliente"))
                    <span class="help-block">{{ $errors->first("cliente") }}</span>
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
    @permission('IreporteFiltroXplantel')
        $("#plantel_f-field").prop("disabled", true);
        //$("#plantel_t-field").prop("disabled", true);
    @endpermission
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