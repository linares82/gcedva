@extends('plantillas.admin_template')

@include('seguimientos._common')

@section('header')
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <li><a href="{{ route('clientes.index') }}">@yield('clientesAppTitle')</a></li>
        <li class="active">Altas por Usuario</li>
    </ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> @yield('seguimientosAppTitle') / Clientes - Cantidades de estatus por municipio en un
            periodo </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::open(['route' => 'clientes.getFichaInscripcionGrupoR', 'id' => 'frm_reporte']) !!}
            <div class="form-group col-md-6 @if ($errors->has('plantel_id')) has-error @endif">
                <label for="plantel_id">Plantel</label>
                {!! Form::select('plantel_id', $plantels, null, [
                    'class' => 'form-control select_seguridad',
                    'id' => 'plantel_id',
                ]) !!}
                @if ($errors->has('plantel_id'))
                    <span class="help-block">{{ $errors->first('plantel_id') }}</span>
                @endif
            </div>
            <div class="form-group col-md-6 @if ($errors->has('especialidad')) has-error @endif">
                <label for="especialidad">Especialidad</label>
                {!! Form::select('especialidad_id', [], null, [
                    'class' => 'form-control select_seguridad',
                    'id' => 'especialidad_id',
                ]) !!}
                <div id='loading10' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}"
                        title="Enviando" /></div>
                @if ($errors->has('especialidad'))
                    <span class="help-block">{{ $errors->first('especialidad') }}</span>
                @endif
            </div>
            <div class="form-group col-md-6 @if ($errors->has('nivel_id')) has-error @endif">
                <label for="nivel_id">Nivel</label>
                {!! Form::select('nivel_id', [], null, ['class' => 'form-control select_seguridad', 'id' => 'nivel_id']) !!}
                <div id='loading11' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}"
                        title="Enviando" /></div>
                @if ($errors->has('nivel_id'))
                    <span class="help-block">{{ $errors->first('nivel_id') }}</span>
                @endif
            </div>
            <div class="form-group col-md-6 @if ($errors->has('grado_id')) has-error @endif">
                <label for="grado_id">Grado</label>
                {!! Form::select('grado_id', [], null, ['class' => 'form-control select_seguridad', 'id' => 'grado_id']) !!}
                <div id='loading12' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}"
                        title="Enviando" /></div>
                @if ($errors->has('grado_id'))
                    <span class="help-block">{{ $errors->first('grado_id') }}</span>
                @endif
            </div>
            <div class="form-group col-md-6 @if ($errors->has('lectivo_id')) has-error @endif">
                <label for="lectivo_id">Periodo Lectivo</label>
                {!! Form::select('lectivo_id', $lectivos, null, ['class' => 'form-control select_seguridad', 'id' => 'lectivo_id']) !!}
                @if ($errors->has('lectivo_id'))
                    <span class="help-block">{{ $errors->first('lectivo_id') }}</span>
                @endif
            </div>
            <div class="form-group col-md-6 @if ($errors->has('grupo_id')) has-error @endif">
                <label for="grupo_id" id="lbl_disponibles">Grupo </label>
                {!! Form::select('grupo_id', [], null, ['class' => 'form-control select_seguridad', 'id' => 'grupo_id']) !!}
                <div class='loading3' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}"
                        title="Enviando" /></div>
                @if ($errors->has('grupo_id'))
                    <span class="help-block">{{ $errors->first('grupo_id') }}</span>
                @endif
            </div>

            <div class="row">
            </div>
            <div class="well well-sm">
                <button id="submit_tbl" type="submit" class="btn btn-primary">Tabla</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            $('#plantel_id').change(function() {
                getCmbEspecialidad();
            });

            $('#especialidad_id').change(function() {
                getCmbNivel();
            });

            $('#nivel_id').change(function() {
                getCmbGrado();
            });

            $('#lectivo_id').change(function() {
                getCmbGrupo();
            });

            function getCmbEspecialidad() {
                $.ajax({
                    url: '{{ route('especialidads.getCmbEspecialidad') }}',
                    type: 'GET',
                    data: "plantel_id=" + $('#plantel_id option:selected').val() +
                        "&especialidad_id=" + $('#especialidad_id option:selected').val() + "",
                    dataType: 'json',
                    beforeSend: function() {
                        $("#loading10").show();
                    },
                    complete: function() {
                        $("#loading10").hide();
                    },
                    success: function(data) {
                        $('#especialidad_id').empty();
                        $('#especialidad_id').append($('<option></option>').text('Seleccionar')
                            .val('0'));
                        $.each(data, function(i) {
                            $('#especialidad_id').append("<option " + data[i].selectec +
                                " value=\"" + data[i].id + "\">" + data[i].name +
                                "<\/option>");
                        });

                    }
                });
            }

            function getCmbNivel() {
                $.ajax({
                    url: '{{ route('nivels.getCmbNivels') }}',
                    type: 'GET',
                    data: "plantel_id=" + $('#plantel_id option:selected').val() +
                        "&especialidad_id=" + $('#especialidad_id option:selected').val() +
                        "&nivel_id=" + $('#nivel_id option:selected').val() + "",
                    dataType: 'json',
                    beforeSend: function() {
                        $("#loading11").show();
                    },
                    complete: function() {
                        $("#loading11").hide();
                    },
                    success: function(data) {
                        //alert(data);
                        //$example.select2("destroy");
                        if ($('#especialidad_id option:selected').val() != 0) {
                            $('#nivel_id').prop('disabled', false);
                        }

                        $('#nivel_id').html('');
                        //$('#especialidad_id').empty();
                        $('#nivel_id').append($('<option></option>').text('Seleccionar').val(
                        '0'));
                        $.each(data, function(i) {
                            //alert(data[i].name);
                            $('#nivel_id').append("<option " + data[i].selectec +
                                " value=\"" + data[i].id + "\">" + data[i].name +
                                "<\/option>");
                        });
                        $('#nivel_id').trigger('change');
                    }
                });
            }
        });

        function getCmbGrado() {
            //var $example = $("#especialidad_id").select2();
            var a = $('#frm_cliente').serialize();
            $.ajax({
                url: '{{ route('grados.getCmbGrados') }}',
                type: 'GET',
                data: "plantel_id=" + $('#plantel_id option:selected').val() + "&especialidad_id=" + $(
                    '#especialidad_id option:selected').val() + "&nivel_id=" + $(
                    '#nivel_id option:selected').val() + "&grado_id=" + $(
                    '#grado_id option:selected').val() + "",
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
                    if ($('#nivel_id option:selected').val() != 0) {
                        $('#grado_id').prop('disabled', false);
                    }

                    $('#grado_id').html('');
                    //$('#especialidad_id').empty();
                    $('#grado_id').append($('<option></option>').text('Seleccionar').val('0'));
                    $.each(data, function(i) {
                        //alert(data[i].name);
                        $('#grado_id').append("<option " + data[i].selectec + " value=\"" + data[
                            i].id + "\">" + data[i].name + "<\/option>");
                    });
                    $('#grado_id').trigger('change');
                }
            });
        }
    
        function getCmbGrupo(){
          //var $example = $("#especialidad_id-field").select2();
          var a= $('#frm_academica').serialize();
              $.ajax({
                  url: '{{ route("asignacionAcademica.getCmbGrupo") }}',
                  type: 'GET',
                  data: "plantel_id=" + $('#plantel_id option:selected').val() + 
                        "&grupo_id=" + $('#grupo_id option:selected').val() + 
                        "&nivel_id=" + $('#nivel_id option:selected').val() + 
                        "&lectivo_id=" + $('#lectivo_id option:selected').val() + "",
                  dataType: 'json',
                  beforeSend : function(){$("#loading13").show();},
                  complete : function(){$("#loading13").hide();},
                  success: function(data){
                      //$example.select2("destroy");
                      $('#grupo_id').html('');
                      
                      //$('#especialidad_id-field').empty();
                      $('#grupo_id').append($('<option></option>').text('Seleccionar').val('0'));
                      
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#grupo_id').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                      });
                      //$example.select2();
                  }
              });       
      }

    </script>
@endpush
