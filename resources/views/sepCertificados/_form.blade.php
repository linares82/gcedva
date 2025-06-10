<div class="form-group col-md-4 @if ($errors->has('plantel_id')) has-error @endif">
   <label for="plantel_id-field">Plantel</label>
   {!! Form::select('plantel_id', $planteles, null, [
      'class' => 'form-control select_seguridad',
      'id' => 'plantel_id-field',
   ]) !!}
   @if ($errors->has('plantel_id'))
      <span class="help-block">{{ $errors->first('plantel_id') }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if ($errors->has('especialidad_id')) has-error @endif">
   <label for="especialidad_id-field">Especialidad</label>
   {!! Form::select('especialidad_id', $list['Especialidad'], null, [
      'class' => 'form-control select_seguridad',
      'id' => 'especialidad_id-field',
   ]) !!}
   @if ($errors->has('especialidad_id'))
      <span class="help-block">{{ $errors->first('especialidad_id') }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if ($errors->has('nivel_id')) has-error @endif">
   <label for="nivel_id-field">Nivel</label>
   {!! Form::select('nivel_id', $list['Nivel'], null, ['class' => 'form-control select_seguridad', 'id' => 'nivel_id-field']) !!}
   @if ($errors->has('nivel_id'))
      <span class="help-block">{{ $errors->first('nivel_id') }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if ($errors->has('grado_id')) has-error @endif">
   <label for="grado_id-field">Grado</label>
   {!! Form::select('grado_id', $list['Grado'], null, ['class' => 'form-control select_seguridad', 'id' => 'grado_id-field']) !!}
   @if ($errors->has('grado_id'))
      <span class="help-block">{{ $errors->first('grado_id') }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if ($errors->has('lectivo_id')) has-error @endif">
   <label for="lectivo_id-field">Lectivo</label>
   {!! Form::select('lectivo_id', $list['Lectivo'], null, [
      'class' => 'form-control select_seguridad',
      'id' => 'lectivo_id-field',
   ]) !!}
   @if ($errors->has('lectivo_id'))
      <span class="help-block">{{ $errors->first('lectivo_id') }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if ($errors->has('grupo_id')) has-error @endif">
   <label for="grupo_id-field">Grupo</label>
   {!! Form::select('grupo_id', $list['Grupo'], null, ['class' => 'form-control select_seguridad', 'id' => 'grupo_id-field']) !!}
   @if ($errors->has('grupo_id'))
      <span class="help-block">{{ $errors->first('grupo_id') }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if($errors->has('r_sep_cargo_id')) has-error @endif">
   <label for="r_sep_cargo_id-field">R_sep_cargo_id</label>
   {!! Form::select('r_sep_cargo_id', $cargos, null, [
      'class' => 'form-control select_seguridad',
      'id' => 'r_sep_cargo_id-field',
   ]) !!}
   @if($errors->has("r_sep_cargo_id"))
   <span class="help-block">{{ $errors->first("r_sep_cargo_id") }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if($errors->has('responsable_id')) has-error @endif">
   <label for="responsable_id-field">Responsable_id</label>
   {!! Form::select('responsable_id', $empleados, null, [
      'class' => 'form-control select_seguridad',
      'id' => 'responsable_id-field',
   ]) !!}
   @if($errors->has("responsable_id"))
   <span class="help-block">{{ $errors->first("responsable_id") }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if($errors->has('id_carrera')) has-error @endif">
   <label for="id_carrera-field">Id_carrera</label>
   {!! Form::text("id_carrera", null, array("class" => "form-control", "id" => "id_carrera-field")) !!}
   @if($errors->has("id_carrera"))
   <span class="help-block">{{ $errors->first("id_carrera") }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if($errors->has('id_asignatura')) has-error @endif">
   <label for="id_asignatura-field">Id_asignatura</label>
   {!! Form::text("id_asignatura", null, array("class" => "form-control", "id" => "id_asignatura-field")) !!}
   @if($errors->has("id_asignatura"))
   <span class="help-block">{{ $errors->first("id_asignatura") }}</span>
   @endif
</div>

<div class="form-group col-md-4 @if($errors->has('fecha_expedicion')) has-error @endif">
   <label for="fecha_expedicion-field">Fecha Expedicion</label>
   {!! Form::text("fecha_expedicion", null, array("class" => "form-control fecha", "id" => "fecha_expedicion-field")) !!}
   @if($errors->has("fecha_expedicion"))
   <span class="help-block">{{ $errors->first("fecha_expedicion") }}</span>
   @endif
</div>

@push('scripts')
   <script>
      $(document).ready(function() {
            
            getCmbEspecialidad();
            getCmbGrupo();
            getCmbNivel();
            getCmbGrado();
            getCmbLectivo();
            
            $('#plantel_id-field').change(function() {
               getCmbEspecialidad();
               getCmbGrupo();
            });

            function getCmbGrupo(){
               //var $example = $("#especialidad_id-field").select2();
               
                     $.ajax({
                        url: '{{ route("grupos.getCmbGrupo") }}',
                        type: 'GET',
                        data: {
                           'grupo_id':$('#grupo_id-field option:selected').val(),
                           'plantel_id':$('#plantel_id-field option:selected').val()
                        },
                        dataType: 'json',
                        beforeSend : function(){$("#loading2").show();},
                        complete : function(){$("#loading2").hide();},
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

            function getCmbEspecialidad() {
               //var $example = $("#especialidad_id-field").select2();
               var a = $('#frm').serialize();
               $.ajax({
                  url: '{{ route('especialidads.getCmbEspecialidad') }}',
                  type: 'GET',
                  data: {
                     plantel_id: $('#plantel_id-field option:selected').val(),
                     especialidad_id:$('#especialidad_id-field option:selected').val(),
                  },
                  dataType: 'json',
                  beforeSend: function() {
                        $("#loading2").show();
                  },
                  complete: function() {
                        $("#loading2").hide();
                  },
                  success: function(data) {
                        //$example.select2("destroy");
                        $('#especialidad_id-field').html('');
                        //$('#especialidad_id-field').empty();
                        $('#especialidad_id-field').append($('<option></option>').text('Seleccionar')
                           .val('0'));
                        $.each(data, function(i) {
                           //alert(data[i].name);
                           $('#especialidad_id-field').append("<option " + data[i].selectec +
                              " value=\"" + data[i].id + "\">" + data[i].name +
                              "<\/option>");
                        });
                        //$example.select2();
                  }
               });
            }

            $('#especialidad_id-field').change(function() {
               getCmbNivel();
            });

            function getCmbNivel() {
               var a = $('#frm').serialize();
               $.ajax({
                  url: '{{ route('nivels.getCmbNivels') }}',
                  type: 'GET',
                  data: {
                     plantel_id: $('#plantel_id-field option:selected').val(),
                     especialidad_id:$('#especialidad_id-field option:selected').val(),
                     nivel_id:$('#nivel_id-field option:selected').val(),
                  },
                  dataType: 'json',
                  beforeSend: function() {
                        $("#loading3").show();
                  },
                  complete: function() {
                        $("#loading3").hide();
                  },
                  success: function(data) {
                        //alert(data);
                        //$example.select2("destroy");
                        $('#nivel_id-field').html('');
                        //$('#especialidad_id-field').empty();
                        $('#nivel_id-field').append($('<option></option>').text('Seleccionar').val(
                           '0'));

                        $.each(data, function(i) {
                           //alert(data[i].name);
                           $('#nivel_id-field').append("<option " + data[i].selectec +
                              " value=\"" + data[i].id + "\">" + data[i].name +
                              "<\/option>");
                        });
                        //$example.select2();
                  }
               });
            }

            $('#nivel_id-field').change(function() {
                getCmbGrado();
            });

            function getCmbGrado() {

                $.ajax({
                    url: '{{ route('grados.getCmbGrados') }}',
                    type: 'GET',
                    data: {
                        plantel_id: $('#plantel_id-field option:selected').val(),
                        especialidad_id: $('#especialidad_id-field option:selected').val(),
                        nivel_id: $('#nivel_id-field option:selected').val(),
                        grado_id: $('#grado_id-field option:selected').val(),
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        $("#loading12").show();
                    },
                    complete: function() {
                        $("#loading12").hide();
                    },
                    success: function(data) {
                        //alert(data);
                        //$example.select2("destroy");
                        $('#grado_id-field').html('');
                        //$('#especialidad_id-field').empty();
                        $('#grado_id-field').append($('<option></option>').text('Seleccionar').val(
                            '0'));
                        $.each(data, function(i) {
                            //alert(data[i].name);
                            $('#grado_id-field').append("<option " + data[i].selectec +
                                " value=\"" + data[i].id + "\">" + data[i].name +
                                "<\/option>");
                        });
                        //$example.select2();
                    }
                });
            }


            $('#grado_id-field').change(function() {
               getCmbLectivo();
            });


            function getCmbLectivo() {
                $.ajax({
                    url: '{{ route('lectivos.getLectivosXGrado') }}',
                    type: 'GET',
                    data: {
                        plantel_id: $('#plantel_id-field option:selected').val(),
                        especialidad_id: $('#especialidad_id-field option:selected').val(),
                        nivel_id: $('#nivel_id-field option:selected').val(),
                        grado_id: $('#grado_id-field option:selected').val(),
                        lectivo_id: $('#lectivo_id-field option:selected').val(),
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        $("#loading13").show();
                    },
                    complete: function() {
                        $("#loading13").hide();
                    },
                    success: function(data) {
                        //$example.select2("destroy");
                        $('#lectivo_id-field').empty('');

                        //$('#especialidad_id-field').empty();
                        $('#lectivo_id-field').append($('<option></option>').text('Seleccionar').val(
                            '0'));
                        $.each(data, function(i) {
                            //alert(data[i].name);
                            $('#lectivo_id-field').append("<option " + data[i].selectec +
                                " value=\"" + data[i].id + "\">" + data[i].name +
                                "<\/option>");

                        });
                        //$example.select2();
                    }
                });
            }
      });
   </script>
@endpush
