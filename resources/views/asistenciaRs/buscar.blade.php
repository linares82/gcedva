@inject('cli_funciones','App\Http\Controllers\ClientesController')

@extends('plantillas.admin_template')

@include('asistenciaRs._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('asistenciaRs.index') }}">@yield('asistenciaRsAppTitle')</a></li>
	    <li class="active">Buscar alumnos</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('asistenciaRsAppTitle') / Editar </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::open(array('route' => 'asistenciaRs.procesar')) !!}

                <div class="form-group col-md-4 @if($errors->has('fecha')) has-error @endif">
                    <label >Empleado: {{$as->empleado->nombre." ".$as->empleado->ape_paterno." ".$as->empleado->ape_materno}}</label><br/>
                       <label >Materia: {{$as->materia->name}}</label>
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('fecha')) has-error @endif">
                       <label for="fecha-field">Fecha</label>
                       {!! Form::hidden("asignacion_academica_id", $asignacion_academica_id, array("class" => "form-control input-sm", "id" => "asignacion_academica_id-field")) !!}
                       {!! Form::text("fecha", null, array("class" => "form-control input-sm", "id" => "fecha-field", 'readonly'=>true)) !!}
                       @if($errors->has("fecha"))
                        <span class="help-block">{{ $errors->first("fecha") }}</span>
                       @endif
                    </div>
                    @permission('asistencias.excepcion')
                    <div class="form-group col-md-4 @if($errors->has('excepcion')) has-error @endif">
                       <label for="excepcion-field">Exepcion</label>
                       {!! Form::checkbox("excepcion", 1, false) !!}
                       @if($errors->has("excepcion"))
                        <span class="help-block">{{ $errors->first("excepcion") }}</span>
                       @endif
                    </div>
                    @endpermission
                <div class="row">
                </div>
                @if(isset($asistencias))
                <table class="table table-condensed table-striped">
                    <thead>
                        <th>Alumno</th><th>Doc. Entregados</th><th>Estatus Cliente</th><th>Fecha</th><th>Asistencia</th><th></th>
                    </thead>
                        @foreach($asistencias as $s)
                        @php
                            $validaEntregaDocs3Meses=$cli_funciones->validaEntregaDocs3Meses($s->cliente_id);
                        @endphp
                        <tr>
                            <td>
                                {{$s->cliente_id}} - {{ optional($s->cliente)->ape_paterno." ".optional($s->cliente)->ape_materno." ".optional($s->cliente)->nombre." ".optional($s->cliente)->nombre2 }}
                            </td>
                            <td>
                                @if($s->bnd_doc_oblig_entregados==1 or $validaEntregaDocs3Meses)
                                    SI o dentro del plazo
                                @else
                                    NO
                                @endif
                            </td>
                            <td>{{ optional($s->cliente->stCliente)->name }}</td>
                            <td>{{ $s->fecha }}</td>
                            <td>
                                <div class="form-group col-md-4  @if($errors->has('est_asistencia_id')) has-error @endif" >
                                    @if(optional($s->cliente)->st_cliente_id==25 or optional($s->cliente)->st_cliente_id==3)                                    
                                    @else
                                        {!! Form::select("est_asistencia_id", $list["EstAsistencium"], $s->est_asistencia_id, array("class" => "select_seguridad1", "id" => "est_asistencia_id".$s->id."-field", "name" => "est_asistencia_id".$s->id."-field")) !!}
                                    @endif
                                    
                                    @if($errors->has("est_asistencia_id"))
                                     <span class="help-block">{{ $errors->first("est_asistencia_id") }}</span>
                                    @endif
                                 </div> 
                            </td>
                            <td>
                                @php
                                    $param_bloqueoXdoc=\App\Param::where('llave','bloqueo_caja_calif_asistenciasXDoc')->first();
                                    
                                    
                                @endphp
                                @if($param_bloqueoXdoc->valor==1)
                                @if($s->bnd_doc_oblig_entregados==1 or 
                                    $s->cliente->st_cliente_id==1 or 
                                    $s->cliente->st_cliente_id==22 or 
                                    $validaEntregaDocs3Meses)
                                <a href="#" onclick="modificarAsistencia({{$s->id}})" class="btn btn-success">Modificar</a>
                                <div id='loading3' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                                <label id="etq_msj"></label>
                                @endif
                                @else
                                <a href="#" onclick="modificarAsistencia({{$s->id}})" class="btn btn-success">Modificar</a>
                                <div id='loading3' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                                <label id="etq_msj"></label>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    <tbody>
                        
                    </tbody>
                </table>
                @endif
                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                    <a class="btn btn-link pull-right" href="{{ route('asignacionAcademicas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection
@push('scripts')
<script>
  //  $(document).ready(function() {
      
      // assuming the controls you want to attach the plugin to
      // have the "datepicker" class set
      //Campo de fecha
  
      @php
   
   $fecha=\Carbon\Carbon::now();
   $fecha_final=$fecha->toDateString();
    $fecha_inicial=$fecha->subDays(10)->toDateString();
   
   

   @endphp
   $('#fecha-field').Zebra_DatePicker({
      direction: ['{{ $fecha_inicial }}', '{{  $fecha_final  }}'],
      days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
      months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
      readonly_element: false,
      lang_clear_date: 'Limpiar',
      show_select_today: 'Hoy',
      
   });


      $('#fecha1-field').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
      });

//    )};
        function modificarAsistencia(id){
            a=id;
            $.ajax({
            url: '{{ route("asistenciaRs.update") }}',
                    type: 'GET',
                    data: "asistencia=" + a + "&estatus=" + $('#est_asistencia_id'+id+'-field option:selected').val(),
                    dataType: 'json',
                    beforeSend : function(){$("#loading3").show(); },
                    complete : function(){$("#loading3").hide(); },
                    success: function(data){
                        if(data==1){
                            $("#etq_msj").text("Actualizacion exitosa");
                            $("#etq_msj").addClass('bg-green')
                        }else{
                            $("#etq_msj").text("Fallo, intentar nuevamente");
                            $("#etq_msj").addClass('bg-red')
                        }
                        
                    }
            });
        }
        
</script>

@endpush



        
    