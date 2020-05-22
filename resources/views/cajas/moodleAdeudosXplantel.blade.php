@php header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
@endphp
@extends('plantillas.admin_template')

@include('cajas._common')

@section('header')

<div class="page-header">
        <h1>@yield('cajasAppTitle') / Adeudos Plantel {{$plantel->razon}}

        </h1>
    </div>
@endsection

@section('content')
    <div class="row">
        @if(isset($message))
        <div class="alert alert-warning">
            {{ $message }}
        </div>
        @endif
        <div class="col-md-12">
            @php
                $bajas=\App\MoodleBaja::where('bnd_alta',0)
                //->orWhereRaw('msj IS NOT NULL and msj_alta IS NOT NULL')
                ->get();
            @endphp
        @if($bajas->count())
        <h3>Solicitudes de baja exitosas y fallidas</h3>
            <table class="table table-condensed table-striped">
                <thead>
                    <th></th><th>Cliente</th><th>Baja</th><th>Fecha Baja</th><th>Mensaje Baja</th><th>Mensaje Alta</th><th>Adeudos Pendientes</th>
                </thead>
                <tbody>
                    @foreach($bajas as $baja)
                    @php
                    $cuenta_adeudos=array_count_values(array_column($registros, 'cliente_id'))[$baja->cliente_id];
                    @endphp
                    <tr>
                        <td>
                            @if($baja->bnd_baja==1)
                            <a href="#" 
                                data-baja="{{ $baja->id }}" 
                                data-cliente="{{ $baja->cliente_id }}"
                                data-matricula= "{{ $baja->cliente->matricula }}"
                                data-loading='loading1{{ $baja->cliente_id }}'
                                data-resultado='resultado{{ $baja->cliente_id }}'
                                class="btn btn-xs btn-info btn-alta btn-alta{{ $baja->cliente_id }}">
                                   S. Alta
                                </a>
                            @endif
                                <div id='loading1{{ $registro["cliente_id"] }}' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                        </td>
                        <td>{{ $baja->cliente->id }} {{ $baja->cliente->nombre }} {{ $baja->cliente->nombre2 }} {{ $baja->cliente->ape_paterno }} {{ $baja->cliente->ape_materno }}</td>
                        <td>{{ $baja->bnd_baja }}</td><td>{{ $baja->fecha_baja }}</td><td>{{ $baja->msj }}</td><td>{{ $baja->msj_alta }}</td>
                        <td>{{ $cuenta_adeudos }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
        <h3 class="text-center alert alert-info">Sin bajas solicitadas</h3>
        
        @endif
        <h3>Adeudos de los ultimos 3 meses</h3>
        @if(isset($registros) and count($registros)>0)
        <table class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th>Moodle</th><th>F. Baja</th><th>Plantel</th><th>Especialidad</th><th>Grupo</th><th>Cliente</th><!--<th>St Cliente</th><th>St Seguimiento</th>--><th>Concepto</th><th>Fecha Pago</th><th>Pagado</th><!--<th>St Caja</th>--><th>Fecha Pago</th><th>Monto</th>
                </tr> 
            </thead>
            <tbody>
                <?php 
                $i=0; 
                $j=0;
                $total_monto=0;
                $suma_total=0;
                $grupo="";        
                ?>
                <?php $colaborador="" ?>
                @foreach($registros as $registro)
                    
                    <tr>
                        <td>
                            @php
                            $bajas=\App\MoodleBaja::where('cliente_id',$registro['cliente_id'])
                            ->where('bnd_baja',1)
                            ->where('bnd_alta',0)
                            ->first();
                            @endphp
                            @permission('moodleBajas.procesarUno')
                            @if(is_null($bajas))
                            <a href="{{ route('moodleBajas.procesarUno',array('cliente'=>$registro['cliente_id'])) }}" 
                               data-cliente="{{ $registro['cliente_id'] }}"
                               data-matricula= "{{$registro['matricula']}}"
                               data-loading='loading{{ $registro["cliente_id"] }}'
                               data-resultado='resultado{{ $registro["cliente_id"] }}'
                               class="btn btn-xs btn-success btn-baja btn-baja{{ $registro["cliente_id"] }}">
                                    S. Baja
                            </a>
                            <div id="resultado{{ $registro["cliente_id"] }}"></div>
                            @else
                            <!--<a href="{{ route('moodleBajas.procesarUnoAlta',array('id'=>$bajas->id)) }}" 
                               data-baja="{{ $bajas->id }}" 
                               data-cliente="{{ $registro['cliente_id'] }}"
                               data-matricula= "{{$registro['matricula']}}"
                               data-loading='loading{{ $registro["cliente_id"] }}'
                               data-resultado='resultado{{ $registro["cliente_id"] }}'
                               class="btn btn-xs btn-info btn-alta btn-alta{{ $registro["cliente_id"] }}">
                                  S. Alta
                               </a>-->
                            @endif
                            @endpermission
                            <div id='loading{{ $registro["cliente_id"] }}' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                            
                        </td>
                        <td>
                        @if(!is_null($bajas))
                        {{$bajas->fecha_baja}}
                        @endif
                        </td>
                        <td>{{$registro['razon']}}</td>
                        <td>{{$registro['especialidad']}}</td>
                        <td>{{$registro['grupo']}}</td>
                        <td><a href='{{route('seguimientos.show',$registro['seguimiento'])}}' target='_blank'> {{$registro['cliente']}} </a></td>
                        <!--<td>@{{$registro['st_cliente']}}</td>
                        <td>@{{$registro['st_seguimiento']}}</td>-->
                        <td>{{$registro['concepto']}}</td>
                        
                        <td>{{$registro['fecha_pago']}}</td>
                        <td>
                            @if($registro['bnd_pagado']==1)
                                SI
                            @else
                                NO
                            @endif
                        </td>
                        <!--<td>@{{$registro['estatus_caja']}}</td>-->
                        <td>{{$registro['fecha_pago']}}</td>
                        <td style="align:right;">{{number_format($registro['total'],2)}}</td>
                        
                    </tr>
                    
                    <?php 
                    $grupo=$registro['grupo']; 
                    $i++;
                    $total_monto=$total_monto+$registro['total'];
                    $suma_total=$suma_total+$registro['total'];
                    ?>
                @endforeach
                    <?php 
                    $j=$i+$j;
                    ?>
                    <tr>
                        <td><strong>Total</strong></td><td colspan="9"><strong>{{$j}}<strong></td><td style="align:right;"><strong>{{number_format($suma_total,2)}}</strong></td>
                    </tr>
            </tbody>
        </table>
        @endif
        </div>
    </div>

@endsection

@push('scripts')
<script src="{{ asset('bower_components\AdminLTE\plugins\JavaScript-MD5-2.14.0\js\md5.min.js') }}"></script>
<script type="text/javascript">

    
$('.btn-baja').click(function(e){
    e.preventDefault();
    //console.log($(this).data('loading'));
    peticionMoodle("", 
                   $(this).data('matricula'),
                   $(this).data('loading'),
                   $(this).data('resultado'), 
                   $(this).data('cliente')); 
    
});

function peticionMoodle(llave="", matricula, loading, resultado, cliente){
    var d = new Date();
    var n = d.getDate('Ymd');
    //alert(n);
    var salt="SbSkhl0XvctpPUscgLNg";
    if(llave==""){
        llave=md5(n+salt);
    }

    $.ajax({
        type: 'GET',
        url: '{{ route('moodleBajas.procesarUno') }}',
        //cache:true,
        data: {
            'method':'changeUserStatus' ,
            'key': llave,
            'username':matricula,
            'active':false
        },
        dataType:"json",
        //jsonp: 'jsonp-callback',
        beforeSend : function(){$("#"+loading).show();},
        complete : function(){$("#"+loading).hide(); },
        success: function(datos) {
            //console.log('exito');
            res = datos.split("}");
            res[0]=res[0]+"}";
            objetivo=JSON.parse(res[0]);
            //console.log(typeof objetivo);
            if(typeof objetivo != "undefined"){
                if(objetivo.status==403){
                    //console.log(objetivo.message);
                    clave=objetivo.message.split(".");
                    //console.log('2 ejecucion con key correcta');
                    peticionMoodle(clave[1], matricula, loading, resultado, cliente);
                }else if(objetivo.success==false){
                    console.log('caso diferente de 403');
                    //console.log(objetivo);
                    $("#"+resultado).html('<span class="badge bg-red">'+objetivo.message+'</span>');
                    crearRegistroBaja(cliente, 0, null, datos);
                }else if(objetivo.success==true){
                    $("#"+resultado).html('<span class="badge bg-green">'+objetivo.success+'</span>');
                    crearRegistroBaja(cliente, 1, date('Y-m-d'),'{success:'+objetivo.success+"}");
                }
            }else{
                console.log('default');
                console.log(objetivo);
                $("#"+resultado).html('<span class="badge bg-red">'+ 'No se pudo obtener un objeto o cadena valida' +'</span>');
            }
        },
        error: function(datos){
            console.log('error');
            res = datos.split("}");
            res[0]=res[0]+"}";
            objetivo=JSON.parse(res[0]);
            //if(typeof objetivo.status !== "undefined" and objetivo.status<>403){
                console.log(objetivo);
            //}
        }
    });
}

function crearRegistroBaja(id, bnd_baja, fecha_baja, msj=""){
    
    $.ajax({
        type: 'GET',
        url: '{{ route('moodleBajas.procesar') }}',
        //cache:true,
        data: {
            'id':id,
            'bnd_baja':bnd_baja,
            'fecha_baja':fecha_baja,
            'msj':msj
        },
        dataType:"json",
        success: function(datos) {
            console.log('registro creado');
            location.reload(); 
        },
        error: function(datos){
            
        }
    });
}

$('.btn-alta').click(function(e){
    e.preventDefault();
    
    peticionMoodleActualizacion("", 
                                $(this).data('matricula'),
                                $(this).data('loading'), 
                                $(this).data('resultado'), 
                                $(this).data('cliente'),
                                $(this).data('baja')); 
    
});

function peticionMoodleActualizacion(llave="", matricula, loading, resultado, cliente, baja){
    var d = new Date();
    var n = d.getDate('Ymd');
    //alert(n);
    var salt="SbSkhl0XvctpPUscgLNg";
    if(llave==""){
        llave=md5(n+salt);
    }

    $.ajax({
        type: 'GET',
        url: '{{ route('moodleBajas.procesarUno') }}',
        //cache:true,
        data: {
            'method':'changeUserStatus' ,
            'key': llave,
            'username':matricula,
            'active':true
        },
        dataType:"json",
        //jsonp: 'jsonp-callback',
        beforeSend : function(){$("#"+loading).show(); },
        complete : function(){$("#"+loading).hide(); },
        success: function(datos) {
            console.log('exito');
            res = datos.split("}");
            res[0]=res[0]+"}";
            objetivo=JSON.parse(res[0]);
            //console.log(typeof objetivo);
            if(typeof objetivo != "undefined"){
                if(objetivo.status==403){
                    //console.log(objetivo.message);
                    clave=objetivo.message.split(".");
                    console.log('2 ejecucion con key correcta');
                    peticionMoodleActualizacion(clave[1], matricula,loading, resultado, cliente, baja);
                }else if(objetivo.success==false){
                    console.log('caso diferente de 403');
                    //console.log(objetivo);
                    $("#"+resultado).html('<span class="badge bg-red">'+objetivo.message+'</span>');
                    actualizarRegistroBaja(baja, 0, null, datos);
                }else if(objetivo.success==true){
                    $("#"+resultado).html('<span class="badge bg-green">'+objetivo.success+'</span>');
                    actualizarRegistroBaja(baja, 1, date('Y-m-d'), '{success:'+objetivo.success+"}");
                }
            }else{
                console.log('default');
                console.log(objetivo);
                $("#"+resultado).html('<span class="badge bg-red">'+ 'No se pudo obtener un objeto o cadena valida' +'</span>');
            }
        },
        error: function(datos){
            console.log('error');
            res = datos.split("}");
            res[0]=res[0]+"}";
            objetivo=JSON.parse(res[0]);
            //if(typeof objetivo.status !== "undefined" and objetivo.status<>403){
                console.log(objetivo);
            //}
        }
    });
}


function actualizarRegistroBaja(id, bnd_alta, fecha_alta,msj){
    
    $.ajax({
        type: 'GET',
        url: '{{ route('moodleBajas.procesarAlta') }}',
        //cache:true,
        data: {
            'id':id,
            'bnd_alta':bnd_alta,
            'fecha_alta':fecha_alta,
            'msj':msj
        },
        dataType:"json",
        success: function(datos) {
            console.log('registro actualizado');
            location.reload(); 
        },
        error: function(datos){
            
        }
    });
}

</script>
    
@endpush