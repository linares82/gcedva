@extends('plantillas.admin_template')

@include('prebecas._common')

@section('header')
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <li class="active">Prebeca - beca</li>
    </ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> @yield('prebecasAppTitle') / Revision </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::open(['route' => 'prebecas.prebecaBecaR']) !!}

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
                {!! Form::select('especialidad_id', array(), null, [
                    'class' => 'form-control select_seguridad',
                    'id' => 'especialidad_id-field',
                ]) !!}
                @if ($errors->has('especialidad_id'))
                    <span class="help-block">{{ $errors->first('especialidad_id') }}</span>
                @endif
            </div>
            <div class="form-group col-md-4 @if ($errors->has('nivel_id')) has-error @endif">
                <label for="nivel_id-field">Nivel</label>
                {!! Form::select('nivel_id', array(), null, [
                    'class' => 'form-control select_seguridad',
                    'id' => 'nivel_id-field',
                ]) !!}
                @if ($errors->has('nivel_id'))
                    <span class="help-block">{{ $errors->first('nivel_id') }}</span>
                @endif
            </div>
            <div class="form-group col-md-4 @if ($errors->has('grado_id')) has-error @endif">
                <label for="grado_id-field">Grado</label>
                {!! Form::select('grado_id', array(), null, [
                    'class' => 'form-control select_seguridad',
                    'id' => 'grado_id-field',
                ]) !!}
                @if ($errors->has('grado_id'))
                    <span class="help-block">{{ $errors->first('grado_id') }}</span>
                @endif
            </div>
            <div class="form-group col-md-4 @if ($errors->has('lectivo_id')) has-error @endif">
                <label for="lectivo_id-field">Lectivo</label>
                {!! Form::select('lectivo_id', array(), null, [
                    'class' => 'form-control select_seguridad',
                    'id' => 'lectivo_id-field',
                ]) !!}
                @if ($errors->has('lectivo_id'))
                    <span class="help-block">{{ $errors->first('lectivo_id') }}</span>
                @endif
            </div>
            <div class="form-group col-md-4 @if ($errors->has('grupo_id')) has-error @endif">
                <label for="grupo_id-field">Grupo</label>
                {!! Form::select('grupo_id', array(), null, [
                    'class' => 'form-control select_seguridad',
                    'id' => 'grupo_id-field',
                ]) !!}
                @if ($errors->has('grupo_id'))
                    <span class="help-block">{{ $errors->first('grupo_id') }}</span>
                @endif
            </div>


            <div class="row">
            </div>
            <div class="well well-sm">
                <button type="submit" class="btn btn-primary">Ver</button>
            </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection

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

