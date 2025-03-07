@extends('plantillas.admin_template')

@include('asignacionAcademicas._common')

@section('header')
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <li><a href="{{ route('asignacionAcademicas.index') }}">@yield('asignacionAcademicasAppTitle')</a></li>
        <li class="active">Horario por Grupo</li>
    </ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> @yield('asignacionAcademicasAppTitle') / Crear </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::open(['route' => 'horarios.horarioGrupoR', 'id' => 'frm_seguimiento']) !!}

            <div class="form-group col-md-6 @if ($errors->has('plantel_f')) has-error @endif">
                <label for="plantel_f-field">Plantel</label>
                {!! Form::select('plantel_f', $list['Plantel'], null, [
                    'class' => 'form-control select_seguridad',
                    'id' => 'plantel_f-field',
                ]) !!}
                @if ($errors->has('plantel_f'))
                    <span class="help-block">{{ $errors->first('plantel_f') }}</span>
                @endif
            </div>
            <div class="form-group col-md-6 @if ($errors->has('especialidad_id')) has-error @endif">
                <label for="especialidad_id-field">Especialidad</label>
                {!! Form::select('especialidad_id', [], null, [
                    'class' => 'form-control select_seguridad',
                    'id' => 'especialidad_id-field',
                ]) !!}
                <div id='loading2' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}"
                        title="Enviando" /></div>
                @if ($errors->has('especialidad_id'))
                    <span class="help-block">{{ $errors->first('especialidad_id') }}</span>
                @endif
            </div>
            <div class="form-group col-md-4 @if ($errors->has('nivel_id')) has-error @endif">
                <label for="nivel_id-field">Nivel</label>
                {!! Form::select('nivel_id', [], null, ['class' => 'form-control select_seguridad', 'id' => 'nivel_id-field']) !!}
                <div id='loading3' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}"
                        title="Enviando" /></div>
                @if ($errors->has('nivel_id'))
                    <span class="help-block">{{ $errors->first('nivel_id') }}</span>
                @endif
            </div>
            <div class="form-group col-md-4 @if ($errors->has('grado_id')) has-error @endif">
                <label for="grado_id-field">Grado</label>
                {!! Form::select('grado_id', [], null, ['class' => 'form-control select_seguridad', 'id' => 'grado_id-field']) !!}
                @if ($errors->has('grado_id'))
                    <span class="help-block">{{ $errors->first('grado_id') }}</span>
                @endif
            </div>
            <div class="form-group col-md-4 @if($errors->has('periodo_estudio_id')) has-error @endif">
                <label for="periodo_estudio_id-field">Periodo</label>
                {!! Form::select("periodo_estudio_id", array(), null, array("class" => "form-control select_seguridad", "id" => "periodo_estudio_id-field")) !!}
                <div id='loading10' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                @if($errors->has("periodo_estudio_id"))
                 <span class="help-block">{{ $errors->first("periodo_estudio_id") }}</span>
                @endif
             </div>
            <div class="form-group col-md-6 @if ($errors->has('grupo_f')) has-error @endif">
                <label for="grupo_f-field">Grupo:</label>
                {!! Form::select('grupo_f', $list['Grupo'], null, [
                    'class' => 'form-control select_seguridad',
                    'id' => 'grupo_t-field',
                ]) !!}
                @if ($errors->has('grupo_f'))
                    <span class="help-block">{{ $errors->first('plantel_t') }}</span>
                @endif
            </div>
            <div class="form-group col-md-6 @if ($errors->has('lectivo_f')) has-error @endif">
                <label for="lectivo_f-field">Lectivo:</label>
                {!! Form::select('lectivo_f', $list['Lectivo'], null, [
                    'class' => 'form-control select_seguridad',
                    'id' => 'lectivo_f-field',
                ]) !!}
                @if ($errors->has('lectivo_f'))
                    <span class="help-block">{{ $errors->first('lectivo_t') }}</span>
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
            $('#fecha_f-field').Zebra_DatePicker({
                days: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
                months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto',
                    'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                ],
                readonly_element: false,
                lang_clear_date: 'Limpiar',
                show_select_today: 'Hoy',
            });
            $('#fecha_t-field').Zebra_DatePicker({
                days: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
                months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto',
                    'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                ],
                readonly_element: false,
                lang_clear_date: 'Limpiar',
                show_select_today: 'Hoy',
            });

            
            $('#plantel_f-field').change(function() {
                getCmbEspecialidad();
                getCmbPeriodo();
            });

            $('#grado_id-field').change(function() {
                getCmbPeriodoEstudios();
                getCmbLectivo();
            });

            function getCmbLectivo(){
          //var $example = $("#especialidad_id-field").select2();
          
              $.ajax({
                  url: '{{ route("lectivos.getLectivosXGrado") }}',
                  type: 'GET',
                  data: {
                    plantel_id:$('#plantel_f-field option:selected').val(),
                    especialidad_id:$('#especialidad_id-field option:selected').val(),
                    nivel_id:$('#nivel_id-field option:selected').val(),
                    grado_id:$('#grado_id-field option:selected').val(),
                  },
                  dataType: 'json',
                  beforeSend : function(){$("#loading13").show();},
                  complete : function(){$("#loading13").hide();},
                  success: function(data){
                      //$example.select2("destroy");
                      $('#lectivo_f-field').empty('');
                      
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

            function getCmbPeriodoEstudios(){
          //var $example = $("#especialidad_id-field").select2();
          
              $.ajax({
                  url: '{{ route("grupos.getCmbGrupoXGrado") }}',
                  type: 'GET',
                  data: {
                    plantel_id:$('#plantel_f-field option:selected').val(),
                    especialidad_id:$('#especialidad_id-field option:selected').val(),
                    nivel_id:$('#nivel_id-field option:selected').val(),
                    grado_id:$('#grado_id-field option:selected').val(),
                  },
                  dataType: 'json',
                  beforeSend : function(){$("#loading13").show();},
                  complete : function(){$("#loading13").hide();},
                  success: function(data){
                      //$example.select2("destroy");
                      $('#grupo_t-field').empty('');
                      
                      //$('#especialidad_id-field').empty();
                      $('#grupo_t-field').append($('<option></option>').text('Seleccionar').val('0'));
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#grupo_t-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                          
                      });
                      //$example.select2();
                  }
              });       
      }

            function getCmbEspecialidad() {
                $.ajax({
                    url: '{{ route('especialidads.getCmbEspecialidad') }}',
                    type: 'GET',
                    data: {
                        plantel_id:$('#plantel_f-field option:selected').val(),
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
                
                $.ajax({
                    url: '{{ route('nivels.getCmbNivels') }}',
                    type: 'GET',
                    data: {
                        plantel_id:$('#plantel_f-field option:selected').val(),
                        especialidad_id:$('#especialidad_id-field option:selected').val(),
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
                        plantel_id:$('#plantel_f-field option:selected').val(),
                        especialidad_id:$('#especialidad_id-field option:selected').val(),
                        nivel_id:$('#nivel_id-field option:selected').val(),
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

            function getCmbPeriodo(){
          
              $.ajax({
                  url: '{{ route("periodoEstudios.getCmbPeriodo") }}',
                  type: 'GET',
                  data: {
                    plantel_id:$('#plantel_f-field option:selected').val(),
                  },
                  dataType: 'json',
                  beforeSend : function(){$("#loading10").show();},
                  complete : function(){$("#loading10").hide();},
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
      


        });
    </script>
@endpush
