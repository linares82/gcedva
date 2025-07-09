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

            <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Inscripcion</th><th>Cliente Id</th><th>Cliente</th>
                            <th>Motivo</th><th>Observaciones</th><th>Porcentaje</th>
                            <th>Beca</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            //dd($registro);
                            $i=0;
                        @endphp
                        @foreach($registros as $registro)
                        @php
                            //dd($registro);
                            
                        @endphp
                            <tr>
                                <td>{{++$i}}</td>
                                <td>{{$registro->plantel->razon}} / {{$registro->especialidad->name}} / 
                                    {{$registro->nivel->name}} / {{$registro->grado->name}} /
                                    {{ $registro->lectivo->name }} / {{$registro->grupo->name}}
                                </td>
                                <td>
                                    @if(isset($registro->cliente))
                                    <a target="_blank" href="{{route('clientes.edit', $registro->cliente->id)}}">
                                    {{$registro->cliente->id}}
                                    </a>
                                    @endif
                                </td>
                                <td>
                                    @if(isset($registro->cliente))
                                    {{$registro->cliente->nombre}} {{$registro->cliente->nombre2}} {{$registro->cliente->ape_paterno}} {{$registro->cliente->ape_materno}}</td>
                                    @endif
                                <td>
                                    @if(isset($registro->cliente->prebeca))
                                    {{optional($registro->cliente->prebeca->motivoBeca)->name}}
                                    @endif
                                </td>
                                <td>
                                    @if(isset($registro->cliente->prebeca))
                                    {{optional($registro->cliente->prebeca)->obs_prebeca}}
                                    @endif
                                </td>
                                <td>
                                    @if(isset($registro->cliente->prebeca))
                                    {{optional($registro->cliente->prebeca->porcentajeBeca)->name}}
                                    @endif
                                </td>
                                <td>
                                    @if(isset($registro->cliente->autorizacionBeca))
                                    <a class="btn btn-info btn-xs pull-right" target="_blank" href="{{ route('autorizacionBecas.findByClienteId',array('cliente_id'=>$registro->cliente_id)) }}"><i class="glyphicon glyphicon-eye"></i> Ver </a>
                                    @else
                                    <a class="btn btn-success btn-xs pull-right" target="_blank" href="{{ route('autorizacionBecas.create',array('id'=>$registro->cliente_id)) }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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

