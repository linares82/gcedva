@extends('plantillas.admin_template')

@include('inscripcions._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('inscripcions.index') }}">@yield('inscripcionsAppTitle')</a></li>
	    <li class="active">Crear</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> @yield('inscripcionsAppTitle') / Crear </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::open(array('route' => 'inscripcions.reinscripcion')) !!}

            <div class="box box-success box-solid">
                <div class="box-header">
                    <h3 class="box-title">De</h3>
                    <div class="box-tools">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                        <div class="form-group col-md-4 @if($errors->has('plantel_id')) has-error @endif">
                        <label for="plantel_id-field">Plantel</label>
                        {!! Form::select("plantel_id", $planteles, isset($input['plantel_id']) ? $input['plantel_id'] : null, array("class" => "form-control select_seguridad", "id" => "plantel_id-field")) !!}
                        @if($errors->has("plantel_id"))
                            <span class="help-block">{{ $errors->first("plantel_id") }}</span>
                        @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('especialidad')) has-error @endif">
                        <label for="especialidad-field">Especialidad</label>
                        {!! Form::select("especialidad_id", $list["Especialidad"], isset($input['especialidad_id']) ? $input['especialidad_id'] : null, array("class" => "form-control select_seguridad", "id" => "especialidad_id-field")) !!}
                        <div id='loading10' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                        @if($errors->has("especialidad"))
                            <span class="help-block">{{ $errors->first("especialidad") }}</span>
                        @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('nivel_id')) has-error @endif">
                        <label for="nivel_id-field">Nivel</label>
                        {!! Form::select("nivel_id", $list["Nivel"], isset($input['nivel_id']) ? $input['nivel_id'] : null, array("class" => "form-control select_seguridad", "id" => "nivel_id-field")) !!}
                        <div id='loading11' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                        @if($errors->has("nivel_id"))
                            <span class="help-block">{{ $errors->first("nivel_id") }}</span>
                        @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('grado_id')) has-error @endif">
                        <label for="grado_id-field">Grado</label>
                        {!! Form::select("grado_id", $list["Grado"], isset($input['grado_id']) ? $input['grado_id'] : null, array("class" => "form-control select_seguridad", "id" => "grado_id-field")) !!}
                        <div id='loading12' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                        @if($errors->has("grado_id"))
                            <span class="help-block">{{ $errors->first("grado_id") }}</span>
                        @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('lectivo_id')) has-error @endif">
                            <label for="lectivo_id-field">Periodo Lectivo</label>
                            {!! Form::select("lectivo_id", $list["Lectivo"], isset($input['lectivo_id']) ? $input['lectivo_id'] : null, array("class" => "form-control select_seguridad", "id" => "lectivo_id-field")) !!}
                            @if($errors->has("lectivo_id"))
                            <span class="help-block">{{ $errors->first("lectivo_id") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('grupo_id')) has-error @endif">
                            <label for="grupo_id-field" id="lbl_disponibles">De Grupo </label>
                            {!! Form::select("grupo_id", $list["Grupo"], isset($input['grupo_id']) ? $input['grupo_id'] : null, array("class" => "form-control select_seguridad", "id" => "grupo_id-field")) !!}
                            @if($errors->has("grupo_id"))
                            <span class="help-block">{{ $errors->first("grupo_id") }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                
                @if(isset($resultados))
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <td><input type="checkbox" id="select-all" /> Todos<br/></td>
                            <td>Cliente</td><td>Estatus Cliente</td><td>Periodo Estudios</td><td>Aprobadas</td><td>No Aprobadas</td>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach($resultados as $c)
                        <tr>
                            <td>
                                @if($c['no_aprobadas']<$bloqueo_materias_desaprobadas->valor)
                                {{ Form::checkbox("id[]", $c['id']) }}
                                @endif
                            </td>
                            <td>{{ $c['cliente'] }} - {{ $c['nombre'] }}</td>
                            <td>{{$c['st_cliente']}}</td>
                            <td>{{ $c['periodo_estudio'] }}</td>
                            <td> {{ $c['aprobadas'] }} 
                                <table id='aprobadas_modulo' style='display: none;'>
                                    <thead>
                                    <th>Materia</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td> {{ $c['no_aprobadas'] }} 
                            
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <div class="box box-warning box-solid">
                <div class="box-header">
                    <h3 class="box-title">A</h3>
                    <div class="box-tools">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                        <div class="form-group col-md-1 @if($errors->has('activar')) has-error @endif">
                            <label for="Activar-field">Activar</label>
                            {!! Form::checkbox("activar", 1, null, [ "id" => "activar-field", 'class'=>'minimal']) !!}
                            @if($errors->has("activar"))
                            <span class="help-block">{{ $errors->first("activar") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('especialidad_to')) has-error @endif">
                        <label for="especialidad_to-field">Especialidad</label>
                        {!! Form::select("especialidad_to", $list["Especialidad"], null, array("class" => "form-control select_seguridad", "id" => "especialidad_to-field")) !!}
                        <div id='loading10' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                        @if($errors->has("especialidad_to"))
                            <span class="help-block">{{ $errors->first("especialidad_to") }}</span>
                        @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('nivel_to')) has-error @endif">
                        <label for="nivel_to-field">Nivel</label>
                        {!! Form::select("nivel_to", $list["Nivel"], null, array("class" => "form-control select_seguridad", "id" => "nivel_to-field")) !!}
                        <div id='loading11' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                        @if($errors->has("nivel_to"))
                            <span class="help-block">{{ $errors->first("nivel_to") }}</span>
                        @endif
                        </div>
                        <div class="form-group col-md-3 @if($errors->has('grado_to')) has-error @endif">
                        <label for="grado_to-field">Grado</label>
                        {!! Form::select("grado_to", $list["Grado"], null, array("class" => "form-control select_seguridad", "id" => "grado_to-field")) !!}
                        <div id='loading12' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                        @if($errors->has("grado_to"))
                            <span class="help-block">{{ $errors->first("grado_id") }}</span>
                        @endif
                        </div>
                    <div class="row"></div>
                    <hr>
                        <div class="form-group col-md-4 @if($errors->has('grupo_to')) has-error @endif">
                            <label for="grupo_to-field" id="lbl_disponibles">A Grupo </label>
                            {!! Form::select("grupo_to", $list["Grupo"], null, array("class" => "form-control select_seguridad", "id" => "grupo_to-field")) !!}
                            @if($errors->has("grupo_to"))
                            <span class="help-block">{{ $errors->first("grupo_to") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('periodo_estudios_to')) has-error @endif">
                            <label for="periodo_estudios_to-field" id="lbl_disponibles">Perido Estudios </label>
                            {!! Form::select("periodo_estudios_to", array(), null, array("class" => "form-control select_seguridad", "id" => "periodo_estudios_to-field")) !!}
                            @if($errors->has("periodo_estudios_to"))
                            <span class="help-block">{{ $errors->first("periodo_estudios_to") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('lectivo_to')) has-error @endif">
                            <label for="lectivo_to-field">A Periodo Lectivo</label>
                            {!! Form::select("lectivo_to", $list["Lectivo"], null, array("class" => "form-control select_seguridad", "id" => "lectivo_to-field")) !!}
                            @if($errors->has("lectivo_to"))
                            <span class="help-block">{{ $errors->first("lectivo_to") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-2 @if($errors->has('registrar_materias')) has-error @endif">
                            <label for="registrar_materias-field">Registrar Materias</label>
                            {!! Form::checkbox("registrar_materias", 1, 1, [ "id" => "registrar_materias-field", 'class'=>'minimal']) !!}
                            @if($errors->has("registrar_materias"))
                            <span class="help-block">{{ $errors->first("registrar_materias") }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            
                <div class="row">
                        </div>
                        <div class="well well-sm">
                            @if(!isset($resultados))
                            <button type="submit" class="btn btn-primary" >Buscar</button>
                            @endif
                            @if(isset($resultados))
                            <button type="submit" class="btn btn-primary" id="btnSubmitId">Procesar</button>
                            @endif
                            <a class="btn btn-link pull-right" href="{{ route('inscripcions.reinscripcion') }}"><i class="glyphicon glyphicon-backward"></i> Nuevo</a>
                        </div>
                
                
            {!! Form::close() !!}
        </div>
    </div>
@endsection
@push('scripts')
  
  <script type="text/javascript">
    
    $(document).ready(function() {
       
       $('#btnSubmitId').prop("disabled", true);
       $('#especialidad_to-field').change(function(){
           activarSubmit();
       });
       $('#nivel_to-field').change(function(){
           activarSubmit();
       });
       $('#grado_to-field').change(function(){
           activarSubmit();
       });
       $('#grupo_to-field').change(function(){
           activarSubmit();
       });
       $('#periodo_estudios_to-field').change(function(){
           activarSubmit();
       });
       $('#lectivo_to-field').change(function(){
           activarSubmit();
       });
       
       function activarSubmit(){
           if($('#activar-field').is(':checked') && $('#especialidad_to-field').val()>0 && 
                                                 $('#nivel_to-field').val()>0 && 
                                                 $('#grado_to-field').val()>0 &&
                                                 $('#grupo_to-field').val()>0 &&
                                                 $('#periodo_estudios_to-field').val()>0 &&
                                                 $('#lectivo_to-field').val()>0){
                $('#btnSubmitId').prop("disabled", false);
           }else if( ! $('#activar-field').is(':checked') && $('#grupo_to-field').val()>0 &&
                                                     $('#periodo_estudios_to-field').val()>0 &&
                                                     $('#lectivo_to-field').val()>0){
               $('#btnSubmitId').prop("disabled", false);
           }else{
               $('#btnSubmitId').prop("disabled", true);
           }
       }
       
       Desactivar();  
      $('#activar-field').change(function() {
        if($(this).is(":checked")) {
            Activar();
        }else{
            Desactivar();
            
        }
    });
      
      function Desactivar(){
          $('#especialidad_to-field').prop("disabled", true);
          $('#nivel_to-field').prop("disabled", true);
          $('#grado_to-field').prop("disabled", true);
          //console.log("desactivado");
      }
      
      function Activar(){
          $('#especialidad_to-field').prop("disabled", false);
          $('#nivel_to-field').prop("disabled", false);
          $('#grado_to-field').prop("disabled", false);
      }
      
      getCmbEspecialidad();
      getCmbEspecialidadTo();
      getCmbNivel();
      getCmbNivelTo();
      getCmbGrado();
      getCmbGradoTo();
      getCmbGrupo();
      getCmbGrupoTo();
      getCmbPeriodoEstudios($('#grupo_to-field option:selected').val(), $('#periodo_estudios_to-field option:selected').val());
      peri=$('#periodo_estudios_to-field option:selected').val();

      $('#plantel_id-field').change(function(){
          getCmbGrupo();
          getCmbGrupoTo();
      });
      
      $('#grupo_to-field').change(function(){
          getCmbPeriodoEstudios($('#grupo_to-field option:selected').val(), $('#periodo_estudios_to-field option:selected').val());
      });

      //$("tr td").parent().addClass('has-sub');
      $('.fecha').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
      });
     


      $('#select-all').click(function(event) {   
            if(this.checked) {
                // Iterate each checkbox
                $(':checkbox').each(function() {
                    this.checked = true;                        
                });
            }else{
                $(':checkbox').each(function() {
                    this.checked = false;                        
                });
            }
        });

    });
    function getCmbPeriodoEstudios(grupo, periodo){
          //var $example = $("#especialidad_id-field").select2();
          
              $.ajax({
                  url: '{{ route("grupos.cbmPeriodosEstudio") }}',
                  type: 'GET',
                  data: "grupo=" + grupo +
                        "&periodo=" + periodo,
                  dataType: 'json',
                  beforeSend : function(){$("#loading13").show();},
                  complete : function(){$("#loading13").hide();},
                  success: function(data){
                      //$example.select2("destroy");
                      $('#periodo_estudios_to-field').empty('');
                      
                      //$('#especialidad_id-field').empty();
                      $('#periodo_estudios_to-field').append($('<option></option>').text('Seleccionar').val('0'));
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#periodo_estudios_to-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                          
                      });
                      //$example.select2();
                  }
              });       
      }
    function getCmbGrupo(){
          //var $example = $("#especialidad_id-field").select2();
          var a= $('#frm_academica').serialize();
              $.ajax({
                  url: '{{ route("grupos.getCmbGrupo") }}',
                  type: 'GET',
                  data: "plantel_id=" + $('#plantel_id-field option:selected').val() + "&grupo_id=" + $('#grupo_id-field option:selected').val() + "",
                  dataType: 'json',
                  beforeSend : function(){$("#loading13").show();},
                  complete : function(){$("#loading13").hide();},
                  success: function(data){
                      //$example.select2("destroy");
                      $('#grupo_id-field').html('');
                      
                      //$('#especialidad_id-field').empty();
                      $('#grupo_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                      
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#grupo_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                      
                      });
                      //$example.select2();
                  }
              });       
      }
      function getCmbGrupoTo(){
          //var $example = $("#especialidad_id-field").select2();
          var a= $('#frm_academica').serialize();
              $.ajax({
                  url: '{{ route("grupos.getCmbGrupo") }}',
                  type: 'GET',
                  data: "plantel_id=" + $('#plantel_id-field option:selected').val() + "&grupo_id=" + $('#grupo_to-field option:selected').val() + "",
                  dataType: 'json',
                  beforeSend : function(){$("#loading13").show();},
                  complete : function(){$("#loading13").hide();},
                  success: function(data){
                      //$example.select2("destroy");
                      
                      $('#grupo_to-field').html('');
                      //$('#especialidad_id-field').empty();
                      
                      $('#grupo_to-field').append($('<option></option>').text('Seleccionar').val('0'));
                      $.each(data, function(i) {
                          //alert(data[i].name);
                       
                          $('#grupo_to-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                      });
                      //$example.select2();
                  }
              });       
      }
      $('#plantel_id-field').change(function(){
          getCmbEspecialidad();
          getCmbEspecialidadTo();
      });
      function getCmbEspecialidad(){
          //var $example = $("#especialidad_id-field").select2();
          var a= $('#frm_academica').serialize();
              $.ajax({
                  url: '{{ route("especialidads.getCmbEspecialidad") }}',
                  type: 'GET',
                  data: "plantel_id=" + $('#plantel_id-field option:selected').val() + "&especialidad_id=" + $('#especialidad_id-field option:selected').val() + "",
                  dataType: 'json',
                  beforeSend : function(){$("#loading10").show();},
                  complete : function(){$("#loading10").hide();},
                  success: function(data){
                      //$example.select2("destroy");
                      $('#especialidad_id-field').html('');
                      
                      //$('#especialidad_id-field').empty();
                      $('#especialidad_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                      
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#especialidad_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                          
                      });
                      //$example.select2();
                  }
              });       
      }
      function getCmbEspecialidadTo(){
          //var $example = $("#especialidad_id-field").select2();
          var a= $('#frm_academica').serialize();
              $.ajax({
                  url: '{{ route("especialidads.getCmbEspecialidad") }}',
                  type: 'GET',
                  data: "plantel_id=" + $('#plantel_id-field option:selected').val() + "&especialidad_id=" + $('#especialidad_to-field option:selected').val() + "",
                  dataType: 'json',
                  beforeSend : function(){$("#loading10").show();},
                  complete : function(){$("#loading10").hide();},
                  success: function(data){
                      //$example.select2("destroy");
                      $('#especialidad_to-field').html('');
                      
                      //$('#especialidad_id-field').empty();
                      $('#especialidad_to-field').append($('<option></option>').text('Seleccionar').val('0'));
                      
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#especialidad_to-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                          
                      });
                      //$example.select2();
                  }
              });       
      }
      $('#especialidad_id-field').change(function(){
          getCmbNivel();
      });
      function getCmbNivel(){
          //var $example = $("#especialidad_id-field").select2();
          var a= $('#frm_academica').serialize();
              $.ajax({
                  url: '{{ route("nivels.getCmbNivels") }}',
                  type: 'GET',
                  data: "plantel_id=" + $('#plantel_id-field option:selected').val() + "&especialidad_id=" + $('#especialidad_id-field option:selected').val() + "&nivel_id=" + $('#nivel_id-field option:selected').val() + "",
                  dataType: 'json',
                  beforeSend : function(){$("#loading11").show();},
                  complete : function(){$("#loading11").hide();},
                  success: function(data){
                      //alert(data);
                      //$example.select2("destroy");
                      $('#nivel_id-field').html('');
                      //$('#especialidad_id-field').empty();
                      $('#nivel_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                      
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#nivel_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                      });
                      //$example.select2();
                  }
              });       
      }
      $('#especialidad_to-field').change(function(){
          getCmbNivelTo();
      });
      function getCmbNivelTo(){
          //var $example = $("#especialidad_id-field").select2();
          var a= $('#frm_academica').serialize();
              $.ajax({
                  url: '{{ route("nivels.getCmbNivels") }}',
                  type: 'GET',
                  data: "plantel_id=" + $('#plantel_id-field option:selected').val() + "&especialidad_id=" + $('#especialidad_to-field option:selected').val() + "&nivel_id=" + $('#nivel_to-field option:selected').val() + "",
                  dataType: 'json',
                  beforeSend : function(){$("#loading11").show();},
                  complete : function(){$("#loading11").hide();},
                  success: function(data){
                      //alert(data);
                      //$example.select2("destroy");
                      $('#nivel_to-field').html('');
                      //$('#especialidad_id-field').empty();
                      $('#nivel_to-field').append($('<option></option>').text('Seleccionar').val('0'));
                      
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#nivel_to-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                      });
                      //$example.select2();
                  }
              });       
      }
      
      $('#nivel_id-field').change(function(){
          getCmbGrado();
      });
      function getCmbGrado(){
          //var $example = $("#especialidad_id-field").select2();
          var a= $('#frm_academica').serialize();
              $.ajax({
                  url: '{{ route("grados.getCmbGrados") }}',
                  type: 'GET',
                  data: "plantel_id=" + $('#plantel_id-field option:selected').val() + "&especialidad_id=" + $('#especialidad_id-field option:selected').val() + "&nivel_id=" + $('#nivel_id-field option:selected').val() + "&grado_id=" + $('#grado_id-field option:selected').val() +"",
                  dataType: 'json',
                  beforeSend : function(){$("#loading12").show();},
                  complete : function(){$("#loading12").hide();},
                  success: function(data){
                      //alert(data);
                      //$example.select2("destroy");
                      $('#grado_id-field').html('');
                      //$('#especialidad_id-field').empty();
                      $('#grado_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                      
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#grado_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                      });
                      //$example.select2();
                  }
              });       
      }
      
      $('#nivel_to-field').change(function(){
          getCmbGradoTo();
      });
      
      function getCmbGradoTo(){
          //var $example = $("#especialidad_id-field").select2();
          var a= $('#frm_academica').serialize();
              $.ajax({
                  url: '{{ route("grados.getCmbGrados") }}',
                  type: 'GET',
                  data: "plantel_id=" + $('#plantel_id-field option:selected').val() + "&especialidad_id=" + $('#especialidad_to-field option:selected').val() + "&nivel_id=" + $('#nivel_to-field option:selected').val() + "&grado_id=" + $('#grado_to-field option:selected').val() +"",
                  dataType: 'json',
                  beforeSend : function(){$("#loading12").show();},
                  complete : function(){$("#loading12").hide();},
                  success: function(data){
                      //alert(data);
                      //$example.select2("destroy");
                      $('#grado_to-field').html('');
                      //$('#especialidad_id-field').empty();
                      $('#grado_to-field').append($('<option></option>').text('Seleccionar').val('0'));
                      
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#grado_to-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                      });
                      //$example.select2();
                  }
              });       
      }
    
      
      
</script>
@endpush