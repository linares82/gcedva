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
    <style>
    .disabled-select {
        background-color:#d5d5d5;
        opacity:0.5;
        border-radius:3px;
        cursor:not-allowed;
        position:absolute;
        top:0;
        bottom:0;
        right:0;
        left:0;
     }
     </style>
    <div class="row">
        <div class="col-md-12">

            {!! Form::open(array('route' => 'inscripcions.lista', 'id'=>'frm')) !!}

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
                
<!--                <div class="form-group col-md-6 @if($errors->has('plantel_f')) has-error @endif" id="div_plantel">
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
                </div>-->

<!--                <div class="form-group col-md-6 @if($errors->has('mes')) has-error @endif">
                    <label for="mes-field">Mes:</label>
                    {!! Form::select("mes", $meses, null, array("class" => "form-control select_seguridad", "id" => "mes")) !!}
                    @if($errors->has("mes"))
                    <span class="help-block">{{ $errors->first("mes") }}</span>
                    @endif
                </div>-->
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
                {!! Form::hidden("asignacion", $asignacion->id, array("class" => "form-control input-sm", "id" => "asignacion-field")) !!}
                {!! Form::hidden("plantel_f", $asignacion->plantel_id, array("class" => "form-control input-sm", "id" => "plantel_f-field")) !!}
                    {!! Form::hidden("lectivo_f", $asignacion->lectivo_id, array("class" => "form-control input-sm", "id" => "lectivo_f-field")) !!}
                    {!! Form::hidden("grupo_f", $asignacion->grupo_id, array("class" => "form-control input-sm", "id" => "grupo_f-field")) !!}
                    {!! Form::hidden("instructor_f", $asignacion->empleado_id, array("class" => "form-control input-sm", "id" => "instructor_f-field")) !!}
                    {!! Form::hidden("materia_f", $asignacion->materium_id, array("class" => "form-control input-sm", "id" => "materia_f-field")) !!}
                
<!--                <div class="form-group col-md-6 @if($errors->has('grupo_f')) has-error @endif">
                    <label for="grupo_f-field">Grupo de:</label>
                    {!! Form::select("grupo_f", $list["Grupo"], null, array("class" => "form-control select_seguridad", "id" => "grupo_f-field")) !!}
                    @if($errors->has("grupo_f"))
                    <span class="help-block">{{ $errors->first("grupo_f") }}</span>
                    @endif
                </div>
                
                <div class="form-group col-md-6 @if($errors->has('instructor_f')) has-error @endif">
                    <label for="instructor_f-field">Instructor de:</label>
                    {!! Form::select("instructor_f", $instructores, null, array("class" => "form-control select_seguridad", "id" => "instructor_f-field")) !!}
                    @if($errors->has("instructor_f"))
                    <span class="help-block">{{ $errors->first("instructor_f") }}</span>
                    @endif
                </div>

                <div class="form-group col-md-6 @if($errors->has('materia_f')) has-error @endif">
                    <label for="materia_f-field">Materia de:</label>
                    {!! Form::select("materia_f", $materias, null, array("class" => "form-control select_seguridad", "id" => "materia_f-field")) !!}
                    @if($errors->has("materia_f"))
                    <span class="help-block">{{ $errors->first("materia_f") }}</span>
                    @endif
                </div>
                -->
<!--                <div class="form-group col-md-6 @if($errors->has('grado_f')) has-error @endif">
                    <label for="grado_f-field">Grado de:</label>
                    {!! Form::select("grado_f", $list["Grado"], null, array("class" => "form-control select_seguridad", "id" => "grado_f-field")) !!}
                    @if($errors->has("grado_f"))
                    <span class="help-block">{{ $errors->first("grado_f") }}</span>
                    @endif
                </div>-->

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
        $('#frm').submit();
        $plantel_activo='{{DB::table("empleados")->where("user_id", Auth::user()->id)->value("plantel_id")}}';
        //$('#plantel_f-field').val($plantel_activo).change();
    /*
      $('#lectivo_f-field').change(function(){
         lectivo=$('#lectivo_f-field option:selected').val();
         
            $.ajax({
                  url: '{{ route("lectivos.getLectivo") }}',
                  type: 'GET',
                  data: "lectivo=" + lectivo,
                  dataType: 'json',
                  beforeSend : function(){$("#loading13").show();},
                  complete : function(){$("#loading13").hide();},
                  success: function(data){
                      $('#fecha_f-field').Zebra_DatePicker({
                            // remember that the way you write down dates
                            // depends on the value of the "format" property!
                            direction: [data.inicio, data.fin],
                            days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
                            months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                            readonly_element: false,
                            lang_clear_date: 'Limpiar',
                            show_select_today: 'Hoy',
                        });
                        $('#fecha_t-field').Zebra_DatePicker({
                            // remember that the way you write down dates
                            // depends on the value of the "format" property!
                            direction: [data.inicio, data.fin],
                            days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
                            months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                            readonly_element: false,
                            lang_clear_date: 'Limpiar',
                            show_select_today: 'Hoy',
                        });
                  }  
            });        
      });
      */
     
     
     
      $('#plantel_f-field').change(function(){
        getCmbLectivoAsignacionAcademica()
        });
      
      $('#lectivo_f-field').change(function(){
        getCmbGrupo();
        });
    $('#grupo_f-field').change(function(){
        //getCmbGrado();
        
        getCmbInstructor();
        });
       $('#instructor_f-field').change(function(){
        
        getCmbMateria();
        
        });
    
      
    function getCmbLectivoAsignacionAcademica(){
        $.ajax({
                  url: '{{ route("asignacionAcademica.getCmbLectivo") }}',
                  type: 'GET',
                  data: "plantel_id=" + $('#plantel_f-field option:selected').val() + 
                        "&lectivo_id=" + $('#lectivo_f-field option:selected').val() + "",
                  dataType: 'json',
                  beforeSend : function(){$("#loading13").show();},
                  complete : function(){$("#loading13").hide();},
                  success: function(data){
                      //$example.select2("destroy");
                      $('#lectivo_f-field').html('');
                      
                      //$('#especialidad_id-field').empty();
                      $('#lectivo_f-field').append($('<option></option>').text('Seleccionar').val('0'));
                      
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#lectivo_f-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                      });
                      //$example.select2();
                  }
              });
    }  
      
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
      
      function getCmbMateria(){
            //var $example = $("#especialidad_id-field").select2();
            var plantel=$('#plantel_f-field option:selected').val();
            var grupo = $('#grupo_f-field option:selected').val();
            var lectivo= $('#lectivo_f-field option:selected').val();
            var instructor= $('#instructor_f-field option:selected').val();
            if(plantel>0 && grupo>0 && lectivo>0){
                $.ajax({
                url: '{{ route("materias.getCmbMateriaXAsignacionAcademica") }}',
                        type: 'GET',
                        data: "plantel=" + plantel + 
                              "&grupo=" + grupo +
                              "&lectivo=" + lectivo +
                              "&instructor=" + instructor + "",
                        dataType: 'json',
                        beforeSend : function(){$("#loading12").show(); },
                        complete : function(){$("#loading12").hide(); },
                        success: function(data){
                        //alert(data);
                        //$example.select2("destroy");
                        $('#materia_f-field').html('');
                        //$('#especialidad_id-field').empty();
                        $('#materia_f-field').append($('<option></option>').text('Seleccionar').val('0'));
                        $.each(data, function(i) {
                        //alert(data[i].name);
                        $('#materia_f-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                        });
                        
                        }
                });
            }
            
        }
        
        function getCmbInstructor(){
            //var $example = $("#especialidad_id-field").select2();
            var plantel=$('#plantel_f-field option:selected').val();
            var grupo = $('#grupo_f-field option:selected').val();
            var lectivo= $('#lectivo_f-field option:selected').val();
            var instructor= $('#instructor_f-field option:selected').val();
            
                $.ajax({
                url: '{{ route("asignacionAcademica.getCmbInstructor") }}',
                        type: 'GET',
                        data: "plantel=" + plantel + 
                              "&grupo=" + grupo +
                              "&lectivo=" + lectivo + 
                              "&instructor=" + instructor + "",
                        dataType: 'json',
                        beforeSend : function(){$("#loading12").show(); },
                        complete : function(){$("#loading12").hide(); },
                        success: function(data){
                        //alert(data);
                        //$example.select2("destroy");
                        $('#instructor_f-field').html('');
                        //$('#especialidad_id-field').empty();
                        $('#instructor_f-field').append($('<option></option>').text('Seleccionar').val('0'));
                        $.each(data, function(i) {
                        //alert(data[i].name);
                        $('#instructor_f-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                        });
                        
                        }
                });
            
            
        }
    
    
    
    @permission('IreporteFiltroXplantel')
        //$("#plantel_f-field").prop("disabled", true);
        $("#div_plantel").append('<div class="disabled-select"></div>');
    @endpermission
        
    });
    
    </script>
@endpush