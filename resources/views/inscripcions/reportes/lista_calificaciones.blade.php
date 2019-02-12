@extends('plantillas.admin_template')

@include('seguimientos._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('seguimientos.index') }}">@yield('seguimientosAppTitle')</a></li>
	    <li class="active">Reporte de Seguimientos</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> Lista </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::open(array('route' => 'inscripcions.listaCalificaciones', 'id'=>'frm')) !!}

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
                    {!! Form::select("plantel_f", $list["Plantel"], null, array("class" => "form-control select_seguridad", "id" => "plantel_f-field")) !!}
                    @if($errors->has("plantel_f"))
                    <span class="help-block">{{ $errors->first("plantel_f") }}</span>
                    @endif
                </div>
                
                <div class="form-group col-md-6 @if($errors->has('lectivo_f')) has-error @endif">
                    <label for="lectivo_f-field">Lectivo de:</label>
                    {!! Form::select("lectivo_f", $list["Lectivo"], null, array("class" => "form-control select_seguridad", "id" => "lectivo_f-field")) !!}
                    @if($errors->has("lectivo_f"))
                    <span class="help-block">{{ $errors->first("lectivo_f") }}</span>
                    @endif
                </div>
                
                <div class="form-group col-md-6 @if($errors->has('grupo_f')) has-error @endif">
                    <label for="grupo_f-field">Grupo de:</label>
                    {!! Form::select("grupo_f", $list["Grupo"], null, array("class" => "form-control select_seguridad", "id" => "grupo_f-field")) !!}
                    @if($errors->has("grupo_f"))
                    <span class="help-block">{{ $errors->first("grupo_f") }}</span>
                    @endif
                </div>
                
                <div class="form-group col-md-6 @if($errors->has('grado_f')) has-error @endif">
                    <label for="grado_f-field">Grado de:</label>
                    {!! Form::select("grado_f", $list["Grado"], null, array("class" => "form-control select_seguridad", "id" => "grado_f-field")) !!}
                    @if($errors->has("grado_f"))
                    <span class="help-block">{{ $errors->first("grado_f") }}</span>
                    @endif
                </div>

                <div class="form-group col-md-6 @if($errors->has('materias')) has-error @endif">
                    <label for="materias-field">Materias:</label>
                    {!! Form::select("materia", $materias, null, array("class" => "form-control select_seguridad", "id" => "materia")) !!}
                    @if($errors->has("materia"))
                    <span class="help-block">{{ $errors->first("materia") }}</span>
                    @endif
                </div>
                
                <!--
                <div class="form-group col-md-6 @if($errors->has('especialidad_f')) has-error @endif">
                    <label for="especialidad_f-field">Especialidad de:</label>
                    {!! Form::select("especialidad_f", $list["Especialidad"], null, array("class" => "form-control select_seguridad", "id" => "especialidad_f-field")) !!}
                    @if($errors->has("especialidad_f"))
                    <span class="help-block">{{ $errors->first("especialidad_f") }}</span>
                    @endif
                </div
                -->    
                
                
                
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
      
      $('#lectivo_f-field').change(function(){
        getCmbGrupo();
        });
    $('#grupo_f-field').change(function(){
        getCmbGrado();    
        });
      
    function getCmbGrupo(){
          //var $example = $("#especialidad_id-field").select2();
              $.ajax({
                  url: '{{ route("asignacionAcademica.getCmbGrupo") }}',
                  type: 'GET',
                  data: "plantel_id=" + $('#plantel_f-field option:selected').val() + 
                        "&grupo_id=" + $('#grupo_f-field option:selected').val() + 
                        "&lectivo_id=" + $('#lectivo_f-field option:selected').val() + "",
                  dataType: 'json',
                  beforeSend : function(){$("#loading13").show();},
                  complete : function(){$("#loading13").hide();},
                  success: function(data){
                      //$example.select2("destroy");
                      $('#grupo_f-field').html('');
                      
                      //$('#especialidad_id-field').empty();
                      $('#grupo_f-field').append($('<option></option>').text('Seleccionar').val('0'));
                      
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#grupo_f-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                      });
                      //$example.select2();
                  }
              });
          }
              
    function getCmbGrado(){
            //var $example = $("#especialidad_id-field").select2();

            $.ajax({
            url: '{{ route("grados.getCmbGradosXAsignacion") }}',
                    type: 'GET',
                    data: "plantel=" + $('#plantel_f-field option:selected').val() + 
                          "&grupo=" + $('#grupo_f-field option:selected').val() +
                          "&lectivo=" + $('#lectivo_f-field option:selected').val() + "",
                    dataType: 'json',
                    beforeSend : function(){$("#loading12").show(); },
                    complete : function(){$("#loading12").hide(); },
                    success: function(data){
                    //alert(data);
                    //$example.select2("destroy");
                    $('#grado_f-field').html('');
                    //$('#especialidad_id-field').empty();
                    $('#grado_f-field').append($('<option></option>').text('Seleccionar').val('0'));
                    $.each(data, function(i) {
                    //alert(data[i].name);
                    $('#grado_f-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                    });
                    //$example.select2();
                    }
            });
        }
      
    
    @permission('IreporteFiltroXplantel')
        $("#plantel_f-field").prop("disabled", true);
        $("#plantel_t-field").prop("disabled", true);
    @endpermission
        
    });
    
    </script>
@endpush