@extends('plantillas.admin_template')

@include('seguimientos._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('seguimientos.index') }}">@yield('seguimientosAppTitle')</a></li>
	    <li class="active">Reporte de Seguimientos</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> @yield('seguimientosAppTitle') / Inscritos por Plantel y Asesor </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::open(array('route' => 'inscripcions.inscritosSinMateriasLectivoR', 'id'=>'frm_analitica')) !!}

                <div class="form-group col-md-6 @if($errors->has('plantel_f')) has-error @endif">
                    <label for="plantel_f-field">Plantel de:</label>
                    {!! Form::select("plantel_f[]", $planteles, null, array("class" => "form-control select_seguridad", "id" => "plantel_f-field",'multiple'=>true)) !!}
                    @if($errors->has("plantel_f"))
                    <span class="help-block">{{ $errors->first("plantel_f") }}</span>
                    @endif
                </div>
                <!--
                <div class="form-group col-md-6 @if($errors->has('especialidad_f')) has-error @endif">
                    <label for="especialidad_f">Especialidad</label>
                    {!! Form::select("especialidad_f[]", $list["Especialidad"], null, array("class" => "form-control select_seguridad", "id" => "especialidad_f-field", 'multiple'=>true)) !!}
                    @if($errors->has("especialidad_f"))
                     <span class="help-block">{{ $errors->first("especialidad_f") }}</span>
                    @endif
                 </div>
                 <div class="form-group col-md-6 @if($errors->has('nivel_f')) has-error @endif">
                    <label for="nivel_f">nivel</label>
                    {!! Form::select("nivel_f[]", $list["nivel"], null, array("class" => "form-control select_seguridad", "id" => "nivel_f-field", 'multiple'=>true)) !!}
                    @if($errors->has("nivel_f"))
                     <span class="help-block">{{ $errors->first("nivel_f") }}</span>
                    @endif
                 </div>
                -->
            
<!--                <div class="form-group col-md-6 @if($errors->has('empleado_f')) has-error @endif">
                    <label for="empleado_f-field">Colaborador de:</label>
                    {!! Form::select("empleado_f", array(), null, array("class" => "form-control select_seguridad", "id" => "empleado_f-field")) !!}
                    @if($errors->has("empleado_f"))
                    <span class="help-block">{{ $errors->first("empleado_f") }}</span>
                    @endif
                </div>-->
                <div class="form-group col-md-6 @if($errors->has('lectivo_f')) has-error @endif">
                    <label for="lectivo_f-field">Lectivo:</label>
                    {!! Form::select("lectivo_f[]", $list["Lectivo"], null, array("class" => "form-control select_seguridad", "id" => "lectivo_f-field", 'multiple'=>true)) !!}
                    @if($errors->has("lectivo_f"))
                    <span class="help-block">{{ $errors->first("lectivo_f") }}</span>
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
        url: '{{ route("empleados.getAsesoresXplantel") }}',
        type: 'GET',
        data: "empleado_id="+$('#empleado_f-field option:selected').val()+"&plantel_id=" + $('#plantel_f-field option:selected').val()  + "",
        dataType: 'json',
        beforeSend : function(){$("#loading3").show();},
        complete : function(){$("#loading3").hide();},
        success: function(data){

            $('#empleado_f-field').html('');
            //$('#especialidad_id-field').empty();
            $('#empleado_f-field').append($('<option></option>').text('Seleccionar Opción').val('0'));


            $.each(data, function(i) {

                $('#empleado_f-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].nombre+"<\/option>");

            });

        }
        });       
    }

    function getCmbEspecialidad(){
                        //var $example = $("#especialidad_id-field").select2();
                        
                        $.ajax({
                        url: '{{ route("especialidads.getCmbEspecialidad") }}',
                                type: 'GET',
                                data: {plantel_id:$('#plantel_id-field option:selected').val(),
                                especialidad_id:$('#especialidad_id-field option:selected').val()},
                                dataType: 'json',
                                beforeSend : function(){$("#loading10").show(); },
                                complete : function(){$("#loading10").hide(); },
                                success: function(data){
                                //$example.select2("destroy");
                                $('#especialidad_id-field').empty();
                                $('#especialidad_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                                $.each(data, function(i) {
                                //alert(data[i].name);
                                $('#especialidad_id-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                                });
                                //$example.select2();
                                }
                        });
                        }

    </script>
@endpush

