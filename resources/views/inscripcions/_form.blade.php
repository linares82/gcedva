                    <div class="form-group col-md-4 @if($errors->has('cliente_id')) has-error @endif">
                       <label for="cliente_id-field">Alumno</label> 
                       {!! Form::text("cliente_id", null, array("class" => "form-control input-sm", "id" => "cliente_id-field")) !!}
                       {!! Form::text("cliente", null, array("class" => "form-control input-sm", "id" => "cliente")) !!}
                       @if($errors->has("cliente_id"))
                        <span class="help-block">{{ $errors->first("cliente_id") }}</span>
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
                    <div class="form-group col-md-4 @if($errors->has('lectivo_id')) has-error @endif">
                       <label for="lectivo_id-field">Periodo Lectivo</label>
                       {!! Form::select("lectivo_id", $list["Lectivo"], null, array("class" => "form-control select_seguridad", "id" => "lectivo_id-field")) !!}
                       @if($errors->has("lectivo_id"))
                        <span class="help-block">{{ $errors->first("lectivo_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-3 @if($errors->has('grupo_id')) has-error @endif">
                       <label for="grupo_id-field" id="lbl_disponibles">Grupo </label>
                       {!! Form::select("grupo_id", $list["Grupo"], null, array("class" => "form-control select_seguridad", "id" => "grupo_id-field")) !!}
                       @if($errors->has("grupo_id"))
                        <span class="help-block">{{ $errors->first("grupo_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-1 @if($errors->has('disponibles')) has-error @endif">
                       <label for="disponibles-field">Disponibles</label>
                       {!! Form::text("disponibles", null, array("class" => "form-control input-sm", "id" => "disponibles-field")) !!}
                    </div>
                    <div class="form-group col-md-3 @if($errors->has('periodo_estudio_id')) has-error @endif">
                       <label for="periodo_estudio_id-field" id="lbl_disponibles">Perido Estudio </label>
                       {!! Form::select("periodo_estudio_id", $list["PeriodoEstudio"], null, array("class" => "form-control select_seguridad", "id" => "periodo_estudio_id-field")) !!}
                       @if($errors->has("periodo_estudio_id"))
                        <span class="help-block">{{ $errors->first("periodo_estudio_id") }}</span>
                       @endif
                    </div>
                    
                    <div class="form-group col-md-3 @if($errors->has('turno_id')) has-error @endif">
                       <label for="turno_id-field" id="lbl_disponibles">Turno </label>
                       {!! Form::select("turno_id", $list["Turno"], null, array("class" => "form-control select_seguridad", "id" => "turno_id-field")) !!}
                       @if($errors->has("turno_id"))
                        <span class="help-block">{{ $errors->first("periodo_estudio_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('fec_inscripcion')) has-error @endif">
                       <label for="fec_inscripcion-field">F. Inscripcion</label>
                       {!! Form::text("fec_inscripcion", null, array("class" => "form-control input-sm", "id" => "fec_inscripcion-field")) !!}
                       @if($errors->has("fec_inscripcion"))
                        <span class="help-block">{{ $errors->first("fec_inscripcion") }}</span>
                       @endif
                    </div>
                    
                    <div class="form-group col-md-4 @if($errors->has('matricula')) has-error @endif">
                       <label for="matricula-field">Matricula</label>
                       {!! Form::text("matricula", null, array("class" => "form-control input-sm", "id" => "matricula-field")) !!}
                       @if($errors->has("matricula"))
                        <span class="help-block">{{ $errors->first("matricula") }}</span>
                       @endif
                    </div>
@push('scripts')
<script type="text/javascript">
    /*window.onbeforeunload=finalizar();
            function finalizar(){
                window.opener.location.reload();
            }*/
    $('#fec_inscripcion-field').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
      });
      
    $(document).ready(function() {
        getCmbGrupo();
        getNombreCliente()
        getCmbPeriodosEstudio();
        $('#grupo_id-field').change(function(){
          getDisponibles();
          getCmbPeriodosEstudio();
        });
        $('#plantel_id-field').change(function(){
          getCmbGrupo();
        });
        $('#lectivo_id-field').change(function(){
          getCmbGrupo();
        });

    function getCmbGrupo(){
          //var $example = $("#especialidad_id-field").select2();
          var a= $('#frm_academica').serialize();
              $.ajax({
                  url: '{{ route("asignacionAcademica.getCmbGrupo") }}',
                  type: 'GET',
                  data: "plantel_id=" + $('#plantel_id-field option:selected').val() + 
                        "&grupo_id=" + $('#grupo_id-field option:selected').val() + 
                        "&lectivo_id=" + $('#lectivo_id-field option:selected').val() + "",
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
      
    function getNombreCliente(){
          //var $example = $("#especialidad_id-field").select2();
          var a= $('#frm_academica').serialize();
              $.ajax({
                  url: '{{ route("clientes.getNombreCliente") }}',
                  type: 'GET',
                  data: "cliente_id=" + $('#cliente_id-field').val(),
                  dataType: 'json',
                  beforeSend : function(){$("#loading13").show();},
                  complete : function(){$("#loading13").hide();},
                  success: function(data){
                      //console.log(data);
                      nombre="";
                      for(var property in data){
                        if(data[property]==null){
                        }else{
                            nombre +=  " "+data[property];
                        }  
                        
                      }
                      $('#cliente').val('');
                      $('#cliente').val(nombre);
                      /*$.each(data, function(i) {
                        
                        $('#cliente').val('');
                        $('#cliente').val(data[i].nombre);
                      });
                      */
                  }
              });       
      }

      function getCmbPeriodosEstudio(){
          //var $example = $("#especialidad_id-field").select2();
          var a= $('#frm_academica').serialize();
              $.ajax({
                  url: '{{ route("periodoEstudios.getCmbPeriodoInscripcion") }}',
                  type: 'GET',
                  data: "grupo_id=" + $('#grupo_id-field option:selected').val() + "&periodo_estudio_id=" + $('#periodo_estudio_id-field option:selected').val() + "",
                  dataType: 'json',
                  beforeSend : function(){$("#loading13").show();},
                  complete : function(){$("#loading13").hide();},
                  success: function(data){
                      //$example.select2("destroy");
                      $('#periodo_estudio_id-field').html('');
                      
                      //$('#especialidad_id-field').empty();
                      $('#periodo_estudio_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                      
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#periodo_estudio_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                      });
                      //$example.select2();
                  }
              });       
      }

      function getDisponibles(){
          
          //var a= $('#frm_cliente').serialize();
              $.ajax({
                  url: '{{ route("grupos.getDisponibles") }}',
                  type: 'GET',
                  data: "grupo_id=" + $('#grupo_id-field option:selected').val() ,
                  dataType: 'json',
                  beforeSend : function(){$("#loading12").show();},
                  complete : function(){$("#loading12").hide();},
                  success: function(data){
                      $('#disponibles-field').val('');
                      $('#disponibles-field').val(data);
                  }
              });       
      }        
    });
</script>
@endpush
