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
<div class="form-group col-md-4 @if ($errors->has('r1_id')) has-error @endif">
   <label for="r1_id-field">Responsable 1</label>
   {!! Form::select('r1_id', $empleados, null, [
      'class' => 'form-control select_seguridad',
      'id' => 'r1_id-field',
   ]) !!}
   @if ($errors->has('r1_id'))
      <span class="help-block">{{ $errors->first('r1_id') }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if ($errors->has('r1_sep_cargo_id')) has-error @endif">
   <label for="r1_sep_cargo_id-field">Sep Cargo</label>
   {!! Form::select('r1_sep_cargo_id', $cargos, null, [
      'class' => 'form-control select_seguridad',
      'id' => 'r1_sep_cargo_id-field',
   ]) !!}
   @if ($errors->has('r1_sep_cargo_id'))
      <span class="help-block">{{ $errors->first('r1_sep_cargo_id') }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if ($errors->has('r1_titulo')) has-error @endif">
   <label for="r1_titulo-field">Titulo Responsble 1</label>
   {!! Form::text('r1_titulo', null, ['class' => 'form-control', 'id' => 'r1_titulo-field']) !!}
   @if ($errors->has('r1_titulo'))
      <span class="help-block">{{ $errors->first('r1_titulo') }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if ($errors->has('r2_id')) has-error @endif">
   <label for="r2_id-field">Responsable 2</label>
   {!! Form::select('r2_id', $empleados, null, [
      'class' => 'form-control select_seguridad',
      'id' => 'r2_id-field',
   ]) !!}
   @if ($errors->has('r2_id'))
      <span class="help-block">{{ $errors->first('r2_id') }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if ($errors->has('r2_sep_cargo_id')) has-error @endif">
   <label for="r2_sep_cargo_id-field">Sep Cargo</label>
   {!! Form::select('r2_sep_cargo_id', $cargos, null, [
      'class' => 'form-control select_seguridad',
      'id' => 'r2_sep_cargo_id-field',
   ]) !!}
   @if ($errors->has('r2_sep_cargo_id'))
      <span class="help-block">{{ $errors->first('r2_sep_cargo_id') }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if ($errors->has('r2_titulo')) has-error @endif">
   <label for="r2_titulo-field">Titulo Responsable 2</label>
   {!! Form::text('r2_titulo', null, ['class' => 'form-control', 'id' => 'r2_titulo-field']) !!}
   @if ($errors->has('r2_titulo'))
      <span class="help-block">{{ $errors->first('r2_titulo') }}</span>
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
