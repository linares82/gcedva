<link rel="stylesheet" type="text/css" href="asset('bower_components/AdminLTE/plugins/lou-multi-select/css/css/multi-select.css')">                
                    <div class="form-group col-md-4 @if($errors->has('plantel_id')) has-error @endif">
                        <label for="plan_estudio_id-field">Plan Estudios</label>
                        {!! Form::select("plan_estudio_id", $list["PlanEstudio"], null, array("class" => "form-control select_seguridad", "id" => "plan_estudio_id-field")) !!}
                        @if($errors->has("plan_estudio_id"))
                        <span class="help-block">{{ $errors->first("plan_estudio_id") }}</span>
                        @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('plantel_id')) has-error @endif">
                       <label for="plantel_id-field">Plantel</label>
                       {!! Form::select("plantel_id", $list["Plantel"], null, array("class" => "form-control select_seguridad", "id" => "plantel_id-field", 'readonly'=>'readonly')) !!}
                       @if($errors->has("plantel_id"))
                        <span class="help-block">{{ $errors->first("plantel_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('especialidad')) has-error @endif">
                       <label for="especialidad-field">Especialidad</label>
                       {!! Form::select("especialidad_id", $list["Especialidad"], null, array("class" => "form-control select_seguridad", "id" => "especialidad_id-field")) !!}
                       <div id='loading10' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                       @if($errors->has("especialidad"))
                        <span class="help-block">{{ $errors->first("especialidad") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('nivel_id')) has-error @endif">
                       <label for="nivel_id-field">Nivel</label>
                       {!! Form::select("nivel_id", $list["Nivel"], null, array("class" => "form-control select_seguridad", "id" => "nivel_id-field")) !!}
                       <div id='loading11' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                       @if($errors->has("nivel_id"))
                        <span class="help-block">{{ $errors->first("nivel_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('grado_id')) has-error @endif">
                       <label for="grado_id-field">Grado</label>
                       {!! Form::select("grado_id", $list["Grado"], null, array("class" => "form-control select_seguridad", "id" => "grado_id-field")) !!}
                       <div id='loading12' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                       @if($errors->has("grado_id"))
                        <span class="help-block">{{ $errors->first("grado_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('name')) has-error @endif">
                       <label for="name-field">Periodo</label>
                       {!! Form::text("name", null, array("class" => "form-control input-sm", "id" => "name-field")) !!}
                       @if($errors->has("name"))
                        <span class="help-block">{{ $errors->first("name") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('desc_certificado')) has-error @endif">
                        <label for="desc_certificado-field">Descripcion Certificado</label>
                        {!! Form::text("desc_certificado", null, array("class" => "form-control", "id" => "desc_certificado-field")) !!}
                        @if($errors->has("desc_certificado"))
                         <span class="help-block">{{ $errors->first("inscripcion") }}</span>
                        @endif
                     </div>  
                    <div class="form-group col-md-4 @if($errors->has('orden')) has-error @endif">
                        <label for="orden-field">Orden</label>
                        {!! Form::text("orden", null, array("class" => "form-control input-sm", "id" => "orden-field")) !!}
                        @if($errors->has("orden"))
                         <span class="help-block">{{ $errors->first("orden") }}</span>
                        @endif
                     </div>
                     <div class="form-group col-md-4 @if($errors->has('bnd_activo')) has-error @endif">
                        <label for="bnd_activo-field">Activo</label>
                        {!! Form::checkbox("bnd_activo", 1, null, [ "id" => "bnd_activo-field", 'class'=>'minimal']) !!}
                        @if($errors->has("bnd_activo"))
                        <span class="help-block">{{ $errors->first("bnd_activo") }}</span>
                        @endif
                    </div> 
                    <!--
                    <div class="form-group col-md-4 @if($errors->has('rvoe')) has-error @endif">
                        <label for="rvoe-field">RVOE</label>
                        {!! Form::text("rvoe", null, array("class" => "form-control input-sm", "id" => "rvoe-field")) !!}
                        @if($errors->has("rvoe"))
                         <span class="help-block">{{ $errors->first("rvoe") }}</span>
                        @endif
                     </div>
                     <div class="form-group col-md-4 @if($errors->has('cct')) has-error @endif">
                        <label for="cct-field">CCT</label>
                        {!! Form::text("cct", null, array("class" => "form-control input-sm", "id" => "cct-field")) !!}
                        @if($errors->has("cct"))
                         <span class="help-block">{{ $errors->first("cct") }}</span>
                        @endif
                     </div>
                     <div class="form-group col-md-4 @if($errors->has('fec_vigencia_rvoe')) has-error @endif">
                        <label for="fec_vigencia_-field">Fec. Vigencia RVOE</label>
                        {!! Form::text("fec_vigencia_rvoe", null, array("class" => "fecha form-control input-sm", "id" => "fec_vigencia_rvoe-field")) !!}
                        @if($errors->has("fec_vigencia_rvoe"))
                         <span class="help-block">{{ $errors->first("fec_vigencia_rvoe") }}</span>
                        @endif
                     </div>
                    -->
                    <div class="row"></div>
                    <div class="form-group col-md-4 @if($errors->has('bnd_carrera_tecnica')) has-error @endif">
                        <label for="bnd_carrera_tecnica-field">Carrera Tecnica</label>
                        {!! Form::checkbox("bnd_carrera_tecnica", 1, null, [ "id" => "bnd_carrera_tecnica-field"]) !!}
                        @if($errors->has("bnd_carrera_tecnica"))
                        <span class="help-block">{{ $errors->first("bnd_carrera_tecnica") }}</span>
                        @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('orden_carrera_tecnica')) has-error @endif">
                        <label for="orden_carrera_tecnica-field">Orden Carrera Tecnica</label>
                        {!! Form::text("orden_carrera_tecnica", null, array("class" => "form-control input-sm", "id" => "orden_carrera_tecnica-field")) !!}
                        @if($errors->has("orden_carrera_tecnica"))
                         <span class="help-block">{{ $errors->first("orden_carrera_tecnica") }}</span>
                        @endif
                     </div>
                    <div class="row"></div>
                    @if(isset($materias_ls))
                    <div class="form-group col-md-4 @if($errors->has('materia_id')) has-error @endif">
                        <label for="materia_id-field">Materias</label>
                        <div id="select_materia">
                            {!! Form::select("materia_id", $materias_ls, null, array("class" => "form-control select_seguridad", "id" => "materia_id-field", "name"=>"materia_id-field[]", 'multiple'=>'multiple')) !!} 
                        </div>
                        <div id='loading3' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div>
                        @if($errors->has("materia_id"))
                            <span class="help-block">{{ $errors->first("materia_id") }}</span>
                        @endif
                    </div>
                    <!--
                    <div class="form-group col-md-4 @if($errors->has('duracion_clase')) has-error @endif">
                        <label for="duracion_clase-field">Duracion Clase</label>
                        {!! Form::text("duracion_clase", null, array("class" => "form-control input-sm", "id" => "duracion_clase-field")) !!}
                        @if($errors->has("duracion_clase"))
                         <span class="help-block">{{ $errors->first("duracion_clase") }}</span>
                        @endif
                     </div>
                     <div class="form-group col-md-4 @if($errors->has('horas_jornada')) has-error @endif">
                        <label for="horas_jornada-field">Horas Jornada</label>
                        {!! Form::text("horas_jornada", null, array("class" => "form-control input-sm", "id" => "horas_jornada-field")) !!}
                        @if($errors->has("horas_jornada"))
                         <span class="help-block">{{ $errors->first("horas_jornada") }}</span>
                        @endif
                     </div>
                    -->
                    @endif
                    

@push('scripts')
  
  <script type="text/javascript">

    
    $(document).ready(function() {

    
      getCmbEspecialidad();
      getCmbNivel();
      getCmbGrado();
      getCmbMateria();
      
      $('#plantel_id-field').change(function(){
          getCmbEspecialidad();
          getCmbMateria();
      });

      
      function getCmbMateria(){
          var $example = $("#especialidad_id-field").select2();
          var a= $('#frm_periodo_estudios').serialize();
              $.ajax({
                  url: '{{ route("materias.getCmbMateria2") }}',
                  type: 'GET',
                  data: "plantel_id=" + $('#plantel_id-field option:selected').val(),
                  dataType: 'json',
                  beforeSend : function(){$("#loading3").show();},
                  complete : function(){$("#loading3").hide();},
                  success: function(data){
                      //$example.select2("destroy");
                      $('#materia_id-field').html('');
                      
                      //$('#especialidad_id-field').empty();
                      $('#materia_id-field').append($('<option></option>').text('Seleccionar Opción').val('0'));
                      
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#materia_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                          
                      });
                      //$example.select2();
                  }
              });       
      }
      function getCmbEspecialidad(){
          //var $example = $("#especialidad_id-field").select2();
          var a= $('#frm_periodo_estudios').serialize();
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
      $('#especialidad_id-field').change(function(){
          getCmbNivel();
      });
      function getCmbNivel(){
          //var $example = $("#especialidad_id-field").select2();
          var a= $('#frm_periodo_estudios').serialize();
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
      
      $('#nivel_id-field').change(function(){
          getCmbGrado();
      });
      function getCmbGrado(){
          //var $example = $("#especialidad_id-field").select2();
          var a= $('#frm_periodo_estudios').serialize();
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

      

    });
    
</script>
@endpush