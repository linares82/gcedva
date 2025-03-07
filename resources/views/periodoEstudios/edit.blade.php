@extends('plantillas.admin_template')

@include('periodoEstudios._common')

@section('header')
<style>
    /* Custom styles specific to the form rows */
    .form-row {
      margin-bottom: 10px;
      padding: 10px;
      /* Add padding for better spacing */
      background-color: #f8f9fa;
      /* Light background color */
      border: 1px solid #dee2e6;
      /* Border color */
      border-radius: .25rem;
      /* Rounded corners */
    }

    .form-row input,
    .form-row select {
      margin-right: 10px;
    }

    .handle {
      cursor: move;
      margin-right: 10px;
    }
  </style>
	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('periodoEstudios.index') }}">@yield('periodoEstudiosAppTitle')</a></li>
	    <li><a href="{{ route('periodoEstudios.show', $periodoEstudio->id) }}">{{ $periodoEstudio->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('periodoEstudiosAppTitle') / Editar {{$periodoEstudio->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($periodoEstudio, array('route' => array('periodoEstudios.update', $periodoEstudio->id),'method' => 'post')) !!}

@include('periodoEstudios._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('periodoEstudios.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
    @if(isset($materias_ls))
    <!--
    <p class="lead my-5">Definir Materia</p>
      
        {!-. Form::model(null, array('route' => array('materiumPeriodos.store'),'method' => 'post','id'=>'definir_materias')) !!}
        
        <div id="form-rows">
          <div class="row g-3 align-items-center mb-4 form-row template-row">
            <div class="col-auto handle">
              <i class="fas fa-grip-vertical"></i>
            </div>
              <div class="form-group col-md-4 @if($errors->has('materia_id')) has-error @endif">
                <label for="materia_id-field">Materias</label>
                <div id="select_materia">
                    {!! Form::select("registro[0][materia_id]", $materias_ls, null, array("class" => "form-control select_materias", 'style'=>"width:100%")) !!} 
                    <input type="hidden" class="form-control" name="registro[0][periodo_estudio_id]" value="{{$periodoEstudio->id}}">
                </div>
                <div id='loading3' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div>
                @if($errors->has("materia_id"))
                    <span class="help-block">{{ $errors->first("materia_id") }}</span>
                @endif
            
            </div>
            <div class="form-group col-md-2">
              <label>Horas Jornada</label>
              <input type="text" class="form-control" name="registro[0][horas_jornada]">
            </div>
            <div class="form-group col-md-2">
              <label>Duracion Clase</label>
              <input type="text" class="form-control" name="registro[0][duracion_clase]">
            </div>
            <div class="form-group col-md-2">
              <button type="button" class="btn btn-danger btn-xs remove-row">
                Quitar
              </button>
            </div>
          </div>
        </div>
        <button id="add-row" class="btn btn-primary">Agregar</button>
        <button id="submit" class="btn btn-primary">Guarda</button>
        {!! Form::close() !!}
    -->
    <div class="row"></div>
        <div class="form-group col-md-8">
        <table class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th>id</th><th>Codigo</th><th>Materia</th><th>Horas Jornada</th><th>Duracion Clase</th><th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($materias as $m)
                <tr>
                    <td>{{ $m->id }} - {{ $m->materia_id }}</td>
                    <td>{{ $m->codigo }}</td>
                    <td>{{$m->materia}}</td>
                    <td class="editable">
                        <div class="editable">
                            @if(is_null($m->horas_jornada))
                                Editar
                            @else
                            {{$m->horas_jornada}}
                            @endif
                            
                            <input class='form-control editable_horas_jornada' style="display:none;" value='{{$m->horas_jornada}}' data-id="{{$m->id}}"></input>
                        </div>
                    </td>
                    <td class="editable">
                        
                        <div class="editable">
                            @if(is_null($m->duracion_clase))
                                Editar
                            @else
                            {{$m->duracion_clase}}
                            @endif
                            
                            <input class='form-control editable_duracion_clase' style="display:none;" value='{{$m->duracion_clase}}' data-id="{{$m->id}}"></input>
                        </div>
                    </td>
                    <td><a href="{{route('periodoEstudios.destroyMateria', $m->id)}}" class="btn btn-xs btn-danger">Eliminar</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        @endif
        @if(isset($periodoEstudio->grupos))
        <div class="col-md-4">
            <table class="table table-condensed table-striped">
                <thead>
                <th>Grupos Vinculados</th><th></th>
                </thead>
                <tbody>
                    @foreach($periodoEstudio->grupos as $g)
                    <tr>
                    <td> {{$g->name}} </td>
                    <td>
                        
                    </td>
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>    
        </div>
        @endif                
    
@endsection
@push('scripts')
<script src="{{asset('/bower_components/AdminLTE/plugins/dulicate-remove-sort-rows/jquery.formRowRepeater.js')}} "></script>
<script src="{{asset('/bower_components/AdminLTE/plugins/dulicate-remove-sort-rows/jquery.serializeFormToJson.js')}} "></script>
<script>
    $(document).ready(function() {

      getCmbMateria();
      
      $('#plantel_id-field').change(function(){
          getCmbMateria();
      });

      $('#definir_materias').formRowRepeater({
          templateRow: '.template-row',
          addRowButton: '#add-row',
          sortableContainer: '#form-rows',
          rowClass: '.form-row',
          handleClass: '.handle',
          removeButtonClass: '.remove-row',
          sortOrderClass: '.sort-order'
      });
      
      $('#submit').on('click', function(event) {
          //event.preventDefault();
          $('#definir_materias').submit();
          console.log('fil');
      });

      $('.editable').dblclick(function(){
            captura=$(this).children("input");
            captura.show();
        });

        $('.editable_horas_jornada').on('keypress', function (e) {      
            if(e.which === 13){
                captura=$(this);
              $.ajax({
                   type: 'get',
                    url: '{{url("materiumPeriodos/update")}}'+"/"+captura.attr('data-id'),
                    data: {
                        'horas_jornada': captura.val(),
                    },
                    dataType:"json",
                    beforeSend : function(){$("#loading3").show(); },
                    complete : function(data){
                        $("#loading3").hide(); 
                        location.reload();
                    },
                    error: function(data){
                    
                    },
                    success: function(data) {
                    
                        
                    },
                   }); 
               }
           });
           $('.editable_duracion_clase').on('keypress', function (e) {      
            if(e.which === 13){
                captura=$(this);
              $.ajax({
                   type: 'get',
                    url: '{{url("materiumPeriodos/update")}}'+"/"+captura.attr('data-id'),
                    data: {
                        'duracion_clase': captura.val(),
                    },
                    dataType:"json",
                    beforeSend : function(){$("#loading3").show(); },
                    complete : function(data){
                        $("#loading3").hide(); 
                        location.reload();
                    },
                    error: function(data){
                    
                    },
                    success: function(data) {
                    
                        
                    },
                   }); 
               }
           });

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
                      $('.select_materias').html('');
                      
                      //$('#especialidad_id-field').empty();
                      $('.select_materias').append($('<option></option>').text('Seleccionar Opción').val('0'));
                      
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('.select_materias').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                          
                      });
                      //$example.select2();
                  }
              });       
      }
  </script>
@endpush