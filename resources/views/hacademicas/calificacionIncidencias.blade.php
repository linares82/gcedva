@inject('cli_funciones','App\Http\Controllers\ClientesController')

@extends('plantillas.admin_template')

@include('hacademicas._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('hacademicas.index') }}">@yield('hacademicasAppTitle')</a></li>
	    <li class="active">Calificaciones</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> @yield('hacademicasAppTitle') / Calificaciones </h3>
    </div>

    <style>
      table tr:hover {
        background-color: #A9D0F5;
        cursor: pointer;
    }
    </style>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">
            @if(isset($msj) and $msj<>"")
                <div class="alert alert-danger">
                    <ul>
                            <li><i class="glyphicon glyphicon-remove"></i> {{ $msj }}</li>
                    </ul>
                </div>
            @endif
            {!! Form::open(array('route' => 'hacademicas.calificacionIncidencia', "id"=>"frm_academica")) !!}
                <div class="form-group col-md-4 @if($errors->has('tpo_examen_id')) has-error @endif">
                   <label for="tpo_examen_id-field">Examen</label>
                   {!! Form::hidden("asignacion", $asignacion, array("class" => "form-control input-sm", "id" => "mail_acudiente-field")) !!}
                   {!! Form::select("tpo_examen_id", $examen, null, array("class" => "form-control select_seguridad", "id" => "tpo_examen_id-field")) !!}
                   <div id='loading' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                   @if($errors->has("tpo_examen_id"))
                    <span class="help-block">{{ $errors->first("st_materium_id") }}</span>
                   @endif
                </div>
                <div class="form-group col-md-4 @if($errors->has('carga_ponderacion_id')) has-error @endif">
                    <label for="carga_ponderacion_id-field">Ponderacion</label>
                    {!! Form::select("carga_ponderacion_id", $carga_ponderaciones, null, array("class" => "form-control select_seguridad", "id" => "carga_ponderacion_id-field")) !!}
                    @if($errors->has("carga_ponderacion_id"))
                     <span class="help-block">{{ $errors->first("carga_ponderacion_id") }}</span>
                    @endif
                 </div>
                 
                <div class="row"></div>
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Cargar</button>
                </div>
            {!! Form::close() !!}
            @if(isset($hacademicas))
                <div class="table-responsive">
                 <table class="table table-condensed table-striped">
                     <thead>
                         <th>id</th>
                         <th>Alumno</th>
                         <th>Estatus Cliente</th>
                         <th>Doc. Entregados</th>
                         <th>Acta Final</th>
                         <th>Ponderacion</th>
                         <th>Calificacion Total</th>
                         <th>Calificacion</th>
                         <th>Calificacion Parcial</th>
                         <th></th>
                         <th></th>
                         <th></th>
                     </thead>
                     <tbody>
                         
                         @foreach($hacademicas as $r)
                         <tr>
                         @php
                             $validaEntregaDocs3Meses=$cli_funciones->validaEntregaDocs3Meses($r->id);
                         @endphp
                         <td>{{$r->id}}</td>
                         <td>{{$r->ape_paterno." ".$r->ape_materno." ".$r->nombre." ".$r->nombre2}}</td>
                         <td>{{$r->estatus_cliente}}</td>
                         <td>
                             @if($r->bnd_doc_oblig_entregados==1 or $validaEntregaDocs3Meses)
                             SI o dentro de plazo valido
                             @else
                             <strong>NO</strong>
                             
                             @endif
                        </td>
                         <td>
                             @php
                                 if(isset($r->fecha_acta)){
                                    $fecha=\Carbon\Carbon::createFromFormat('Y-m-d',$r->fecha_acta);
                                    echo "F".$fecha->day.sprintf("%02d",$fecha->month).substr($fecha->year,-2).sprintf("%03d",$r->consecutivo_acta);
                                }
                             @endphp
                             
                         </td>
                         <td>{{$r->ponderacion}}</td>
                         <td><div id="div_c{{$r->id}}{{$r->calificacion_ponderacion_id}}">{{$r->calificacion}}</div></td>
                         <td><div id="div_par{{$r->id}}{{$r->calificacion_ponderacion_id}}">{{ $r->calificacion_parcial }}</div></td>
                         <td><div id="div_cp{{$r->id}}{{$r->calificacion_ponderacion_id}}">{{ $r->calificacion_parcial_calculada }}</div></td>
                         <td>
                         </td>
                         <td>
                            @permission('incidenciasCalificacions.create')
                            @if ($dentroPeriodoIncidencias)
                                <a target="_blank" href="{{ route('incidenciasCalificacions.create', array('calificacion_ponderacion_id'=>$r->calificacion_ponderacion_id)) }}" class="btn btn-warning btn-xs" target="_blank">Incidencia</a>         
                            @endif
                            @endpermission
                         </td>
                         <td>
                             <div id='loading{{$r->id}}}' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                         </td>
                         </tr>
                         @endforeach
                     </tbody>
                 </table>
                </div>
            @endif
            @if(!isset($hacademicas))
                Lo sentimos usted no es el profesor de la materia o la fecha limite del perido lectivo ha finalizado.
            @endif        
        </div>
    </div>
    
    
@endsection

@push('scripts')
  
  <script type="text/javascript">
      $('.fecha').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
      });
     
     $(document).on("click", ".btn-guardar_caificacion", function (e) {
        //alert($('#calificacion_parcial'+$(this).data('cliente_id')).val());
        @php
            $calificacion_prohibida=\App\Param::where('llave', 'calificacion_prohibida')->first();
            //dd($ponderacion_seleccionada->bnd_excepcion_calificacion_prohibida);
            if(!isset($ponderacion_seleccionada)){
                $excepcion_calificacion_prohibida=0;
            }else{
                $excepcion_calificacion_prohibida=$ponderacion_seleccionada->bnd_excepcion_calificacion_prohibida;
            }
        @endphp 
        
        
        if({{$calificacion_prohibida->valor}} && 
            !{{$excepcion_calificacion_prohibida}} &&
            $('#calificacion_parcial'+$(this).data('cliente_id')).val()>=1 && 
            $('#calificacion_parcial'+$(this).data('cliente_id')).val()<=4.9){
            alert("Calificacion invalida");
        }else{
            var miurl = "{{route('hacademicas.actualizarCalificacion')}}";
        let id=$(this).data('cliente_id');
        let calificacion_ponderacion=$(this).data('calificacion_ponderacion_id')
        var data = new FormData();
        data.append('calificacion_ponderacion', $(this).data('calificacion_ponderacion_id'));
        data.append('calificacion_parcial', $('#calificacion_parcial'+$(this).data('cliente_id')+$(this).data('calificacion_ponderacion_id')).val());

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('#_token').val()
            }
        });
        $.ajax({
            url: miurl,
            type: 'GET',

            // Form data
            //datos del formulario
            data: "calificacion_ponderacion=" + $(this).data('calificacion_ponderacion_id') +
                  "&calificacion_parcial=" + $('#calificacion_parcial'+$(this).data('cliente_id')+$(this).data('calificacion_ponderacion_id')).val() + "",
            //necesario para subir archivos via ajax
            dataType: 'json',
            //mientras enviamos el archivo
            beforeSend : function(){$(".btn-guardar_caificacion").prop('disabled',true);},
            complete : function(){$(".btn-guardar_caificacion").prop('disabled',false);},
            //una vez finalizado correctamente
            success: function (data) {
                //location.reload();
                //console.log(data.calificacion);
                $('#div_c'+id+calificacion_ponderacion).html(data.calificacion);
                $('#div_par'+id+calificacion_ponderacion).html(data.calificacion_parcial);
                $('#div_cp'+id+calificacion_ponderacion).html(data.calificacion_parcial_calculada);
            },
            //si ha ocurrido un error
            error: function (data) {
                

            }
        });
        }
        
    })
    
    cmbPonderaciones();
    
    $('#tpo_examen_id-field').change(function(){
        cmbPonderaciones();
    });
    
    function cmbPonderaciones(){
        $.ajax({
            url: '{{ route("hacademicas.cmbPonderaciones") }}',
                    type: 'GET',
                    data: "tpo_examen_id=" + $('#tpo_examen_id-field option:selected').val() + 
                          "&asignacion_id=" + {{$asignacion}} + 
                          "&carga_ponderacion_id="+$('#carga_ponderacion_id-field option:selected').val(),
                    dataType: 'json',
                    beforeSend : function(){$("#loading").show(); },
                    complete : function(){$("#loading").hide(); },
                    success: function(data){
                        $('#carga_ponderacion_id-field').empty();
                        $('#carga_ponderacion_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                        $.each(data, function(i) {
                            //alert(data[i].name);
                            $('#carga_ponderacion_id-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                        });
                        $('#carga_ponderacion_id-field').select2({
                            placeholder: 'Seleccionar opción'
                          });
                    }
            });
    }

    
</script>
@endpush